<?php

namespace App\Test\Entity;

use App\Entity\Station;
use PHPUnit\Framework\TestCase;

class StationTest extends TestCase
{
    /**
     * @var Station
     */
    private $station;

    public function testStationCanHaveTurnstiles(): void
    {
        $this->assertEmpty($this->station->getTurnstiles());
    }


    protected function setUp(): void
    {
        $this->station = new Station('Sokolinaya Gora');
    }


}
