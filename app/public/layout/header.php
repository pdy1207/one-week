<?php 
function getCourseBadgeClass($course_name) {
    $mapping = [
        '42km' => 'bg-danger',
        '21km' => 'bg-warning',
        '10km' => 'bg-success',
        '5km'  => 'bg-primary'
    ];
    foreach ($mapping as $key => $class) {
        if (strpos($course_name, $key) !== false) return $class;
    }
    return 'bg-secondary';
}

// 현재 페이지 및 환경 변수 설정
$current_file = basename($_SERVER['PHP_SELF']);

// 404 페이지거나 별도로 $hide_header 가 설정된 경우 헤더 출력 안 함
$is_hidden_page = ($current_file === '404.php' || (isset($hide_header) && $hide_header === true));
// 관리자 관련 페이지 여부 확인
$admin_pages = ['login.php', 'admin_dashboard.php', 'details.php', 'send_message.php'];
$is_admin_mode = in_array($current_file, $admin_pages);
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $g_title ?? '마라톤 대회' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/admin.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if(isset($js_array)): ?>
    <?php foreach ($js_array as $js): ?>
    <script src="<?= $js ?>?v=<?= date('YmdHis') ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>

    <script>
    $(document).ready(function() {
        $('.nav-link').on('click', function() {
            sessionStorage.removeItem('applyForm');
        });
    });
    </script>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php if (!$is_hidden_page): ?>
    <header class="custom-header py-3 mb-4 border-bottom">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">

            <a href="<?= $is_admin_mode ? '../admin_dashboard.php' : '/' ?>"
                class="text-decoration-none custom-title fs-4 fw-bold">
                <?= $g_title ?>
            </a>

            <ul class="nav gap-2">
                <?php if (!$is_admin_mode): ?>
                <li class="nav-item"><a href="/" class="nav-link <?= ($menu_code === '') ? 'active' : '' ?>">대회 현황</a>
                </li>
                <li class="nav-item"><a href="../list.php"
                        class="nav-link <?= ($menu_code === 'list') ? 'active' : '' ?>">접수 내역</a></li>
                <li class="nav-item"><a href="../agree.php"
                        class="nav-link <?= ($menu_code === 'agree') ? 'active' : '' ?>">대회 접수</a></li>
                <li class="nav-item"><a href="../admin/login.php" class="nav-link text-muted" target="_blank">관리자</a>
                </li>

                <?php elseif ($current_file !== 'login.php'): ?>
                <li class="nav-item"><a href="../admin/details.php"
                        class="nav-link <?= ($menu_code === 'details') ? 'active' : '' ?>">접수 관리</a></li>
                <li class="nav-item"><a href="../admin/send_message.php"
                        class="nav-link <?= ($menu_code === 'send') ? 'active' : '' ?>">문자 발송</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Docs</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://gem-hacksaw-4b1.notion.site/..." target="_blank">API
                                문서</a></li>
                        <li><a class="dropdown-item" href="https://github.com/..." target="_blank">GitHub</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="../admin/logout.php" class="nav-link text-danger">Logout</a></li>
                <?php endif; ?>
            </ul>

        </div>
    </header>
    <?php endif; ?>