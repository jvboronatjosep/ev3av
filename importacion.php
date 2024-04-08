<?php

require_once "autoloader.php";

$importacion = new Importar();
$importacion->customers();
$importacion->brandCustomer();
?>