<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

class InOutTurnstileUnlocked extends InOutTurnstileState
{

    public function paymentReceived()
    {
        // TODO: Implement paymentReceived() method.
    }

    public function passengerPassed(Passenger $passenger): void
    {
        $this->turnstile->transitionTo(new InOutTurnstileLocked());
    }

    public function passengerApproached(Passenger $passenger)
    {
        // TODO: Implement passengerApproached() method.
    }

    public function passengerComeOut(Passenger $passenger)
    {
        // TODO: Implement passengerComeOut() method.
    }
}
