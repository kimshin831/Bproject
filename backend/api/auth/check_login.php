<?php
// 응답을 JSON 형식으로 설정
header('Content-Type: application/json');

// 세션 관련 설정 파일 포함
require_once '../../config/session.php';

try {
    // 세션이 시작되지 않았을 경우 세션 시작
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // 세션 시작
    }

    // 로그인 상태 확인
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        // 사용자가 로그인 상태일 경우 JSON 응답 반환
        echo json_encode([
            'logged_in' => true, // 로그인 상태
            'user_id' => $_SESSION['user_id'] ?? null, // 세션에 저장된 사용자 ID
            'username' => $_SESSION['username'] ?? null // 세션에 저장된 사용자 이름
        ]);
    } else {
        // 사용자가 로그인하지 않은 경우 JSON 응답 반환
        echo json_encode([
            'logged_in' => false, // 로그인 상태 아님
            'message' => 'User is not logged in' // 로그인 상태가 아님을 나타내는 메시지
        ]);
    }
} catch (Exception $e) {
    // 예기치 못한 에러 처리
    echo json_encode([
        'success' => false, // 요청 실패 상태
        'error' => 'An unexpected error occurred', // 에러 메시지
        'details' => $e->getMessage() // 에러 상세 내용
    ]);

    // 에러 로그 기록 (서버 로그에 기록)
    error_log($e->getMessage());
}
?>
