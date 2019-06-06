<?php


namespace App\Event;


use App\Entity\Passenger;

interface OutTurnstileEvents
{
    public function lightCrossed(Passenger $passenger): void;

    public function passengerExited(Passenger $passenger): void;
}
