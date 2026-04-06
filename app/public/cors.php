<?php

$js_array = ['./js/agree.js'];

$g_title = '마라톤 코스 선택';
$menu_code = 'agree';

require './layout/header.php';
?>


<main class="w-50 mx-auto border rounded-2 p-5 ">
    <!-- 마라톤 코스 선택 -->
    <div class="mt-4">
        <label class="form-label fw-bold">🏃 마라톤 코스 선택</label>

        <div class="row g-3">

            <!-- 5km -->
            <div class="col-6">
                <input type="radio" class="btn-check" name="course" id="course1" value="5km" checked>
                <label class="btn btn-outline-success w-100 p-3" for="course1">
                    <div class="fw-bold">5km</div>
                    <small>가족 러닝</small><br>
                    <small>30,000원</small>
                </label>
            </div>

            <!-- 10km -->
            <div class="col-6">
                <input type="radio" class="btn-check" name="course" id="course2" value="10km">
                <label class="btn btn-outline-info w-100 p-3" for="course2">
                    <div class="fw-bold">10km</div>
                    <small>일반 코스</small><br>
                    <small>50,000원</small>
                </label>
            </div>

            <!-- Half -->
            <div class="col-6">
                <input type="radio" class="btn-check" name="course" id="course3" value="half">
                <label class="btn btn-outline-warning w-100 p-3" for="course3">
                    <div class="fw-bold">Half</div>
                    <small>21.0975km</small><br>
                    <small>60,000원</small>
                </label>
            </div>

            <!-- Full -->
            <div class="col-6">
                <input type="radio" class="btn-check" name="course" id="course4" value="full">
                <label class="btn btn-outline-danger w-100 p-3" for="course4">
                    <div class="fw-bold">Full</div>
                    <small>42.195km</small><br>
                    <small>70,000원</small>
                </label>
            </div>
            <div class="mt-4 d-flex">
                <button type="button" id="btn_next" class="btn btn-primary w-100 py-2">
                    다음 →
                </button>
            </div>
        </div>
    </div>
</main>

<?php 
    require './layout/footer.php';
 ?>