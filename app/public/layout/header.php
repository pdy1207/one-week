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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?php 
if(isset($js_array)){
    foreach ($js_array as $var) {
        echo '<script src="' . $var . '?v=' . date('YmdHis') . '"></script>' . PHP_EOL;
    }
} ?>

<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4"><?= $g_title ?></span>
            </a>
            <ul class="nav nav-pills gap-2">
                <li class="nav-item">
                    <a href="/" class="nav-link <?= ($menu_code === '') ? 'active' : '' ?>" aria-current="page">Main</a>
                </li>
                <li class="nav-item">
                    <a href="../agree.php" class="nav-link <?= ($menu_code === 'agree') ? 'active' : '' ?>">대회 접수 하기</a>
                </li>

            </ul>
        </header>
    </div>
</body>

</html>