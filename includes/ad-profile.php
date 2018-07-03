<?php
require './../function.php';
$con = connectdb();
if(isset($_POST['oldPwd'])  && isset($_POST['newPwd']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $oldPwd = md5($_POST['oldPwd']);
    $newPwd = md5($_POST['newPwd']);
    $check = mysqli_query($con, "Select password from admin where id='$id'");
    $result = mysqli_fetch_array($check);
    if($oldPwd == $result['password']){
        mysqli_query($con, "Update admin set password='$newPwd' where id='$id'");
        echo 'Password successfully updated';
    }else{
        echo 'Invalid password';
    }
}elseif(isset($_POST['adminName']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['adminName'];
    mysqli_query($con, "Update admin set name='$name' where id='$id'");
    echo "success";
}elseif(isset($_POST['adminEmail']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $email = $_POST['adminEmail'];
    $check = mysqli_query($con, "Select id from admin where email='$email'");
    if(mysqli_num_rows($check) == 0){
        mysqli_query($con, "Update admin set email='$email' where id='$id'");
        echo "success";
    }else{
        echo "invalid";
    }
}