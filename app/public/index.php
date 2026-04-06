<!-- Landing Page -->

<?php
    $g_title ='대회 정보';
    $menu_code = '';
    require './layout/header.php';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $g_title ?></title>
</head>

<body>

    <div class="container mt-5">

        <!-- 대회 정보 -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3">🏆 2026 마라톤 대회 접수</h2>

                <p class="card-text">
                    📅 날짜: 2026년 4월 10일<br>
                    📍 장소: 대전 엔디소프트 11층<br>
                    ⏰ 시작 시간: 오전 9시<br>
                    📝 참가 인원: 선착순 모집 (최대 500명)
                </p>
            </div>
        </div>

        <!-- 코스 정보 -->
        <div class="card shadow-sm">
            <div class="card-body">

                <h4 class="mb-4">🎟️ 코스별 정보</h4>

                <?php
            // 실제 db 연결
            $courses = [
                [
                    'name' => '5km 코스 (가족 런)',
                    'price' => 30000,
                    'total' => 3000,
                    'registered' => 120,
                    'limit' => '나이 제한 없음',
                    'color' => 'success'
                ],
                [
                    'name' => '10km 코스',
                    'price' => 50000,
                    'total' => 5000,
                    'registered' => 2500,
                    'limit' => ''
                ],
                [
                    'name' => 'Half 코스 (21.0975km)',
                    'price' => 60000,
                    'total' => 4000,
                    'registered' => 2000,
                    'limit' => ''
                ],
                [
                    'name' => 'Full 코스 (42.195km)',
                    'price' => 80000,
                    'total' => 2000,
                    'registered' => 1900,
                    'limit' => '만 18세 이상',
                    'color' => 'danger'
                ]
            ];

            foreach ($courses as $c) {

                $percent = ($c['registered'] / $c['total']) * 100;
                $remaining = $c['total'] - $c['registered'];

                // 색상 기본값
                $color = $c['color'] ?? 'primary';
            ?>

                <div class="mb-4">

                    <div class="d-flex justify-content-between">
                        <strong><?= $c['name'] ?></strong>
                        <span class="text-muted">
                            현재: <?= number_format($c['registered']) ?> / <?= number_format($c['total']) ?>
                        </span>
                    </div>

                    <div class="small text-muted mb-1">
                        💰 참가비: <?= number_format($c['price']) ?>원
                        <?php if (!empty($c['limit'])): ?>
                        | <span class="badge bg-dark"><?= $c['limit'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="small text-muted mb-1">
                        🎯 잔여 인원: <?= number_format($remaining) ?>명
                    </div>

                    <div class="progress">
                        <div class="progress-bar bg-<?= $color ?>" style="width: <?= $percent ?>%"></div>
                    </div>

                </div>

                <?php } ?>

            </div>
        </div>

    </div>

</body>

</html>

<?php
    require './layout/footer.php';
    
?>