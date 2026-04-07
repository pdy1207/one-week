<?php
require '../config/db.php';
require 'main.php';

$controller = new MainController($dbh);

$phone = $_POST['phone'] ?? '';

if (!$phone) {
    echo json_encode([
        'status' => 400,
        'message' => '전화번호가 없습니다.'
    ]);
    exit;
}

// 중복 체크
$exists = $controller->checkDuplicate($phone);

echo json_encode([
    'status' => 200,
    'exists' => $exists
]);