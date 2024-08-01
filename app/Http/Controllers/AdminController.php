<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class
AdminController extends Controller
{
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            return view('admin.index');
        } else {
            // Unauthorized
            return view('index');
        }
    }
}