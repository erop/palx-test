<?php


namespace App\Entity;


use DomainException;

class MetroHasNoStationsAtAllException extends DomainException
{
    protected $message = 'Metro must have at least one station';
}
