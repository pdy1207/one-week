<?php
// 1. 에러 출력 (문제 해결 후 주석 처리)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/db.php'; 
// require_once '/var/www/html/vendor/autoload.php'; // 로컬 기준

// 2. 경로 설정 (서버 절대 경로 확인됨)
$base_dir = '/home/pdy/www';



if (file_exists($base_dir . '/vendor/autoload.php')) {
    require_once $base_dir . '/vendor/autoload.php';
} else {
    // 여기서 에러나면 진짜로 vendor 폴더 안에 autoload.php가 없는 겁니다.
    die("에러: " . $base_dir . "/vendor/autoload.php 파일이 없습니다. 파일질라로 확인하세요.");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

// 타임아웃 방지
set_time_limit(0);
ini_set('max_execution_time', 0);
// 폼 데이터 수신
$selected_ids  = $_POST['u_ids'] ?? []; // 체크박스로 선택된 ID들
$raw_content   = $_POST['content'] ?? '';
$subject       = $_POST['subject'] ?? '2026 마라톤 대회 안내 메일';

// [중요] 선택된 사람이 없으면 뒤로가기
if (empty($selected_ids)) {
    echo "<script>alert('선택된 수신자가 없습니다. 목록에서 체크박스를 선택해주세요.'); history.back();</script>";
    exit;
}

// 2. 선택된 ID들에 대해서만 DB 조회 (IN 연산자 사용)
$placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
$sql = "SELECT r.*, c.name as course_name 
        FROM registrations r 
        LEFT JOIN courses c ON r.course_id = c.id 
        WHERE r.id IN ($placeholders)";

$stmt = $dbh->prepare($sql);
$stmt->execute($selected_ids);
$targets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success_count = 0;
$fail_count    = 0;

if ($targets) {
    $mail = new PHPMailer(true);
    try {
        // SMTP 서버 설정
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
            if (empty($user['email'])) {
                $fail_count++;
                continue;
            }

            // 치환 변수 처리
            $search  = ['{이름}', '{참가번호}', '{코스}', '{연락처}'];
            $replace = [$user['name'], $user['participant_code'], $user['course_name'], $user['phone']];
            $user_msg = str_replace($search, $replace, $raw_content);
            $formatted_msg = nl2br($user_msg);

            // 메일 본문 디자인 (생략 없이 유지)
            $html_body = "
            <div style='max-width: 600px; margin: 20px auto; font-family: sans-serif; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden;'>
                <div style='background-color: #0d6efd; padding: 30px; text-align: center; color: white;'>
                    <h1 style='margin: 0; font-size: 24px;'>대회 안내 메시지</h1>
                </div>
                <div style='padding: 30px; background-color: #ffffff; line-height: 1.8; color: #444;'>
                    {$formatted_msg}
                </div>
                <div style='background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999;'>
                    대표전화: 02-1234-5678 | © 2026 Marathon Festival
                </div>
            </div>";

            try {
                $mail->clearAddresses();
                $mail->addAddress($user['email'], $user['name']);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $html_body;
                $mail->AltBody = strip_tags($user_msg);

                $mail->send();
                $success_count++;
            } catch (Exception $e) {
                $fail_count++;
            }
        }
    } catch (Exception $e) {
        echo "메일 서버 설정 오류: {$mail->ErrorInfo}";
        exit;
    }
}

echo "<script>
    alert('발송 완료! (성공: {$success_count}건, 실패: {$fail_count}건)');
    location.href = '../admin/send_message.php'; 
</script>";