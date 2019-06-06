<?php

namespace App\Test\Entity;

use App\Entity\Metro;
use App\Entity\MetroHasNoStationsAtAllException;
use App\Entity\Station;
use App\Entity\StationIsInMetroException;
use PHPUnit\Framework\TestCase;

class MetroTest extends TestCase
{
    /**
     * @var Metro
     */
    private $metro;

    public function testMetroMustHaveAtLeastOneStation(): void
    {
        $this->expectException(MetroHasNoStationsAtAllException::class);
        count($this->metro->getStations());
    }

    public function testMetroCanAddStations(): void
    {
        $station1 = new Station('Novonikolskaya');
        $this->metro->addStations($station1);
        $this->assertCount(1, $this->metro->getStations());
        $this->expectException(StationIsInMetroException::class);
        $this->metro->addStations($station1);
        $station2 = new Station('Staroperdunskay');
        $this->metro->addStations($station2);
        $this->assertCount(2, $this->metro->getStations());
    }


    protected function setUp(): void
    {
        $this->metro = new Metro();
    }


}
