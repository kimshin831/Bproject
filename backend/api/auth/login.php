<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// MySQL 데이터베이스 연결 설정
$servername = "localhost";
$username = "green609b";
$password = "green609!";
$dbname = "green609b";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit();
}

// POST 요청 데이터 받기
$data = json_decode(file_get_contents("php://input"), true);

$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (empty($username) || empty($password)) {
    http_response_code(400); // 잘못된 요청
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
        // 세션에 사용자 정보 저장
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];

        http_response_code(200); // 성공
        echo json_encode([
            "status" => "success",
            "message" => "로그인 성공!",
            "username" => $user['username'],
            "name" => $user['name']
        ]);
    } else {
        http_response_code(401); // 인증 실패
        echo json_encode(["status" => "error", "message" => "비밀번호가 올바르지 않습니다."]);
    }
} else {
    http_response_code(404); // 사용자 없음
    echo json_encode(["status" => "error", "message" => "아이디가 존재하지 않습니다."]);
}

$stmt->close();
$conn->close();
?>
