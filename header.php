<?php
require './function.php';
if(!loggedin()){
    header("Location: login.php");
    exit();
}
$con = connectdb();
$id = $_SESSION['d11m'];
$get = mysqli_query($con, "Select * from admin where id='$id'");
$row = mysqli_fetch_assoc($get);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo $title; ?> | Dream11 Mania</title>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="./css/sb-admin.css" rel="stylesheet">
        <!-- JQuery Library -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <header>
            <!-- Navigation Bar -->
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
                <a class="navbar-brand" href="./dashboard.php"><img src="./images/dreamEleven.png" style="width: 50px;height: 50px;" class="img-fluid">&nbsp;Dream11 Mania</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard" style="margin-top:20px">
                            <a class="nav-link" href="./dashboard.php">
                                <i class="fa fa-fw fa-dashboard"></i>
                                <span class="nav-link-text">Home</span>
                            </a>
                        </li>
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users">
                            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                                <i class="fa fa-fw fa-user"></i>
                                <span class="nav-link-text">Users</span>
                            </a>
                            <ul class="sidenav-second-level collapse" id="collapseComponents">
                                <li>
                                    <a href="user.php">All Users</a>
                                </li>
                                <li>
                                    <a href="user-new.php">Add New</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav sidenav-toggler">
                        <li class="nav-item">
                            <a class="nav-link text-center" id="sidenavToggler">
                                <i class="fa fa-fw fa-angle-left"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hi <?php echo $row['name']; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    Edit My Profile
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-fw fa-sign-out"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>