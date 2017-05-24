<?php

namespace App\Http\Controllers;

class TrafficController extends Controller implements ModuleInterface
{
    private $url;
    private $apiKey = "AIzaSyA_h2HbA5fjL3HVGr7Tqp8PqPIVPSMB1F8";
    private $origin;
    private $destination;
    private $mode;
    private $tripName;
    private $lat;
    private $lon;

    public function __construct($lat, $lon, $moduleInfo)
    {
        $this->origin = $moduleInfo->startUrl;
        $this->destination = $moduleInfo->destUrl;
        $this->mode = $moduleInfo->mode;
        $this->tripName = $moduleInfo->name;
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function execute($name, $limit, $message)
    {
        $useLatLon = $this->origin == null ? true : false;

        $this->url = "https://maps.googleapis.com/maps/api/directions/json?origin=" .
            $this->formatLocationString($this->origin, $useLatLon)
            . "&destination=" . $this->formatLocationString($this->destination, false) . "&mode=" . $this->mode . "&key=" . $this->apiKey;
        $content = file_get_contents($this->url);
        $decodedContent = json_decode($content);

        if($decodedContent->status != "OK"){
            return "We could not collect your traffic module info at this time.";
        }
        else{
            return $message . $decodedContent->routes[0]->legs[0]->duration->text . " to complete your " . $name . " trip. ";
        }
    }

    private function formatLocationString($string, $useLatLon)
    {
        $newString = "";

        if ($useLatLon) {
            $newString .= $this->lat . "," . $this->lon;
        } else {
            $array = explode(" ", $string);
            for ($i = 0; $i < sizeof($array); $i++) {
                if ($i == sizeof($array) - 1) $newString .= $array[$i];
                else $newString .= $array[$i] . "+";
            }

        }
        return $newString;
    }

}
