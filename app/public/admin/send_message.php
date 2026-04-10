<?php
require '../controller/exit.php';
session_start();
require '../config/db.php'; 

// 코스 목록 (대상 필터용)
$courses = $dbh->query("SELECT id, name FROM courses")->fetchAll();
$menu_code = 'send';
$g_title = '메시지 발송 시스템';
require '../layout/header.php'; 

// 기본적으로 띄워줄 템플릿 문구 정의
$default_template = "안녕하세요, {이름}님!

2026 마라톤 대회 참가를 진심으로 환영합니다.
신청하신 정보는 다음과 같습니다.

[MY REGISTRATION]
- 참가번호 : {참가번호}
- 신청코스 : {코스}
- 연락처 : {연락처}

상기 정보가 본인 정보와 다를 경우 사무국으로 연락 바랍니다.
대회 당일 최상의 컨디션으로 뵙기를 기대하겠습니다.

감사합니다.";
?>

<div class="container-fluid py-4" style="max-width: 1100px;">
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-megaphone me-2"></i>메시지 발송 및 수신자 선택</h4>
    </div>

    <form id="msgForm" action="../api/process_send.php" method="POST">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white fw-bold border-0 pt-4 px-4">1. 대상 필터링</div>
                    <div class="card-body px-4 pb-4">
                        <label class="form-label small fw-bold">발송 수단</label>
                        <select name="send_type" class="form-select mb-3">
                            <option value="email" selected>이메일 발송</option>
                            <option value="sms">문자(준비중)</option>
                        </select>

                        <label class="form-label small fw-bold">코스 선택</label>
                        <select name="target_course" id="filter_course" class="form-select mb-3">
                            <option value="all">전체 코스</option>
                            <?php foreach($courses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="form-label small fw-bold">결제 상태</label>
                        <select name="target_pay" id="filter_pay" class="form-select">
                            <option value="all">전체 상태</option>
                            <option value="1">결제 완료</option>
                            <option value="0">미납</option>
                        </select>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold small"><i class="bi bi-lightning-charge me-1"></i>치환 변수 클릭 삽입</h6>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-white text-dark border pointer" onclick="addTag('{이름}')">{이름}</span>
                            <span class="badge bg-white text-dark border pointer"
                                onclick="addTag('{참가번호}')">{참가번호}</span>
                            <span class="badge bg-white text-dark border pointer" onclick="addTag('{코스}')">{코스}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white fw-bold border-0 pt-4 px-4">2. 내용 작성</div>
                    <div class="card-body px-4 pb-4">
                        <input type="text" name="subject" class="form-control mb-3 fw-bold" placeholder="메일 제목"
                            value="2026 마라톤 대회 안내 메일">
                        <textarea name="content" id="msgContent" class="form-control mb-2"
                            rows="10"><?= $default_template ?></textarea>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">글자 수: <strong id="charCount">0</strong>자</span>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">발송 시작</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div
                        class="card-header bg-white fw-bold border-0 pt-4 px-4 d-flex justify-content-between align-items-end">
                        <div>
                            3. 수신자 목록
                            <span class="badge bg-primary ms-2"><span id="selectedCount">0</span>명 선택됨</span>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkAll">
                            <label class="form-check-label small" for="checkAll">목록 전체 선택</label>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover border-top">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th width="50">선택</th>
                                        <th>이름</th>
                                        <th>연락처/이메일</th>
                                        <th>신청코스</th>
                                        <th>결제 상태</th>
                                    </tr>
                                </thead>
                                <tbody id="userList">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const msgContent = document.getElementById('msgContent');
const userList = document.getElementById('userList');
const checkAll = document.getElementById('checkAll');

// 1. 수신자 목록 불러오기 (AJAX)
function loadUsers() {
    const course = document.getElementById('filter_course').value;
    const pay = document.getElementById('filter_pay').value;

    fetch(`../api/get_users.php?course=${course}&pay=${pay}`)
        .then(res => res.json())
        .then(data => {
            userList.innerHTML = '';
            data.forEach(user => {
                // 이메일 유무 확인
                const hasEmail = user.email && user.email.trim() !== '';

                const row = `
                    <tr class="${!hasEmail ? 'table-light' : ''}">
                        <td>
                            <input type="checkbox" name="u_ids[]" value="${user.id}" 
                                   class="form-check-input u-check" 
                                   ${!hasEmail ? 'disabled' : ''}>
                        </td>
                        <td><span class="fw-bold">${user.name}</span><br><small class="text-muted">${user.participant_code}</small></td>
                        <td>
                            <small>
                                ${hasEmail ? user.email : '<span class="text-danger fw-bold">이메일 미등록</span>'}
                                <br>${user.phone}
                            </small>
                        </td>
                        <td><span class="badge bg-light text-dark border">${user.course_name}</span></td>
                        <td><span class="badge ${user.pay_complete == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'}">
                            ${user.pay_complete == 1 ? '결제완료' : '미납'}</span>
                        </td>
                    </tr>`;
                userList.insertAdjacentHTML('beforeend', row);
            });
            updateCount();
        });
}

// 2. 전체 선택/해제 (disabled 된 항목은 건드리지 않음)
checkAll.addEventListener('change', function() {
    // disabled 되지 않은(이메일이 있는) 체크박스만 선택
    document.querySelectorAll('.u-check:not(:disabled)').forEach(c => {
        c.checked = this.checked;
    });
    updateCount();
});

// 3. 선택 인원 수 업데이트
function updateCount() {
    const checked = document.querySelectorAll('.u-check:checked').length;
    document.getElementById('selectedCount').innerText = checked;
}

// 4. 이벤트 위임 (개별 체크박스 클릭 시)
userList.addEventListener('change', (e) => {
    if (e.target.classList.contains('u-check')) updateCount();
});

// 5. 필터 변경 시 자동 로드
document.getElementById('filter_course').addEventListener('change', loadUsers);
document.getElementById('filter_pay').addEventListener('change', loadUsers);

// 기타 편의 기능 (치환, 글자수)
function addTag(tag) {
    const start = msgContent.selectionStart;
    msgContent.setRangeText(tag, start, msgContent.selectionEnd, 'end');
    msgContent.focus();
    updateCharCount();
}

function updateCharCount() {
    document.getElementById('charCount').innerText = msgContent.value.length;
}

msgContent.addEventListener('input', updateCharCount);
window.onload = loadUsers; // 초기 로드

// 폼 검증
document.getElementById('msgForm').onsubmit = function() {
    if (document.querySelectorAll('.u-check:checked').length === 0) {
        alert('발송 대상을 선택해주세요.');
        return false;
    }
    return confirm('선택한 대상에게 발송을 시작하시겠습니까?');
};
// 발송 수단 선택 엘리먼트와 버튼 가져오기
const sendTypeSelect = document.querySelector('select[name="send_type"]');
const submitBtn = document.querySelector('button[type="submit"]');

function handleSendTypeChange() {
    const isSms = (sendTypeSelect.value === 'sms');

    if (isSms) {
        // 1. 버튼 비활성화 및 스타일 변경
        submitBtn.disabled = true;
        submitBtn.classList.replace('btn-primary', 'btn-secondary');
        submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>문자 기능 준비 중';

        // 2. 알림 (선택 사항)
        alert("문자 발송 기능은 현재 시스템 점검 중입니다.\n이메일 발송을 이용해 주세요.");
    } else {
        // 이메일일 경우 다시 활성화
        submitBtn.disabled = false;
        submitBtn.classList.replace('btn-secondary', 'btn-primary');
        submitBtn.innerHTML = '발송 시작';
    }
}

// 이벤트 리스너 연결
sendTypeSelect.addEventListener('change', handleSendTypeChange);

// 초기 실행 (혹시 모를 초기값 상태 체크)
handleSendTypeChange();
</script>

<?php require '../layout/footer.php'; ?>