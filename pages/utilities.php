<?php 
    function draw_header_global($username){
        if (isset($_SESSION['username']))
            draw_header($_SESSION['username']);
        else
            draw_header(null);
    }
?>