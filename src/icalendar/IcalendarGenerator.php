<?php

/**
*   IcalendarGenerator
*
*   @version 200711
*/

declare(strict_types=1);

namespace Icalendar;

use DateTime;
use DateTimeZone;
use RuntimeException;
use Spatie\IcalendarGenerator\Components\{
    Calendar,
    Event
};
use Icalendar\{
    IcalendarEvent,
    IcalendarObject,
    IcalendarGeneratorInterface
};

class IcalendarGenerator implements IcalendarGeneratorInterface
{
    /**
    *   event_property_maps
    *
    *   @var array [IcalendarEvent porp name => [Event name,method name]
    *   @example [
    *       'name2' => ['NAME1', [$this, 'methodName']],
    *   ]
    */
    private $event_property_maps = [
        'dt_start' => ['startAt', 'toDateTime'],
        'dt_end' => ['endsAt', 'toDateTime'],
        'dt_create' => ['createdAt', 'toDateTime'],
        'dt_update' => ['startAt', 'toDateTime'],
        'nm_description' => ['description', 'toText'],
        'nm_location' => ['address', 'toText'],
        'ar_organizer' => ['organizer', 'toAAddress'],
        'ar_attendee' => ['attendee', 'toAAddress'],
        'tm_alert' => ['alert', 'toAlertWithTime'],
        'nm_alert' => ['alert', 'toAlertWithMessage'],
    ];
    
    /**
    *   alert_data
    *
    *   @var mixed
    */
    private $alert_data;
    
    /**
    *   {inherit}
    *
    */
    public function send($icalendar)
    {
        if ($icalendar instanceof IcalendarObject) {
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
            );
            $this->resetAlert();
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
        $result = Event::create();
        
        foreach ($event as $name => $val) {
            list($event_method, $this_method) =
                $this->resolveIcalendarEvent($name);
            
            call_user_func(
                [$this, $this_method],
                $result,
                $event_method,
                $val
            );
        }
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
    
    /**
    *   toText
    *
    *   @param Event $event
    *   @param string $event_method
    *   @param string $val
    */
    private function toText(
        Event $event,
        string $event_method,
        string $val
    ) {
        call_user_func(
            [$event, $event_method],
            $val
        );
    }
    
    /**
    *   toAddress
    *
    *   @param Event $event
    *   @param string $event_method
    *   @param array $ar
    */
    private function toAddress(
        Event $event,
        string $event_method,
        string $array
    ) {
        foreach ($ar as $address => $text) {
            call_user_func(
                [$event, $event_method],
                $address,
                $text
            );
        }
    }
    
    /**
    *   toAlertWithTime
    *
    *   @param Event $event
    *   @param string $event_method
    *   @param int $time
    */
    private function toAlertWithTime(
        Event $event,
        string $event_method,
        int $time
    ) {
        if (!isset($this->alert_data)) {
            $this->alert_data = $time;
            return;
        }
        
        call_user_func(
            [$event, $event_method],
            $time,
            $this->alert_data
        );
        $this->resetAlert();
    }
    
    /**
    *   toAlertWithMessage
    *
    *   @param Event $event
    *   @param string $event_method
    *   @param string $message
    */
    private function toAlertWithMessage(
        Event $event,
        string $event_method,
        string $message
    ) {
        if (!isset($this->alert_data)) {
            $this->alert_data = $message;
            return;
        }
        
        call_user_func(
            [$event, $event_method],
            $this->alert_data,
            $message
        );
        $this->resetAlert();
    }
    
    /**
    *   resetAlert
    *
    */
    private function resetAlert()
    {
        $this->alert_data = null;
    }
}
