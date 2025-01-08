<?php
// 응답을 JSON 형식으로 설정
header('Content-Type: application/json');

// 데이터베이스 연결 및 세션 관련 설정 파일 포함
require_once '../../config/db.php'; // 데이터베이스 연결 설정 파일
require_once '../../config/session.php'; // 세션 설정 파일

// 세션이 시작되지 않은 경우 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // 세션 시작
}

// 요청 방식 확인 (POST 요청만 처리)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 클라이언트로부터 JSON 데이터 수신
    $data = json_decode(file_get_contents('php://input'), true);

    // 입력 값 확인 (username과 password가 비어있는지 확인)
    if (empty($data['username']) || empty($data['password'])) {
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

    try {
        // 사용자 조회 쿼리 실행
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username"); // 사용자 이름으로 사용자 정보 조회
        $stmt->bindParam(':username', $username); // 사용자 이름을 쿼리에 바인딩
        $stmt->execute(); // 쿼리 실행
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // 결과를 연관 배열로 가져오기

        // 사용자 및 비밀번호 확인
        if ($user && password_verify($password, $user['password'])) {
            // 비밀번호가 일치하면 세션에 사용자 정보 저장
            $_SESSION['user_id'] = $user['id']; // 사용자 ID 저장
            $_SESSION['username'] = $username; // 사용자 이름 저장

            // 로그인 성공 응답 반환
            echo json_encode([
                'success' => true,
                'message' => 'Login successful' // 로그인 성공 메시지
            ]);
        } else {
            // 사용자 이름 또는 비밀번호가 잘못된 경우
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password' // 로그인 실패 메시지
            ]);
        }
    } catch (PDOException $e) {
        // 데이터베이스 오류 처리
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage() // PDOException 메시지 포함
        ]);
    }
} else {
    // 잘못된 요청 방식 처리 (POST가 아닌 경우)
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method' // 잘못된 요청 방식 메시지
    ]);
}
?>
