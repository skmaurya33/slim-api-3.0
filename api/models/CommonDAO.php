<?php

class CommonDAO extends Database {

    private $tblUserToken = 'tbl_user_token';

    function getUserByToken($token) {
        $sql = "SELECT * FROM $this->tblUserToken WHERE token=:token";
        $this->query($sql);
        $this->bind(':token', $token);
        return $this->single();
    }

}
