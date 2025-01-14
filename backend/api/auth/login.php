<?php
header("Content-Type: application/json; charset=UTF-8");

// MySQL 데이터베이스 연결 설정
$servername = "localhost";
$username = "nede"; // MySQL 사용자명
$password = "dudtls1004!!"; // MySQL 비밀번호
$dbname = "nede";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// POST 요청 데이터 받기
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "아이디와 비밀번호를 입력해주세요."]);
    exit();
}

// 사용자 인증
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // 비밀번호 검증
    if (password_verify($password, $user['password'])) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 세션에 사용자 정보 저장
        $_SESSION['username'] = $user['username']; // 세션에 사용자 ID 저장
        $_SESSION['name'] = $user['name'];         // 세션에 사용자 이름 저장 (DB 컬럼 이름에 따라 변경 필요)
        echo json_encode(["status" => "success", "message" => "로그인 성공!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "비밀번호가 올바르지 않습니다."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "아이디가 존재하지 않습니다."]);
}

$stmt->close();
$conn->close();
?>
