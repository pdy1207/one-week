<?php

$js_array = ['./js/cors.js'];

$g_title = '마라톤 코스 선택';
$menu_code = 'agree';

require './layout/header.php';

$courses = [
    ['id' => 1, 'name' => '5km', 'desc' => '가족 러닝', 'price' => 30000, 'max' => 100, 'current' => 95],
    ['id' => 2, 'name' => '10km', 'desc' => '일반 코스', 'price' => 50000, 'max' => 100, 'current' => 60],
    ['id' => 3, 'name' => 'Half', 'desc' => '21.0975km', 'price' => 60000, 'max' => 80, 'current' => 80],
    ['id' => 4, 'name' => 'Full', 'desc' => '42.195km', 'price' => 70000, 'max' => 50, 'current' => 10],
];
?>


<main class="w-50 mx-auto border rounded-2 p-5 ">

    <form id="f_course" method="get" action="info.php">
        <!-- 마라톤 코스 선택 -->
        <div class="mt-4">
            <label class="form-label fw-bold">🏃 마라톤 코스 선택</label>

            <div class="row g-3">

                <?php foreach ($courses as $c): 
                    $remaining = $c['max'] - $c['current'];
                    $isFull = $remaining <= 0;
                ?>
                <div class="col-6">

                    <input type="radio" class="btn-check course-radio" name="course" id="course<?= $c['id'] ?>"
                        value="<?= $c['id'] ?>" data-price="<?= $c['price'] ?>" <?= $isFull ? 'disabled' : '' ?>>

                    <label class="btn w-100 p-3 <?= $isFull ? 'btn-secondary' : 'btn-outline-primary' ?>"
                        for="course<?= $c['id'] ?>">
                        <div class="fw-bold"><?= $c['name'] ?></div>

                        <small><?= $remaining ?> / <?= $c['max'] ?> 남음</small><br>

                        <small><?= number_format($c['price']) ?>원</small>

                        <?php if ($isFull): ?>
                        <div class="badge bg-danger mt-2">접수 마감</div>
                        <?php endif; ?>
                    </label>

                </div>
                <?php endforeach; ?>
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