<?php
    require '../controller/exit.php';
    session_start();
    require '../config/db.php'; 

    if (!isset($_SESSION['admin_idx'])) {
        echo "<script>alert('로그인이 필요한 페이지입니다.'); location.href = './admin_login.php';</script>";
        exit;
    }

    function format_phone($phone) {
        $phone = preg_replace("/[^0-9]/", "", $phone); 
        $length = strlen($phone);

        switch($length) {
            case 11: // 010-1234-5678
                return preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $phone);
            case 10: 
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
            default:
                return $phone;
        }
    }

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $course_filter = isset($_GET['course_filter']) ? $_GET['course_filter'] : '';
    $limit = 10; 

    // 2. 검색 쿼리 구성
    $where = " WHERE 1=1";
    $params = [];

    if ($search) {
        $where .= " AND (r.name LIKE :search OR r.phone LIKE :search OR r.participant_code LIKE :search)";
        $params['search'] = "%$search%";
    }
    if ($course_filter) {
        $where .= " AND r.course_id = :course_filter";
        $params['course_filter'] = $course_filter;
    }

    $sql = "SELECT r.*, c.name as course_name 
            FROM registrations r 
            LEFT JOIN courses c ON r.course_id = c.id 
            $where 
            ORDER BY r.created_at DESC 
            LIMIT $limit";

    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 코스 목록 (필터용)
    $courses = $dbh->query("SELECT id, name FROM courses")->fetchAll();

    $g_title = '접수 내역 관리';
    $menu_code = 'details';
    require '../layout/header.php'; 
?>
<style>

</style>

<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">참가자 접수 내역</h4>
        <div class="text-muted small">현재 화면에 표시된 데이터 외에도 더보기로 확인 가능합니다.</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-2">
                    <select name="course_filter" class="form-select border-light bg-light">
                        <option value="">모든 코스</option>
                        <?php foreach($courses as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($course_filter == $c['id']) ? 'selected' : '' ?>>
                            <?= $c['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text border-light bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-light bg-light"
                            placeholder="이름, 연락처, 참가번호" value="<?= htmlspecialchars($search) ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">검색하기</button>
                </div>
                <div class="col-md-1">
                    <a href="details.php" class="btn btn-outline-secondary w-100"><i
                            class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">참가번호</th>
                        <th>이름</th>
                        <th>코스</th>
                        <th>연락처</th>
                        <th>결제상태</th>
                        <th>사이즈</th>
                        <th>주소</th>
                        <th>접수일시</th>
                    </tr>
                </thead>
                <tbody id="participant_list">
                    <?php if(empty($list)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">검색 결과가 없습니다.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($list as $row): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-primary"><?= $row['participant_code'] ?></td>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                            <div class="small text-muted"><?= $row['birth'] ?> (<?= $row['gender'] ?>)</div>
                        </td>
                        <td>
                            <span class="badge <?= getCourseBadgeClass($row['course_name']) ?> shadow-sm px-2 py-1">
                                <?= $row['course_name'] ?>
                            </span>
                        </td>
                        <td><?= format_phone($row['phone']) ?></td>
                        <td><?= $row['pay_complete'] ? '<span class="badge bg-secondary">결제완료</span>' : '<span class="badge bg-danger text-dark">미납</span>' ?>
                        </td>
                        <td><?= $row['size'] ?></td>
                        <td>
                            <small class="d-block text-muted">[<?= $row['zipcode'] ?>]</small>
                            <small><?= htmlspecialchars($row['addr1'] . ' ' . $row['addr2']) ?></small>
                        </td>
                        <td class="small"><?= date('m-d H:i', strtotime($row['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if(count($list) >= $limit): ?>
    <div id="more_container" class="text-center mt-4 mb-5">
        <button id="btn_more" class="btn btn-white shadow-sm rounded-pill px-5 py-2 border" data-offset="<?= $limit ?>"
            data-search="<?= htmlspecialchars($search) ?>" data-course="<?= htmlspecialchars($course_filter) ?>">
            <i class="bi bi-plus-lg me-2"></i>더보기
        </button>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('btn_more')?.addEventListener('click', function() {
    const btn = this;
    const offset = parseInt(btn.getAttribute('data-offset'));
    const search = btn.getAttribute('data-search');
    const course = btn.getAttribute('data-course');

    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>로딩 중...';
    btn.disabled = true;

    fetch(
            `../api/get_more_participants.php?offset=${offset}&search=${encodeURIComponent(search)}&course_filter=${course}`
        )
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                if (res.html.trim() !== '') {
                    document.getElementById('participant_list').insertAdjacentHTML('beforeend', res.html);
                    btn.setAttribute('data-offset', offset + 5);
                    btn.innerHTML = '<i class="bi bi-plus-lg me-2"></i>더보기';
                    btn.disabled = false;
                }

                if (res.is_last) {
                    document.getElementById('more_container').innerHTML =
                        '<p class="text-muted small">마지막 데이터입니다.</p>';
                }
            }
        });
});
</script>



<?php require '../layout/footer.php'; ?>