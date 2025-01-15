<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once '../../config/db.php';

try {
    // 데이터베이스에서 리뷰 가져오기
    $stmt = $conn->prepare("SELECT user_id, username, title, content, image_path, created_at, updated_at FROM reviews ORDER BY created_at DESC");
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($reviews as &$review) {
        if (!empty($review['image_path'])) {
            $review['image_path'] = 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/' . basename($review['image_path']);
        }
    }

    // JSON 형식으로 응답 반환
    echo json_encode($reviews);
} catch (PDOException $e) {
    http_response_code(500); // 서버 오류 상태 코드 반환
    echo json_encode(["error" => "리뷰 데이터를 가져오는 데 실패했습니다: " . $e->getMessage()]);
}
?>
