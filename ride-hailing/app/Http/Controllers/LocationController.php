<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\SubCounty;
use Illuminate\Http\Request;

// LocationController.php

class LocationController extends Controller
{
    // Get all counties
    public function getCounties()
    {
        // Get all county names
        $counties = County::pluck('name'); // Use 'pluck' to return an array of names
        return response()->json($counties);
    }

    // Get sub-counties by county ID
    // LocationController.php
    public function getSubCounties(Request $request, $countyName)
    {
        $county = County::where('name', $countyName)->first();

        if (!$county) {
            return response()->json(['error' => 'County not found'], 404);
        }

        $subCounties = SubCounty::where('county_id', $county->id)->pluck('name');
        return response()->json($subCounties);
    }

}

