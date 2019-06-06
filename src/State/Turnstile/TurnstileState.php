<?php


namespace App\State\Turnstile;


use App\Entity\Turnstile\Turnstile;

abstract class TurnstileState
{
    /**
     * @var Turnstile
     */
    protected $turnstile;

    /**
     * @param mixed $turnstile
     */
    public function setTurnstile($turnstile): void
    {
        $this->turnstile = $turnstile;
    }

    protected function print(string $message): void
    {
        echo $message . PHP_EOL;
    }

}
