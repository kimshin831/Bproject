<?php
// 응답을 JSON 형식으로 설정
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// 세션 관련 설정 파일 포함
require_once '../../config/session.php';


try {
    // 세션이 시작되지 않았을 경우 세션 시작
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // 세션 시작
    }
    
    // 디버깅 로그: 세션 상태와 데이터 확인
    error_log("Session Status: " . session_status());
    error_log("Session ID: " . session_id());
    error_log("Session Data: " . print_r($_SESSION, true));

    // 로그인 상태 확인
    if (isset($_SESSION['username']) && isset($_SESSION['name'])) {
        // 로그인된 사용자
        http_response_code(200);
        echo json_encode([
            'logged_in' => true,
            'user_id' => $_SESSION['username'],
            'username' => $_SESSION['name']
        ]);
    } else {
        // 로그인되지 않은 사용자
        http_response_code(401);
        echo json_encode([
            'logged_in' => false,
            'message' => 'User is not logged in'
        ]);

        error_log("User Not Logged In. Session ID: " . session_id());
    }
} catch (Exception $e) {
    // 예기치 못한 에러 처리
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'An unexpected error occurred'
    ]);

    error_log("Error: " . $e->getMessage());
}
?>
