<?php
$title = "My Profile";
include './header.php';
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="jumbotron" style="margin-top: 15px">
            <h1 class="display-4">Profile</h1>
            <div class="col-lg-6">
                <form>
                    <fieldset>
                        <legend>Personal Information</legend>
                        <div class="form-group row">
                            <label for="staticName" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <div id="staticNameDiv">
                                    <input type="text" readonly="" class="form-control-plaintext" id="staticName" value="<?php echo $row['name'] ?>">
                                </div>
                                <div id="inputNameDiv" class="row invisible">
                                    <input type="text" autocomplete="off" class="form-control form-control-sm col-sm-8" id="adminName" placeholder="Enter name">
                                    <input type="button" onclick="changeName()" class="col-sm-2 btn btn-primary btn-sm" value="OK" />
                                    <input type="button" class="col-sm-2 btn btn-secondary btn-sm" onclick="hideInput('name')" value="Cancel" />
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-fw fa-pencil" data-toggle="tooltip" onclick="showInput('name')" id="editName" data-placement="right" title="" data-original-title="Change Name"></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <div id="staticEmailDiv">
                                    <input type="text" readonly="" class="form-control-plaintext" id="staticEmail" value="<?php echo $row['email'] ?>">
                                </div>
                                <div id="inputEmailDiv" class="row invisible">
                                    <input type="email" autocomplete="off" class="form-control form-control-sm col-sm-8" id="adminEmail" aria-describedby="emailHelp" placeholder="Enter email">
                                    <input type="button" class="col-sm-2 btn btn-primary btn-sm" onclick="changeEmail()" value="OK" />
                                    <input type="button" class="col-sm-2 btn btn-secondary btn-sm" onclick="hideInput('email')" value="Cancel" />
                                    <small class="text-muted" id="validateEmail"></small>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-fw fa-pencil" data-toggle="tooltip" onclick="showInput('email')" id="editEmail" data-placement="right" title="" data-original-title="Change Email"></i>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <hr class="my-4">
                <form id="chnPassForm">
                    <fieldset>
                        <legend>Change Password</legend>
                        <div class="form-group row">
                            <label for="oldPassword" class="col-sm-4 col-form-label">Old Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm" id="oldPassword" placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="newPassword" class="col-sm-4 col-form-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm" id="newPassword" placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm" id="cnfPassword" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                            </div>
                            <div class="col-6">
                                <p class="text-right text-muted" id="pwdValidator"></p>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
    //Show hidden input fields
    function showInput(inputType){
        if(inputType === "name"){
            $('#editName').hide();
            $('#staticNameDiv').hide();
            $('#inputNameDiv').removeClass("invisible");
        }else{
            $('#editEmail').hide();
            $('#staticEmailDiv').hide();
            $('#inputEmailDiv').removeClass("invisible");
        }
    }

    //Hide input fields
    function hideInput(inputType){
        if(inputType === "name"){
            $('#adminName').val("");
            $('#editName').show();
            $('#staticNameDiv').show();
            $('#inputNameDiv').addClass("invisible");
        }else{
            $('#adminEmail').val("");
            $('#editEmail').show();
            $('#staticEmailDiv').show();
            $('#inputEmailDiv').addClass("invisible");
            $('#validateEmail').html("");
        }
    }

    //Change Admin Name
    function changeName(){
        var adminName = $('#adminName').val();
        if(adminName !== ""){
            var dataString = "adminName="+adminName+"&id="+<?php echo $id ?>;
            $.ajax({
                type: "POST",
                url: "includes/ad-profile.php",
                data: dataString,
                cache: false,
                success: function(result){
                    if(result === "success"){
                        $('#staticName').val(adminName);
                        hideInput("name");
                    }
                }
            });
        }
    }
    //Check Valid Email
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }
    //Change Admin Name
    function changeEmail(){
        var adminEmail = $('#adminEmail').val();
        if(adminEmail !== "" && validateEmail(adminEmail)){
            var dataString = "adminEmail="+adminEmail+"&id="+<?php echo $id ?>;
            $.ajax({
                type: "POST",
                url: "includes/ad-profile.php",
                data: dataString,
                cache: false,
                success: function(result){
                    if(result === "success"){
                        $('#staticEmail').val(adminEmail);
                        hideInput('email');
                    }else{
                        $('#validateEmail').html("Email id already exist");
                    }
                }
            });
        }else{
            $('#validateEmail').html("Invalid email");
        }
    }

    // Change Admin Password
    $('#chnPassForm').submit(function(e){
      $('#pwdValidator').html("");
      e.preventDefault();
      var oldPwd = $('#oldPassword').val();
      var newPwd = $('#newPassword').val();
      var cnfPwd = $('#cnfPassword').val();
      if(oldPwd !== "" && newPwd !== "" && cnfPwd !== ""){
        if(newPwd === cnfPwd){
            var dataString = "oldPwd="+oldPwd+"&newPwd="+newPwd+"&id="+<?php echo $id ?>;
            // AJAX Code To Submit Form.
            $.ajax({
                type: "POST",
                url: "includes/ad-profile.php",
                data: dataString,
                cache: false,
                success: function(result){
                    if(result === "Password successfully updated"){
                        $('#chnPassForm')[0].reset();
                    }
                    $('#pwdValidator').html(result);
                }
            });
        }else{
            $('#pwdValidator').html("Passwords donot match");    
        }
      }else{
        $('#pwdValidator').html("Password cannot be left blank");
      }
    });
    </script>
<?php
include './footer.php';
?>