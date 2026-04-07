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

<body>

    <div class="container mt-5">

        <!-- 대회 정보 -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3"><?= $g_title ?></h2>

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

                <h4 class="mb-4">코스별 정보</h4>

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