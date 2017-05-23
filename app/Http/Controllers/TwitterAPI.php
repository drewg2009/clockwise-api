<?php
/**
 * Created by PhpStorm.
 * User: drewgallagher
 * Date: 2/10/17
 * Time: 11:32 PM
 */

namespace App\Http\Controllers;

//already loaded in with Laravel application
//require "../../../vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterAPI
{

    private $CONSUMER_KEY = "wrojMyMfgEVTzpiEOJ2jOHm2v";
    private $CONSUMER_SECRET = "66fkiRnmi0CV9jY6hx3WpMWXDQjHfkruRvHY64DrLUEjxlF0mc";
    private $ACCESS_TOKEN = "768473595521544192-UixSDvDLq9JXW0oewox4ThTUiAdPD3N";
    private $ACCESS_TOKEN_SECRET = "THRfyxRT7CQyJYDqgaja9IKg7W8iMSzckmySMeRLZrnL7";
    private $name, $limit;

    public function __construct($name, $limit)
    {
        $this->name = $name;
        $this->limit = $limit;
    }

    /**
     * Make API Call to Twitter for tweet search of a certain account
     * Allow ability to exclude tweets that are retweets, replies, or mentions
     *
     * @return array of posts
     */
    public function getContent($excludeReplies, $mentions, $resultType)
    {
        $connection = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET, $this->ACCESS_TOKEN, $this->ACCESS_TOKEN_SECRET);
        $content = $connection->get("search/tweets", ["q" => "from:". $this->name, "exclude_replies" => $excludeReplies
            , "count" => $this->limit, "result_type" => $resultType]);
        $array = array();


        foreach($content->statuses  as $item){
            array_push($array, $item);
        }

        return $array;
    }

}