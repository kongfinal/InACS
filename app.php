<?php
$url = $_GET['url'];
if($url == ""){
    $url = 'login';
    require_once 'view/'.$url.'.php';
}else{
    require_once 'view/'.$url.'.php';
}