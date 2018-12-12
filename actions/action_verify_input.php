<?php

    function verifyString($string){
        return !preg_match("/^[a-zA-Z\s]+$/", $string);
    }

    function verifyEmail($email){
        return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }

?>