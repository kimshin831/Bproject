<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['username'])) {
        echo json_encode(["status" => "error", "message" => "로그인 상태가 아닙니다."]);
        exit;
    }

    $user_id = $_SESSION['username']; // 수정: 로그인한 사용자 ID
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        echo json_encode(["status" => "error", "message" => "제목과 내용을 입력해주세요."]);
        exit;
    }

    // 업로드 경로 설정
    $uploadDir = '/uploads/';
    $absoluteUploadDir = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

    // 디렉토리 생성 (존재하지 않으면)
    if (!is_dir($absoluteUploadDir)) {
        mkdir($absoluteUploadDir, 0755, true);
    }

    $filePathForDb = null; // 기본값: 이미지 없음

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $absoluteFilePath = $absoluteUploadDir . $fileName;

        // 파일 이동
        if (move_uploaded_file($_FILES['image']['tmp_name'], $absoluteFilePath)) {
            $filePathForDb = $uploadDir . $fileName; // 상대 경로만 저장
        } else {
            echo json_encode(["status" => "error", "message" => "이미지 업로드 실패"]);
            exit;
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO reviews (username, title, content, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $content, $filePathForDb]);

        echo json_encode(["status" => "success", "message" => "리뷰가 성공적으로 저장되었습니다."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "리뷰 저장 실패: " . $e->getMessage()]);
    }
}
?>
