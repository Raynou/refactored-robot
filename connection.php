<?php
require_once(__DIR__ . '/../../config.php');


function insertAnalysis($record) {
    global $DB;
    $user_id = intval($record->user_id);
    $timestamp = $record->timestamp;
    $page = $record->page;
    $object = (object) array(
        'user_id' => $user_id,
        'timestamp' => $timestamp,
        'page' => $page
    );
    $table = "block_simplecamera_details";
    $detailsId = $DB->insert_record($table, $object, true);
    $table = "block_simplecamera_analysis";
    $sentiment = $record->sentiment;
    $object = (object) array(
        'sentiment' => $sentiment,
        'details' => $detailsId,
    );
    $DB->insert_record($table, $object, false);
}