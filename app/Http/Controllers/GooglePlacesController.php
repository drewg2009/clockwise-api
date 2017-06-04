<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePlacesController extends Controller
{
    public function getNearbyLocations(Request $request)
    {
        $placesApiKey = "AIzaSyCCb7yaagbE_5Gujv9U5AQOYlVXF-R-QMo";
        $textSearchUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=";
        $result = file_get_contents($textSearchUrl . $this->formatLocationString($request->placesQuery) . "&key=" . $placesApiKey);
        echo $result;
    }

    private function formatLocationString($string)
    {
        $newString = "";
        $array = explode(" ", $string);
        for ($i = 0; $i < sizeof($array); $i++) {
            if ($i == sizeof($array) - 1) $newString .= $array[$i];
            else $newString .= $array[$i] . "+";
        }

        return $newString;
    }
}
