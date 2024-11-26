<?php
require_once ('User/controllers/controller.php');
$controller = new controller();

    if(isset($_SESSION['session_value'])){

        if(isset($_GET['controller']) && $_GET['controller']===$_SESSION['session_value']) {
            if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                $controller->logout();
            } else if (isset($_GET['action']) && $_GET['action'] === 'problem') {
                $type=isset($_GET['type']) ? $_GET['type']:'none';
                $difficulty=isset($_GET['difficulty']) ? $_GET['difficulty']:'none';
                $controller->problem($difficulty,$type);
            } else if (isset($_GET['action']) && $_GET['action'] === 'submit') {
                $type=isset($_GET['type']) ? $_GET['type']:'none';
                $difficulty=isset($_GET['difficulty']) ? $_GET['difficulty']:'none';
                if($type === 'none' || $difficulty === 'none'){
                    echo"<script>alert('비정상적인접근')</script>";
                }else {
                    $controller->submitscore($_GET['type'], $_GET['difficulty']);
                }
            }
        }else{
            $controller->problem('none','none');
        }
    }else{
        if(isset($_GET['token'])){
            $jwt_token=$_GET['token'];
            $controller->JwtHandler();
        }else{
            echo "<script>
            alert('비정상적인 접근 입니다.');
            window.location.href = 'http//61.245.248.211';
          </script>";
        }
    }

?>