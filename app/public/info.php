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

    <form method="post" action="./pay.php">

        <!-- 코스 (hidden) -->
        <div class="mb-3">
            <label class="form-label">코스</label>
            <input type="hidden" name="course" value="<?= $course ?>">
            <input id="course_name" name="course_name" type="text" class="form-control" readonly>
        </div>

        <!-- 이름 -->
        <div class="mb-3">
            <label class="form-label">이름</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- 생년월일 -->
        <div class="mb-3">
            <label class="form-label">생년월일</label>
            <input type="date" name="birth" class="form-control" required>
        </div>

        <!-- 성별 -->
        <div class="mb-3">
            <label class="form-label">성별</label><br>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="M" required>
                <label class="form-check-label">남</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="F">
                <label class="form-check-label">여</label>
            </div>
        </div>

        <!-- 연락처 -->
        <div class="mb-3">
            <label class="form-label">연락처</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <!-- 이메일 -->
        <div class="mb-3">
            <label class="form-label">이메일</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- 기념품 사이즈 -->
        <div class="mb-3">
            <label class="form-label">기념품 사이즈</label>

            <select name="tshirt_size" class="form-select" required>
                <option value="">선택</option>
                <option value="S">S (85)</option>
                <option value="M">M (90)</option>
                <option value="L">L (95)</option>
                <option value="XL">XL (100)</option>
                <option value="XXL">XXL (105)</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary w-50">
                신청 완료
            </button>
            <button type="submit" class="btn btn-outline-secondary w-50">
                신청 취소
            </button>
        </div>

    </form>

</main>

<?php 
    require './layout/footer.php';
?>