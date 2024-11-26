<?php
session_start();
require_once('User/models/model.php');
require_once('User/config/database.php');

class Controller {
    private $model;


    public function __construct() {
        $this->model = new Model();
    }

    public function JwtHandler() {
        $token = $_GET['token'];

        // 토큰을 분리하여 헤더, 암호화된 페이로드, 암호화된 대칭 키, 서명 추출
        list($header, $encryptedPayload, $encryptedSymmetricKey, $signature) = explode('.', $token);

        // 대칭 키 복호화
        $symmetricKey = $this->model->JwtDecryptSymmetricKey($encryptedSymmetricKey);
        if ($symmetricKey) {
            // 페이로드 복호화
            $decryptedPayload = $this->model->JwtDecryptPayload($encryptedPayload, $symmetricKey);
            if ($decryptedPayload) {
                // 디코드
                $decoded = $this->model->JwtDecode($decryptedPayload);
                if ($decoded) {
                    // 서명 검증
                    $signatureValidation = $this->model->JwtSignatureAuth($header . '.' . $encryptedSymmetricKey, $signature);
                    if ($signatureValidation) {
                        session_regenerate_id();
                        $_SESSION['username'] = $decoded['username'];
                        $_SESSION['session_value'] = $decoded['session_value'];
                        #해당부분에서 함수실행
                        $this->createuserDirectoryAndFile($_SESSION['username'],$_SESSION['session_value']);

                        header('Location: index.php?controller=' . $_SESSION['session_value'] . '&action=problem');
                        exit();
                    } else {
                        echo "유효하지 않은 서명";
                    }
                } else {
                    echo "페이로드 디코딩 실패";
                }
            } else {
                echo "페이로드 복호화 실패";
            }
        } else {
            echo "대칭 키 복호화 실패";
        }
    }
    private function createuserDirectoryAndFile($username, $session_value) {
        // 사용자 디렉토리 생성
        $user_directory = "problems/" . $username;
        if (!file_exists($user_directory)) {
            mkdir($user_directory, 0755, true); // 사용자 디렉토리 생성
        }

        $problem_names = array('sqlinjection', 'xss', 'lfi');

        // 각 문제 이름별로 디렉토리 생성 및 파일 작성
        foreach ($problem_names as $problem_name) {
            // 문제 이름별 디렉토리 생성
            $problem_directory = $user_directory . "/" . $problem_name;
            if (!file_exists($problem_directory)) {
                mkdir($problem_directory, 0755, true); // 문제 이름 디렉토리 생성
            }

            // 각 난이도에 대해 파일 생성
            foreach (['easy', 'medium', 'hard'] as $difficulty) {
                $filename = $session_value . "_" . $difficulty . ".php"; // 파일 이름
                $filepath = $problem_directory . "/" . $filename; // 전체 파일 경로

                $template_file = "public/template/{$problem_name}/{$difficulty}.php";

                if (file_exists($template_file)) {
                    // 템플릿 파일이 존재하면 해당 파일을 새 위치에 복사
                    copy($template_file, $filepath);
                } else {
                    // 템플릿 파일이 없다면 기본 내용으로 파일 생성
                    $file_content = "<?php echo '문제: {$problem_name}<br>'; echo '사용자: {$username}<br>'; echo '세션값: {$session_value}'; ?>";
                    file_put_contents($filepath, $file_content); // 파일 생성
                }
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: http://61.245.248.211/index.php?controller=user&action=logout');
        exit();
    }
    public function problem($difficulty,$type='none') {

            if($type == "sqlinjection"||$type == "xss"||$type == "lfi"){
                if($difficulty=="none") {
                    include 'User/views/' . $type . '.php';
                }else if ($difficulty == "easy"||$difficulty == "medium"||$difficulty == "hard"){
                    include "problems/".$_SESSION['username']."/".$type."/".$_SESSION['session_value']."_".$difficulty.".php";
                }else{
                    echo "<script>alert('비정상적인 접근입니다.');window.location.href='index.php'</script>";
                }
            }else{
                include 'User/views/problem.php';

            }

    }


    public function submitscore($type,$difficulty){
        $username = $_SESSION['username'];

        $token = $this->model->submitscore($username,$type,$difficulty);
        $url = 'http://61.245.248.211/index.php?controller=user&action=submit';
        $data = ['token' => $token];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // HTTP 상태 코드 확인
        curl_close($ch);
        error_log("Generated token: " . $token);

        if ($httpCode === 200 ) {
            echo "<script>alert('점수가 성공적으로 제출되었습니다.'); window.location.href = 'index.php?controller=" . $_SESSION['session_value'] . "&action=problem&type=" . $type . "';</script>";
        } else {
            echo "<script>alert('점수 제출에 실패했습니다. 다시 시도해주세요.');</script>";
        }
       # header('Location: http://192.0.0.1:8081/index.php?token=' . urlencode($token));
        exit();



    }
}
?>