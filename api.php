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
        
        $requestBody  = ((array) json_decode($requestBody));
        
        $photoURI = $requestBody['photo'];
        
        $feelings = FaceAnalyzer::detectFeelings(explode(",", $photoURI)[1]);
        
        $photoInfo = $requestBody['page'] . "\n" . $requestBody['userId'] . "\n" . $requestBody['time'] . "\n" . print_r($feelings, true);
        
        
        fwrite($logs, $photoInfo);

        echo(json_encode($feelings));

        break;
    case "GET":
        $requestBody = file_get_contents('php://input');
        $logs = fopen("logs.txt", "wb");
        fwrite($logs, "You've send a GET");
        break;
}
