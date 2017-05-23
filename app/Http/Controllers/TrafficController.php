<?php

namespace App\Http\Controllers;

class TrafficController extends Controller implements ModuleInterface
{
    private $url;
    private $apiKey = "AIzaSyDTr4kNRhwbVgi7NFlNstgnuOUxcVFC3gs";
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

        $this->url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
            $this->formatLocationString($this->origin, $useLatLon)
            . "&destinations=" . $this->formatLocationString($this->destination, false) . "&mode=" . $this->mode . "&key=" . $this->apiKey;
        $content = file_get_contents($this->url);
        $decodedContent = json_decode($content);

        $string = "";
        if($useLatLon){
            $string ="";
        }
        else{
            $string = $message . $decodedContent->rows[0]->elements[0]->duration->text . " to travel fr"
            . $this->origin . " to " . $this->destination . " by " . $this->mode . ".";
        }
        return $string;

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
