<?php


namespace App\Entity\Turnstile;


use App\Event\OutTurnstileEvents;
use App\State\Turnstile\OutTurnstileLocked;
use App\State\Turnstile\OutTurnstileState;

class OutTurnstile extends Turnstile implements OutTurnstileEvents
{
    /**
     * @var OutTurnstileState
     */
    protected $state;

    use OutTurnstileTrait;

    public function __construct(OutTurnstileState $state = null)
    {
        parent::__construct($state ?? new OutTurnstileLocked());
    }



}
