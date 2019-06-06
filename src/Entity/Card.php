<?php


namespace App\Entity;


class Card
{
    /**
     * @var int
     */
    private $balance = 0;

    /**
     * Card constructor.
     */
    public function __construct()
    {
    }

    public function add($amount): void
    {
        $this->balance += $amount;
    }

    public function withdrawTicket(): void
    {
        $ticketPrice = Metro::getTicketPrice();
        if (($positiveDelta = $ticketPrice - $this->getBalance()) > 0) {
            throw new NotEnoughMoneyOnCardException($positiveDelta);
        }
        $this->balance -= $ticketPrice;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}
