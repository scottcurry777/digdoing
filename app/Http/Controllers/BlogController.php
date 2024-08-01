<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        
        // The blog is for the website to post articles, such as 'Top things men love doing in 2020'
        
        $interests  = DB::table('interests')
            ->get();
            
        return view('blog.index', [
            'location'  => 'The World',
            'interests' => $interests
        ]);
    }
}