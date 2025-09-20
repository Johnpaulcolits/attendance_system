<?php


class User{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function register($id, $idnumber, $email, $fname, $mname,
    $lname, $year, $course, $password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (id, idnumber, email, fname, mname, lname, year, course, password) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?)");
        $stmt->bind_param("sssssssss", $id, $idnumber, $email, $fname, $mname, $lname, $year, $course, $hashedPassword);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function CheckUser($email, $idnumber){


    }

    public function login($email, $password){
        
    }
}