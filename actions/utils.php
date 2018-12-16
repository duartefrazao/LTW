<?php
    function getTimeOffset($time){
        switch ($time) {
            case 'day':
                return 86400;
            case 'month':
                return 2628000;
            case 'week':
                return 604800;
            case 'year':
                return 31556952;
            case 'all':
                return time();
            default:
                return 86400;
        }
    }
?>