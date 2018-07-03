<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Routes for user

//Login User
$app->post('/login/user', function (Request $request, Response $response, array $args) {
    if($request->getParam('phone') && $request->getParam('password')){
        $con = connectdb();
        $phone = $request->getParam('phone');
        $pass = $request->getParam('password');
        $password = md5($pass);
        $checkLogin = mysqli_query($con, "Select * from user where phone='$phone' and password='$password'");
        if(mysqli_num_rows($checkLogin) == 1){
            $result = mysqli_fetch_array($checkLogin);
            $userId = $result['id'];
            $token = $result['token'];
            if($token == null){
                $token = openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                mysqli_query($con, "Update user set token='$token' where id='$userId'");
            }
            $webToken = base64_encode($userId."-".$token);
            $oldResponse = $response->withAddedHeader('Token', $webToken);
            $newResponse = $oldResponse->withJson("Login Successful", 200);
        }else{
            $newResponse = $response->withJson("Invalid Credentials", 404);    
        }
    }else{
        $newResponse = $response->withJson("Invalid Credentials", 404);
    }
    return $newResponse;
});

//Search Username
$app->get('/check/user/{phone}', function (Request $request, Response $response, array $args){
    if($request->getAttribute('phone')){
        $phone = $request->getAttribute('phone');
        if(checkAvail($phone)){
            $newResponse = $response->withJson("User Available", 200);
        }else{
            $newResponse = $response->withJson("User Not Available", 404);
        }
    }
    return $newResponse;
});

//Logout User
$app->get('/logout/user/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'user')){
            if($request->getAttribute('id')){
                $con = connectdb();
                $id = $request->getAttribute('id');
                if(mysqli_query($con, "Update user set token=null where id='$id'")){
                    $newResponse = $response->withJson("User Updated", 200);
                }else{
                    $newResponse = $response->withJson("Internal Server Error", 500);
                }
            }else{
                $newResponse = $response->withJson("Id Not Found", 404);
            }
        }else{
            $newResponse = $response->withJson("Unauthoried Request", 401);
        }
    }else{
        $newResponse = $response->withJson("Unauthoried Request", 401);
    }
    return $newResponse;
});


//Get all user
$app->get('/user', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'user')){
            $con = connectdb();
            $getUser = mysqli_query($con, "Select * from user");
            while($result = mysqli_fetch_assoc($getUser)){
                $data[] = $result; 
            }
            $newResponse = $response->withJson($data, 200);
        }else{
            $newResponse = $response->withJson("Unauthoried Request", 401);
        }
    }else{
        $newResponse = $response->withJson("Unauthoried Request", 401);
    }
    return $newResponse;
});

//Get Single user
$app->get('/user/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'user')){
            $con = connectdb();
            $id = $request->getAttribute('id');
            $getUser = mysqli_query($con, "Select * from user where id='$id'");
            $result = mysqli_fetch_assoc($getUser);
            $newResponse = $response->withJson($result, 200);
        }else{
            $newResponse = $response->withJson("Unauthoried Request", 401);
        }
    }else{
        $newResponse = $response->withJson("Unauthoried Request", 401);
    }
    return $newResponse;
});

//Create Single user
$app->post('/user', function (Request $request, Response $response, array $args) {
    if($request->getParam('name') && $request->getParam('phone') && $request->getParam('password')){
        $con = connectdb();
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $pass = $request->getParam('password');
        $password = md5($pass);
        $joined = date("Y-m-d");
        if(checkAvail($phone)){
            if(mysqli_query($con, "Insert into user (name, phone, password, joined) values ('$name', '$phone', '$password', '$joined')")){
                $newResponse = $response->withJson("User Added", 201); 
            }else{
                $newResponse = $response->withJson("Internal Server Error", 500);  
            }
        }else{
            $newResponse = $response->withJson("Username Not Available", 409);
        }
    }else{
        $newResponse = $response->withJson("Invalid Parameters", 404);
    }
    return $newResponse;
});

//Delete Single user
$app->delete('/user/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'user')){
            $con = connectdb();
            $id = $request->getAttribute('id');
            if(mysqli_query($con, "DELETE FROM user where id='$id'")){
                $newResponse = $response->withStatus(204);
            }else{
                $newResponse = $response->withJson("Internal Server Error", 500);
            }
        }else{
            $newResponse = $response->withJson("Unauthoried Request", 401);
        }
    }else{
        $newResponse = $response->withJson("Unauthoried Request", 401);
    }
    return $newResponse;
});

//Update Single user
$app->put('/update/user/', function (Request $request, Response $response, array $args) {
    $con = connectdb();
    $phone = $request->getParam('phone');
    $pass = $request->getParam('password');
    $password = md5($pass);
    if(!checkAvail($phone)){
        $newResponse = $response->withJson("User Updated",200);
        if(mysqli_query($con, "Update user set password='$password' where phone='$phone'")){
            $newResponse = $response->withJson("User updated",200);
        }else{
            $newResponse = $response->withJson("Internal Server Error",500);
        }
    }else{
        $newResponse = $response->withJson("Phone Not Found",404);
    }
    return $newResponse;
});