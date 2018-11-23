<?php

class UserDAO extends Database {

    private $tblUser = 'tbl_user';
    private $tblUserToken = 'tbl_user_token';

    function isEmailExist($email) {
        $sql = "SELECT id FROM $this->tblUser WHERE email = :email";
        $this->query($sql);
        $this->bind(':email', $email);
        $result = $this->single();
        return empty($result) ? false : true;
    }

    function signup($req) {

        $sql = " INSERT INTO $this->tblUser (name, email, password, mobile, created_at)";
        $sql .= " VALUES (:name, :email, :password, :mobile, :created_at)";

        $this->query($sql);
        $this->bind(':name', $req['name']);
        $this->bind(':email', $req['email']);
        $this->bind(':password', md5($req['password']));
        $this->bind(':mobile', $req['mobile']);
        $this->bind(':created_at', date('Y-m-d'));
        $this->execute();
        return $this->lastInsertId();
    }

    function getUserByEmail($email) {

        $sql = "SELECT * FROM $this->tblUser WHERE email = :email";
        $this->query($sql);
        $this->bind(':email', $email);
        $result = $this->single();
        return $result;
    }

    function updateToken($user_id, $token, $device_id) {

        $sql = "INSERT INTO $this->tblUserToken (user_id, token, device_id) VALUES(:user_id, :token, :device_id) ";
        $sql .= "ON DUPLICATE KEY UPDATE token = :token";
        $this->query($sql);
        $this->bind(':user_id', $user_id);
        $this->bind(':token', $token);
        $this->bind(':device_id', $device_id);
        $this->execute();
        return $this->lastInsertId();
    }

    function getLoginByCreds($email, $password) {

        $sql = "SELECT * FROM $this->tblUser WHERE email = :email AND password = :password";
        $this->query($sql);
        $this->bind(':email', $email);
        $this->bind(':password', md5($password));
        $result = $this->single();
        return $result;
    }

    function getUserById($id) {
        $sql = "SELECT * FROM $this->tblUser WHERE id=:id";
        $this->query($sql);
        $this->bind(':id', $id);
        return $this->single();
    }

}

//end of class
