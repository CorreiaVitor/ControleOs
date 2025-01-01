<?php

use Src\Controller\ChamadoCtrl;

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

$dados = (new ChamadoCtrl)->MostrarDadosChamadoCtrl();



?>