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

    function storeChannelInfo($channel,$userId){
        echo '
        <script>
            localStorage.setItem(\'channel\',' . json_encode($channel) .');
            localStorage.setItem(\'userId\',' . json_encode($userId) .');
        </script>';
    }

    function removeChannelInfo(){
        echo '
        <script>
            localStorage.removeItem(\'channel\');
            localStorage.removeItem(\'userId\');
        </script>';
    }
?>