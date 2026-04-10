<?php
    require './controller/exit.php';
    session_start();
    require './config/db.php'; 
    

    if (!isset($_SESSION['admin_idx'])) {
        echo "<script>alert('로그인이 필요한 페이지입니다.'); location.href = './admin/login.php';</script>";
        exit;
    }

    // [통계 쿼리] 1. 요약 정보
    $stmt = $dbh->query("SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN pay_complete = 1 THEN 1 ELSE 0 END) as paid,
        SUM(CASE WHEN pay_complete = 0 THEN 1 ELSE 0 END) as unpaid
    FROM registrations");
    $summary = $stmt->fetch();

    // [통계 쿼리] 2. 코스별 접수 현황 (파이 차트용)
    $stmt = $dbh->query("SELECT c.name, COUNT(r.id) as cnt 
        FROM courses c 
        LEFT JOIN registrations r ON c.id = r.course_id 
        GROUP BY c.id");
    $course_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // [통계 쿼리] 3. 티셔츠 사이즈별 현황 (그래프/표용)
    $stmt = $dbh->query("SELECT size, COUNT(*) as cnt FROM registrations GROUP BY size ORDER BY size");
    $size_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $admin_name = $_SESSION['admin_name'];
    $admin_id = $_SESSION['admin_id'];
    $g_title = 'ADMIN DASHBOARD';

    require './layout/header.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4 w-50">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center p-4 bg-white shadow-sm rounded-4">
                <div>
                    <h4 class="fw-bold mb-1"><span class="text-primary"><?= $admin_name ?></span>님 환영합니다!</h4>
                    <p class="text-muted small mb-0">대회 운영 및 접수 현황을 확인하세요.</p>
                </div>
                <a href="./admin/logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">로그아웃</a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3 me-3"><i
                            class="bi bi-people-fill fs-3"></i></div>
                    <div>
                        <p class="text-muted mb-1">총 접수</p>
                        <h3 class="fw-bold mb-0"><?= number_format($summary['total']) ?>명</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success-subtle text-success rounded-3 p-3 me-3"><i
                            class="bi bi-credit-card-fill fs-3"></i></div>
                    <div>
                        <p class="text-muted mb-1">결제 완료</p>
                        <h3 class="fw-bold mb-0"><?= number_format($summary['paid']) ?>명</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger-subtle text-danger rounded-3 p-3 me-3"><i
                            class="bi bi-exclamation-triangle-fill fs-3"></i></div>
                    <div>
                        <p class="text-muted mb-1">미 결제</p>
                        <h3 class="fw-bold mb-0"><?= number_format($summary['unpaid']) ?>명</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">코스별 비율</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="courseChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">기념품 사이즈 현황</h5>
                        <small class="text-muted">발주 및 재고 관리를 위한 실시간 수량</small>
                    </div>
                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">총
                        <?= number_format(array_sum(array_column($size_data, 'cnt'))) ?>개</span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-7">
                            <div style="position: relative; height: 260px;">
                                <canvas id="sizeChart"></canvas>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="size-list-group">
                                <?php foreach($size_data as $row): ?>
                                <div
                                    class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-3 hover-bg-light">
                                    <div class="d-flex align-items-center">
                                        <span class="size-dot me-2"></span>
                                        <span class="fw-semibold text-secondary"><?= $row['size'] ?></span>
                                    </div>
                                    <span class="fw-bold text-dark"><?= number_format($row['cnt']) ?> <small
                                            class="text-muted fw-normal">개</small></span>
                                </div>
                                <?php endforeach; ?>

                                <div
                                    class="border-top mt-3 pt-2 d-flex justify-content-between align-items-center px-2">
                                    <span class="fw-bold text-primary">합계</span>
                                    <span
                                        class="fw-bold text-primary fs-5"><?= number_format(array_sum(array_column($size_data, 'cnt'))) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4" style="max-width: 1200px;">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                    <h4 class="fw-bold mb-0 text-dark">대회 접수 및 발주 현황</h4>
                </div>

                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-6 border-end p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2 text-primary"></i>코스별 접수</h5>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">총
                                    <?= number_format($summary['total']) ?>명</span>
                            </div>

                            <div class="row align-items-center">
                                <div>
                                    <table class="table table-sm table-hover align-middle mb-0">
                                        <tbody class="small">
                                            <?php foreach($course_data as $row): 
                                        $p = $summary['total'] > 0 ? ($row['cnt'] / $summary['total']) * 100 : 0; ?>
                                            <tr>
                                                <td class="py-2 text-secondary fw-semibold"><?= $row['name'] ?></td>
                                                <td class="text-end fw-bold"><?= number_format($row['cnt']) ?>명</td>
                                                <td class="text-end text-muted small"><?= round($p, 1) ?>%</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-4 bg-light-subtle">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-success"></i>기념품 발주</h5>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">합계
                                    <?= number_format(array_sum(array_column($size_data, 'cnt'))) ?>개</span>
                            </div>

                            <div class="row align-items-center">
                                <div>
                                    <div class="row g-1 text-center">
                                        <?php foreach($size_data as $row): ?>
                                        <div class="col-6">
                                            <div class="bg-white border rounded-3 p-2 mb-1">
                                                <div class="text-muted" style="font-size: 0.7rem;"><?= $row['size'] ?>
                                                </div>
                                                <div class="fw-bold text-success">
                                                    <?= number_format($row['cnt']) ?><small class="fw-normal">개</small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top p-3 text-center">
                    <button onclick="location.href='./admin/details.php'"
                        class="btn btn-dark btn-sm rounded-pill px-5 shadow-sm">
                        전체 명단 확인하기 <i class="bi bi-chevron-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// 1. 코스별 파이 차트 데이터 준비
const courseLabels = <?= json_encode(array_column($course_data, 'name')) ?>;
const courseCounts = <?= json_encode(array_column($course_data, 'cnt')) ?>;

new Chart(document.getElementById('courseChart'), {
    type: 'doughnut',
    data: {
        labels: courseLabels,
        datasets: [{
            data: courseCounts,
            backgroundColor: ['#157347', '#0D6EFD', '#FFC107', '#DC3545', ],
            hoverOffset: 4
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// 2. 사이즈별 막대 그래프 데이터 준비
const sizeLabels = <?= json_encode(array_column($size_data, 'size')) ?>;
const sizeCounts = <?= json_encode(array_column($size_data, 'cnt')) ?>;

new Chart(document.getElementById('sizeChart'), {
    type: 'bar',
    data: {
        labels: sizeLabels,
        datasets: [{
            label: '주문 수량',
            data: sizeCounts,
            backgroundColor: 'rgba(13, 110, 253, 0.1)', // 연한 블루 배경
            borderColor: '#0d6efd', // 진한 블루 선
            borderWidth: 2,
            borderRadius: 8, // 막대 끝을 둥글게
            borderSkipped: false,
            barPercentage: 0.6 // 막대 두께 적절히 조정
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    drawBorder: false,
                    color: '#f0f0f0'
                },
                ticks: {
                    stepSize: 1,
                    color: '#aaa'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#0d6efd',
                padding: 12,
                cornerRadius: 10,
                displayColors: false
            }
        }
    }
});
</script>


<?php require './layout/footer.php'; ?>