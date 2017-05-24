<?php

namespace App\Http\Controllers;

class WeatherController extends Controller implements ModuleInterface
{
    private $latitude = "";
    private $longitude = "";
    private $info;
    private $finalUrl1;
    private $finalUrl2;
    private $finalUrl3;


    public function __construct($lat, $lon, $info)
    {
        $this->latitude = $lat;
        $this->longitude = $lon;
        $this->info = $info;
        $this->finalUrl1 = "http://api.openweathermap.org/data/2.5/weather?lat=" . $this->latitude . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&units=" . (($this->info->fahrenheit) ? "imperial" : "metric");
        $this->finalUrl2 = "http://api.openweathermap.org/data/2.5/forecast/daily?lat=" . $this->latitude . "" . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&cnt=1&mode=json" . "&units=" . (($this->info->fahrenheit) ? "imperial" : "metric");
        $this->finalUrl3 = "http://api.openweathermap.org/data/2.5/forecast?lat=" . $this->latitude . "" . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&units=" . (($this->info->fahrenheit) ? "imperial" : "metric");

    }


    public function execute($name, $limit, $message)
    {
        $string = "";
        $response1  = file_get_contents($this->finalUrl1);
        $response2 = file_get_contents($this->finalUrl2);
        if($response1 && $response2) {
            $currentTemp = (int)json_decode($response1)->main->temp;
            $jsonObj = json_decode($response2);
            $string = $message . $this->getString($jsonObj, $currentTemp);
        }
        else{
            $string = "Clockwise could not retrieve your weather info at this time. ";
        }

        return $string;
    }

    private function getString($jsonObj, $currentTemp)
    {
        $string = "";
        if(isset($jsonObj->city->name)) {
            $string .= $jsonObj->city->name . " area. ";
        }
        if($this->info->description){
            $string .= $jsonObj->list[0]->weather[0]->description . ". ";
        }
        if($this->info->currentTemp) {
            $string .= "It is currently " . $currentTemp . " degrees. ";
        }
        if($this->info->maxTemp){
            $string .= "The high today will be " . (int)$jsonObj->list[0]->temp->max . "degrees. ";
        }
        if(isset($jsonObj->list[0]->rain) && $jsonObj->list[0]->rain > 0 && isset($jsonObj->list[0]->snow) && $jsonObj->list[0]->snow > 0){
            $string .= "Expect rain and snow today. ";
        }
        else if(isset($jsonObj->list[0]->rain) && $jsonObj->list[0]->rain > 0){
            $string .= "Expect rain today. ";
        }
        else if(isset($jsonObj->list[0]->snow) && $jsonObj->list[0]->snow > 0){
            $string .= "Expect snow today. ";
        }

        return $string;

    }

}
