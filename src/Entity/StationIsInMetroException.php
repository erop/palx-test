<?php


namespace App\Entity;


use DomainException;

class StationIsInMetroException extends DomainException
{
    protected $message = 'Station with this name is already in the metro';
}
