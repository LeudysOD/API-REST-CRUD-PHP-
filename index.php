<?php
include 'BD/BD.php';
include 'App/Request.php';

header("Access-Control-Allow-Origin *");

$requesting= new Request();
$requesting->execute();




?>