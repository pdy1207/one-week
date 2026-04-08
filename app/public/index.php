<?php
    require './controller/exit.php';
    $js_array = ['./js/main.js'];
    $g_title ='2026 MARATHON';
    $menu_code = '';
    require './layout/header.php';    
    
?>

<main class="d-flex flex-column bg-light">

    <div class="container mt-n4 position-relative" style="z-index: 2;">
        <div class="card border-0 shadow-lg mb-5 rounded-4 p-5 bg-white ">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-light">
                        <div class="bg-primary text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-info-circle-fill fs-4"></i>
                        </div>
                        <h2 class="card-title mb-0 fw-bold text-dark">대회 요강 및 주요 정보</h2>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 g-4 text-dark fs-6">
                        <div class="col d-flex align-items-center">
                            <i class="bi bi-calendar-check-fill text-primary fs-3 me-3"></i>
                            <div>
                                <small class="text-muted d-block">대회 일시</small>
                                <strong class="fw-bold">2026년 4월 10일 (금) 오전 9시</strong>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill text-danger fs-3 me-3"></i>
                            <div>
                                <small class="text-muted d-block">집결 장소</small>
                                <strong class="fw-bold">대전 엔디소프트 11층</strong>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center">
                            <i class="bi bi-clock-fill text-warning fs-3 me-3"></i>
                            <div>
                                <small class="text-muted d-block">시작 시간</small>
                                <strong class="fw-bold">09:00 정각 출발 (08:30 집결)</strong>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center">
                            <i class="bi bi-file-person-fill text-success fs-3 me-3"></i>
                            <div>
                                <small class="text-muted d-block">모집 부문</small>
                                <strong class="fw-bold">선착순 모집 (부문별 상이)</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center">
                    <div class="bg-light p-4 rounded-4 shadow-sm border border-light">
                        <img src="https://trophyrang.com/data/item/1583214642/thumb-18201_320x372.png" alt="마라톤 트로피"
                            class="img-fluid" style="max-height:180px;">
                        <p class="small text-muted mb-0 mt-3">끝까지 달린 당신에게<br>영광의 트로피를 드립니다!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-white shadow-sm mb-5" style="background: linear-gradient(135deg, #e5336e 0%, #5a8cff 100%);">
        <div class="container py-4 text-center">
            <h1 class="display-3 fw-extrabold text-uppercase mb-3" style="letter-spacing:-2px;">
                2026 MARATHON
            </h1>
            <a href="./agree.php" class="btn btn-light btn-lg rounded-pill fw-bold shadow-sm px-5 py-3">
                지금 바로 참가 신청 <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="container mt-n4 position-relative" style="z-index: 2;">
        <div id="course_section">
            <div class="d-flex align-items-center pb-5 border-bottom border-light">
                <div class="bg-dark text-white rounded-3 p-3 me-3 d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-flag-fill fs-4"></i>
                </div>
                <h2 id="course_list_title" class="fw-bold mb-0 text-dark">나만의 코스를 선택하세요!</h2>
                <span class="ms-3 badge bg-danger rounded-pill px-3 py-2">🔥 실시간 모집 현황</span>
            </div>

            <div id="course_list" class="row g-4 ">
            </div>
        </div>
    </div>

</main>

<?php
    require './layout/footer.php';
?>