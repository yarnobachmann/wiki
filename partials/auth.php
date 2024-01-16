<?php
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ../../admin/user/login");
        exit;
    }
    ?>