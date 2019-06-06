<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

abstract class OutTurnstileState extends TurnstileState
{
    abstract public function passengerApproached(Passenger $passenger);

    abstract public function passengerComeOut(Passenger $passenger);
}
