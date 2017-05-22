<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class RemindersController extends Controller implements ModuleInterface
{
    private $remindersList;

    public function  __construct($remindersList)
    {
        $this->remindersList = $remindersList;
    }

    public function execute($name, $limit, $message){

        return $message . $name . " reminders. " . $this->getString();
    }

    private function getString(){
        $string ="";
        $count = 0;
        $size = sizeof($this->remindersList);
        foreach($this->remindersList as $number => $item){
            if($size == 1) $string = $item . ". ";
            else{
                if($count == $size - 1){
                    $string = " and " . $item . ". ";
                }
                else{
                    $string .= $item . ", ";
                }
            }
            $count++;
        }
        return $string;
    }
}
