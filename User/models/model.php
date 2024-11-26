<?php
class Model {
    private  $privateKey;
    private $publicKey;
    public function __construct() {
        // 개인 키 및 공개 키 파일 읽기
        $this->privateKey = file_get_contents('User/config/private_key.pem');
        $this->publicKey = file_get_contents('User/config/public_key1.pem');
    }
    public function JwtDecode($encoded) {
        $decodedPayload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $encoded)), true);
        if ($decodedPayload !== null) {
            if (isset($decodedPayload['exp']) && time() > $decodedPayload['exp']) {
                echo "토큰이 만료되었습니다.";
                return false; // 토큰이 만료되었으면 false를 반환
            }
            return $decodedPayload;
        } else {
            echo "디코딩 실패";
            return false;
        }
    }

    public function JwtDecryptPayload($encrypted, $symmetricKey) {
        // Base64 URL 디코딩 후 복호화
        $encryptedPayload = base64_decode(str_replace(['-', '_'], ['+', '/'], $encrypted));

        // 대칭 키로 페이로드 복호화
        $decryptedPayload = openssl_decrypt($encryptedPayload, 'aes-256-cbc', $symmetricKey, 0, substr($symmetricKey, 0, 16));

        if ($decryptedPayload !== false) {
            return $decryptedPayload;
        } else {
            echo "페이로드 복호화 실패: " . openssl_error_string();
            return false;
        }
    }
    public function JwtDecryptSymmetricKey($encryptedKey) {
        // RSA 개인 키로 대칭 키 복호화
        $encryptedKeyDecoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $encryptedKey));
        openssl_private_decrypt($encryptedKeyDecoded, $decryptedKey, $this->privateKey);

        if ($decryptedKey) {
            return $decryptedKey;
        } else {
            echo "대칭 키 복호화 실패: " . openssl_error_string();
            return false;
        }
    }


    public function JwtSignatureAuth($signedData, $signature) {
        $publicKey = file_get_contents('User/config/public_key1.pem');
        $decodedSignature = base64_decode(str_replace(['-', '_'], ['+', '/'], $signature));

        $isValid = openssl_verify($signedData, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256);
        return $isValid === 1;
    }
    public function submitscore($username,$type,$difficulty){
        $symmetricKey = openssl_random_pseudo_bytes(32);
        $private_key = openssl_pkey_get_private(file_get_contents('User/config/private_key.pem'));
        $public_key = openssl_pkey_get_public(file_get_contents('User/config/public_key1.pem'));
        $header = json_encode(['alg'=>'HS256','typ'=>'JWT']);
        $payload = json_encode(['username'=>$username,'type'=>$type,'difficulty'=>$difficulty,]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $encryptedPayload = openssl_encrypt($base64UrlPayload, 'aes-256-cbc', $symmetricKey, 0, substr($symmetricKey, 0, 16));
        $base64UrlEncryptedPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encryptedPayload));
        openssl_public_encrypt($symmetricKey, $encryptedSymmetricKey, $public_key);
        $base64UrlEncryptedSymmetricKey = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encryptedSymmetricKey));
        openssl_sign($base64UrlHeader . "." . $base64UrlEncryptedSymmetricKey, $signature, $private_key, OPENSSL_ALGO_SHA256);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        return $base64UrlHeader . "." . $base64UrlEncryptedPayload . "." . $base64UrlEncryptedSymmetricKey . "." . $base64UrlSignature;
    }


}
?>
