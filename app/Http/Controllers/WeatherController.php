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
        $response  = file_get_contents($this->finalUrl2);
        $jsonObj  = json_decode($response);
//        dd($jsonObj);
        $string  = $this->getString($jsonObj);
        return $string;
    }

    private function getString($jsonObj)
    {
        $string = "Here is the weather for the " . $jsonObj->city->name . " area";
        if($this->info->description){

        }
        if($this->info->currentTemp) {
            $string .= "It is currently " . currentTemp . " degrees. ";
        }
//        if(getMaxTemp) sb.append("The high today will be " + (int)maxTemp + " degrees. ");
//        if(rain > 0 && snow > 0) sb.append("Expect rain and snow today. ");
//        else if (rain > 0) sb.append("Expect rain today. ");
//        else if (snow > 0) sb.append("Expect snow today. ");


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
