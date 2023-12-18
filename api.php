<?php
require_once("./vendor/autoload.php");

header("Conten-Type:application/json");
$method = $_SERVER["REQUEST_METHOD"];

use Stormwind\FaceAnalyzer;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

switch($method) {
    case "POST":
        $requestBody = file_get_contents('php://input');

        $logs = fopen("logs.txt", "wb");

        //fwrite($logs, $requestBody);
        
        $requestBody  = ((array) json_decode($requestBody));
        
        $photoURI = $requestBody['photo'];
        
        $feelings = FaceAnalyzer::detectFeelings(explode(",", $photoURI)[1]);
        

        fwrite($logs, $requestBody['page'] . "\n" . print_r($feelings, true));

        echo(json_encode($feelings));

        break;
    case "GET":
        $requestBody = file_get_contents('php://input');
        $logs = fopen("logs", "wb");
        fwrite($log, "You've send a GET");
        break;
}