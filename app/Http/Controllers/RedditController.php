<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedditController extends Controller implements ModuleInterface
{
    private $url = "http://www.reddit.com/r/";
    private $ext = "/.rss";

    public function execute($name,$limit,$message)
    {

        $finalUrl = $this->url . $name . $this->ext;
        $xmlObject = XMLParserController::get_rss_item($finalUrl, $limit);
        if($xmlObject){
            return $message . $name . ". " . $this->getString($xmlObject);
        }
        else{
            return "Clockwise could not retrieve your reddit post info. ";
        }

    }

    private function getString($array){
        $string = "";
        for ($i=0;$i<sizeof($array);$i++){
            $string .= $array[$i]->title . ". ";
        }
        return $string;
    }
}
