<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

class OutTurnstileLocked extends OutTurnstileState
{

    public function passengerApproached(Passenger $passenger)
    {
        $this->turnstile->transitionTo(new OutTurnstileUnlocked());
    }

    public function passengerComeOut(Passenger $passenger)
    {
        // TODO: Implement passengerComeOut() method.
    }
}
