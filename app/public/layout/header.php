<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $g_title ?></title>
    <style>
    .nav-link {
        cursor: pointer;
        transition: 0.2s;
    }

    .nav-link:hover {
        background-color: #0d6efd;
        color: #fff !important;
        border-radius: 0.375rem;
    }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
<link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('.nav-link').on('click', function() {
        sessionStorage.removeItem('applyForm');
    });
});
</script>
<style>
body,
input,
button,
select,
textarea {
    font-family: 'Pretendard', 'Noto Sans KR', sans-serif;
}

body {
    background: #f8f9fb;
}

/* 헤더 */
.custom-header {
    background: linear-gradient(135deg, #E5336E, #5a8cff);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* 타이틀 */
.custom-title {
    color: #fff;
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* 네비 */
.nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 20px;
    transition: 0.2s;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff !important;
}

/* 활성 */
.nav-link.active {
    background: #fff;
    color: #0d6efd !important;
    font-weight: 600;
}
</style>
<?php 
if(isset($js_array)){
    foreach ($js_array as $var) {
        echo '<script src="' . $var . '?v=' . date('YmdHis') . '"></script>' . PHP_EOL;
    }
} ?>

<header class="custom-header py-3 mb-4">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">

        <!-- 로고 -->
        <a href="/" class="text-decoration-none custom-title fs-4">
            <?= $g_title ?>
        </a>

        <!-- 메뉴 -->
        <ul class="nav gap-2">
            <li class="nav-item">
                <a href="/" class="nav-link <?= ($menu_code === '') ? 'active' : '' ?>">
                    Info
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
                <a href="https://gem-hacksaw-4b1.notion.site/33a9c91d6b5780089d58c722bc9406dc?source=copy_link"
                    class="nav-link" target="_blank">
                    DOCS
                </a>
            </li>
        </ul>

    </div>
</header>

</html>