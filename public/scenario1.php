<?php

use App\Entity\Metro;
use App\Entity\Passenger;
use App\Entity\Station;
use App\Entity\Turnstile\InOutTurnstile;
use App\Entity\Turnstile\InTurnstile;
use App\Entity\Turnstile\OutTurnstile;

require __DIR__ . '/../vendor/autoload.php';

// passengers enters through turnstile

$metro = new Metro();
$mayakovka = new Station('Mayakovskaya');
$mayakovka->addTurnstiles(new InTurnstile(), new InOutTurnstile(), new OutTurnstile());

$tverskaya = new Station('Tverskaya');
$tverskaya->addTurnstiles(new OutTurnstile());

$metro->addStations($mayakovka, $tverskaya);

$passenger = new Passenger();
$stationsAvailable = $passenger->chooseEnterableStations($metro);
if (count($stationsAvailable) === 0) {
    exit('No available stations to enter. Sorry... Finishing execution...');
}
/** @var Station $station */
$station = $stationsAvailable[0];
$turnstile = $station->getEnterableTurnstiles()[0];
$passenger->earn(100);
$passenger->topUpCard(60);
$passenger->applyCardTo($turnstile);
$passenger->comeInsideThrough($turnstile);

