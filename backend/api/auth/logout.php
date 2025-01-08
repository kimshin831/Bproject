<?php
// 응답을 JSON 형식으로 설정
header('Content-Type: application/json');

// 세션 관련 설정 파일 포함
require_once '../../config/session.php'; // 세션 설정 파일 포함

// 세션이 시작되지 않았을 경우 세션을 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // 세션 시작
}

// 모든 세션 변수 해제
session_unset(); // 현재 세션에서 저장된 모든 변수 제거

// 세션 종료
session_destroy(); 

// 세션 쿠키 삭제 (선택 사항)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params(); // 현재 세션 쿠키의 설정 값 가져오기
    setcookie(
        session_name(), // 세션 쿠키 이름
        '', // 빈 값으로 설정
        time() - 42000, // 유효 시간을 과거로 설정하여 쿠키 삭제
        $params["path"], // 쿠키 경로
        $params["domain"], // 쿠키 도메인
        $params["secure"], // HTTPS에서만 전송 여부
        $params["httponly"] // HTTP 전용 여부
    );
}

// 로그아웃 성공 메시지를 JSON 형식으로 반환
echo json_encode(['success' => true]); // 클라이언트에 로그아웃 성공 메시지 전달
?>
