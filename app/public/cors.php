<?php

$js_array = ['./js/cors.js'];

$g_title = '마라톤 코스 선택';
$menu_code = 'agree';

require './layout/header.php';

$agree_rally  = isset($_POST['agree_rally']) ? (int)$_POST['agree_rally'] : 0;
$agree_info   = isset($_POST['agree_info']) ? (int)$_POST['agree_info'] : 0;
$agree_market = isset($_POST['agree_market']) ? (int)$_POST['agree_market'] : 0;

?>


<main class="w-50 mx-auto border rounded-2 p-5 ">

    <form id="f_course" method="get" action="info.php">
        <input type="hidden" name="agree_rally" value="<?= $agree_rally ?>">
        <input type="hidden" name="agree_info" value="<?= $agree_info ?>">
        <input type="hidden" name="agree_market" value="<?= $agree_market ?>">
        <!-- 마라톤 코스 선택 -->
        <div class="mt-4">
            <h3 class="form-label fw-bold">🏃 마라톤 코스 선택</h3>

            <div class="row g-3">

                <div id="course_list" class="row g-3"></div>

                <div class="mt-4 d-flex">
                    <button type="button" id="btn_next" class="btn btn-primary w-100 py-2">
                        다음 →
                    </button>
                </div>
                <div class="mt-4 p-3 border rounded bg-light text-center">
                    <h5>총 결제 예정 금액</h5>
                    <h3 id="total_price">0원</h3>
                </div>
            </div>
        </div>
    </form>
</main>

<?php 
    require './layout/footer.php';
 ?>