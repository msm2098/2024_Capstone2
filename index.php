<?php
require_once ('User/controllers/controller.php');
$controller = new controller();

    if(isset($_SESSION['session_value'])){

        if(isset($_GET['controller']) && $_GET['controller']===$_SESSION['session_value']) {
            if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                $controller->logout();
            } else if (isset($_GET['action']) && $_GET['action'] === 'problem') {
                $controller->problem();
            }
        }else{
            $controller->problem();
        }
    }else{
        if(isset($_GET['token'])){
            $jwt_token=$_GET['token'];
            $controller->JwtHandler();
        }else{
            echo "<script>
            alert('비정상적인 접근 입니다.');
            window.location.href = 'http://192.0.0.2:8081';
          </script>";
        }
    }

?>