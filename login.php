<?php
require './function.php';
if(loggedin()){
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/bootstrap-theme.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Dream11 Mania | Admin Login</title>
</head>
<body>
    <div class="container">
        <div class="mx-auto col-lg-4">
            <div class="login-form-validation-container">
                <div id="form-validator" class="login-form-container invisible"></div>
            </div>
            <div class="login-form-container">
                <form id="loginForm">
                    <fieldset>
                        <div class="form-group">
                            <label for="adminEmail">Email address</label>
                            <input type="email" onclick="hideValidator()" class="form-control" id="adminEmail" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="adminPassword">Password</label>
                            <input type="password" onclick="hideValidator()" class="form-control" id="adminPassword">
                        </div>
                        <div class="form-group">
                            <a href="http://">Lost Password?</a>
                            <button type="submit" class="btn btn-primary float-lg-right float-md-right float-sm-right">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script src="./vendor/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script>
        //Hide Validator if shown
        function hideValidator(){
            $('#form-validator').html('');
            $('#form-validator').addClass("invisible");
        }

        //Show Validator
        function showValidator($content){
            $('#form-validator').html($content);
            $('#form-validator').removeClass("invisible");
            $('form').shake(2, 13, 250);
        }

        $('#loginForm').submit(function(e){
            e.preventDefault();
            var email = $('#adminEmail').val();
            var pass = $('#adminPassword').val();
            
            if(email !== '' && pass !== ''){
                var dataString = "adminEmail="+email+"&adminPassword="+pass;
                // AJAX Code To Submit Form.
                $.ajax({
                    type: "POST",
                    url: "includes/ad-login.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        if(result === 'success'){
                            window.location.replace('dashboard.php');
                        }else{
                            $content = '<p><b>ERROR:</b> Invalid username and password.</p>';
                            showValidator($content);            
                        }
                    }
                });
            }else{
                $content = '<p><b>ERROR:</b> Fill username and password.</p>';
                showValidator($content);
            }
        });

        //Shaky Effect to Login Form
        jQuery.fn.shake = function(intShakes, intDistance, intDuration) {
            this.each(function() {
                $(this).css({
                    position: "relative"
                });
                for (var x = 1; x <= intShakes; x++) {
                    $(this).animate({
                        left: (intDistance * -1)
                    }, (((intDuration / intShakes) / 4))).animate({
                        left: intDistance
                    }, ((intDuration / intShakes) / 2)).animate({
                        left: 0
                    }, (((intDuration / intShakes) / 4)));
                }
            });
            return this;
        };
    </script>
</body>
</html>