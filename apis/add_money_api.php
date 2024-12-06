<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once '../connectDB.php';
require_once '../models/money.php';

$connectDB = new connectDB();
$money = new money($connectDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$result = $money->addMoney($data->moneyDetail, $data->moneyDateTime, $data->moneyInOut, $data->moneyType, $data->userId);

if ($result == true) {
    $resultData = array();
    $resultArray = array(
        "message" => "1"
    );
    array_push($resultData, $resultArray);
    echo json_encode($resultData);
} else {
    $resultData = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultData, $resultArray);
    echo json_encode($resultData);
}