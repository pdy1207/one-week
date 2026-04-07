<?php

require '../controller/main.php';

try {

    // JSON 데이터 받기 (Postman / fetch 대응)
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception('데이터가 없습니다.');
    }

    // 필수값 체크
    $required = [
        'course_id','name','birth','gender','phone','email','size',
        'agree_rally','agree_info','agree_market','code',
        'zipcode','addr1','addr2'
    ];

    foreach ($required as $key) {
        if (!isset($data[$key]) || $data[$key] === '') {
            throw new Exception("필수값 누락: {$key}");
        }
    }

    $main = new MainController($dbh);

    // DB INSERT 실행
    $result = $main->infoRegistration($data);

    echo json_encode([
        'data' => $result
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'status' => 'error',
        'message' => '서버 오류 발생',
        'detail' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}