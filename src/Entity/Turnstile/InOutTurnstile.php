<?php


namespace App\Entity\Turnstile;


use App\Event\InTurnstileEvents;
use App\Event\OutTurnstileEvents;
use App\State\Turnstile\InOutTurnstileLocked;
use App\State\Turnstile\InOutTurnstileState;

class InOutTurnstile extends Turnstile implements InTurnstileEvents, OutTurnstileEvents
{
    use InTurnstileTrait, OutTurnstileTrait;

    public function __construct(InOutTurnstileState $state = null)
    {
        parent::__construct($state ?? new InOutTurnstileLocked());
    }


}
