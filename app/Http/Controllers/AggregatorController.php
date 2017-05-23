<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AggregatorController extends Controller
{
    private $finalString = "";

    public function __construct()
    {
    }

    public function executeAll(Request $request)
    {

        $moduleInfoDecoded = json_decode($request->moduleInfo);
        foreach ($moduleInfoDecoded as $key => $value) {
            switch ($key) {
                case "weather":
//                    $weather = new WeatherController($moduleInfoDecoded->lat, $moduleInfoDecoded->lon, $value);
//                    $weather->execute("",1,"");
                    break;
                case "tdih":
                    if ($value) {
                        $date = date("/m/d");
                        $history = new HistoryController($date);
                        $this->finalString .= $history->execute(null, null, "Here is what happened on this day in history: ") . " ";
                    }
                    break;
                case "quote":
                    if ($value) {
                        $quoteController = new QuoteController();
                        $this->finalString .= $quoteController->execute(null, null, "Here is the quote of the day. ") . ". ";

                    }
                    break;

                case "fact":
                    if ($value) {
                        $twitterController = new TwitterController();
                        $this->finalString .= $twitterController->execute("OddFunFacts", 1, "Here is the fun fact of the day from ") . ". ";
                    }
                    break;
                case "news":
                    foreach ($value as $subModule) {
                        $newsController = new NewsController();
                        $this->finalString .= $newsController->execute($subModule->category, $subModule->amount, "Here are the top news stories from ");
                    }
                    break;
                case "twitter":
                    foreach ($value as $subModule) {
                        $twitterController = new TwitterController();
                        $this->finalString .= $twitterController->execute($subModule->username, $subModule->amount, "Here are the twitter posts from ");
                    }
                    break;
                case "reddit":
                    foreach ($value as $subModule) {
                        $redditController = new RedditController();
                        $this->finalString .= $redditController->execute($subModule->subreddit, $subModule->amount, "Here are the top reddit posts from ");
                    }
                    break;
                case "countdown":
                    foreach ($value as $subModule) {
                        $countdownController = new CountdownController($subModule->date);
                        $this->finalString .= $countdownController->execute($subModule->event, null, "Countdown: ");
                    }
                    break;
                case "reminders":
                    foreach ($value as $subModule) {
                        $remindersController = new RemindersController($subModule->list);
                        $this->finalString .= $remindersController->execute($subModule->name, null, "Reminders: Here are your ");
                    }
                    break;
                case "traffic":
                    foreach ($value as $subModule) {
                        $trafficController = new TrafficController($moduleInfoDecoded->lat, $moduleInfoDecoded->lon, $subModule->list);
                        $this->finalString .= $trafficController->execute($subModule->name, null, "Traffic: It will ");
                    }
                    break;
                default:
                    break;
            }
        }


//        $redditController = new RedditController();
//        $twitterController = new TwitterController();
//        $countdownController = new CountdownController("March 16 2017");
//
//        $trafficController = new TrafficController("kent oh 44240", "columbus ohio", "driving");
//
//
//        $this->finalString .= $twitterController->execute("epochSoftware",5, "Here are the top posts from ") . ". ";
//        $this->finalString .= $redditController->execute("sports",3, "Here are the top reddit posts from ") . ". ";
//        $this->finalString .= $history->execute(null, null, "Here is what happened on this day in history: ");
//        //$this->finalString .= $weather->execute(null, null, "Weather:Here is the weather for the area: ");
////        $this->finalString .= $newsController->execute("Sports", 3, "Here are the top news stories from ");
////        $this->finalString .= $newsController->execute("Technology", 3, "Here are the top news stories from ");
////        $this->finalString .= $newsController->execute("Elections", 3, "Here are the top news stories from ");
////        $this->finalString .= $newsController->execute("Health", 3, "Here are the top news stories from ");
////        $this->finalString .= $newsController->execute("Business", 3, "Here are the top news stories from ");
////        $this->finalString .= $newsController->execute("Science", 3, "Here are the top news stories from ");
//        $this->finalString .= $trafficController->execute(null, null, "It will take you ");


        echo $this->finalString;
    }
}
