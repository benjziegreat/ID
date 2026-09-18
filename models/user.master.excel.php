<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename={$_POST['SalesType']} Product Sales.xls");
header("Pragma: no-cache");

$buffer = $_POST['csvBuffer'];

echo $buffer;

?>