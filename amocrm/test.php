<?php

require_once 'Amo.php';
header('Content-type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$amo = new Amo('74957776675', 737850, 'fghjhgfdfgh');

$amo->test();

?>