<?php
require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . '/../../config.php');
require_once("connection.php");

$logs = fopen("logs.txt", "wb");
header("Content-Type:application/json");
$method = $_SERVER["REQUEST_METHOD"];

use Stormwind\FaceAnalyzer;

// Load credentials from moodle config
$config = get_config('block_simplecamera');
if (isset($config->AWS_REGION) && isset($config->AWS_PUBLIC_KEY) && isset($config->AWS_SECRET_KEY)) {
    FaceAnalyzer::setCredentials($config);
}

function insertRecord($record) {
    try {
        insertAnalysis($record);
    }catch(Exception $e) {
        error_log("ERROR: " . $e);
    }
}

switch($method) {
    case "POST":
        $requestBody = file_get_contents('php://input');
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
}