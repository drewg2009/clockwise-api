<?php

namespace App\Http\Controllers;


class NewsController extends Controller implements ModuleInterface
{
    private $url;
    private $linksArray;


    public function __construct()
    {
        $this->linksArray = array(

            "Top" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss",
            "Sports" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=s&output=rss",
            "Business" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=b&output=rss",
            "Technology" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=tc&output=rss",
            "Science" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=snc&output=rss",
            "Health" => "http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=m&output=rss",
            "Elections" => "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=tc&output=rss"

        );

    }

    public function execute($name, $limit, $message)
    {
        $this->url = $this->linksArray[$name];
        $xmlObject = XMLParserController::get_rss_item($this->url, $limit);
        if($xmlObject){
            return $message . $name . ". " . $this->getString($xmlObject);
        }
        else{
            return "Clockwise could not retrieve your news module info. ";
        }
    }

    private function getString($array)
    {
        $string = "";
        for ($i = 0; $i < sizeof($array); $i++) {
            $string .= $array[$i]->title . ". ";
        }
        return $string;
    }
}
