<?php
$js_array = ['./js/cors.js'];
$g_title = '마라톤 코스 선택';
$menu_code = 'agree';

require './layout/header.php';

// 데이터 수신
$agree_rally  = isset($_POST['agree_rally']) ? (int)$_POST['agree_rally'] : 0;
$agree_info   = isset($_POST['agree_info']) ? (int)$_POST['agree_info'] : 0;
$agree_market = isset($_POST['agree_market']) ? (int)$_POST['agree_market'] : 0;

echo $agree_rally, $agree_info, $agree_market;

?>

<main class="container py-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            <form id="f_course" method="get" action="info.php"
                class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div style="height: 6px; background: linear-gradient(90deg, #6610f2, #0d6efd);"></div>

                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-extrabold text-dark mt-2">마라톤 코스 선택</h2>
                        <p class="text-secondary">코스를 선택해 주세요.</p>
                    </div>

                    <input type="hidden" name="agree_rally" value="<?= $agree_rally ?>">
                    <input type="hidden" name="agree_info" value="<?= $agree_info ?>">
                    <input type="hidden" name="agree_market" value="<?= $agree_market ?>">

                    <div id="course_list" class="row g-4 mb-5">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">코스 정보를 불러오는 중...</p>
                        </div>
                    </div>

                    <div class="bg-light rounded-4 p-4 mb-4 border border-dashed border-2">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                <h5 class="text-secondary mb-1">최종 결제 예정 금액</h5>
                                <h2 id="total_price" class="fw-bold text-primary mb-0">0원</h2>
                            </div>
                            <div class="col-md-6 d-flex gap-2">
                                <button type="button" id="btn_cancel"
                                    class="btn btn-outline-secondary flex-fill py-3 rounded-3 fw-bold">
                                    이전으로
                                </button>
                                <button type="button" id="btn_next"
                                    class="btn btn-primary flex-fill py-3 rounded-3 fw-bold shadow-sm">
                                    다음 단계로 <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</main>


<?php require './layout/footer.php'; ?>