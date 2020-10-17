<?php

/**
*   IcalendarGenerator
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

class IcalendarGeneratorTest extends ConcertoTestCase
{
    /**
    *
    **/
    public function eventDataProvider()
    {
        $csv_file = new SplFileObject(
            realpath(__DIR__ . '/data/IcalendarGeneratorTest.event.csv')
        );
        
        $dataset = [];
        
        foreach ($csv_file as $list) {
            $dataset[] = $
            
        }
        
        
        
        return [
            [
                [
                    [
                        'dt_start' => '20210304',
                        'dt_end' => '20210305',
                        
                        
                        
                        
                        
                    ],
                ],
            ],
        ];
    }
    
    
    
    
    
    
    
    /**
    *   @test
    *   @dataProvider resolveIcalendarEventProvider
    **/
    public function resolveIcalendarEvent($dataset)
    {
//      $this->markTestIncomplete();
        
        $obj = new IcalendarGenerator();
        
        
        
        
        
    }
    
    
    
    
    
    /**
    *
    **/
    public function toDateTimeProvider()
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
    *   @dataProvider toDateTimeProvider
    **/
    public function toDateTime($dataset)
    {
      $this->markTestIncomplete();
        
        $calendar = new IcalendarObject();
        
        foreach($dataset as $list) {
            $event = new IcalendarEvent();
            $event->fromArray($list);
            $calendar->add($event);
        }
        
        $obj = new IcalendarGenerator();
        
        $this->assertEquals(
            
            
            
        );
    }
    
}
