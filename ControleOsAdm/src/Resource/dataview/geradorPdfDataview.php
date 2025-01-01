<?php

include_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Src\public\Util;

Util::VerificarLogado();

use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

?>