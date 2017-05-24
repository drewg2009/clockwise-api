<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller implements ModuleInterface
{
    //private  $url = "http://www.infoplease.com/rss/dayinhistory.rss";
    //private $url = "http://feeds.feedburner.com/historyorb/todayinhistory?format=xml";
    //private $url ="http://www.history.com/this-day-in-history/rss";
    private $url = "http://history.muffinlabs.com/date";
    private $date;

    public function __construct($date)
    {
        $this->date = $date;
        $this->url .= $this->date;
    }

    public function execute($name, $limit, $message)
    {
        $content  = file_get_contents($this->url);
        if($content) {
            $jsonObj = json_decode($content);
            $randRange = sizeof($jsonObj->data->Events) - 1; //index starts at 0
            $index = rand(0, $randRange);
            return $message . " " . $jsonObj->data->Events[$index]->text;
        }
        else{
            return "Clockwise could not retrieve your history module info. ";
        }
    }


}
