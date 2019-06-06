<?php


namespace App\Entity\Turnstile;


use App\Entity\Passenger;

trait OutTurnstileTrait
{

    public function lightCrossed(Passenger $passenger): void
    {
        $this->state->passengerApproached($passenger);
    }

    public function passengerExited(Passenger $passenger): void
    {
    }
}
