<?php
/**
 * Created by PhpStorm.
 * User: drewgallagher
 * Date: 5/31/17
 * Time: 9:36 PM
 */

namespace App\Http\Controllers;


class AmazonPollyController extends Controller
{
    private $awsAccessKeyId;
    private $awsSecretKey;
    private $credentials;
    public $client;

    public function  __construct()
    {

        $this->awsAccessKeyId = 'AKIAI6KMEBP6U7WOPWHA';
        $this->awsSecretKey = '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';
        $this->credentials = new \Aws\Credentials\Credentials($this->awsAccessKeyId, $this->awsSecretKey);
        $this->client = new \Aws\Polly\PollyClient([
            'version' => '2016-06-10',
            'credentials' => $this->credentials,
            'region' => 'us-east-1',
        ]);
    }

    public function getSpeech($voiceId, $text){
        $result = $this->client->synthesizeSpeech([
            'OutputFormat' => 'mp3',
            'Text' => $text,
            'TextType' => 'text',
            'VoiceId' => $voiceId,
        ]);
        return json_encode(base64_encode($result->get('AudioStream')->getContents()));
    }

    public function getIntroMessage(){
        $introMessage = "Hello. Clockwise is collecting your module info. Please wait one moment. ";
        echo $this->getSpeech("Joanna", $introMessage);
    }

    public function getErrorMessage(){
        $errorMessage = "Clockwise could not load your module information at this time. Please try again later. ";
        echo $this->getSpeech("Joanna", $errorMessage);
    }



}