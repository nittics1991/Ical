<?php

/**
*   IcalendarObject
*
*   @version 200711
*/
declare(strict_types=1);

namespace test\Icalendar;

use Concerto\test\ConcertoTestCase;
use Icalendar\{
    IcalendarEvent,
    IcalendarObject
};

class IcalendarObjectTest extends ConcertoTestCase
{
    /**
    *
    **/
    public function addEventProvider()
    {
        return [
            [
                [
                    [
                        'dt_start' => '20210304',
                        'dt_end' => '20210305',
                    ],
                ],
            ],
            [
                [
                    [
                        'dt_start' => '20210304',
                        'dt_end' => '20210305',
                    ],
                    [
                        'dt_start' => '20210306',
                        'dt_end' => '20210307',
                    ],
                ],
            ],
        ];
    }
    
    /**
    *   @test
    *   @dataProvider addEventProvider
    **/
    public function addEvent($dataset)
    {
//      $this->markTestIncomplete();
        
        $obj = new IcalendarObject();
        
        foreach($dataset as $list) {
            $event = new IcalendarEvent();
            $event->fromArray($list);
            $obj->add($event);
        }
        
        $actual = [];
        
        foreach ($obj as $event) {
            $actual[] = $event->toArray();
        }
        
        $this->assertEquals($dataset, $actual);
    }
    
}
