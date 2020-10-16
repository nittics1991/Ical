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
    *
    **/
    public function isValidMailAddressProvider()
    {
        return [
            [
                ['test@example.com' => 'テスト'],
                true,
            ],
            [
                ['test@example.com' => 1234],
                false,
            ],
            [
                ['test' => 'テスト'],
                false,
            ],
            
            //Validate::isEmailTextが数値を受け付けない
            /*
            [
                [1234 => 'テスト'],
                false,
            ],
            */
            [
                ['test@example.com' => 'テスト'],
                true,
            ],
            [
                [],
                true,
            ],
            [
                null,
                false,
            ],
            [
                [
                    'test@example.com' => 'テスト',
                    'test@example.com' => 'テスト',
                ],
                true,
            ],
            [
                [
                    'test@example.com' => 'テスト',
                    'test' => 'テスト'
                ],
                false,
            ],
        ];
    }
    
    /**
    *   @test
    *   @dataProvider isValidMailAddressProvider
    **/
    public function isValidMailAddress($value, $expect)
    {
//      $this->markTestIncomplete();
        
        $obj = new IcalendarEvent();
        
        $this->assertEquals(
            $expect,
            $this->callPrivateMethod(
                $obj,
                'isValidMailAddress',
                [$value]
            )
        );
        
        
    }
    
}
