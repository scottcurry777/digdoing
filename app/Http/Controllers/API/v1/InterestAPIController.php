<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InterestAPIController extends Controller
{
    public function getInterests()
    {
        // Update most popular interests once a day.  Clear this cache if a new interest is added.
        $interests  = Cache::remember('all_interests', 86400, function () {
            // Sort by most popular
            $results    = DB::table('interests')
                ->selectRaw('
                    interests.*,
                    count(user_interests.user_id) as num_users,
                    count(locations_interests.location_id) as num_locations
                ')
                ->leftJoin('user_interests', 'user_interests.interest_id', 'interests.id')
                ->leftJoin('locations_interests', 'locations_interests.interest_id', 'interests.id')
                ->groupBy('interests.id')
                ->orderBy('num_users', 'desc')
                ->orderBy('num_locations', 'desc')
                ->get();

            foreach ($results as $interestKey => $interestValue) {
                $results[$interestKey]->color   = substr(dechex(crc32($interestValue->slug)), 0, 6);
                $results[$interestKey]->name    = ucwords(strtolower($interestValue->name));
            }

            return $results;
        });

        return $interests;
    }

    public function getInterestLocations(Request $request)
    {
        $interestID         = $request->input('interestID');
        $country            = $request->input('country');
        $state              = $request->input('state');
        $locationParentID   = $request->input('locationParentID');

        $interestLocations  = Cache::remember('interest_locations_' . $interestID . '_country_' . $country . '_state_' . $state . '_location_' . $locationParentID, 86400, function () use ($interestID, $country, $state, $locationParentID) {

            $interestLocationsQuery = DB::table('locations_interests')
                ->select(
                    'locations_interests.thumbs_up',
                    'locations_interests.thumbs_down',
                    'locations_interests.rating',
                    'locations.slug',
                    'locations.name',
                    'locations.alternatenames',
                    'locations.image',
                    'states.fips as state_fips',
                    'states.state as state',
                    'countries.fips as country_fips',
                    'countries.country as country'
                )
                ->leftJoin('locations', 'locations.id', 'locations_interests.location_id')
                ->leftJoin('states', 'states.id', 'locations.state_id')
                ->leftJoin('countries', 'countries.id', 'states.country_id')
                ->where('locations_interests.interest_id', $interestID);

            if ($country) {
                $interestLocationsQuery->where('countries.fips', $country);
                if ($state) {
                    $interestLocationsQuery->where('states.fips', $state);
                    if ($locationParentID) {
                        // Show locations in that location.  i.e. parks in a city
                        $interestLocationsQuery->where('locations.parent_id', $locationParentID);
                    }
                }
            }

            $return = $interestLocationsQuery
                ->orderBy('locations_interests.rating', 'desc')
                ->get();

            foreach ($return as $interestLocationKey => $interestLocation) {
                $return[$interestLocationKey]->color    = substr(dechex(crc32($interestLocation->slug)), 0, 6);
                $return[$interestLocationKey]->name     = ucwords(strtolower($interestLocation->name));
            }

            // Testing of Ratings
            /*
            foreach ($return as $interestLocationKey => $interestLocation) {
                $return[$interestLocationKey]->rating    = '0.83';
            }
            */

            // Testing of Vote
            /*
            foreach ($return as $interestLocationKey => $interestLocation) {
                $return[$interestLocationKey]->vote    = 'good'; // bad, neutral, good
            }
            */

            return $return;
        });

        return $interestLocations;
    }

    public function joinCommunity(Request $request)
    {
        $interest   = $request->input('interest');
        $user       = Auth::user()->id;

        if (
            (!$interest)
            or (!$user)
        ) {
            // Required Parameters Missing
            return false;
        }

        $checkUser      = DB::table('users')
            ->where('id', $user)
            ->first();

        if (!$checkUser) {
            // Bad User ID
            return false;
        }

        $checkInterest  = DB::table('interests')
            ->where('id', $interest)
            ->first();

        if (!$checkInterest) {
            // Bad Interest ID
            return false;
        }

        $checkUserInterest  = DB::table('user_interests')
            ->where('user_id', $user)
            ->where('interest_id', $interest)
            ->first();

        if (!$checkUserInterest) {
            $insert = DB::table('user_interests')
                ->insert([
                    'user_id'       => $user,
                    'interest_id'   => $interest,
                    'created_at'    => \Carbon\Carbon::now()
                ]);

            if (!$interest) {
                return false;
            }
        }

        return true;
    }

    public function leaveCommunity(Request $request)
    {

    }

}