<?php

class JwtHandler {
    // 고정된 비밀 키
    private static $secret_key = 'seoungmin';

    // JWT 생성 함수
    public static function createToken($username, $session_id) {
        // JWT 헤더와 페이로드 설정
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode(['username' => $username, 'session_id' => $session_id]);

        // Base64 URL 인코딩
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // 서명 생성
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // 최종 JWT 토큰
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    // JWT 검증 및 디코딩 함수
    public static function decodeToken($jwt) {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);

        // 서명 검증
        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $signatureEncoded));
        $expectedSignature = hash_hmac('sha256', $headerEncoded . "." . $payloadEncoded, self::$secret_key, true);

        if (!hash_equals($signature, $expectedSignature)) {
            return false; // 서명이 일치하지 않으면 false 반환
        }

        return json_decode(base64_decode($payloadEncoded), true); // 서명이 올바르면 페이로드 반환
    }
}
?>
