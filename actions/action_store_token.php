<?php
    function storeToken(){
        echo '<script>localStorage.setItem(\'csrf\',' . json_encode($_SESSION['csrf']) .');</script>';
    }
?>