<?php


namespace App\State\Turnstile;


use App\Entity\Passenger;
use App\Entity\Turnstile\ProhibitedActionException;

class InTurnstileLocked extends InTurnstileState
{

    public function paymentReceived(): void
    {
        $this->print('Unlocking turnstile to let passenger come in');
        $this->turnstile->transitionTo(new InTurnstileUnlocked());
    }

    public function passengerPassed(Passenger $passenger): void
    {
        throw new ProhibitedActionException('You can not pass through locked turnstile');
    }

}
