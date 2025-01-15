<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $reviewId = $data['id'] ?? null;

    if (!$reviewId) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "리뷰 ID가 제공되지 않았습니다."]);
        exit;
    }

    if ($review['username'] !== $loggedInUser) {
        http_response_code(403);
        echo json_encode(["status" => "error", "message" => "수정 권한이 없습니다."]);
        exit;
    }
    
    try {
        // 리뷰의 이미지 경로 가져오기
        $stmt = $conn->prepare("SELECT image_path FROM reviews WHERE user_id = ?");
        $stmt->execute([$reviewId]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($review && !empty($review['image_path'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $review['image_path'];
        
            // 디버깅: 파일 경로 확인
            error_log("삭제 시도 파일 경로: " . $filePath);
        
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    error_log("파일 삭제 성공: " . $filePath);
                } else {
                    error_log("파일 삭제 실패: " . $filePath);
                }
            } else {
                error_log("파일이 존재하지 않음: " . $filePath);
            }
        }

        // 리뷰 삭제
        $stmt = $conn->prepare("DELETE FROM reviews WHERE user_id = ?");
        $stmt->execute([$reviewId]);

        echo json_encode(["status" => "success", "message" => "리뷰가 성공적으로 삭제되었습니다."]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "리뷰 삭제 중 오류 발생: " . $e->getMessage()]);
    }
}
?>
