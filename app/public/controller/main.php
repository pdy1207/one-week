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

        public function checkDuplicate($name, $phone) {

            $sql = "
                SELECT COUNT(*) 
                FROM registrations 
                WHERE name = ? AND phone = ?
            ";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([$name, $phone]);

            return $stmt->fetchColumn() > 0;
        }

        public function infoRegistration($data) {

            // 중복 체크
            if ($this->checkDuplicate($data['name'], $data['phone'])) {
                return [
                    'status' => 409,
                    'message' => '이미 동일한 이름과 전화번호로 신청되었습니다.'
                ];
            }

            $sql = "
                INSERT INTO registrations 
                (course_id, name, birth, gender, phone, email, SIZE,
                agree_rally, agree_info, agree_market, ip,
                zipcode, addr1, addr2, pay_complete,participant_code)
                VALUES 
                (:course_id, :name, :birth, :gender, :phone, :email, :size,
                :agree_rally, :agree_info, :agree_market, :ip,
                :zipcode, :addr1, :addr2, 1, :code)
            ";

            $stmt = $this->dbh->prepare($sql);

            $stmt->execute([
                ':course_id'      => $data['course_id'],
                ':name'           => $data['name'],
                ':birth'          => $data['birth'],
                ':gender'         => $data['gender'],
                ':phone'          => $data['phone'],
                ':email'          => $data['email'],
                ':size'           => $data['size'],
                ':agree_rally'    => $data['agree_rally'],
                ':agree_info'     => $data['agree_info'],
                ':agree_market'   => $data['agree_market'],
                ':ip'             => $_SERVER['REMOTE_ADDR'],
                ':zipcode'        => $data['zipcode'],
                ':addr1'          => $data['addr1'],
                ':addr2'          => $data['addr2'],
                ':code'           => $data['code'],  
            ]);

            return [
                'status' => 200,
                'message' => '등록 완료'
            ];
        }
    }