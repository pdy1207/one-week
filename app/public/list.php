<?php

$js_array = ['./js/list.js'];

$g_title = '접수 내역 조회';
$menu_code = 'list';

require './layout/header.php';

?>

<main class="container py-5 flex-grow-1 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">

                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary-subtle text-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-search fs-2"></i>
                        </div>
                        <h2 class="fw-extrabold text-dark mb-1">접수 내역 조회</h2>
                        <p class="text-secondary mb-0 small">신청 시 입력한 이름과 전화번호를 입력해주세요.</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary fs-7">
                            <i class="bi bi-person-fill me-1"></i> 이름
                        </label>
                        <input type="text" id="name"
                            class="form-control form-control-lg rounded-3 border-light shadow-sm fs-6"
                            placeholder="홍길동">
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-secondary fs-7">
                            <i class="bi bi-phone-fill me-1"></i> 전화번호
                        </label>
                        <input type="text" id="phone"
                            class="form-control form-control-lg rounded-3 border-light shadow-sm fs-6"
                            placeholder="010-1234-5678">
                    </div>

                    <button id="btn_search"
                        class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm hover-up">
                        조회하기
                    </button>
                </div>
            </div>


            <div id="skeleton" class="d-none mt-4 animate__animated animate__fadeIn">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden placeholder-glow">
                    <div class="bg-primary text-white p-4 text-center opacity-25">
                        <span class="placeholder col-4 rounded-pill d-block mb-1">&nbsp;</span>
                        <span class="placeholder col-6 rounded-pill fs-3 d-block">&nbsp;</span>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-4">
                            <div>
                                <span class="placeholder col-3 rounded">&nbsp;</span>
                                <span class="placeholder col-5 rounded d-block mt-1">&nbsp;</span>
                            </div>
                            <span class="placeholder col-2 rounded-pill p-3 opacity-25">&nbsp;</span>
                        </div>

                        <div class="row g-3 fs-6">
                            <div class="col-6">
                                <span class="placeholder col-3 rounded">&nbsp;</span>
                                <span class="placeholder col-5 rounded d-block mt-1">&nbsp;</span>
                            </div>
                            <div class="col-6">
                                <span class="placeholder col-3 rounded">&nbsp;</span>
                                <span class="placeholder col-7 rounded d-block mt-1">&nbsp;</span>
                            </div>
                            <div class="col-12 mt-4 pt-2 border-top border-light">
                                <span class="placeholder col-4 rounded">&nbsp;</span>
                                <span class="placeholder col-9 rounded d-block mt-1">&nbsp;</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 text-center">
                        <span class="placeholder col-4 rounded-pill py-3 opacity-25">&nbsp;</span>
                    </div>
                </div>
            </div>


            <div id="result" class="mt-4">
            </div>

        </div>
    </div>
</main>


<?php require './layout/footer.php'; ?>