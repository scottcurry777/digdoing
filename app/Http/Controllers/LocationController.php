<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index(Request $request, $country = '', $state = '', $location = '', $locationRoute = '')
    {
        $countries  = Cache::remember('all_countries', 86400, function () {
            return DB::table('countries')
                ->select('fips', 'country')
                ->orderBy('country', 'asc')
                ->get();
        });

        $states  = Cache::remember('all_states', 86400, function () {
            return DB::table('states')
                ->select(
                    'states.fips',
                    'states.state',
                    'countries.fips as country_fips'
                )
                ->leftJoin('countries', 'countries.id', 'states.country_id')
                ->orderBy('states.state', 'asc')
                ->get();
        });
            
        if ($location) {
            $locationDetails    = Cache::remember('location_details_' . $country . '_' . $state . '_' . $location, 86400, function () use ($country, $state, $location) {
                $return = DB::table('locations')
                    ->select(
                        'locations.id',
                        'locations.slug',
                        'locations.slug_search',
                        'locations.name',
                        'locations.alternatenames',
                        'locations.adverb',
                        'locations.image',
                        'locations.description',
                        'states.fips as state_fips',
                        'states.state as state',
                        'countries.fips as country_fips',
                        'countries.country as country'
                    )
                    ->leftJoin('states', 'states.id', 'locations.state_id')
                    ->leftJoin('countries', 'countries.id', 'states.country_id')
                    ->where('locations.slug', $location)
                    ->where('states.fips', $state)
                    ->where('countries.fips', $country)
                    ->first();

                if (!is_null($return)) {
                    $return->color  = substr(dechex(crc32($return->slug)), 0, 6);
                    $return->name   = ucwords(strtolower($return->name));
                }

                return $return;
            });

            if (is_null($locationDetails)) {
                return view('location.locationNotFound', [
                    'location'      => $location,
                ]);
            }

            $locationInterests    = Cache::remember('location_interests_' . $locationDetails->id, 86400, function () use ($locationDetails) {
                $return = DB::table('locations_interests')
                    ->select(
                        'locations_interests.thumbs_up',
                        'locations_interests.thumbs_down',
                        'locations_interests.rating',
                        'interests.id',
                        'interests.slug',
                        'interests.name',
                        'interests.image'
                    )
                    ->leftJoin('interests', 'interests.id', 'locations_interests.interest_id')
                    ->where('locations_interests.location_id', $locationDetails->id)
                    ->orderBy('locations_interests.rating', 'desc')
                    ->get();

                foreach ($return as $interestKey => $interestValue) {
                    $return[$interestKey]->color    = substr(dechex(crc32($interestValue->slug)), 0, 6);
                    $return[$interestKey]->name     = ucwords(strtolower($interestValue->name));
                }

                return $return;
            });

            if (Auth::id()) {
                foreach ($locationInterests as $locationInterest) {
                    $hasUserJoined  = DB::table('user_interests')
                        ->where('interest_id', $locationInterest->id)
                        ->where('user_id', Auth::id())
                        ->count();

                    if ($hasUserJoined >= 1) {
                        $locationInterest->userJoined   = true;
                    } else {
                        $locationInterest->userJoined   = false;
                    }
                }
            }

            // Testing of Vote
            /*
            foreach ($locationInterests as $locationInterestKey => $locationInterest) {
                $locationInterests[$locationInterestKey]->vote    = 'good'; // bad, neutral, good
            }
            */

            // Check for Location Route
            if ($locationRoute == 'things-to-do') {

                // TODO: Get Interests for Location

                return view('location.things-to-do', [
                    'location'              => $locationDetails,
                    'location_interests'    => $locationInterests,
                ]);
            } elseif ($locationRoute == 'community') {

                // TODO: Get Community Posts for Location

                return view('location.community', [
                    'location'              => $locationDetails,
                    'location_interests'    => $locationInterests,
                ]);
            } else if ($locationRoute == 'together') {

                // TODO: Get Calendar items for location

                return view('location.together', [
                    'location'              => $locationDetails,
                    'location_interests'    => $locationInterests,
                ]);
            } else {
                // No Location Route or Location Route not valid
                return view('location.location', [
                    'location'              => $locationDetails,
                    'location_interests'    => $locationInterests,
                ]);
            }
        }
        
        if ($state) {
            $stateDetails    = Cache::remember('state_details_' . $country . '_' . $state, 86400, function () use ($country, $state) {
                return  DB::table('states')
                    ->select(
                        'states.*',
                        'countries.fips as country_fips'
                    )
                    ->leftJoin('countries', 'countries.id', 'states.country_id')
                    ->where('states.fips', $state)
                    ->where('countries.fips', $country)
                    ->first();
            });

            if ($stateDetails) {
                return view('location.index', [
                    'location'      => $stateDetails->state,
                    'country'       => $stateDetails->country_fips,
                    'countries'     => $countries,
                    'state'         => $stateDetails->fips,
                    'states'        => $states,
                ]);
            }
        }
        
        if ($country) {
            $countryDetails = Cache::remember('country_details_' . $country, 86400, function () use ($country) {
                return DB::table('countries')
                    ->where('fips', $country)
                    ->first();
            });

            if ($countryDetails) {
                return view('location.index', [
                    'location'      => $countryDetails->name,
                    'country'       => $countryDetails->fips,
                    'countries'     => $countries,
                    'state'         => null,
                    'states'        => $states,
                ]);
            }
        }

        return view('location.index', [
            'location'      => 'The World',
            'country'       => null,
            'countries'     => $countries,
            'state'         => null,
            'states'        => $states,
        ]);
    }
}