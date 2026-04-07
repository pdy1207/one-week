<?php

    $js_array = ['./js/info.js'];

    $g_title = '참가자 정보 입력';
    $menu_code = 'agree';
    $course = isset($_GET['course']) ? (int)$_GET['course'] : 0;
    $course_name = isset($_GET['name']) ? $_GET['name'] : '';

    $agree_rally  = isset($_GET['agree_rally']) && $_GET['agree_rally'] !== '' ? (int)$_GET['agree_rally'] : 0;
    $agree_info   = isset($_GET['agree_info']) && $_GET['agree_info'] !== '' ? (int)$_GET['agree_info'] : 0;
    $agree_market = isset($_GET['agree_market']) && $_GET['agree_market'] !== '' ? (int)$_GET['agree_market'] : 0;

    // 필수 값이 없으면 루트로 이동
    if (!$agree_rally || !$agree_info || !$course) {
        header("Location: ./");
        exit;
    }

    require './layout/header.php';    
?>

<!-- kakao 우편서비스 -->

<script src="//t1.kakaocdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<main class="w-50 mx-auto border rounded-2 p-5">
    <form action="./pay.php" method="post">
        <h3 class="mb-4 text-center">참가자 정보 입력</h3>


        <!-- 코스 (hidden) -->
        <div class="mb-3">
            <label class="form-label">코스</label>
            <input type="hidden" id="agree_rally" name="agree_rally" value="<?= $agree_rally ?>">
            <input type="hidden" id="agree_info" name="agree_info" value="<?= $agree_info ?>">
            <input type="hidden" id="agree_market" name="agree_market" value="<?= $agree_market ?>">

            <input type="hidden" name="course" value="<?= $course ?>">

            <div class="d-flex  gap-2">
                <!-- 코스 이름 -->
                <input id="course_name" name="course_name" type="text"
                    class="form-control fw-bold text-center bg-light border-2" readonly>

                <!-- 코스 설명 -->
                <input id="course_des" name="course_des" type="text"
                    class="form-control text-muted bg-light border-0 text-center" readonly>
            </div>
        </div>

        <!-- 이름 -->
        <div class="mb-3">
            <label class="form-label">이름</label>
            <input type="text" name="name" id="name" class="form-control">
            <div id="name_error" class="text-danger small mt-1 d-none"></div>
        </div>

        <!-- 생년월일 -->
        <div class="mb-3">
            <label class="form-label">생년월일</label>
            <input type="text" name="birth" id="birth" class="form-control" placeholder="YYYY-MM-DD">
            <div id="birth_error" class="text-danger small mt-1 d-none"></div>
        </div>

        <!-- 성별 -->
        <div class="mb-3">
            <label class="form-label">성별</label><br>

            <div class="form-check form-check-inline">
                <input class="form-check-input" id="M" type="radio" name="gender" value="M">
                <label class="form-check-label" for="M">남</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" id="F" type="radio" name="gender" value="F">
                <label class="form-check-label" for="F">여</label>
            </div>
        </div>

        <!-- 연락처 -->
        <div class="mb-3">
            <label class="form-label">연락처</label>
            <input type="text" name="phone" class="form-control" id="phone">
            <div id="phone_error" class="d-none text-danger"></div>
        </div>

        <!-- 이메일 -->
        <div class="mb-3">
            <label class="form-label">이메일</label>
            <input type="email" name="email" class="form-control" id="email">
            <div id="email_error" class="d-none text-danger"></div>
        </div>

        <!-- 기념품 사이즈 -->
        <div class="mb-3">
            <label class="form-label">기념품 사이즈</label>

            <select name="tshirt_size" class="form-select">
                <option value="">선택</option>
                <option value="S">S (85)</option>
                <option value="M">M (90)</option>
                <option value="L">L (95)</option>
                <option value="XL">XL (100)</option>
                <option value="XXL">XXL (105)</option>
            </select>
        </div>

        <!-- 우편번호 & 주소 중복 -->
        <div class="mt-3 d-flex align-items-end gap-2 ">
            <div>
                <label for="f_zipcode">우편번호</label>
                <input type="text" name="zipcode" id="zipcode" readonly class="form-control mt-2" maxlength="5"
                    minlength="5">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 찾기</button>
        </div>

        <div class="d-flex gap-2 justify-content-between mt-3 mb-4">
            <div class="flex-grow-1">
                <label for="f_adress" class="form-label">주소</label>
                <input type="text" class="form-control" id="f_adress" name="f_adress">
            </div>

            <div class="flex-grow-1">
                <label for="f_adress2" class="form-label">상세 주소</label>
                <input type="text" class="form-control" id="f_adress2" name="f_adress2" placeholder="상세 주소를 입력해주세요">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary w-50">
                신청 완료
            </button>
            <button type="button" id="btn_cancel" class="btn btn-outline-secondary w-50">
                신청 취소
            </button>
        </div>
    </form>

</main>

<?php 
    require './layout/footer.php';
?>