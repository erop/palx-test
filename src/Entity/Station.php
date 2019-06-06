<?php


namespace App\Entity;


use App\Entity\Turnstile\Turnstile;
use App\Event\InTurnstileEvents;

class Station
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Turnstile[]
     */
    private $turnstiles = [];

    /**
     * Station constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addTurnstiles(Turnstile...$turnstiles): void
    {
        foreach ($turnstiles as $turnstile) {
            $this->turnstiles[] = $turnstile;
        }
    }

    public function isEnterable(): bool
    {
        $enterableTurnstiles = array_filter($this->getTurnstiles(), static function (Turnstile $turnstile) {
            return $turnstile->isEnterable();
        });
        return count($enterableTurnstiles) > 0;
    }

    /**
     * @return Turnstile[]
     */
    public function getTurnstiles(): array
    {
        return $this->turnstiles;
    }

    /**
     * @return Turnstile[]|InTurnstileEvents[]
     */
    public function getEnterableTurnstiles(): array
    {
        return array_filter($this->getTurnstiles(), static function (Turnstile $turnstile) {
            return $turnstile->isEnterable();
        });
    }

}
