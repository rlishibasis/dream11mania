<?php
$title = "Add Admin";
include './header.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="jumbotron" style="margin-top: 15px">
            <div class="col-lg-7">
                <form id="adminForm">
                    <fieldset>
                        <legend>Add Admin</legend>
                        <p class="text-muted">Create a new admin to this site.</p>
                        <div class="form-group row">
                            <label for="adminName" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" autocomplete="off" class="form-control form-control-sm col-sm-8" id="adminName">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="adminEmail" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" autocomplete="off" class="form-control form-control-sm col-sm-8" id="adminEmail" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="adminPassword" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm col-sm-8" id="adminPassword">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="adminCnfPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm col-sm-8" id="adminCnfPassword">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary btn-sm">Add Admin</button>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted" id="adminFormValidator"></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="jumbotron" style="margin-top: 15px">
            <legend>All Admins</legend>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody id="output">
                    
                </tbody>
            </table>
        </div>
    </div>
    <script>
    
    $(window).on('load', function() {
        fetchAdmin();
    });
    
    //Fetch All Admins
    function fetchAdmin(){
        var dataString = "admin=admin";
        $.ajax({
            type: "POST",
            url: "includes/get-admin.php",
            data: dataString,
            cache: false,
            success: function(result){
                $('#output').html(result);
            }
        });   
    }

    //Check Valid Email
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }
    //Create a new admin
    $('#adminForm').submit(function(e){
        e.preventDefault();
        $('#adminFormValidator').html("");
        var name = $('#adminName').val();
        var email = $('#adminEmail').val();
        var password = $('#adminPassword').val();
        var cnfpassword = $('#adminCnfPassword').val();
        if(name !== "" && email !== "" && password !== "" && cnfpassword !== ""){
            if(validateEmail(email)){
                if(password === cnfpassword){
                    var dataString = "adminName="+name+"&adminEmail="+email+"&adminPassword="+password;
                    $.ajax({
                        type: "POST",
                        url: "includes/ad-register.php",
                        data: dataString,
                        cache: false,
                        success: function(result){
                            if(result === "success"){
                                $('#adminFormValidator').html("New admin added");
                                $('#adminForm')[0].reset();
                                fetchAdmin();
                            }else{
                                $('#adminFormValidator').html("Email id already exist");
                            }
                        }
                    });   
                }else{
                    $('#adminFormValidator').html("Passwords donot match");    
                }
            }else{
                $('#adminFormValidator').html("Invalid email");
            }
        }else{
            $('#adminFormValidator').html("Fields cannot be left blank");
        }
    });
    
    </script>
<?php
include './footer.php';
?>