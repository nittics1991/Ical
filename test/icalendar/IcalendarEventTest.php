<?php

/**
*   IcalendarEvent
*
*   @version 200711
*/
declare(strict_types=1);

namespace test\icalendar;

use Concerto\test\ConcertoTestCase;
use Icalendar\IcalendarEvent;

class IcalendarEventTest extends ConcertoTestCase
{
    /**
    *   @test
    **/
    public function first()
    {
//      $this->markTestIncomplete();
        
        $obj = new IcalendarEvent();
        $obj->dt_start = '20191031 123456';
        
        $this->assertEquals('20191031 123456', $obj->dt_start);
        
        
    }
    
}
