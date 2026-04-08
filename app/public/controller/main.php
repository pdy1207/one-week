<?php

    require '../config/db.php';       

    header('Content-Type: application/json; charset=utf-8');

    class MainController {

        private $dbh;

        public function __construct($dbh) {
            $this->dbh = $dbh;
        }

        public function getCourses() {

            $sql = "
                SELECT 
                    c.*,
                    COUNT(r.id) AS registered
                FROM courses c
                LEFT JOIN registrations r 
                    ON c.id = r.course_id
                GROUP BY c.id
            ";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCoursesName($course_id){
            $sql = "SELECT name,description FROM courses WHERE id = ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([$course_id]);
            
            return $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function checkDuplicate($phone) {

            $sql = "
                SELECT COUNT(*) 
                FROM registrations 
                WHERE phone = ?
            ";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([$phone]);

            return $stmt->fetchColumn() > 0;
        }

        public function infoRegistration($data) {

        try {
            $this->dbh->beginTransaction();

            // 코스 인원 체크 + 락
            $sql = "
                SELECT max_participants, 
                    (SELECT COUNT(*) FROM registrations WHERE course_id = ?) AS registered
                FROM courses
                WHERE id = ?
                FOR UPDATE
            ";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([$data['course_id'], $data['course_id']]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($course['registered'] >= $course['max_participants']) {
                throw new Exception('마감된 코스입니다.');
            }

            // 중복 체크
            if ($this->checkDuplicate($data['phone'])) {
                throw new Exception('이미 신청된 정보입니다.');
            }

            // 등록 
            $sql = "
                INSERT INTO registrations 
                (course_id, name, birth, gender, phone, email, size,
                agree_rally, agree_info, agree_market, ip,
                zipcode, addr1, addr2, pay_complete, participant_code)
                VALUES 
                (:course_id, :name, :birth, :gender, :phone, :email, :size,
                :agree_rally, :agree_info, :agree_market, :ip,
                :zipcode, :addr1, :addr2, 1, :code)
            ";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                ':course_id'    => $data['course_id'],
                ':name'         => $data['name'],
                ':birth'        => $data['birth'],
                ':gender'       => $data['gender'],
                ':phone'        => $data['phone'],
                ':email'        => $data['email'],
                ':size'         => $data['size'],
                ':agree_rally'  => $data['agree_rally'],
                ':agree_info'   => $data['agree_info'],
                ':agree_market' => $data['agree_market'],
                ':ip'           => $_SERVER['REMOTE_ADDR'],
                ':zipcode'      => $data['zipcode'],
                ':addr1'        => $data['addr1'],
                ':addr2'        => $data['addr2'],
                ':code'         => $data['code'],
            ]);


            $this->dbh->commit();

            return [
                'status' => 200,
                'message' => '등록 완료'
            ];

        } catch (Exception $e) {

            $this->dbh->rollBack();

            return [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
    }
    }