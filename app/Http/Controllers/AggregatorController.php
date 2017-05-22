<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AggregatorController extends Controller
{
    private $finalString = "";

    public function __construct()
    {
    }

    public function executeAll(Request $request){

        dd($request->moduleInfo);

        $quoteController = new QuoteController();
        $redditController = new RedditController();
        $twitterController = new TwitterController();
        $newsController = new NewsController();
        $countdownController = new CountdownController("March 16 2017");
        $history = new HistoryController("/03/15");
        $weather = new WeatherController(41.157, -81.35, false);
        $trafficController = new TrafficController("kent oh 44240", "columbus ohio", "driving");


        $this->finalString .= $quoteController->execute(null, null, "Here is the quote of the day. ") . ". ";
        $this->finalString .= $twitterController->execute("epochSoftware",5, "Here are the top posts from ") . ". ";
        //$this->finalString .= $twitterController->execute("OddFunFacts",1, "Here is the fun fact of the day from ") . ". ";
        $this->finalString .= $redditController->execute("sports",3, "Here are the top reddit posts from ") . ". ";
        $this->finalString .= $history->execute(null, null, "Here is what happened on this day in history: ");
        //$this->finalString .= $weather->execute(null, null, "Weather:Here is the weather for the area: ");
        $this->finalString .= $newsController->execute("Top", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Sports", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Technology", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Elections", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Health", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Business", 3, "Here are the top news stories from ");
//        $this->finalString .= $newsController->execute("Science", 3, "Here are the top news stories from ");
        $this->finalString .= $countdownController->execute("My Birthday", null, "Countdown: ");
        $this->finalString .= $trafficController->execute(null, null, "It will take you ");



        echo $this->finalString;
    }
}
