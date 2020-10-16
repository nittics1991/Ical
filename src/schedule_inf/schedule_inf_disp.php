<?php

declare(strict_types=1);

use schedule_inf\model\{
    ScheduleInfDispControllerModel,
    ScheduleInfDispFactory
};

require_once('login.php');

$pdo = _getDBConSingleton($configSystem);
$model = new ScheduleInfDispControllerModel(
    new ScheduleInfDispFactory($pdo)
);

$model->setQuery();

$model->buildCalendar();
$model->send();
