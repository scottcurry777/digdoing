<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        
        // News are newsworth articles, or articles that have come from other news sources
        
        $interests  = DB::table('interests')
            ->get();
            
        return view('news.index', [
            'location'  => 'The World',
            'interests' => $interests
        ]);
    }
}