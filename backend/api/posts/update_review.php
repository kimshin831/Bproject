<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "리뷰 ID가 제공되지 않았습니다."]);
        exit;
    }

    $reviewId = intval($_GET['id']);
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "제목과 내용을 입력해주세요."]);
        exit;
    }

    try {
        // 기존 리뷰 정보 가져오기
        $stmt = $conn->prepare("SELECT image_path FROM reviews WHERE user_id = ?");
        $stmt->execute([$reviewId]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$review) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "리뷰를 찾을 수 없습니다."]);
            exit;
        }

        $uploadDir = '/uploads/';
        $absoluteUploadDir = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

        // 새 이미지 업로드 처리
        $newImagePath = $review['image_path']; // 기존 이미지 유지
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $absoluteFilePath = $absoluteUploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $absoluteFilePath)) {
                $newImagePath = $uploadDir . $fileName; // 새 이미지 경로 설정

                // 기존 이미지 삭제
                $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . $review['image_path'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "새 이미지 업로드 실패"]);
                exit;
            }
        }

        // 리뷰 업데이트
        $stmt = $conn->prepare("UPDATE reviews SET title = ?, content = ?, image_path = ? WHERE user_id = ?");
        $stmt->execute([$title, $content, $newImagePath, $reviewId]);

        echo json_encode(["status" => "success", "message" => "리뷰가 성공적으로 수정되었습니다."]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "리뷰 수정 중 오류 발생: " . $e->getMessage()]);
    }
}
?>
