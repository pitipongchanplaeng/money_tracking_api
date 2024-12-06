<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once '../connectDB.php';
require_once '../models/money.php';

$connectDB = new connectDB();
$money = new money($connectDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$result = $money->getMoney($data->userId);

if ($result->rowCount() > 0) {
    $resultData = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $resultArray = array(
            "message" => "1",
            "moneyId" => strval($moneyId),
            "userId" => strval($userId),
            "moneyDetail" => $moneyDetail,
            "moneyDateTime" => $moneyDateTime,
            "moneyInOut" => strval($moneyInOut),
            "moneyType" => strval($moneyType),
        );
        array_push($resultData, $resultArray);
    }
    echo json_encode($resultData);
} else {
    $resultData = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultData, $resultArray);
    echo json_encode($resultData);
}