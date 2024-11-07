<?php
    if(isset($_GET['token'])){
        $jwt_token=$_GET['token'];
        echo $jwt_token;
        $payload  = JwtHandler::decodeTokern($jwt_token);
        if($payload){
            $username = $payload['username'];
            $session_id = $payload['session_id'];
            echo($username+$session_id);
        }
    }else{
        echo 'No Parms';
    }
?>