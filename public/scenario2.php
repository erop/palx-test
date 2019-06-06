<?php

use App\Entity\Metro;
use App\Entity\Passenger;
use App\Entity\Station;
use App\Entity\Turnstile\InTurnstile;

require __DIR__ . '/../vendor/autoload.php';

// passengers enters through turnstile

$metro = new Metro();
$redgate = new Station('Krasnye Vorota');
$redgate->addTurnstiles(new InTurnstile());

$passenger = new Passenger();
$enterableTurnstiles = $redgate->getEnterableTurnstiles();
$wrongTurnstile = $enterableTurnstiles[0];
try {
    $passenger->approachFromInside($wrongTurnstile);
} catch (TypeError $e) {
    echo 'Passenger can not exit through enterable-only turnstile. Sorry...' . PHP_EOL;
}


