<?php

/**
*   IcalendarEvent
*
*   @version 200711
*/
declare(strict_types=1);

namespace Concerto\icalendar;

use Concerto\standard\{
    DataContainerValidatable,
    Validate
};

class IcalendarEvent extends DataContainerValidatable
{
    /**
    *   {inherit}
    */
    protected static $schema = [
        'dt_start',
        'dt_end',
        'dt_create',
        'dt_update',
        'nm_description',
        'nm_location',
        'ar_organizer',
        'ar_attendee',
        'tm_alert',
        'nm_alert',
    ];
    
    /**
    *
    */
    protected function isValidMailAddress($val)
    {
        if (!is_array($val)) {
            return false;
        }
        
        foreach ($val as $adr => $name) {
            if (!Validate::isEmailText($adr)) {
                return false;
            }
            if (!Validate::isText($name)) {
                return false;
            }
        }
        return true;
    }
    
    public function isValidDt_start($val)
    {
        return Validate::isTextDateTime($val);
    }
    
    public function isValidDt_end($val)
    {
        return Validate::isTextDateTime($val);
    }
    
    public function isValidDt_create($val)
    {
        return Validate::isTextDateTime($val);
    }
    
    public function isValidDt_update($val)
    {
        return Validate::isTextDateTime($val);
    }
    
    public function isValidNm_description($val)
    {
        return Validate::isText($val);
    }
    
    public function isValidNm_location($val)
    {
        if (!isset($val)) {
            return true;
        }
        return Validate::isText($val);
    }
    
    public function isValidAr_organizer($val)
    {
        return $this->isValidMailAddress($val);
    }
    
    public function isValidAr_attendee($val)
    {
        if (!isset($val) || $val === []) {
            return true;
        }
        return $this->isValidMailAddress($val);
    }
    
    public function isValidTm_alert($val)
    {
        if (!isset($val)) {
            return true;
        }
        return Validate::isInt($val);
    }
    
    public function isValidNm_alert($val)
    {
        if (!isset($val)) {
            return true;
        }
        return Validate::isText($val);
    }
}
