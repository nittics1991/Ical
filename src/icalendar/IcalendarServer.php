<?php

/**
*   IcalendarCollection
*
*   @version 200711
*/

namespace Concerto\icalendar;

use DateTime;
use DateTimeZone;
use RuntimeException;
use Spatie\IcalendarGenerator\Components\{
    Calendar,
    Event
};

use Concerto\icalendar\
    IcalendarEvent,
    IcalendarObject,
    IcalendarServerInterface
};

class IcalendarServer implements IcalendarServerInterface
{
    /**
    *   event_property_maps
    *
    *   @var array [IcalendarEvent porp name => [Event name,callback]
    *   @example [
    *       'name2' => ['NAME1', [$this, 'methodName']],
    *   ]
    */
    private $event_property_maps = [
        'dt_start' => ['startAt', [$this, 'toDateTime']],
        'dt_end' => ['endsAt', [$this, 'toDateTime']],
        'dt_create' => ['createdAt', [$this, 'toDateTime']],
        'dt_update' => ['startAt', [$this, 'toDateTime']],
        'nm_description' => ['description', [$this, 'toText']],
        'nm_location' => ['address', [$this, 'toText']],
        'ar_organizer' => ['organizer', [$this, 'toDateTime']],
        'ar_attendee' => ['attendee', [$this, 'toDateTime']],
        'no_priority' => ['startAt', [$this, 'toDateTime']],
        'tm_alert' => ['startAt', [$this, 'toDateTime']],
        'nm_alert' => ['startAt', [$this, 'toDateTime']],
    ];
    
    /**
    *   {inherit}
    *
    */
    public function send($icalendar)
    {
        if ($icalendar instanceof IcalendarObject::class) {
            throw new RuntimeException(
                "require IcalendarObject"
            );
        }
        $this->doSend($icalendar);
    }
    
    /**
    *   doSend
    *
    *   @param IcalendarObject $icalendar
    */
    private function doSend(IcalendarObject $icalendar)
    {
        $calendar = Calendar::create();
        
        foreach ($icalendar as $event) {
            $calendar->event(
                $this->buildEvent($event)
            )
        }
        $calendar->get();
    }
    
    /**
    *   buildEvent
    *
    *   @param IcalendarEvent $event
    *   @rutuen Event
    */
    private function buildEvent(IcalendarEvent $event): Event
    {
        $result = Event::create()
        
        foreach ($event as $name => $val) {
            list($event_method, $callback) =
                $this->resolveIcalendarEvent($name);
            
            call_user_func(
                $callback,
                $result,
                $event_method,
                $val
            );
        return $result;
    }
    
    /**
    *   resolveIcalendarEvent
    *
    *   @param string $name IcalendarEvent prop name
    *   @rutuen array [Event method name, callback]
    */
    private function resolveIcalendarEvent(string $name): array
    {
        return $this->event_property_maps[$name];
    }
    
    /**
    *   toDateTime
    *
    *   @param Event $event
    *   @param string $event_method
    *   @param string $val
    */
    private function toDateTime(
        Event $event,
        string $event_method,
        string $val
    ) {
        call_user_func(
            [$event, $event_method],
            DateTime::createFromFormat($val, '!Ymd His')
        );
    }
    
    
    
    
    
    
    
    
}
