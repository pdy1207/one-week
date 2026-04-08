<?php

$js_array = ['./js/pay.js'];

$g_title = '대회 코스 및 결제 정보';
$menu_code = 'agree';
$course = $_GET['course'] ?? '';

require './layout/header.php';    


$data = $_POST ?? [];

// 필수 체크
if (empty($data)) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 동의 체크 상태
$agree_rally = !empty($data['agree_rally']);
$agree_info = !empty($data['agree_info']);
$agree_market = $data['agree_market'] ?? 0;

$course = (int)($data['course'] ?? 0);

switch ($course) {
    case 1:
        $price = 30000;
        break;
    case 2:
        $price = 50000;
        break;
    case 4:
        $price = 60000;
        break;
    case 5:
        $price = 70000;
        break;
    default:
        $price = '잘못된 오류입니다.';
}

?>

<main class="container py-3">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-body p-5">

                    <h2 class="text-center fw-bold mb-4">대회 코스 & 결제 정보</h2>

                    <input type="hidden" name="course" value="<?= $data['course'] ?>">
                    <input type="hidden" name="name" value="<?= $data['name'] ?>">
                    <input type="hidden" name="birth" value="<?= $data['birth'] ?>">
                    <input type="hidden" name="gender" value="<?= $data['gender'] ?>">
                    <input type="hidden" name="phone" value="<?= $data['phone'] ?>">
                    <input type="hidden" name="email" value="<?= $data['email'] ?>">
                    <input type="hidden" name="tshirt_size" value="<?= $data['tshirt_size'] ?>">
                    <input type="hidden" name="agree_rally" value="<?= $data['agree_rally'] ?>">
                    <input type="hidden" name="agree_info" value="<?= $data['agree_info'] ?>">
                    <input type="hidden" name="agree_market" value="<?= $data['agree_market'] ?>">
                    <input type="hidden" name="zipcode" value="<?= $data['zipcode'] ?>">
                    <input type="hidden" name="f_adress" value="<?= $data['f_adress'] ?>">
                    <input type="hidden" name="f_adress2" value="<?= $data['f_adress2'] ?>">

                    <!-- 코스 -->
                    <div class="d-flex  gap-2">
                        <!-- 코스 이름 -->
                        <input id="course_name" value="<?= htmlspecialchars($data['course_name']) ?>" type="text"
                            class="form-control text-center bg-light border-2" readonly>

                        <!-- 코스 설명 -->
                        <input id="course_des" value="<?= htmlspecialchars($data['course_des']) ?>" type="text"
                            style="color: white !important;" class="form-control text-muted border-0 text-center "
                            readonly>
                    </div>

                    <hr>

                    <!-- 정보 -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-muted">이름</span>
                            <span><?= htmlspecialchars($data['name']) ?></span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-muted">생년월일</span>
                            <span><?= htmlspecialchars($data['birth']) ?></span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-muted">연락처</span>
                            <span><?= htmlspecialchars($data['phone']) ?></span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-muted">이메일</span>
                            <span><?= htmlspecialchars($data['email']) ?></span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-muted">기념품 사이즈</span>
                            <span><?= htmlspecialchars($data['tshirt_size']) ?></span>
                        </div>

                        <div class="py-2 d-flex justify-content-between align-items-start">
                            <div class="text-muted">주소</div>

                            <div class="text-end">
                                (<?= htmlspecialchars($data['zipcode']) ?>)<br>
                                <?= htmlspecialchars($data['f_adress']) ?><br>
                                <?= htmlspecialchars($data['f_adress2']) ?>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- 개인정보 동의 상태 -->
                    <div class="mb-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">개인정보 수집 동의</span>
                            <span class="<?= $agree_info ? 'text-success' : 'text-danger' ?> fw-bolder">
                                <?= $agree_info ? '동의' : '미동의' ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">러닝 대회 참가 동의</span>
                            <span class="<?= $agree_rally ? 'text-success' : 'text-danger' ?> fw-bolder">
                                <?= $agree_rally ? '동의' : '미동의' ?>
                            </span>
                        </div>


                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">이벤트/마케팅 동의</span>
                            <span class="<?= $agree_market ? 'text-success' : 'text-danger' ?> fw-bolder">
                                <?= $agree_market ? '동의' : '미동의' ?>
                            </span>
                        </div>


                    </div>

                    <!-- 금액 -->
                    <div class="text-center bg-light p-4 rounded-3 mb-4">
                        <div class="text-muted fw-bolder">결제 금액</div>
                        <div class="fs-2 fw-bold text-danger">
                            <?= number_format($price) ?>원
                        </div>
                    </div>

                    <!-- 로딩 -->
                    <div id="loading" class="d-none text-center mb-3">
                        <div class="spinner-border"></div>
                        <div class="mt-2">결제 처리 중...</div>
                    </div>

                    <!-- 결과 -->
                    <div id="result" class="text-center fw-bold mb-3"></div>

                    <!-- 버튼 -->
                    <button id="btn_pay" class="btn btn-danger w-100 py-3 fw-bold rounded-3 text-light">
                        결제 진행하기
                    </button>

                </div>
            </div>

        </div>
    </div>

</main>

<?php 
require './layout/footer.php';
?>