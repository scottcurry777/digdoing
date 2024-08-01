<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
Use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialController extends Controller
{
    
    public function redirect ($provider, Request $request)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }
    
    public function callback ($provider, Request $request)
    {
        if ($request->has('error')) {
            // User did not log in
            
            if (($request->wantsJSON()) or ($request->root() == 'https://api.digdoing.com')) {
                return response()->json([
                    'message' => 'User Refused Access'
                ], 401);
            } else {
                // TODO: SHOW THE USER AN ERROR MESSAGE SOMEHOW
                
                return redirect('/login/');
            }
        } else {
            // User successfully logged in
            
            $getInfo = Socialite::driver($provider)->stateless()->user();
            $user = $this->createUser($getInfo, $provider); 
            
            if (($request->wantsJSON()) or ($request->root() == 'https://api.digdoing.com')) {
                // generate a token and return the token
                
                $userToken = $user->token() ?? $user->createToken('socialLogin');
                
                return response()->json([
                    "token_type" => "Bearer",
                    "access_token" => $userToken->accessToken
                ], 200);
            } else {
                // log the user in and return the user to the previous URL
                
                auth()->login($user);
                
                return redirect()->intended('/');
            }
        }
    }
    
    function createUser ($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        
        if (!$user) {
            $user = User::create([
                'name'          => $getInfo->name,
                'email'         => $getInfo->email,
                'provider'      => $provider,
                'provider_id'   => $getInfo->id
            ]);
        }
        
        return $user;
    }
    
    
    // TODO: YOU MIGHT HAVE TO MOVE THIS TO AUTHENTICATE PROVIDER OR SOMEWHERE ELSE
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    
}
