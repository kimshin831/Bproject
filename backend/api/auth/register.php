<?php
// 응답을 JSON 형식으로 설정
header('Content-Type: application/json');

// 데이터베이스 연결 설정
$servername = 'localhost';
$dbname = 'nede';
$username = 'nede';
$password = 'dudtls1004!!'; // Dothome에서 생성한 DB 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    // 연결 실패 시 JSON 형식으로 오류 메시지 반환
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// JSON 데이터 수신
$data = json_decode(file_get_contents('php://input'), true);

// 입력 데이터 유효성 검사
if (!isset($data['username']) || !isset($data['password'])) {
    // username 또는 password가 제공되지 않은 경우 오류 메시지 반환
    echo json_encode([
        'success' => false,
        'message' => 'Username and password are required' // 필수 입력값 누락 메시지
    ]);
    exit(); // 스크립트 종료
}

// 클라이언트로부터 받은 사용자 이름과 비밀번호를 변수에 저장
$username = $data['username'];
$password = $data['password'];

// 사용자 이름 중복 확인
$query = "SELECT * FROM users WHERE username = ?"; // 동일한 username이 있는지 확인하는 쿼리
$stmt = $conn->prepare($query); // SQL 쿼리 준비
$stmt->bind_param('s', $username); // username 값을 안전하게 바인딩
$stmt->execute(); // 쿼리 실행
$result = $stmt->get_result(); // 실행 결과 가져오기

if ($result->num_rows > 0) {
    // 동일한 username이 이미 존재할 경우
    echo json_encode([
        'success' => false,
        'message' => 'Username already exists' // 중복 사용자 이름 메시지
    ]);
    exit(); // 스크립트 종료
}

// 비밀번호 해싱 (보안을 위해 원본 비밀번호를 데이터베이스에 저장하지 않음)
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // 비밀번호 해싱

// 사용자 등록 쿼리
$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query); // SQL 쿼리 준비
$stmt->bind_param('ss', $username, $hashed_password); // username과 해싱된 비밀번호를 바인딩

if ($stmt->execute()) {
    // 쿼리 실행 성공 시 사용자 등록 성공 메시지 반환
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful' // 등록 성공 메시지
    ]);
} else {
    // 쿼리 실행 실패 시 오류 메시지 반환
    echo json_encode([
        'success' => false,
        'message' => 'Registration failed: ' . $stmt->error // 실패 이유 포함
    ]);
}

// SQL 문과 데이터베이스 연결 종료
$stmt->close(); // 준비된 SQL 문 닫기
$conn->close(); // 데이터베이스 연결 닫기
?>