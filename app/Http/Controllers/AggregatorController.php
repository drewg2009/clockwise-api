<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AggregatorController extends Controller
{
    private $finalString = "";
    private $introMessage = "Hello. Clockwise is collecting your module info. Please wait one moment. ";
    private $errorMessage = "Clockwise could not load your module information at this time. Please try again later. ";

    public function __construct()
    {
    }

    public function executeAll(Request $request)
    {
        $moduleInfoDecoded = json_decode($request->moduleInfo);
        foreach ($moduleInfoDecoded as $key => $value) {
            switch ($key) {
                case "weather":
                    foreach ($value as $subModule) {
                        $weatherController = new WeatherController($moduleInfoDecoded->lat, $moduleInfoDecoded->lon, $subModule);
                        $this->finalString .= $weatherController->execute(null, null, "Here is the weather for the ");
                    }
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
                        $this->finalString .= $twitterController->execute("CrazyWowFacts", 1, "Here is the fun fact of the day from ") . ". ";
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
                        $trafficController = new TrafficController($moduleInfoDecoded->lat, $moduleInfoDecoded->lon, $subModule);
                        $this->finalString .= $trafficController->execute($subModule->name, null, "Traffic: It will take you ");
                    }
                    break;

                default:
                    break;
            }
        }



        $awsAccessKeyId = 'AKIAI6KMEBP6U7WOPWHA';
        $awsSecretKey = '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';
        $credentials = new \Aws\Credentials\Credentials($awsAccessKeyId, $awsSecretKey);
        $client = new \Aws\Polly\PollyClient([
            'version' => '2016-06-10',
            'credentials' => $credentials,
            'region' => 'us-east-1',
        ]);

        $speechArray = array();

        $contentResult = $client->synthesizeSpeech([
            'OutputFormat' => 'mp3',
            'Text' => $this->finalString,
            'TextType' => 'text',
            'VoiceId' => 'Joanna',
        ]);


        $errorResult = $client->synthesizeSpeech([
            'OutputFormat' => 'mp3',
            'Text' => $this->errorMessage,
            'TextType' => 'text',
            'VoiceId' => 'Joanna',
        ]);

        $introResult = $client->synthesizeSpeech([
            'OutputFormat' => 'mp3',
            'Text' => $this->introMessage,
            'TextType' => 'text',
            'VoiceId' => 'Joanna',
        ]);


        array_push($speechArray, base64_encode($contentResult->get('AudioStream')->getContents()));
        array_push($speechArray, base64_encode($errorResult->get('AudioStream')->getContents()));
        array_push($speechArray, base64_encode($introResult->get('AudioStream')->getContents()));



//        header('Content-Transfer-Encoding: binary');
//        header('Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3');
//        header('Content-length: ' . strlen($resultData));
//        header('Content-Disposition: attachment; filename="pollyTTS.mp3"');
//        header('X-Pad: avoid browser bug');
//        header('Cache-Control: no-cache');

        echo json_encode($speechArray);
    }
}
