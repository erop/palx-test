<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

abstract class InTurnstileState extends TurnstileState
{
    abstract public function paymentReceived();

    abstract public function passengerPassed(Passenger $passenger);
}
