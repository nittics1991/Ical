<?php

/**
*   factory
*
*   @version 200711
*/
namespace schedule_inf\model;

use \PDO;
use Concerto\conf\{
    Config,
    ConfigArray
};
use schedule_inf\model\{
    IcalendarEvent,
    IcalendarObject,
    IcalendarServer
};
use schedule_inf\model\{
    ScheduleInfDispModel,
    QueryScheduleInfDisp
};

class ScheduleInfDispFactory
{
    /**
    *   pdo
    *
    *   @val PDO
    */
    private $pdo;
    
    /**
    *   __construct
    *
    *   @param PDO $pdo
    */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    
    
    public function getPdo()
    {
        return $this->pdo;
    }
    
    public function getConfig()
    {
        return new Config(
            new ConfigArray(
                __DIR__ . '/../../_config/common/schedule_inf/schedule_inf_disp.php'
            )
        );
    }
    
    public function getWfConfig()
    {
        return new Config(
            new ConfigArray(
                __DIR__ . '/../../_config/common/wf_new2/wf_new_disp.php'
            )
        );
    }
    
    
    
    public function getCalendar()
    {
        return new IcalendarObject();
    }
    
    public function getEvent()
    {
        return new IcalendarEvent();
    }
    
    public function getServer()
    {
        return new IcalendarServer();
    }
    
    
    
    public function getQuery()
    {
        return new QueryScheduleInfDisp();
    }
    
    public function getModel()
    {
        return new ScheduleInfDispModel(
            $this->getPdo()
        );
    }
}
