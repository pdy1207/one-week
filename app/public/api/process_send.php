<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

$send_type = $_POST['send_type']; // sms or email
$target_course = $_POST['target_course'];
$target_pay = $_POST['target_pay'];
$raw_content = $_POST['content'];
$subject = $_POST['subject'] ?? '[공지] 대회 안내 메시지';

// 1. 발송 대상자 추출
$where = " WHERE 1=1";
$params = [];

if ($target_course !== 'all') {
    $where .= " AND r.course_id = :course";
    $params['course'] = $target_course;
}
if ($target_pay !== 'all') {
    $where .= " AND r.pay_complete = :pay";
    $params['pay'] = $target_pay;
}

$sql = "SELECT r.*, c.name as course_name 
        FROM registrations r 
        LEFT JOIN courses c ON r.course_id = c.id 
        $where";
$stmt = $dbh->prepare($sql);
$stmt->execute($params);
$targets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success_count = 0;

foreach ($targets as $user) {
    // 2. 치환 변수 처리 (핵심!)
    $search = ['{이름}', '{참가번호}', '{코스}', '{연락처}'];
    $replace = [$user['name'], $user['participant_code'], $user['course_name'], $user['phone']];
    
    $final_msg = str_replace($search, $replace, $raw_content);

    // 3. 실제 발송 처리 (예시 코드)
    if ($send_type === 'sms') {
        // SMS API 연동부 (예: CoolSMS, Aligo 등)
        // sendSms($user['phone'], $final_msg); 
    } else {
        // Email 발송 (PHPMailer 권장)
        // sendMail($user['email'], $subject, $final_msg);
    }
    $success_count++;
}

echo "<script>
    alert('총 {$success_count}명에게 발송을 완료했습니다.');
    location.href = '../admin/send_message.php';
</script>";