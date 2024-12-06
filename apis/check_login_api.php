<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once '../connectDB.php';
require_once '../models/users.php';

$connectDB = new connectDB();
$user = new user($connectDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$result = $user->checkLogin($data->userName, $data->userPassword);

if ($result->rowCount() > 0) {
    $resultData = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // ตรวจสอบว่ามีไฟล์ภาพหรือไม่
        $base64Image = null;
        if (!empty($userImage)) {
            $imagePath = __DIR__ . "/../images/users/" . $userImage; // เปลี่ยน path ตามโครงสร้างของคุณ
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $base64Image = base64_encode($imageData);
            }
        }

        $resultArray = array(
            "message" => "1",
            "userId" => strval($userId),
            "userFullname" => $userFullname,
            "userBirthDate" => $userBirthDate,
            "userName" => $userName,
            "userPassword" => $userPassword,
            "userImage" => $base64Image, // ส่งภาพแบบ Base64
        );
        array_push($resultData, $resultArray);
    }
    echo json_encode($resultData);
} else {
    $resultData = array();
    $resultArray = array(
        "massage" => "0"
    );
    array_push($resultData, $resultArray);
    echo json_encode($resultData);
}