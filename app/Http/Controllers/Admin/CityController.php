<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\City;

class CityController extends Controller
{
    // Fetch all city details
    public function getCityDetails()
    {
        $cities = City::all();
        return response()->json([
            'status' => true,
            'data' => $cities
        ], 200);
    }

    // Fetch states
    public function getStates()
    {
        $states = City::select('state')->distinct()->orderBy('state', 'asc')->get();
        return response()->json([
            'status' => true,
            'data' => $states
        ], 200);
    }

    // Fetch countries
    public function getCountries()
    {
        $countries = City::select('country')->distinct()->orderBy('state', 'asc')->get();
        return response()->json([
            'status' => true,
            'data' => $countries
        ], 200);
    }

    // Fetch cities by state or country (For dependent dropdown)
    public function getCitiesByStateOrCountry(Request $request)
    {
        $query = City::query();

        if ($request->has('state')) {
            $query->orderBy('city_name', 'asc')->where('state', $request->state);
        }

        if ($request->has('country')) {
            $query->orderBy('country', 'asc')->where('country', $request->country);
        }

        $cities = $query->get();

        return response()->json([
            'status' => true,
            'data' => $cities
        ], 200);
    }
}
