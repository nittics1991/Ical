<?php

/**
*   Controller Model
*
*   @version 200711
*/

declare(strict_types=1);

namespace schedule_inf\model;

use Concerto\standard\ControllerModel;
use schedule_inf\model\ScheduleInfDispFactory;

class ScheduleInfDispControllerModel extends ControllerModel
{
    /**
    *   名前空間
    *
    *   @val string
    */
    protected $namespace = 'schedule_inf';
    
    /**
    *   __construct
    *
    *   @param ScheduleInfDispFactory $factory
    */
    public function __construct(ScheduleInfDispFactory $factory)
    {
        parent::__construct($factory);
    }
    
    /**
    *   query処理
    *
    */
    public function setQuery()
    {
        $query = $this->factory->getQuery();
        
        if ($query->isValid()) {
            $this->session->cd_tanto = $query->cd_tanto ??
                $this->session->cd_tanto;
        }
    }
    
    /**
    *   buildCalendar
    *
    */
    public function buildCalendar()
    {
        $model = $this->factory->getModel();
        
        $schedule_list = $model->getSchedule(
            $this->session->cd_tanto
        );
        
        if (empty($schedule_list)) {
            return;
        }
        
        $this->calendar = $this->factory->getCalendar();
        $config = $this->factory->getConfig();
        $tm_alert = $config['tm_alert'] ?? null;
        $nm_alert = $config['nm_alert'] ?? null;
        
        foreach ($schedule_list as $list) {
            $event = $this->factory->getEvent();
            
            $event->dt_start = "{$list['dt_yyyymmdd']} 000000";
            $event->dt_end = "{$list['dt_yyyymmdd']} 235959";
            $event->dt_create = date('Ymd His');
            $event->dt_update = date('Ymd His');
            $event->nm_description =
                $list['no_cyu'] . '_'
                . $list['nm_syohin'] . '_'
                . $list['nm_setti'] . '_'
                . $this->resolveColumnName($list['cd_column']);
             
            $event->ar_organizer = [
                $list['mail_adr'] => $list['nm_tanto']
            ];
            
            if (isset($tm_alert) && isset($nm_alert)) {
                $event->tm_alert = $tm_alert;
                $event->nm_alert = $nm_alert;
            }
            
            if ($event->isValid()) {
                $this->calendar->add($event);
            }
        }
    }
    
    /**
    *   resolveColumnName
    *
    *   @param string $name
    *   @return string
    */
    private function resolveColumnName(string $name): string
    {
        static $config;
        
        if (!isset($config)) {
            $config = $this->facrtory->getWfConfig();
        }
        return $config[$name] ?? '';
    }
    
    /**
    *   send
    *
    */
    public function send()
    {
        if (!isset($this->calendar)) {
            return;
        }
        $server = $this->factory->getServer();
        $server->send($this->calendar);
    }
}
