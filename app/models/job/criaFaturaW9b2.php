<?php

require_once '../../../config/config.php';
require_once '../../../vendor/autoload.php';

use app\models\dao\CronDao;

$dao = new CronDao();
$dao->criaFatura();
echo 'fatura criada';