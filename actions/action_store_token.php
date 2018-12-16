<?php
    function storeToken(){
        echo '<script>localStorage.setItem(\'csrf\',' . json_encode($_SESSION['csrf']) .');</script>';
    }

    function storePageLocation($page){
        echo '<script>localStorage.setItem(\'page\',' . json_encode($page) .');</script>';
    }

    function removePageLocation(){
        echo '<script>localStorage.removeItem(\'cenas\');</script>';
    }
?>