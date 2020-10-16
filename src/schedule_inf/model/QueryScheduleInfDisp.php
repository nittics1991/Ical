<?php

/**
*   QUERY
*
*   @version 200711
*/

namespace schedule_inf\model;

use Concerto\standard\Query;
use Concerto\Validate;

class QueryScheduleInfDisp extends Query
{
    /**
    *   Columns
    *
    *   @val array
    */
    protected static $schema = [
        'cd_tanto',
    ];
    
    public function isValidCd_tanto($val)
    {
        return Validate::isTanto($val);
    }
}
