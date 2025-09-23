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
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? OR idnumber = ?");
        $stmt->bind_param("ss", $email, $idnumber);
        $stmt->execute();
        $result = $stmt->get_result();

        $userExist = $result->num_rows > 0;

        $stmt->close();
        return $userExist;

    }

   public function login($email, $password){
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();   
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user["password"])) {
        return $user; // return the user row if login success
    }
    return false;
}





}