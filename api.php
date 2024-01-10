<?php
require_once("./vendor/autoload.php");

header("Conten-Type:application/json");
$method = $_SERVER["REQUEST_METHOD"];

use Stormwind\FaceAnalyzer;
use Stormwind\QueryHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function insertRecord($record) {
    try {
        $handler = new QueryHandler();
        $handler->insertAnalysis($record);
    }catch(Exception $e) {
        error_log("ERROR: " . $e);
    }
}

switch($method) {
    case "POST":
        $requestBody = file_get_contents('php://input');
        
        $logs = fopen("logs.txt", "wb");
        $requestBody  = ((array) json_decode($requestBody));
        
        $photoURI = $requestBody['photo'];
        $feelings = FaceAnalyzer::detectFeelings(explode(",", $photoURI)[1]); 

        $photoInfo = $requestBody['page'] . "\n" . $requestBody['userId'] . "\n" . $requestBody['time'] . "\n" . print_r("", true) . "\n" . print_r($feelings, true);
        fwrite($logs, $photoInfo);

        $recordDetails = new stdClass();
        $recordDetails->user_id = $requestBody['userId'];
        $recordDetails->timestamp = $requestBody['time'];
        $recordDetails->page = $requestBody['page'];
        $recordDetails->sentiment = $feelings[0]["Type"];
        insertRecord($recordDetails);

        break;
    case "GET":
        $requestBody = file_get_contents('php://input');
        $logs = fopen("logs.txt", "wb");
        fwrite($logs, "You've send a GET");
        break;
}
