<?php
if($_POST['adminEmail'] && $_POST['adminPassword']){
    require './../function.php';
    $con = connectdb();
    $email = sanitizeString($_POST['adminEmail']);
    $pass = md5(sanitizeString($_POST['adminPassword']));
    $check = mysqli_query($con, "Select id from admin where email = '$email' and password = '$pass' ");
    if(mysqli_num_rows($check) == 1){
        $result = mysqli_fetch_array($check);
        $adminId = $result['id'];
        $_SESSION['d11m'] = $adminId;
        echo 'success';
    }else{
        echo 'unsuccessful';    
    }
}else{
    echo 'unsuccessful';
}
