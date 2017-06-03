<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePlacesController extends Controller
{
    public function getNearbyLocations(Request $request)
    {
        $placesApiKey = "AIzaSyCCb7yaagbE_5Gujv9U5AQOYlVXF-R-QMo";
        $textSearchUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=";
        $result = file_get_contents($textSearchUrl . $request->placesQuery . "&key=" . $placesApiKey);
        echo json_encode($result);
    }
}
