<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $type       = $request->input('t');
        $search     = $request->input('q'); // query
        $return     = $request->input('r');
        $start      = $request->input('f'); // from number
        $limit      = $request->input('n'); // number
        $country    = $request->input('c');
        $state      = $request->input('s');
        $location   = $request->input('l');
        $interest   = $request->input('i');
        
        $results    = array();
        
        if (
            (!$limit)
            or (!is_numeric($limit))
            or ($limit > 100)
        ) {
            $limit  = 100;
        }
        
        if ($type == 'locations') {
            if ($search) {
                $results    = Cache::remember('search_results_locations_country_' . $country . '_state_' . $state . '_slug_' . $search . '_limit_' . $limit, 86400, function () use ($search, $country, $state, $limit) {
                    $searchQuery    = DB::table('locations')
                        ->select(
                            'locations.*',
                            'states.fips as state_id',
                            'states.state',
                            'countries.fips as country_id',
                            'countries.country'
                        )
                        ->leftJoin('states', 'states.id', 'locations.state_id')
                        ->leftJoin('countries', 'countries.id', 'states.country_id')
                        ->where('locations.slug', 'like', $search . '%')
                        ->take($limit);

                    if ($country) {
                        $searchQuery->where('countries.fips', $country);
                    }

                    if ($state) {
                        $searchQuery->where('states.fips', $state);
                    }

                    if ($limit) {
                        $searchQuery->take($limit);
                    }

                    $return = $searchQuery->get();

                    foreach ($return as $searchKey => $searchValue) {
                        $return[$searchKey]->name   = ucwords(strtolower($searchValue->name));
                    }

                    return $return;
                });
            } else {
                $results    = Cache::remember('search_results_locations_limit_' . $limit, 86400, function () use ($limit) {
                    return DB::table('locations')
                        ->take($limit)
                        ->get();
                });
            }
        }
        
        if ($return == 'json') {
            return json_encode($results);
        } else {
            return view('search.index', [
                'results'   => $results
            ]);
        }
    }
    
}