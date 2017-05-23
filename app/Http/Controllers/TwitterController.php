<?php

namespace App\Http\Controllers;

class TwitterController extends Controller implements ModuleInterface
{

    public function execute($name, $limit, $message)
    {
        $string = "";
        $twitterAPI = new TwitterAPI($name, $limit);
        $twitterContent = $twitterAPI->getContent(false, false, "recent");

        if (sizeof($twitterContent) > 0) {
            $string = $message . $name . ": " . $this->getString($twitterContent);
        } else {
            $string = "Could not retrieve posts for the " . $name . " username";
        }
        return $string;
    }

    private function getString($array)
    {
        $string = "";
        for ($i = 0; $i < sizeof($array); $i++) {
            $string .= $this->cleanString($array[$i]->text) . " ";
        }
        return $string;
    }

    /**
     * Rebuild string without url characters
     *
     * @param $url
     * @return string
     */
    private function cleanString($url)
    {
        $stringArray = explode(" ", $url);
        $newString = "";
        foreach ($stringArray as $string) {
            if (strpos($string, "http://") === false && strpos($string, "https://") === false
                && strpos($string, "@") === false
            ) {

                if (strpos($string, "#") !== false) {
                    $newString .= str_replace("#", "", $string) . " ";
                } else {
                    $newString .= $string . " ";
                }
            }
        }

        return $newString;
    }
}
