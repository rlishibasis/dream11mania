<?php
require './../function.php';
$con = connectdb();
if($_POST['admin']){
    $get_admin = mysqli_query($con, "Select * from admin");
    $results = "";
    while($row = mysqli_fetch_object($get_admin)) {
        $results .= '<tr>';
        $results .= '<td>'.$row->name.'</td>';
        $results .= '<td>'.$row->email.'</td>';
        $results .= '<td>'.$row->joined.'</td>';
        $results .= '</tr>';
    }
    echo $results;
}