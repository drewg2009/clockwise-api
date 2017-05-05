<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrafficController extends Controller implements ModuleInterface
{
    private $url;
    private $apiKey = "AIzaSyDTr4kNRhwbVgi7NFlNstgnuOUxcVFC3gs";
    private $origins;
    private $destinations;
    private $mode;

    public function __construct($origins, $destinations, $mode)
    {
        $this->origins = $origins;
        $this->destinations = $destinations;
        $this->mode = $mode;
    }

    public function execute($name, $limit, $message)
    {
        $this->url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
            $this->formatLocationString($this->origins)
            . "&destinations=" . $this->formatLocationString($this->destinations) . "&mode=" . $this->mode .  "&key=" . $this->apiKey;
        $content = file_get_contents($this->url);
        $decodedContent = json_decode($content);

        return $message . $decodedContent->rows[0]->elements[0]->duration->text . " to travel from "
            . $this->origins . " to " . $this->destinations . " by " . $this->mode . ".";

    }

    private function formatLocationString($string){
        $array = explode(" ", $string);
        $newString = "";
        for($i = 0; $i < sizeof($array); $i++){
            if($i == sizeof($array) - 1) $newString .= $array[$i];
            else $newString .= $array[$i] . "+";
        }
        return $newString;
    }

}
