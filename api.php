<?php
require_once("./vendor/autoload.php");

header("Conten-Type:application/json");
$method = $_SERVER["REQUEST_METHOD"];

use Stormwind\FaceAnalyzer;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function insert_record($database, $record) {
    require_once(__DIR__ . '/../../config.php');
    global $DB;
    $DB->insert_record($database, $record);
}

switch($method) {
    case "POST":
        $requestBody = file_get_contents('php://input');
        
        $logs = fopen("logs.txt", "wb");
        
        $requestBody  = ((array) json_decode($requestBody));
        $record_details = new stdClass();
        $record_details->user_id = $requestBody['userId'];
        $record_details->timestamp = $requestBody['time'];
        $record_details->page = $requestBody['page'];
        
        $photoURI = $requestBody['photo'];
        
        //$feelings = FaceAnalyzer::detectFeelings(explode(",", $photoURI)[1]);
        
        $photoInfo = $requestBody['page'] . "\n" . $requestBody['userId'] . "\n" . $requestBody['time'] . "\n" . print_r("", true) . "\n" . print_r($record, true);
        
        insert_record("block_simplecamera_details", $record_details);
        
        fwrite($logs, $photoInfo);

        //echo(json_encode($feelings));

        break;
    case "GET":
        $requestBody = file_get_contents('php://input');
        $logs = fopen("logs.txt", "wb");
        fwrite($logs, "You've send a GET");
        break;
}
