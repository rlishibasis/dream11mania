<?php
include './../function.php';
if($_GET['loggedout'] == TRUE){
    session_destroy();
    header("Location: ../index.php");
}