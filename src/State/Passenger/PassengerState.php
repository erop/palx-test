<?php


namespace App\State\Passenger;


use App\Entity\Passenger;

abstract class PassengerState
{
    /**
     * @var Passenger
     */
    private $passenger;

    /**
     * @param Passenger $passenger
     */
    public function setPassenger(Passenger $passenger): void
    {
        $this->passenger = $passenger;
    }


}
