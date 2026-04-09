<?php
require '../config/db.php';

$course = $_GET['course'] ?? 'all';
$pay = $_GET['pay'] ?? 'all';

$sql = "SELECT r.id, r.name, r.participant_code , r.email, r.phone, r.pay_complete, c.name as course_name 
        FROM registrations r 
        LEFT JOIN courses c ON r.course_id = c.id 
        WHERE 1=1";

if($course != 'all') $sql .= " AND r.course_id = " . (int)$course;
if($pay != 'all') $sql .= " AND r.pay_complete = " . (int)$pay;

$stmt = $dbh->query($sql);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));