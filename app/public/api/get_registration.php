<?php

require '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

try {

    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'] ?? '';
    $phone = $data['phone'] ?? '';

    if (!$name || !$phone) {
        http_response_code(400);
        echo json_encode([
            'status' => 400,
            'message' => '필수값 누락'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sql = "
        SELECT course_id, name, birth, phone, email, size, 
        agree_rally, agree_info, agree_market, 
        DATE_FORMAT(created_at, '%Y년 %m월 %d일 %H시 %i분') AS created_at, 
        zipcode, addr1, addr2, pay_complete, participant_code  
        FROM registrations
        WHERE name = ? AND phone = ?
        LIMIT 1
    ";

    $stmt = $dbh->prepare($sql);
    $stmt->execute([$name, $phone]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode([
            'status' => 404,
            'message' => '조회 결과 없음',
            'data' => null
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'status' => 200,
        'data' => $row
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'status' => 500,
        'message' => '서버 오류',
        'detail' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);

}