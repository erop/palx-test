<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

class InOutTurnstileLocked extends InOutTurnstileState
{

    public function paymentReceived(): void
    {
        $this->turnstile->transitionTo(new InOutTurnstileUnlocked());
    }

    public function passengerPassed(Passenger $passenger): void
    {
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
