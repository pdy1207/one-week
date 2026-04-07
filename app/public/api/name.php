<?php

require '../controller/main.php';

try {

    $course_id = isset($_GET['course']) ? (int)$_GET['course'] : 0;
    $main = new MainController($dbh);
    $courses_name = $main->getCoursesName($course_id);

    echo json_encode([
        'status' => 200,
        'data' => $courses_name
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'status' => 'error',
        'message' => '서버 오류 발생',
        'detail' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}