<?php


namespace App\Entity\Turnstile;


use App\Event\InTurnstileEvents;
use App\State\Turnstile\InTurnstileLocked;
use App\State\Turnstile\InTurnstileState;

class InTurnstile extends Turnstile implements InTurnstileEvents
{
    use InTurnstileTrait;
    /**
     * @var InTurnstileState
     */
    protected $state;

    public function __construct(InTurnstileState $state = null)
    {
        parent::__construct($state ?? new InTurnstileLocked());
    }
}
