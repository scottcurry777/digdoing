<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModerateController extends Controller
{
    public function index()
    {
        return view('moderate.index');
    }
}