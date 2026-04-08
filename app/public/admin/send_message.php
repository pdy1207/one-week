<?php
session_start();
require '../config/db.php'; 

// 코스 목록 (대상 필터용)
$courses = $dbh->query("SELECT id, name FROM courses")->fetchAll();
$menu_code = 'send';
$g_title = '메시지 발송 시스템';
require '../layout/header.php'; 
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
                                <input class="form-check-input" type="radio" name="send_type" id="type_sms" value="sms"
                                    checked>
                                <label class="form-check-label" for="type_sms">문자(SMS/LMS)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="send_type" id="type_email"
                                    value="email">
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
                            <label class="form-label small fw-bold">이메일 제목</label>
                            <input type="text" name="subject" class="form-control" placeholder="이메일 제목을 입력하세요">
                        </div>

                        <label class="form-label small fw-bold">본문 내용</label>
                        <textarea name="content" id="msgContent" class="form-control mb-2" rows="12"
                            placeholder="메시지 내용을 입력하세요..."></textarea>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">글자 수: <strong id="charCount">0</strong>자</span>
                            <button type="submit" class="btn btn-primary px-4 shadow">발송 시작 <i
                                    class="bi bi-send-fill ms-1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// 이메일 제목 필드 토글
document.getElementsByName('send_type').forEach(el => {
    el.addEventListener('change', (e) => {
        document.getElementById('email_subject_area').style.display = (e.target.value === 'email') ?
            'block' : 'none';
    });
});

// 치환 변수 삽입
function addTag(tag) {
    const area = document.getElementById('msgContent');
    area.value += tag;
    area.focus();
}

// 글자 수 계산
document.getElementById('msgContent').addEventListener('input', function() {
    document.getElementById('charCount').innerText = this.value.length;
});
</script>


<?php require '../layout/footer.php'; ?>