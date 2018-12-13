<?php

    function verifyString($string){

        if($string === NULL)
            return TRUE;

        return ctype_alnum($string);
    }

    function verifyEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>