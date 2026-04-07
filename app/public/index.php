<!-- Landing Page -->
<?php
    $js_array = ['./js/main.js'];
    $g_title ='2026 마라톤 대회 정보';
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

<body class="d-flex flex-column min-vh-100">

    <div class="container mt-5">

        <!-- 대회 정보 -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3"><i class="bi bi-trophy-fill"></i> <?= $g_title ?></h2>

                <p class="card-text">
                    <i class="bi bi-calendar-check-fill"></i> 날짜: 2026년 4월 10일<br>
                    <i class="bi bi-geo-alt-fill"></i> 장소: 대전 엔디소프트 11층<br>
                    <i class="bi bi-clock-fill"></i> 시작 시간: 오전 9시<br>
                    <i class="bi bi-file-person-fill"></i> 참가 인원: 선착순 모집
                </p>
            </div>
        </div>

        <!-- 코스 정보 -->
        <div class="card shadow-sm">
            <div class="card-body">

                <h4 class="mb-4"><i class="bi bi-person-walking"></i> 코스별 정보</h4>

                <!-- 받아온 데이터 출력 -->
                <div id="course_list"></div>

            </div>
        </div>

    </div>

</body>

</html>

<?php
    require './layout/footer.php';
    
?>