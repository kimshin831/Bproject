<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

// 디버깅: 요청 메서드와 파라미터 확인
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("GET Parameters: " . print_r($_GET, true));

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "리뷰 ID가 제공되지 않았습니다."]);
    exit;
}

$reviewId = intval($_GET['id']); // 리뷰 ID 가져오기

try {
    $stmt = $conn->prepare("SELECT user_id, username, title, content, image_path, created_at, updated_at FROM reviews WHERE user_id = ?");
    $stmt->execute([$reviewId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($review) {
        // 이미지 경로 변환
        if (!empty($review['image_path'])) {
            $review['image_path'] = 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/' . basename($review['image_path']);
        }
        echo json_encode($review);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "리뷰를 찾을 수 없습니다."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "리뷰 데이터를 가져오는 데 실패했습니다: " . $e->getMessage()]);
}
?>
