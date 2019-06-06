<?php


namespace App\Entity;


use App\Entity\Turnstile\Turnstile;
use App\Event\InTurnstileEvents;
use App\Event\OutTurnstileEvents;

class Passenger
{

    /**
     * @var Card
     */
    private $card;

    /**
     * @var int
     */
    private $money;

    /**
     * Passenger constructor.
     * @param int  $money
     * @param Card $card
     */
    public function __construct(int $money = null, Card $card = null)
    {
        $this->card = $card ?? new Card;
        $this->money = $money ?? 0;
    }

    public function getCardBalance(): int
    {
        return $this->getCard()->getBalance();
    }

    public function getCard(): Card
    {
        return $this->card;
    }

    /**
     * @param Card $card
     */
    public function setCard(Card $card): void
    {
        $this->card = $card;
    }

    public function topUpCard($amount): void
    {
        if ($amount > $this->money) {
            throw new PassengerDoNotHaveEnoughMoneyException(sprintf('Not enough money to top-up card: you have %s, but need %s',
                $this->money, $amount));
        }
        $this->transferMoneyToCard($amount);
    }

    /**
     * @param $amount
     */
    private function transferMoneyToCard($amount): void
    {
        $this->money -= $amount;
        $this->getCard()->add($amount);
    }

    public function earn($amount): void
    {
        $this->money += $amount;
    }

    public function spend(int $amount): void
    {
        if ($amount > $this->getMoney()) {
            $template = 'You need %d more money to spend amount of %d';
            $message = sprintf($template, $amount - $this->getMoney(), $amount);
            throw new PassengerDoNotHaveEnoughMoneyException($message);
        }
        $this->money -= $amount;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * "Enter station" means
     * - select stations from metro
     *    - throw exception if not exists
     * - select turnstile to enter
     *    - throw exception if no enterable turnstiles
     * - apply card to turnstile
     * - if enough money on card let the passenger in
     * - if not enough money do not unlock turnstile
     * @param Metro  $metro
     * @param string $stationName
     */
    public function enterStation(Metro $metro, string $stationName)
    {

    }

    public function getEnterableStations(Metro $metro): array
    {
        return array_filter($metro->getStations(), static function (Station $station) {
            return $station->isEnterable();
        });
    }

    public function applyCardTo(InTurnstileEvents $turnstile): void
    {
        $turnstile->cardApplied($this);
    }

    public function comeInsideThrough(InTurnstileEvents $turnstile): void
    {
        $turnstile->passengerEntered($this);
    }

    public function payByCard(): void
    {
        $this->getCard()->withdrawTicket();
    }

    public function approachFromInside(OutTurnstileEvents $turnstile): void
    {
        $turnstile->lightCrossed($this);
    }

    public function chooseEnterableStations(Metro $metro): array
    {
        $result = [];
        foreach ($metro->getStations() as $station) {
            if ($station->isEnterable()) {
                $result[] = $station;
            }
        }
        return $result;
    }


    /**
     * @param Station $station
     * @return Turnstile\Turnstile[]|InTurnstileEvents[]|array
     */
    public function chooseEnterableTurnstiles(Station $station): array
    {
        return $station->getEnterableTurnstiles();
    }


}
