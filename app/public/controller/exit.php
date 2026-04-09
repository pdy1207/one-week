<?php

// 사용자가 요청한 주소
$request_uri = $_SERVER['REQUEST_URI'];

// 만약 메인페이지(/)나 알려진 파일이 아니면 404 띄우기
if ($request_uri !== '/' && $request_uri !== '/index.php') {
    http_response_code(404);
    include "404.php";
    exit;
}