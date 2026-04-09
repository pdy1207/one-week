<?php
require '../config/db.php';

// 알리고 API 설정 (회원가입 후 발급받은 키 입력)
$key     = "본인의_API_KEY"; 
$user_id = "알리고_아이디";
$sender  = "0212345678"; // 인증받은 발신번호

// 폼 데이터 수신
$selected_ids = $_POST['u_ids'] ?? [];
$raw_content  = $_POST['content'] ?? '';

if (empty($selected_ids)) exit("대상 없음");

// 대상자 정보 가져오기
$placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
$stmt = $dbh->prepare("SELECT name, phone, participant_code FROM registrations WHERE id IN ($placeholders)");
$stmt->execute($selected_ids);
$targets = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($targets as $user) {
    
    // 치환 변수 처리
    $msg = str_replace('{이름}', $user['name'], $user['phone']);
    $msg = str_replace('{참가번호}', $user['participant_code'], $msg);

    // API 전송 데이터 구성
    $data = [
        'key'      => $key,
        'user_id'  => $user_id,
        'sender'   => $sender,
        'receiver' => $receiver,
        'msg'      => $msg,
        'title'    => '안내문자', // LMS일 경우 제목 필요
        'testmode_yn' => 'Y'    // [중요] 테스트 시 Y, 실제 발송 시 N
    ];

    // CURL을 이용한 API 호출
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://apis.aligo.in/send/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    // 결과 확인용 (DB 로그 저장 등 추가 가능)
    // $result = json_decode($response, true);
}

echo "<script>alert('문자 발송 처리가 완료되었습니다.'); history.back();</script>";