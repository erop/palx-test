<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

class OutTurnstileUnlocked extends OutTurnstileState
{

    public function passengerApproached(Passenger $passenger)
    {
        // TODO: Implement passengerApproached() method.
    }

    public function passengerComeOut(Passenger $passenger)
    {
        // TODO: Implement passengerComeOut() method.
    }
}
