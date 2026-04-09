<?php
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

<div class="container-fluid py-4" style="max-width: 1000px;">
    <div class="mb-4">
        <h4 class="fw-bold"><i class="bi bi-megaphone me-2"></i>메시지/이메일 대량 발송</h4>
        <p class="text-muted">참가자들에게 공지사항 및 안내 문자를 일괄 전송합니다.</p>
    </div>

    <form id="msgForm" action="../api/process_send.php" method="POST">
        <div class="row">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white fw-bold border-0 pt-4 px-4">1. 발송 대상 설정</div>
                    <div class="card-body px-4 pb-4">
                        <label class="form-label small fw-bold">발송 수단</label>
                        <div class="d-flex gap-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="send_type" id="type_sms" value="sms">
                                <label class="form-check-label" for="type_sms">문자(SMS/LMS)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="send_type" id="type_email"
                                    value="email" checked>
                                <label class="form-check-label" for="type_email">이메일</label>
                            </div>
                        </div>

                        <label class="form-label small fw-bold">수신 대상 필터</label>
                        <select name="target_course" class="form-select mb-3">
                            <option value="all">전체 참가자</option>
                            <?php foreach($courses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="form-label small fw-bold">결제 상태</label>
                        <select name="target_pay" class="form-select mb-3">
                            <option value="all">전체</option>
                            <option value="1">결제 완료자만</option>
                            <option value="0">미납자만</option>
                        </select>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-primary border-start border-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary"><i class="bi bi-info-circle me-2"></i>치환 변수 가이드</h6>
                        <p class="small text-muted mb-0">아래 단어를 적으면 개별 정보로 치환됩니다.</p>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-light text-dark border pointer" onclick="addTag('{이름}')">{이름}</span>
                            <span class="badge bg-light text-dark border pointer"
                                onclick="addTag('{참가번호}')">{참가번호}</span>
                            <span class="badge bg-light text-dark border pointer" onclick="addTag('{코스}')">{코스}</span>
                            <span class="badge bg-light text-dark border pointer" onclick="addTag('{연락처}')">{연락처}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white fw-bold border-0 pt-4 px-4">2. 메시지 내용 작성</div>
                    <div class="card-body px-4 pb-4">
                        <div id="email_subject_area" style="display:none;" class="mb-3">
                            <input type="text" name="subject" class="form-control" placeholder="이메일 제목을 입력하세요" readonly
                                value="2026 마라톤 대회 안내 메일">
                        </div>

                        <label class="form-label small fw-bold">본문 내용</label>
                        <textarea name="content" id="msgContent" class="form-control mb-2" rows="12"
                            placeholder="메시지 내용을 입력하세요..."><?= $default_template ?></textarea>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">글자 수: <strong
                                    id="charCount"><?= mb_strlen($default_template) ?></strong>자</span>
                            <button type="submit" class="btn btn-primary px-4 shadow">발송 시작 </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// 이메일 제목 필드 토글 및 문자 발송 차단 로직
const submitBtn = document.querySelector('button[type="submit"]'); // 발송 버튼
const msgContent = document.getElementById('msgContent');

document.getElementsByName('send_type').forEach(el => {
    el.addEventListener('change', (e) => {
        const isEmail = (e.target.value === 'email');

        // 1. 이메일 제목 영역 토글
        document.getElementById('email_subject_area').style.display = isEmail ? 'block' : 'none';

        // 2. 문자 발송일 경우 버튼 제어
        if (e.target.value === 'sms') {
            submitBtn.disabled = true;
            submitBtn.classList.replace('btn-primary', 'btn-secondary');
            submitBtn.innerHTML = '기능 구현 중';

            // 안내 툴팁이나 경고 문구를 줄 수도 있습니다.
            alert("문자 발송 기능은 현재 시스템 점검 중입니다.\n이메일 발송을 이용해 주세요.");
        } else {
            // 이메일일 경우 버튼 원복
            submitBtn.disabled = false;
            submitBtn.classList.replace('btn-secondary', 'btn-primary');
            submitBtn.innerHTML = '발송 시작';
        }
    });
});

// 치환 변수 삽입 (커서 위치 기준)
function addTag(tag) {
    const start = msgContent.selectionStart;
    const end = msgContent.selectionEnd;
    const text = msgContent.value;

    msgContent.value = text.substring(0, start) + tag + text.substring(end);
    msgContent.focus();

    // 삽입 후 커서 위치 조정
    msgContent.selectionStart = msgContent.selectionEnd = start + tag.length;
    updateCharCount();
}

// 글자 수 업데이트 함수
function updateCharCount() {
    document.getElementById('charCount').innerText = msgContent.value.length;
}

msgContent.addEventListener('input', updateCharCount);
</script>

<?php require '../layout/footer.php'; ?>