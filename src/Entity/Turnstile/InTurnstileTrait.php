<?php


namespace App\Entity\Turnstile;


use App\Entity\Passenger;

trait InTurnstileTrait
{
    public function cardApplied(Passenger $passenger): void
    {
        $passenger->payByCard();
        $this->state->paymentReceived();
    }

    public function passengerEntered(Passenger $passenger): void
    {
       $this->state->passengerPassed($passenger);
    }

}
