
<?php
// 데이터베이스 연결 설정
$host = 'localhost';
$db_name = 'nede';
$username = 'nede';
$password = 'dudtls1004!!';

// PDO를 사용하여 데이터베이스 연결
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 연결 실패 시 에러 메시지 출력
    echo "데이터베이스 연결 실패: " . $e->getMessage();
    exit;
}
?>