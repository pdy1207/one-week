<?php

$js_array = ['./js/pay.js'];

$g_title = '결제 페이지';
$menu_code = 'agree';
$course = $_GET['course'] ?? '';

require './layout/header.php';    
?>

<main class="w-50 mx-auto border rounded-4 p-5 text-center">

    <h3 class="mb-4">결제하기</h3>

    <p class="mb-4">참가 신청을 완료하려면 결제를 진행하세요.</p>

    <!-- 로딩 -->
    <div id="loading" class="d-none mb-3">
        <div class="spinner-border" role="status"></div>
        <p class="mt-2">결제 처리 중...</p>
    </div>

    <!-- 결과 메시지 -->
    <div id="result" class="mb-3 fw-bold"></div>

    <!-- 결제 버튼 -->
    <button id="btn_pay" class="btn btn-primary w-100">
        결제하기
    </button>

</main>

<?php 
require './layout/footer.php';
?>