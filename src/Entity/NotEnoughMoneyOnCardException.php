<?php


namespace App\Entity;


use LogicException;

class NotEnoughMoneyOnCardException extends LogicException
{
    /**
     * NotEnoughMoneyOnCardException constructor.
     * @param int $deficit
     */
    public function __construct(int $deficit)
    {
        $this->message = sprintf('You need %d more money on the card to enter metro', $deficit);
        parent::__construct();
    }
}
