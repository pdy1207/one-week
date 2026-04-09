<?php
session_start();
require '../config/db.php'; 
require_once '/var/www/html/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

// 타임아웃 방지
set_time_limit(0);
ini_set('max_execution_time', 0);

$send_type     = $_POST['send_type'];
$target_course = $_POST['target_course'];
$target_pay    = $_POST['target_pay'];
$raw_content   = $_POST['content']; // 사용자가 textarea에 입력한 내용
$subject       = $_POST['subject'] ?? '2026 마라톤 대회 안내 메일';

// 1. 발송 대상자 필터링 쿼리
$where  = " WHERE 1=1";
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

if (!$targets) {
    echo "<script>alert('발송 대상자가 없습니다.'); history.back();</script>";
    exit;
}

$success_count = 0;
$fail_count    = 0;

// 2. PHPMailer 객체 생성 (루프 밖에서 1회 설정)
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'pdyme1207@gmail.com'; 
    $mail->Password   = 'zcjb tgkx boll ariu'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    $mail->setFrom('pdyme1207@gmail.com', '2026 마라톤 사무국');

    foreach ($targets as $user) {
        if (empty($user['email'])) continue;

        // --- 치환 변수 처리 ({이름} 등) ---
        $search    = ['{이름}', '{참가번호}', '{코스}', '{연락처}'];
        $replace   = [$user['name'], $user['participant_code'], $user['course_name'], $user['phone']];
        
        // 사용자가 입력한 raw_content에서 치환 수행
        $user_msg = str_replace($search, $replace, $raw_content);
        // 줄바꿈을 <br>로 변경하여 HTML 메일 본문에 삽입 준비
        $formatted_msg = nl2br($user_msg);

        // --- 디자인 템플릿 구성 ---
        $html_body = "
        <div style='max-width: 600px; margin: 20px auto; font-family: \"Apple SD Gothic Neo\", \"Malgun Gothic\", sans-serif; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
            <div style='background-color: #0d6efd; padding: 40px 20px; text-align: center; color: white;'>
                <p style='margin: 0; font-size: 14px; opacity: 0.8; letter-spacing: 2px;'>2026 MARATHON FESTIVAL</p>
                <h1 style='margin: 10px 0 0; font-size: 26px; font-weight: 700;'>대회 안내 메시지</h1>
            </div>
            
            <div style='padding: 35px; background-color: #ffffff;'>
                <p style='font-size: 18px; color: #333; margin-bottom: 25px;'></p>
                

                 <div style='line-height: 1.8; color: #444; font-size: 15px; border-left: 4px solid #0d6efd; padding-left: 15px;'>
                     {$formatted_msg}
                 </div>
                
                <div style='margin-top: 40px; border-top: 1px dashed #ddd; padding-top: 20px;'>
                    <p style='font-size: 13px; color: #777;'>※ 대회 당일 오전 8시까지 집결해 주시기 바랍니다.<br>※ 참가권 번호표는 현장에서 배부됩니다.</p>
                </div>
            </div>

            <div style='background-color: #f8f9fa; padding: 25px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eee;'>
                <p style='margin: 0;'>본 메일은 발신 전용이며 회신되지 않습니다.</p>
                <p style='margin: 5px 0 0;'>대표전화: 02-1234-5678 | 2026 마라톤 사무국</p>
                <p style='margin: 15px 0 0; opacity: 0.6;'>© 2026 Marathon Festival. All Rights Reserved.</p>
            </div>
        </div>";

        try {
            $mail->clearAddresses();
            $mail->addAddress($user['email'], $user['name']);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html_body;
            $mail->AltBody = strip_tags($user_msg); // 텍스트 버전

            $mail->send();
            $success_count++;
        } catch (Exception $e) {
            $fail_count++;
        }
    }
} catch (Exception $e) {
    echo "서버 설정 오류: {$mail->ErrorInfo}";
    exit;
}

echo "<script>
    alert('총 {$success_count}명에게 발송을 완료했습니다.');
    location.href = '../admin/send_message.php';
</script>";