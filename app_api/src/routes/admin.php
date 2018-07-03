<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Routes for admin

//Login admin
$app->post('/login/admin', function (Request $request, Response $response, array $args) {
    if($request->getParam('email') && $request->getParam('password')){
        $con = connectdb();
        $email = $request->getParam('email');
        $pass = $request->getParam('password');
        $password = md5($pass);
        $checkLogin = mysqli_query($con, "Select * from admin where email='$email' and password='$password'");
        if(mysqli_num_rows($checkLogin) == 1){
            $result = mysqli_fetch_array($checkLogin);
            $status = $result['status'];
            if(!$status){
                $newResponse = $response->withJson("Admin Revoked", 401);
                return $newResponse;
            }
            $adminId = $result['id'];
            $token = $result['token'];
            if($token == null){
                $token = openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                mysqli_query($con, "Update admin set token='$token' where id='$adminId'");
            }
            $webToken = base64_encode($adminId."-".$token);
            $oldResponse = $response->withAddedHeader('Token', $webToken);
            $newResponse = $oldResponse->withJson("Login Successful", 200);
        }else{
            $newResponse = $response->withJson("Login Unsuccessful", 404);    
        }
    }else{
        $newResponse = $response->withJson("Login Unsuccessful", 404);
    }
    return $newResponse;
});

//Logout admin
$app->get('/logout/admin/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            if($request->getAttribute('id')){
                $con = connectdb();
                $id = $request->getAttribute('id');
                if(mysqli_query($con, "Update admin set token=null where id='$id'")){
                    $newResponse = $response->withStatus(200);    
                }else{
                    $newResponse = $response->withStatus(500);    
                }
            }else{
                $newResponse = $response->withStatus(404);
            }
        }else{
            $newResponse = $response->withStatus(401);    
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});

//Get all admin
$app->get('/admin', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            $con = connectdb();
            $getAdmin = mysqli_query($con, "Select * from admin");
            while($result = mysqli_fetch_assoc($getAdmin)){
                $data[] = $result; 
            }
            $newResponse = $response->withJson($data, 200);
        }else{
            $newResponse = $response->withStatus(401);
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});

//Get Single Admin
$app->get('/admin/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            $con = connectdb();
            $id = $request->getAttribute('id');
            $getAdmin = mysqli_query($con, "Select * from admin where id='$id'");
            $result = mysqli_fetch_assoc($getAdmin);
            $newResponse = $response->withJson($result, 200);
        }else{
            $newResponse = $response->withStatus(401);
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});

//Create Single Admin
$app->post('/admin', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            if($request->getParam('name') && $request->getParam('email') && $request->getParam('password')){
                $con = connectdb();
                $name = $request->getParam('name');
                $email = $request->getParam('email');
                $pass = $request->getParam('password');
                $password = md5($pass);
                $joined = date("Y-m-d");
                if(checkAvail($email)){
                    if(mysqli_query($con, "Insert into admin (name, email, password, joined) values ('$name', '$email', '$password', '$joined')")){
                        $newResponse = $response->withStatus(201);    
                    }else{
                        $newResponse = $response->withStatus(500);    
                    }
                }else{
                    $newResponse = $response->withStatus(409);
                }
            }else{
                $newResponse = $response->withStatus(404);
            }
        }else{
            $newResponse = $response->withStatus(401);
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});

//Revoke Admin
$app->delete('/admin/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            $con = connectdb();
            $id = $request->getAttribute('id');
            if(mysqli_query($con, "Update admin set status='0' where id='$id'")){
                $newResponse = $response->withStatus(204);
            }else{
                $newResponse = $response->withStatus(500);
            }
        }else{
            $newResponse = $response->withStatus(401);
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});

//Update Single Admin
$app->put('/admin/{id}', function (Request $request, Response $response, array $args) {
    if($request->hasHeader('Token')){
        $token = $request->getHeader('Token');
        if(authToken($token[0], 'admin')){
            $con = connectdb();
            $id = $request->getAttribute('id');
            $pass = $request->getParam('password');
            $password = md5($pass);
            if(mysqli_query($con, "Update admin set password='$password' where id='$id'")){
                $newResponse = $response->withJson( "Admin Updated", 200);
            }else{
                $newResponse = $response->withStatus(500);
            }
        }else{
            $newResponse = $response->withStatus(401);    
        }
    }else{
        $newResponse = $response->withStatus(401);
    }
    return $newResponse;
});