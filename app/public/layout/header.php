<?php 
function getCourseBadgeClass($course_name) {
    if (strpos($course_name, '10km') !== false) return 'bg-success'; 
    if (strpos($course_name, '5km') !== false) return 'bg-primary';  
    if (strpos($course_name, '21km') !== false) return 'bg-warning';   
    if (strpos($course_name, '42km') !== false) return 'bg-danger';    
    return 'bg-secondary'; // 기본값
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $g_title ?></title>
    <!-- 부트스트랩 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <!-- 부트스트랩 아이콘 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- 폰트 -->
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" rel="stylesheet">
    <!-- css경로 -->
    <link rel="stylesheet" href="../css/header.css">
    <!-- css경로 -->
    <link rel="stylesheet" href="../css/admin.css">
    <!-- 부트스트랩 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- js 업데이트 -->
    <?php 
        if(isset($js_array)){
            foreach ($js_array as $var) {
                echo '<script src="' . $var . '?v=' . date('YmdHis') . '"></script>' . PHP_EOL;
            }
        } ?>
    <!-- nav-link css -->
    <script>
    $(document).ready(function() {
        $('.nav-link').on('click', function() {
            sessionStorage.removeItem('applyForm');
        });
    });
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="custom-header py-3 mb-4">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">

            <?php 
                $current_file = basename($_SERVER['PHP_SELF']); 
                if ($current_file !== 'login.php' && $current_file !== 'admin_dashboard.php' && $current_file !== 'details.php' && $current_file !== 'send_message.php'): 
            ?>
            <!-- 로고 -->
            <a href="/" class="text-decoration-none custom-title fs-4">
                <?= $g_title ?>
            </a>
            <?php else: ?>
            <a href="../admin_dashboard.php" class="text-decoration-none custom-title fs-4">
                <?= $g_title ?>
            </a>
            <?php endif; ?>
            <?php 
                $current_file = basename($_SERVER['PHP_SELF']); 
                if ($current_file !== 'login.php' && $current_file !== 'admin_dashboard.php' && $current_file !== 'details.php' && $current_file !== 'send_message.php'): 
            ?>


            <!-- 메뉴 -->
            <ul class="nav gap-2">
                <li class="nav-item">
                    <a href="/" class="nav-link <?= ($menu_code === '') ? 'active' : '' ?>">
                        대회 현황
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../list.php" class="nav-link <?= ($menu_code === 'list') ? 'active' : '' ?>">
                        접수 내역
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../agree.php" class="nav-link <?= ($menu_code === 'agree') ? 'active' : '' ?>">
                        대회 접수
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/login.php" class="nav-link" target="_blank">
                        관리자 페이지
                    </a>
                </li>

            </ul>

            <?php elseif($current_file !== 'login.php'): ?>
            <ul class="nav gap-2">
                <li class="nav-item">
                    <a href="../admin/details.php" class="nav-link <?= ($menu_code === 'details') ? 'active' : '' ?>">
                        접수 내역
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/send_message.php" class="nav-link <?= ($menu_code === 'send') ? 'active' : '' ?>">
                        문자 발송
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Docs
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                                href="https://gem-hacksaw-4b1.notion.site/33a9c91d6b5780089d58c722bc9406dc?pvs=74"
                                target="_blank">
                                API 및 프로젝트 폴더 문서
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="https://github.com/pdy1207/one-week-readme/tree/main"
                                target="_blank">
                                기술문서 README.md
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>

        </div>
    </header>