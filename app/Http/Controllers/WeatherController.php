<?php

namespace App\Http\Controllers;

class WeatherController extends Controller implements ModuleInterface
{
    private $latitude = "";
    private $longitude = "";
    private $isCelsius = "";
    private $finalUrl1;
    private $finalUrl2;
    private $finalUrl3;


    public function __construct($latitude, $longitude, $isCelisus)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->isCelsius = $isCelisus;
        $this->finalUrl1 = "http://api.openweathermap.org/data/2.5/weather?lat=" . $this->latitude . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&units=" . (($this->isCelsius) ? "metric" : "imperial");
        $this->finalUrl2 = "http://api.openweathermap.org/data/2.5/forecast/daily?lat=" . $this->latitude . "" . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&cnt=1&mode=json" . "&units=" . (($this->isCelsius) ? "metric" : "imperial");
        $this->finalUrl3 = "http://api.openweathermap.org/data/2.5/forecast?lat=" . $this->latitude . "" . "&lon=" . $this->longitude . "&APPID=fa18ccaa8bfec044e6bf94d88d7055dd&units=" . (($this->isCelsius) ? "metric" : "imperial");

    }


    public function execute($name, $limit, $message)
    {
        $string = "";
        $response  = file_get_contents($this->finalUrl1);
        $jsonobj  = json_decode($response);
        $string  = $this->getString();
        dd($jsonobj);
        return $string;
    }

    private function getString($array)
    {
//    {
//    sb.append("Weather:Here is the weather for the " + locationName + " area. ");
//        if(getDescription) sb.append(description + ". ");
//        if(getCurrentTemp) sb.append("It is currently " + (int)currentTemp + " degrees. ");
//        if(getMaxTemp) sb.append("The high today will be " + (int)maxTemp + " degrees. ");
//        if(rain > 0 && snow > 0) sb.append("Expect rain and snow today. ");
//        else if (rain > 0) sb.append("Expect rain today. ");
//        else if (snow > 0) sb.append("Expect snow today. ");
//        return sb.toString();

    }

}
