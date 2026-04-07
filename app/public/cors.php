<?php

$js_array = ['./js/cors.js'];

$g_title = '마라톤 코스 선택';
$menu_code = 'agree';

require './layout/header.php';

$agree_rally  = isset($_POST['agree_rally']) ? (int)$_POST['agree_rally'] : 0;
$agree_info   = isset($_POST['agree_info']) ? (int)$_POST['agree_info'] : 0;
$agree_market = isset($_POST['agree_market']) ? (int)$_POST['agree_market'] : 0;

?>

<style>
/* 기본 선택 색 제거 */
.course-radio:checked+label {
    color: #fff;
}

/* 가족 러닝 */
.course-radio[data-desc="가족 러닝"]:checked+label {
    background-color: #198754;
    /* bg-success */
    border-color: #198754;
}

/* 일반 코스 */
.course-radio[data-desc="일반 코스"]:checked+label {
    background-color: #0d6efd;
    /* bg-primary */
    border-color: #0d6efd;
}

/* Half 코스 */
.course-radio[data-desc="Half 코스"]:checked+label {
    background-color: #ffc107;
    /* bg-warning */
    border-color: #ffc107;
    color: #000;
}

/* Full 코스 */
.course-radio[data-desc="Full 코스"]:checked+label {
    background-color: #dc3545;
    /* bg-danger */
    border-color: #dc3545;
}
</style>

<body class="d-flex flex-column min-vh-100">
    <main class="w-50 mx-auto border rounded-2 p-5 flex-grow-1">

        <form id="f_course" method="get" action="info.php">
            <input type="hidden" name="agree_rally" value="<?= $agree_rally ?>">
            <input type="hidden" name="agree_info" value="<?= $agree_info ?>">
            <input type="hidden" name="agree_market" value="<?= $agree_market ?>">

            <!-- 마라톤 코스 선택 -->
            <h3 class="form-label fw-bold">🏃 마라톤 코스 선택</h3>

            <!-- 코스 카드 그리드 -->
            <div id="course_list" class="row g-3"></div>

            <!-- 버튼 영역 -->
            <div class="mt-4 d-flex gap-2">
                <button type="button" id="btn_next" class="btn btn-primary flex-fill py-2">
                    다음 →
                </button>
                <button type="button" id="btn_cancel" class="btn btn-secondary flex-fill py-2">
                    취소
                </button>
            </div>

            <!-- 총 결제금액 영역 -->
            <div class="mt-4 p-3 border rounded bg-light text-center">
                <h5>결제 예정 금액</h5>
                <h3 id="total_price">0원</h3>
            </div>
        </form>
    </main>
</body>
<?php 
    require './layout/footer.php';
 ?>