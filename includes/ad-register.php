<?php
if($_POST['adminName'] && $_POST['adminEmail'] && $_POST['adminPassword']){
    require './../function.php';
    $con = connectdb();
    $name = sanitizeString($_POST['adminName']);
    $email = sanitizeString($_POST['adminEmail']);
    $pass = md5(sanitizeString($_POST['adminPassword']));
    $joined = date('Y-m-d');
    $check = mysqli_query($con, "Select id from admin where email = '$email'");
    if(mysqli_num_rows($check) == 0){
        mysqli_query($con, "Insert into admin (name, email, password, joined) values('$name', '$email', '$pass', '$joined')");
        echo 'success';
    }else{
        echo 'duplicate';    
    }
}else{
    echo 'unsuccessful';
}
