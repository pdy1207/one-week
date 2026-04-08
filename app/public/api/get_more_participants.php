<?php
        session_start();
        require '../config/db.php';

        header('Content-Type: application/json');

        if (!isset($_SESSION['admin_idx'])) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $course_filter = isset($_GET['course_filter']) ? $_GET['course_filter'] : '';
        $limit = 5;

        // 쿼리 작성
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

        $sql = "SELECT r.*, c.name as course_name FROM registrations r 
                LEFT JOIN courses c ON r.course_id = c.id 
                $where ORDER BY r.created_at DESC LIMIT :offset, :limit";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        foreach($params as $key => $val) { $stmt->bindValue(':'.$key, $val); }
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $html = '';
        foreach ($list as $row) {
            $pay_badge = $row['pay_complete'] ? '<span class="badge bg-success">결제완료</span>' : '<span class="badge bg-warning text-dark">미납</span>';
            $reg_date = date('m-d H:i', strtotime($row['created_at']));
            $addr = htmlspecialchars($row['addr1'] . ' ' . $row['addr2']);
            $name = htmlspecialchars($row['name']);
            
            $html = '';
            foreach ($list as $row) {

                $formatted_phone = preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})/", "$1-$2-$3", $row['phone']);

                // 1. 코스별 배지 색상 결정 로직 추가
                $c_name = $row['course_name'];
                $badge_class = 'bg-secondary'; 

                if (strpos($c_name, '10km') !== false) {
                    $badge_class = 'bg-success'; 
                } elseif (strpos($c_name, '5km') !== false) {
                    $badge_class = 'bg-primary'; 
                } elseif (strpos($c_name, '21km') !== false) {
                    $badge_class = 'bg-warning';  
                } elseif (strpos($c_name, '42km') !== false) {
                    $badge_class = 'bg-danger';    
                }

                $pay_badge = $row['pay_complete'] ? '<span class="badge bg-secondary">결제완료</span>' : '<span class="badge bg-danger text-dark">미납</span>';
                $reg_date = date('m-d H:i', strtotime($row['created_at']));
                $addr = htmlspecialchars($row['addr1'] . ' ' . $row['addr2']);
                $name = htmlspecialchars($row['name']);
                
                // 2. TD 부분에 $badge_class 적용
                $html .= "
                <tr>
                    <td class='ps-4 fw-bold text-primary'>{$row['participant_code']}</td>
                    <td>
                        <div class='fw-bold'>{$name}</div>
                        <div class='small text-muted'>{$row['birth']} ({$row['gender']})</div>
                    </td>
                    <td><span class='badge {$badge_class} shadow-sm'>{$c_name}</span></td>
                    <td>{$formatted_phone}</td>
                    <td>{$pay_badge}</td>
                    <td>{$row['size']}</td>
                    <td>
                        <small class='d-block text-muted'>[{$row['zipcode']}]</small>
                        <small>{$addr}</small>
                    </td>
                    <td class='small'>{$reg_date}</td>
                </tr>";
            }
        }

        // 다음 데이터가 더 있는지 확인용
        echo json_encode([
            'status' => 'success',
            'html' => $html,
            'is_last' => count($list) < $limit
        ]);