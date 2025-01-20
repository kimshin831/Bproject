<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON 데이터 파싱
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("DELETE 요청 데이터: " . print_r($data, true)); // 요청 데이터 로그

    $reviewId = $data['id'] ?? null;

    if (!$reviewId) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "리뷰 ID가 제공되지 않았습니다."]);
        exit;
    }

    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "로그인 상태가 아닙니다."]);
        exit;
    }

    try {
        // 리뷰 데이터 가져오기
        $stmt = $conn->prepare("SELECT image_path FROM reviews WHERE user_id = ?");
        $stmt->execute([$reviewId]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($review && !empty($review['image_path'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $review['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath); // 이미지 파일 삭제
            }
        }

        // 리뷰 삭제
        $stmt = $conn->prepare("DELETE FROM reviews WHERE user_id = ?");
        $stmt->execute([$reviewId]);

        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "리뷰가 성공적으로 삭제되었습니다."]);
    } catch (PDOException $e) {
        error_log("리뷰 삭제 중 오류 발생: " . $e->getMessage()); // 로그에 기록
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "리뷰 삭제 중 오류 발생: " . $e->getMessage()]);
    }
}
?>
