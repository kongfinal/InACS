<?php
session_start();

$from_timal = date("Y-m-d H:i:s");
$to_timal = $_SESSION["end_time"];

$timefirst = strtotime($from_timal);
$timesecound = strtotime($to_timal);

$differenceinsecounds=$timesecound-$timefirst

echo gmdate("H:i:s")
?>