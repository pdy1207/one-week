<?php

    $js_array = ['./js/info.js'];

    $g_title = '참가자 정보 입력';
    $menu_code = 'agree';
    $course = isset($_GET['course']) ? (int)$_GET['course'] : 0;
    $course_name = isset($_GET['name']) ? $_GET['name'] : '';
    require './layout/header.php';    
?>
<main class="w-50 mx-auto border rounded-2 p-5">

    <h3 class="mb-4 text-center">참가자 정보 입력</h3>


    <!-- 코스 (hidden) -->
    <div class="mb-3">
        <label class="form-label">코스</label>

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

    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary w-50">
            신청 완료
        </button>
        <button type="button" class="btn btn-outline-secondary w-50">
            신청 취소
        </button>
    </div>


</main>

<?php 
    require './layout/footer.php';
?>