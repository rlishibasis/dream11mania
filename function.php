<?php
//Init session
session_start();

//Connect to db
function connectdb(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "d11m";
    $con  = mysqli_connect($host, $user, $pass, $dbname);
    if($con){
        return $con;
    }else{
        die("Database connectivity error");
    }
}

//Filter the values
function sanitizeString($var){
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

//Restrict inner access
//Check Login
function loggedin(){
    if(isset($_COOKIE['d11m']) || isset($_SESSION['d11m'])){
        $loggedin= TRUE;
        return $loggedin;
    }
}