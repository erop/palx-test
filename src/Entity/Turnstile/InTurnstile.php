<?php


namespace App\Entity\Turnstile;


use App\Event\InTurnstileEvents;
use App\State\Turnstile\InTurnstileLocked;
use App\State\Turnstile\InTurnstileState;

class InTurnstile extends Turnstile implements InTurnstileEvents
{
    /**
     * @var InTurnstileState
     */
    protected $state;

    use InTurnstileTrait;

    public function __construct(InTurnstileState $state = null)
    {
        parent::__construct($state ?? new InTurnstileLocked());
    }


}
