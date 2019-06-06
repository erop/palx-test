<?php


namespace App\Entity\Turnstile;


use App\Event\InTurnstileEvents;
use App\Event\OutTurnstileEvents;
use App\State\Turnstile\TurnstileState;

abstract class Turnstile
{
    /**
     * @var TurnstileState
     */
    protected $state;

    /**
     * Turnstile constructor.
     * @param TurnstileState $state
     */
    public function __construct(TurnstileState $state)
    {
        $this->transitionTo($state);
    }

    public function transitionTo(TurnstileState $state): void
    {
        echo sprintf('Transitioning to state: %s', get_class($state)) . PHP_EOL;
        $this->state = $state;
        $this->state->setTurnstile($this);
    }

    public function getState(): TurnstileState
    {
        return $this->state;
    }

    /**
     * @param TurnstileState $state
     */
    public function setState(TurnstileState $state): void
    {
        $this->state = $state;
    }

    public function isEnterable(): bool
    {
        return ($this instanceof InTurnstileEvents);
    }

    public function isExitable(): bool
    {
        return ($this instanceof OutTurnstileEvents);
    }
}
