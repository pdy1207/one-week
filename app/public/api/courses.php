<?php

require '../controller/main.php';

try {

    $courses = [];

    $main = new MainController($dbh);
    $courses = $main->getCourses();

    echo json_encode([
        'status' => 200,
        'data' => $courses
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    http_response_code(500); // 서버 에러

    echo json_encode([
        'status' => 'error',
        'message' => '서버 오류 발생',
        'detail' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}