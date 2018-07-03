<?php
include 'function.php';

if(loggedin() == true){
    header("Location: dashboard.php");
}else{
    header("Location: login.php");
}