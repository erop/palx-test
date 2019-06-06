<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

abstract class InOutTurnstileState extends TurnstileState
{
    abstract public function paymentReceived();

    abstract public function passengerPassed(Passenger $passenger);

    abstract public function passengerApproached(Passenger $passenger);

    abstract public function passengerComeOut(Passenger $passenger);
}
