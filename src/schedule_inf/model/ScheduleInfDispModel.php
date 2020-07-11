<?php

/**
*   Model
*
*   @version 200711
*/
declare(strict_types=1);

namespace schedule_inf\model;

use PDO;

class ScheduleInfDispModel
{
    /**
    *   object
    *
    *   @val object
    */
    protected $pdo;
    
    /**
    *   __construct
    *
    *   @param PDO
    */
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }
    
    /**
    *   getSchedule
    *
    *   @param string $cd_tanto
    *   @return array
    */
    private function getSchedule(string $cd_tanto): array
    {
        $sql = "
            
            
            
            
            
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':tanto', $cd_tanto, PDO::PARAM_STR);
        
        $dt_now = date('Ymd His');
        $stmt->bindValue(':now', $dt_now, PDO::PARAM_STR);
        
        $stmt->execute();
        return (array)$stmt->fetchAll();
    }
}
