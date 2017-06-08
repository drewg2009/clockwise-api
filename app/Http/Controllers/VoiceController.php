<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoiceController extends Controller
{
    public function getAllVoices(){
        $polly = new AmazonPollyController();
        $result = $polly->client->describeVoices();
        $voices = $result["Voices"];
        echo json_encode($voices);
    }
}
