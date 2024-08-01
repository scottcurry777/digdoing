<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class MainController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // User Logged In
            return view('home');
        } else {
            // User Not Logged In
            return view('index');
        }
    }
    
    public function api(Request $request)
    {
        if (Auth::check()) {
            $user           = Auth::user();
            $userName       = $user->name;
            $accessToken    = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiNzFmYjdlZWFkYjc0NmRhZTY1NGRkZmNmYzdlZDkxYmVkNTcyZTY1MjQ4NjE3YjY0NDMxYjAyMGMyYjA3ZjllNDZhYjVlNTAyNzZmNWJiMjgiLCJpYXQiOjE1ODkyNTc0ODcsIm5iZiI6MTU4OTI1NzQ4NywiZXhwIjoxNjIwNzkzNDg3LCJzdWIiOiIiLCJzY29wZXMiOlsiKiJdfQ.ooofjhUpqz38UBnTi_mx9VpaYkfcPXkGHPvKd8EpzjIOPHjYu6MNmFeDDT553QL-zsljOcm0_uGHCnahXneQhwdmEdzUbUQGTLzCFwyxdpoz7jwD2hpLkLm18SInKQNMdb0nYg1GfyXbg1BRnbQVDogtlg6pNyPQanBSOhQWgzxtokkBmhtdb_IcCG9XobhSWsf0zTHbYB2Ni0EHCNtVMncOj7Psoc3dSb7ATd1rAYY7j3Z0_Ts07DBl2NWmFHMBtcKIjZzvpJ0iD0k7x__8sI-jRkSm6XPiAk4ENyrOCaIG-FhLp9nbNCOMDwAEZHLeu9i0AL-I5zjZQBhzUJZtu8Kw5oDmDJ620YM0Yp8DpQgKfbJNtmPJI6wCCivDqoIL_dv_xZn0iRZfJKNv_vCLk0YGPQ-MKtsA6bPfpweHiwhZTOKpwcc0VBdlVxuHfTp2hUzJfnn1ePAx8cYtXigK8n8a8PaR5vSz5UovuJgI_UHPsxd6U-A3ePigDYWKdKn5PGhgAvqBbOd516X0SoqglH30pajRh-0guDe7oRDYrQnjD5pk4jXSxzDoW8fdHhxvyjXiUCLZDDo8jCKJrABScv8MmKwaIrqhyMjFZOdPzIzMKnUDnA-L5GgERL2oVHM7xHqyKsWyZAhtPOsfmd7gj4ct8pfxVZKNBXk3PrdTq0Y';
        } else {
            $userName       = null;
            $accessToken    = null;
        }
        
        /*
        
Accept:
application/json
Authorization:
Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiNzFmYjdlZWFkYjc0NmRhZTY1NGRkZmNmYzdlZDkxYmVkNTcyZTY1MjQ4NjE3YjY0NDMxYjAyMGMyYjA3ZjllNDZhYjVlNTAyNzZmNWJiMjgiLCJpYXQiOjE1ODkyNTc0ODcsIm5iZiI6MTU4OTI1NzQ4NywiZXhwIjoxNjIwNzkzNDg3LCJzdWIiOiIiLCJzY29wZXMiOlsiKiJdfQ.ooofjhUpqz38UBnTi_mx9VpaYkfcPXkGHPvKd8EpzjIOPHjYu6MNmFeDDT553QL-zsljOcm0_uGHCnahXneQhwdmEdzUbUQGTLzCFwyxdpoz7jwD2hpLkLm18SInKQNMdb0nYg1GfyXbg1BRnbQVDogtlg6pNyPQanBSOhQWgzxtokkBmhtdb_IcCG9XobhSWsf0zTHbYB2Ni0EHCNtVMncOj7Psoc3dSb7ATd1rAYY7j3Z0_Ts07DBl2NWmFHMBtcKIjZzvpJ0iD0k7x__8sI-jRkSm6XPiAk4ENyrOCaIG-FhLp9nbNCOMDwAEZHLeu9i0AL-I5zjZQBhzUJZtu8Kw5oDmDJ620YM0Yp8DpQgKfbJNtmPJI6wCCivDqoIL_dv_xZn0iRZfJKNv_vCLk0YGPQ-MKtsA6bPfpweHiwhZTOKpwcc0VBdlVxuHfTp2hUzJfnn1ePAx8cYtXigK8n8a8PaR5vSz5UovuJgI_UHPsxd6U-A3ePigDYWKdKn5PGhgAvqBbOd516X0SoqglH30pajRh-0guDe7oRDYrQnjD5pk4jXSxzDoW8fdHhxvyjXiUCLZDDo8jCKJrABScv8MmKwaIrqhyMjFZOdPzIzMKnUDnA-L5GgERL2oVHM7xHqyKsWyZAhtPOsfmd7gj4ct8pfxVZKNBXk3PrdTq0Y

        */
        
        return view('api.index', [
            'userName'      => $userName,
            'accessTokens'  => $accessToken
        ]);
    }
}