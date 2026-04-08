<?php
session_start();
require '../config/db.php'; 

$userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (!$userid || !$password) {
    echo "<script>alert('아이디와 비밀번호를 모두 입력해주세요.'); history.back();</script>";
    exit;
}

try {
    $stmt = $dbh->prepare("SELECT * FROM admins WHERE userid = :userid LIMIT 1");
    $stmt->execute(['userid' => $userid]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        
        $_SESSION['admin_idx'] = $admin['id'];
        $_SESSION['admin_id'] = $admin['userid'];
        $_SESSION['admin_name'] = $admin['admin_name'];

        $updateStmt = $dbh->prepare("UPDATE admins SET last_login = NOW() WHERE id = :id");
        $updateStmt->execute(['id' => $admin['id']]);

        echo "<script>location.href = '../admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 일치하지 않습니다.'); history.back();</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('서버 오류 발생'); history.back();</script>";
}