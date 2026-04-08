<?php
    $js_array = ['./js/info.js'];
    $g_title = '참가자 정보 입력';
    $menu_code = 'agree';
    
    // 데이터 수신
    $course = isset($_GET['course']) ? (int)$_GET['course'] : 0;
    $agree_rally  = isset($_GET['agree_rally']) ? (int)$_GET['agree_rally'] : 0;
    $agree_info   = isset($_GET['agree_info']) ? (int)$_GET['agree_info'] : 0;
    $agree_market = isset($_GET['agree_market']) ? (int)$_GET['agree_market'] : 0;

    // 필수 값이 없으면 루트로 이동
    if (!$agree_rally || !$agree_info || !$course) {
        echo "<script>alert('잘못된 접근 입니다.'); window.location.href = './';</script>";
        exit;
    }

    require './layout/header.php';    
?>
<link rel="stylesheet" href="./css/info.css">

<script src="//t1.kakaocdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">

            <form action="./pay.php" method="post" id="f_info"
                class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <h3 class="mb-1 fw-bold">참가자 정보 입력</h3>
                    <p class="mb-0 opacity-75">대회 참가를 위한 상세 정보를 입력해 주세요.</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    <div id="course_des_box" class="mb-5 p-3 bg-light rounded-3 border-start border-primary border-4">
                        <label id="course_des_sel" class="form-label small text-uppercase fw-bold">선택한
                            코스</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="hidden" name="course" value="<?= $course ?>">
                            <input type="hidden" name="agree_rally" value="<?= $agree_rally ?>">
                            <input type="hidden" name="agree_info" value="<?= $agree_info ?>">
                            <input type="hidden" name="agree_market" value="<?= $agree_market ?>">

                            <div class="flex-grow-1">
                                <input id="course_name" name="course_name" type="text"
                                    class="form-control-plaintext fs-4 fw-extrabold p-0" readonly value="불러오는 중...">
                                <input id="course_des" name="course_des" type="text"
                                    class="form-control-plaintext text-secondary p-0 small" readonly value="">
                            </div>
                            <i class="bi bi-check2-circle fs-1 text-primary opacity-25"></i>
                        </div>
                    </div>

                    <h5 class="mb-3 fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i>기본 정보</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">이름</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg"
                                placeholder="실명을 입력하세요">
                            <div id="name_error" class="text-danger small mt-1 d-none"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">생년월일</label>
                            <input type="text" name="birth" id="birth" class="form-control form-control-lg"
                                placeholder="YYYY-MM-DD">
                            <div id="birth_error" class="text-danger small mt-1 d-none"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold d-block">성별</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="gender" id="M" value="M" autocomplete="off">
                                <label class="btn btn-outline-primary py-2" for="M">남성 (Male)</label>

                                <input type="radio" class="btn-check" name="gender" id="F" value="F" autocomplete="off">
                                <label class="btn btn-outline-primary py-2" for="F">여성 (Female)</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    <h5 class="mb-3 fw-bold"><i class="bi bi-telephone me-2 text-primary"></i>연락처 및 옵션</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">연락처</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg"
                                placeholder="010-0000-0000">
                            <div id="phone_error" class="text-danger small mt-1 d-none"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">이메일</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg"
                                placeholder="example@mail.com">
                            <div id="email_error" class="text-danger small mt-1 d-none"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">기념품 사이즈 (T-Shirt)</label>
                            <select name="tshirt_size" class="form-select form-select-lg">
                                <option value="" selected disabled>사이즈를 선택하세요</option>
                                <option value="S">S (85)</option>
                                <option value="M">M (90)</option>
                                <option value="L">L (95)</option>
                                <option value="XL">XL (100)</option>
                                <option value="XXL">XXL (105)</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    <h5 class="mb-3 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>기념품 수령 주소</h5>
                    <div class="row g-2 mb-3">
                        <div class="col-8 col-md-4">
                            <input type="text" name="zipcode" id="zipcode" readonly
                                class="form-control form-control-lg bg-white" placeholder="우편번호">
                        </div>
                        <div class="col-4 col-md-3">
                            <button type="button" class="btn btn-dark btn-lg w-100" id="btn_zipcode">검색</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg" id="f_adress" name="f_adress"
                            placeholder="기본 주소" readonly>
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-lg" id="f_adress2" name="f_adress2"
                            placeholder="상세 주소를 입력해 주세요">
                    </div>

                    <div class="row g-3 mt-5">
                        <div class="col-md-6 order-2 order-md-1">
                            <button type="button" id="btn_cancel"
                                class="btn btn-light btn-lg w-100 fw-bold text-secondary">신청 취소</button>
                        </div>
                        <div class="col-md-6 order-1 order-md-2">
                            <button type="button" class="btn btn-primary btn-lg w-100 fw-bold shadow">
                                정보 입력 완료 <i class="bi bi-arrow-right-circle ms-1"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</main>



<?php require './layout/footer.php'; ?>