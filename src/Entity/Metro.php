<?php


namespace App\Entity;


class Metro
{
    public const TICKET_PRICE = 30;
    /**
     * @var array
     */
    private $stations = [];

    /**
     * Metro constructor.
     */
    public function __construct()
    {
    }

    public static function getTicketPrice(): int
    {
        return self::TICKET_PRICE;
    }

    public function addStations(Station... $stations): void
    {
        foreach ($stations as $station) {
            if ($this->isInMetro($station)) {
                throw new StationIsInMetroException();
            }
            $this->stations[] = $station;
        }
    }

    private function isInMetro(Station $givenStation): bool
    {
        foreach ($this->stations as $existingStation) {
            if ($existingStation->getName() === $givenStation->getName()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Station[]
     */
    public function getStations(): array
    {
        if (count($this->stations) < 1) {
            throw new MetroHasNoStationsAtAllException();
        }
        return $this->stations;
    }
}
