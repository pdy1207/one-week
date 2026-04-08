<?php

http_response_code(404);
$g_title = '';
$hide_header = true; 
require './layout/header.php'; 
?>

<div class="container text-center py-5">
    <div class="py-5">
        <h2 class="fw-bold">요청하신 페이지를 찾을 수 없습니다.</h2>
        <p class="text-muted mb-4">
            입력하신 주소가 잘못되었거나, 페이지가 삭제되었을 수 있습니다.<br>
            입력하신 주소를 다시 한번 확인해주세요.
        </p>
        <a href="/" class="btn btn-primary rounded-pill px-5 shadow-sm">
            <i class="bi bi-house-door me-2"></i>메인으로 돌아가기
        </a>
    </div>
</div>