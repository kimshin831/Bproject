<?php
header("Content-Type: application/json; charset=UTF-8");

// 세션 시작
session_start();

// 디버깅용 로그 추가
error_log("Logging out. Current Session ID: " . session_id());
error_log("Session Data Before Destroy: " . print_r($_SESSION, true));

// 세션 파괴 (로그아웃 처리)
if (session_destroy()) {
    // 세션 쿠키 제거
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    error_log("Logout Successful");
    echo json_encode([
        "status" => "success",
        "message" => "Logged out successfully"
    ]);
} else {
    error_log("Logout Failed");
    echo json_encode([
        "status" => "error",
        "message" => "Failed to log out"
    ]);
}
?>
