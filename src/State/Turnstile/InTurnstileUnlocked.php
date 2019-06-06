<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;

class InTurnstileUnlocked extends InTurnstileState
{

    public function paymentReceived(): void
    {
        $this->print('You have already paid to enter the metro');
    }

    public function passengerPassed(Passenger $passenger): void
    {
        $this->print('Locking the turnstile after passenger come in');
        $this->turnstile->transitionTo(new InTurnstileLocked());
    }
}
