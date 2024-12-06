<?php
class user
{
    private $connDB;

    public $message;

    public $userId;
    public $userFullname;
    public $userBirthDate;
    public $userName;
    public $userPassword;
    public $userImage;

    public function __construct($connectDB)
    {
        $this->connDB = $connectDB;
    }

    public function insertNewUser($userFullname, $userBirthDate, $userName, $userPassword, $userImage)
    {
        if (!empty($userImage)) {
            $query = "
            INSERT INTO user_tb (userFullname, userBirthDate, userName, userPassword, userImage) 
            VALUES (:userFullname, :userBirthDate, :userName, :userPassword, :userImage)
            ";
        } else {
            $query = "
            INSERT INTO user_tb (userFullname, userBirthDate, userName, userPassword) 
            VALUES (:userFullname, :userBirthDate, :userName, :userPassword)
            ";
        }

        $userFullname = htmlspecialchars(strip_tags($userFullname));
        $userBirthDate = htmlspecialchars(strip_tags($userBirthDate));
        $userName = htmlspecialchars(strip_tags($userName));
        $userPassword = htmlspecialchars(strip_tags($userPassword));
        if (!empty($userImage)) {
            $userImage = htmlspecialchars(strip_tags($userImage));
        }

        $stmt = $this->connDB->prepare($query);

        $stmt->bindParam(':userFullname', $userFullname);
        $stmt->bindParam(':userBirthDate', $userBirthDate);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':userPassword', $userPassword);
        if (!empty($userImage)) {
            $stmt->bindParam(':userImage', $userImage);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($userName, $userPassword)
    {
        $query = "
        SELECT * FROM user_tb
        WHERE userName = :userName AND userPassword = :userPassword
        ";

        $userName = htmlspecialchars(strip_tags($userName));
        $userPassword = htmlspecialchars(strip_tags($userPassword));

        $stmt = $this->connDB->prepare($query);

        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':userPassword', $userPassword);

        $stmt->execute();

        return $stmt;
    }
}