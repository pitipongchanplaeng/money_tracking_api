<?php
class money
{
    private $connDB;

    public $message;

    public $moneyId;
    public $moneyDetail;
    public $moneyDateTime;
    public $moneyInOut;
    public $moneyType;
    public $userId;

    public function __construct($connectDB)
    {
        $this->connDB = $connectDB;
    }

    public function getMoney($userId)
    {
        $query = "SELECT * FROM money_tb WHERE userId = :userId ORDER BY moneyDateTime DESC";

        $userId = intval(htmlspecialchars(strip_tags($userId)));

        $stmt = $this->connDB->prepare($query);

        $stmt->bindParam(':userId', $userId);

        $stmt->execute();

        return $stmt;
    }

    public function addMoney($moneyDetail, $moneyDateTime, $moneyInOut, $moneyType, $userId)
    {
        $query = "
        INSERT INTO money_tb (moneyDetail, moneyDateTime, moneyInOut, moneyType, userId) 
        VALUES (:moneyDetail, :moneyDateTime, :moneyInOut, :moneyType, :userId)";

        $moneyDetail = htmlspecialchars(strip_tags($moneyDetail));
        $moneyDateTime = htmlspecialchars(strip_tags($moneyDateTime));
        $moneyInOut = htmlspecialchars(strip_tags($moneyInOut));
        $moneyType = intval(htmlspecialchars(strip_tags($moneyType)));
        $userId = intval(htmlspecialchars(strip_tags($userId)));

        $stmt = $this->connDB->prepare($query);

        $stmt->bindParam(':moneyDetail', $moneyDetail);
        $stmt->bindParam(':moneyDateTime', $moneyDateTime);
        $stmt->bindParam(':moneyInOut', $moneyInOut);
        $stmt->bindParam(':moneyType', $moneyType);
        $stmt->bindParam(':userId', $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}