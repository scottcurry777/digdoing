<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LocationAPIController extends Controller
{
    public function getLocations(Request $request, $country = '', $state = '')
    {
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
                $locations  = Cache::remember('state_locations_' . $stateDetails->id, 86400, function () use ($stateDetails) {
                    $return = DB::table('locations')
                        ->select(
                            'locations.id',
                            'locations.slug',
                            'locations.slug_search',
                            'locations.name',
                            'locations.alternatenames',
                            'locations.adverb',
                            'locations.image',
                            'states.fips as state',
                            'countries.fips as country'
                        )
                        ->selectRaw("count(locations_interests.id) as count_interests")
                        ->leftJoin('states', 'states.id', 'locations.state_id')
                        ->leftJoin('countries', 'countries.id', 'states.country_id')
                        ->leftJoin('locations_interests', 'locations_interests.location_id', 'locations.id')
                        ->where('locations.state_id', $stateDetails->id)
                        ->groupBy('locations.id')
                        ->orderByRaw("count(locations_interests.id) DESC")
                        ->take(100)
                        ->get();

                    foreach ($return as $locationKey => $locationValue) {
                        $return[$locationKey]->color    = substr(dechex(crc32($locationValue->slug)), 0, 6);
                        $return[$locationKey]->name     = ucwords(strtolower($locationValue->name));
                    }

                    return $return;
                });

                return $locations;
            }
        }

        if ($country) {
            $countryDetails = Cache::remember('country_details_' . $country, 86400, function () use ($country) {
                return DB::table('countries')
                    ->where('fips', $country)
                    ->first();
            });

            if ($countryDetails) {
                $locations  = Cache::remember('country_locations_' . $countryDetails->id, 86400, function () use ($countryDetails) {
                    // TODO: There are too many items (2.4 million +) to be able to sort in less than 30 seconds.  So leaving sorting off for now until we can get Elasticsearch working.

                    // TODO: Actually, run this nightly in a Kernel schedule and store as a DB View or something.  Then have this controller just pull the view.
                    $return = DB::table('locations')
                        ->select(
                            'locations.id',
                            'locations.slug',
                            'locations.slug_search',
                            'locations.name',
                            'locations.alternatenames',
                            'locations.adverb',
                            'locations.image',
                            'states.fips as state',
                            'countries.fips as country'
                        )
                        // ->selectRaw("count(locations_interests.id) as count_interests")
                        ->leftJoin('states', 'states.id', 'locations.state_id')
                        ->leftJoin('countries', 'countries.id', 'states.country_id')
                        // ->leftJoin('locations_interests', 'locations_interests.location_id', 'locations.id')
                        ->where('countries.id', $countryDetails->id)
                        // ->groupBy('locations.id')
                        // ->orderByRaw("count(locations_interests.id) DESC")
                        ->take(100)
                        ->get();

                    foreach ($return as $locationKey => $locationValue) {
                        $return[$locationKey]->color    = substr(dechex(crc32($locationValue->slug)), 0, 6);
                        $return[$locationKey]->name     = ucwords(strtolower($locationValue->name));
                    }

                    return $return;
                });

                return $locations;
            }
        }
        $locations  = Cache::remember('all_locations', 86400, function () {
            // TODO: There are too many items (2.4 million +) to be able to sort in less than 30 seconds.  So leaving sorting off for now until we can get Elasticsearch working.

            // TODO: Actually, run this nightly in a Kernel schedule and store as a DB View or something.  Then have this controller just pull the view.
            $return = DB::table('locations')
                ->select(
                    'locations.id',
                    'locations.slug',
                    'locations.slug_search',
                    'locations.name',
                    'locations.alternatenames',
                    'locations.adverb',
                    'locations.image',
                    'states.fips as state',
                    'countries.fips as country',
                )
                // ->selectRaw("count(locations_interests.id) as count_interests")
                ->leftJoin('states', 'states.id', 'locations.state_id')
                ->leftJoin('countries', 'countries.id', 'states.country_id')
                // ->leftJoin('locations_interests', 'locations_interests.interest_id', 'interests.id')
                // ->groupBy('locations.id')
                // ->orderByRaw("count(locations_interests.id) DESC")
                ->take(100)
                ->get();

            foreach ($return as $locationKey => $locationValue) {
                $return[$locationKey]->color    = substr(dechex(crc32($locationValue->slug)), 0, 6);
                $return[$locationKey]->name     = ucwords(strtolower($locationValue->name));
            }

            return $return;
        });

        return $locations;

    }

}