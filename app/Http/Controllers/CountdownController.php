<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CountdownController extends Controller implements ModuleInterface
{

    private $eventDate;

    public function __construct($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    public function execute($name, $limit, $message)
    {
        $daysUntil = $this->getDaysUntil();
        if ($daysUntil == 0) return $message .= "Countdown for $name has been reached.";
        else if ($daysUntil == 1) return $message .= "There is $daysUntil day until $name.";
        else return $message .= "There are $daysUntil days until $name.";

    }

    private function getDaysUntil()
    {
        $now = strtotime(date('F D Y')) * 1000;
        $eventMs = strtotime($this->eventDate) * 1000;
        $msDiff = $eventMs - $now;
        return ceil($msDiff * .0000000115741);
    }


}
