<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function ProcessLocationInterestVote(Request $request)
    {
        $locationInterest   = $request->input('location_interest');
        $vote               = $request->input('vote');
        $user               = Auth::user()->id;
        
        $currentRating  = DB::table('locations_interests')
            ->where('id', $locationInterest)
            ->first();
        
        if (!$currentRating) {
            // Location Interest Not Found
            return false;
        }
        
        $lastThumbsUp   = $currentRating->thumbs_up;
        $lastThumbsDown = $currentRating->thumbs_down;
        
        $currentVote    = DB::table('locations_interests_votes')
            ->where('location_interest_id', $locationInterest)
            ->where('user_id', $user)
            ->first();
        
        if ($currentVote) {
            $lastVote   = $currentVote->vote;
            
            switch ($lastVote) {
                case '1':
                    $newThumbsUp    = $lastThumbsUp - 1;
                    $newThumbsDown  = $lastThumbsDown;
                    break;
                case '0':
                    $newThumbsUp    = $lastThumbsUp - 1;
                    $newThumbsDown  = $lastThumbsDown - 1;
                    break;
                case '-1':
                    $newThumbsUp    = $lastThumbsUp;
                    $newThumbsDown  = $lastThumbsDown - 1;
                    break;
                default:
                    // Error in the Votes DB
                    return false;
            }
            
            switch ($vote) {
                case '1':
                    $newThumbsUp    = $newThumbsUp + 1;
                    break;
                case '0':
                    $newThumbsUp    = $newThumbsUp + 1;
                    $newThumbsDown  = $newThumbsDown + 1;
                    break;
                case '-1':
                    $newThumbsDown  = $newThumbsDown + 1;
                default:
                    // Invalid Vote Value
                    return false;
            }
            
            // Update Vote
            $update = DB::table('locations_interests_votes')
            ->where('location_interest_id', $locationInterest)
            ->where('user_id', $user)
            ->update([
                'vote'          => $vote,
                'updated_at'    => \Carbon\Carbon::now()
            ]);
                
            if (!$update) {
                // The Update Failed
                return false;
            }
        } else {
            switch ($vote) {
                case '1':
                    $newThumbsUp    = $lastThumbsUp + 1;
                    $newThumbsDown  = $lastThumbsDown;
                    break;
                case '0':
                    $newThumbsUp    = $lastThumbsUp + 1;
                    $newThumbsDown  = $lastThumbsDown + 1;
                    break;
                case '-1':
                    $newThumbsUp    = $lastThumbsUp;
                    $newThumbsDown  = $lastThumbsDown + 1;
                default:
                    // Invalid Vote Value
                    return false;
            }
            
            // Insert Vote
            $insert = DB::table('locations_interests_votes')
            ->update([
                'location_interest_id'  => $locationInterest,
                'user_id'               => $user,
                'vote'                  => $vote,
                'created_at'            => \Carbon\Carbon::now()
            ]);
                
            if (!$insert) {
                // The Insert Failed
                return false;
            }
        }
        
        $newRating  = $newThumbsUp / ($newThumbsUp + $newThumbsDown);
        $newRating  = round($newRating, 2);
        
        // Update Rating
        
        $update = DB::table('locations_interests')
            ->where('id', $locationInterest)
            ->update([
                'thumbs_up'     => $newThumbsUp,
                'thumbs_down'   => $newThumbsDown,
                'rating'        => $newRating,
                'updated_at'    => \Carbon\Carbon::now()
            ]);
        
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    
}