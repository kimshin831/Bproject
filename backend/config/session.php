<?php
// 세션 쿠키 설정
session_set_cookie_params([
    'lifetime' => 0,           // 브라우저 닫으면 세션 만료
    'path' => '/',             // 모든 경로에서 유효
    'domain' => '',            // 필요 시 도메인 설정
    'secure' => true,          // HTTPS 환경에서만 전송
    'httponly' => true,        // JavaScript 접근 방지
    'samesite' => 'None'       // 크로스 도메인 허용
]);

// 세션 시작
session_start();
?>