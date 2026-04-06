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
            $sql = "SELECT name FROM courses WHERE id = ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([$course_id]);
            
            return $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }