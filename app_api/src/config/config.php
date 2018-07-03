<?php
    function connectdb(){
        //Properties
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpassword = "";
        $dbname = "d11m";
        $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if($con){
            return $con;
        }else{
            die("Error establishing database connectivity");
        }
    }

    function authToken($headerToken, $role){
        $con = connectdb();
        $webToken = base64_decode($headerToken);
        list($userId, $token) = explode('-', $webToken);
        $authUser = mysqli_query($con, "Select id from $role where id='$userId' and token = '$token'");
        if(mysqli_num_rows($authUser) == 1){
            return true;
        }
    }

    function checkAvail($username){
        $con = connectdb();
        if(is_numeric($username)){
            $checkUser = mysqli_query($con, "Select id from user where phone = '$username'");
        }else{
            $checkUser = mysqli_query($con, "Select id from admin where email = '$username'");
        }
        if(mysqli_num_rows($checkUser) == 0){
            return true;
        }
    }