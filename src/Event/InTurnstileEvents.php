<?php


namespace App\Event;


use App\Entity\Passenger;

interface InTurnstileEvents
{

    public function cardApplied(Passenger $passenger): void;

    public function passengerEntered(Passenger $passenger): void;
}
