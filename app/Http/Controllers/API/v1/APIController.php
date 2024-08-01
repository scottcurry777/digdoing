<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function index (Request $request)
    {
        return response()->json([
            'message' => 'Welcome to digDoing.  Current API version is 1.0.'
        ], 200);
    }
    
    public function v1 (Request $request)
    {
        return response()->json([
            'message' => 'Welcome to digDoing.'
        ], 200);
    }
}