<?php

$js_array = ['./js/list.js'];

$g_title = '접수 내역 조회';
$menu_code = 'list';

require './layout/header.php';

?>

<body class="d-flex flex-column min-vh-100">
    <main class="container py-5 flex-grow-1">

        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">

                        <h3 class="text-center fw-bold mb-4">접수 내역 조회</h3>

                        <!-- 입력 -->
                        <div class="mb-3">
                            <label class="form-label">이름</label>
                            <input type="text" id="name" class="form-control rounded-3" placeholder="이름 입력">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">전화번호</label>
                            <input type="text" id="phone" class="form-control rounded-3" placeholder="010-1234-5678">
                        </div>

                        <button id="btn_search" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                            조회하기
                        </button>

                        <!-- 로딩 -->
                        <!-- <div id="loading" class="text-center mt-3 d-none">
                            <div class="spinner-border"></div>
                            <div class="mt-2">조회 중...</div>
                        </div> -->
                        <!-- 스켈레톤 영역 -->
                        <div id="skeleton" class="d-none mt-4">
                            <div class="card border-0 shadow-lg rounded-4 overflow-hidden placeholder-glow">
                                <div class="bg-primary text-white p-3 placeholder col-12 mb-0">&nbsp;</div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="placeholder col-4 me-2">&nbsp;</span>
                                        <span class="placeholder col-6">&nbsp;</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                    <hr>
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="placeholder col-6 me-2">&nbsp;</span>
                                        <span class="placeholder col-4">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 결과 -->
                        <div id="result" class="mt-4"></div>

                    </div>
                </div>

            </div>
        </div>

    </main>
</body>

<?php require './layout/footer.php'; ?>