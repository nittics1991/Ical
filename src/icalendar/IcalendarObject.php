<?php

/**
*   IcalendarObject
*
*   @version 200711
*/
declare(strict_types=1);

namespace Icalendar;

use Icalendar\IcalendarEvent;
use IteratorAggregate;

class IcalendarObject implements IteratorAggregate
{
    /**
    *   events
    *
    *   @var array
    */
    protected array $events = [];
    
    /**
    *   add
    *
    *   @param IcalendarEvent $event
    *   @return $this
    */
    public function add(IcalendarEvent $event): IcalendarCollection
    {
        $this->events[] = $event;
        return $this;
    }
    
    /**
    *   {inherit}
    *
    */
    public function getIterator()
    {
        foreach ($this->events as $event) {
            yield $event;
        }
    }
}
