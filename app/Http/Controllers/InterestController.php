<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InterestController extends Controller
{
    // TODO: When adding slug_search, make it all lowercase.  It can be comma, semicolon, or space separated (doesn't matter)
    
    public function index()
    {
        return view('interest.index');
    }
    
    public function getInterest(Request $request)
    {
        $interest           = $request->segment(1);
        $interestRoute      = $request->segment(2);
        $country            = $request->segment(3);
        $state              = $request->segment(4);
        $location           = $request->segment(5);
        $locationName       = '';
        $locationAdverb     = 'in';
        $locationParentID   = '';
        $userJoined         = false;

        $interestData   = Cache::remember('interest_data_' . $interest, 86400, function () use ($interest) {
            return DB::table('interests')
                ->where('slug', $interest)
                ->first();
        });

        if (is_null($interestData)) {
            return view('interest.interestNotFound', [
                'isInterest'    => true,
                'interest'      => $interest,
            ]);
        }

        $interestData->color    = substr(dechex(crc32($interestData->slug)), 0, 6);

        $interestData->communitySize    = DB::table('user_interests')
            ->where('interest_id', $interestData->id)
            ->count();
        
        if (Auth::id()) {
            $hasUserJoined  = DB::table('user_interests')
                ->where('interest_id', $interestData->id)
                ->where('user_id', Auth::id())
                ->count();
            
            if ($hasUserJoined >= 1) {
                $userJoined = true;
            }
        }
        
        $countries  = DB::table('countries')
            ->select('fips', 'country')
            ->orderBy('country', 'asc')
            ->get();
        
        $states     = DB::table('states')
            ->select(
                'states.fips',
                'states.state',
                'countries.fips as country_fips'
            )
            ->leftJoin('countries', 'countries.id', 'states.country_id')
            ->orderBy('states.state', 'asc')
            ->get();
        
        if ($country) {
            $checkCountry   = DB::table('countries')
                ->select('name')
                ->where('fips', $country)
                ->first();
                
            if ($checkCountry) {
                $locationName   = $checkCountry->name;
                
                if ($state) {
                    $checkState = DB::table('states')
                        ->select('state')
                        ->where('fips', $state)
                        ->first();
                        
                    if ($checkState) {
                        $locationName   = $checkState->state;
                        
                        if ($location) {
                            $checkLocation  = DB::table('locations')
                                ->select(
                                    'locations.id',
                                    'locations.name',
                                    'locations.adverb'
                                )
                                ->leftJoin('states', 'states.id', 'locations.state_id')
                                ->leftJoin('countries', 'countries.id', 'states.country_id')
                                ->where('countries.fips', $country)
                                ->where('states.fips', $state)
                                ->where('locations.slug', $location)
                                ->first();
                            
                            if ($checkLocation) {
                                $locationParentID   = $checkLocation->id;
                                $locationName       = $checkLocation->name;
                                $locationAdverb     = $checkLocation->adverb;
                            } else {
                                $location   = null;
                            }
                        }
                    } else {
                        $state  = null;
                    }
                }
            } else {
                $country    = null;
            }
        }
            
        if ($interestRoute == 'locations') {
            return view('interest.locations', [
                'isInterest'            => true,
                'interest'              => $interestData,
                'userJoined'            => $userJoined,
                'country'               => $country,
                'countries'             => $countries,
                'state'                 => $state,
                'states'                => $states,
                'locationName'          => $locationName,
                'locationAdverb'        => $locationAdverb,
                'location'              => $location,
                'locationParentID'      => $locationParentID,
            ]);
        } elseif ($interestRoute == 'together') {
            // populate events from DB where location and interest match
            $calendar   = array();
            
            // populate looking for people to plan with where location and interest match
            $toPlan     = array();
            
            // populate looking for others to join already planned event where location and interest match
            $toJoin     = array();
            
            return view('interest.together', [
                'isInterest'            => true,
                'interest'              => $interestData,
                'userJoined'            => $userJoined,
                'country'               => $country,
                'countries'             => $countries,
                'state'                 => $state,
                'states'                => $states,
                'locationName'          => $locationName,
                'locationAdverb'        => $locationAdverb,
                'location'              => $location,
                'calendar'              => $calendar,
                'toPlan'                => $toPlan,
                'toJoin'                => $toJoin,
            ]);
        } elseif ($interestRoute == 'community') {
            // populate links where interest matches
            $links      = array();
            
            return view('interest.community', [
                'isInterest'            => true,
                'interest'              => $interestData,
                'userJoined'            => $userJoined,
                'country'               => $country,
                'countries'             => $countries,
                'state'                 => $state,
                'states'                => $states,
                'locationName'          => $locationName,
                'locationAdverb'        => $locationAdverb,
                'location'              => $location,
                'links'                 => $links,
            ]);
        } else {
            // this route is also 'discussion'
            
            // populate posts from DB where location and interest match
            $posts  = array();
            
            return view('interest.interest', [
                'isInterest'            => true,
                'interest'              => $interestData,
                'userJoined'            => $userJoined,
                'country'               => $country,
                'countries'             => $countries,
                'state'                 => $state,
                'states'                => $states,
                'locationName'          => $locationName,
                'locationAdverb'        => $locationAdverb,
                'location'              => $location,
                'posts'                 => $posts,
            ]);
        }
    }
}