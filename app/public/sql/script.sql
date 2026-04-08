CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,        -- 5km, 10km 등
    description VARCHAR(100),         -- 설명
    price INT NOT NULL,               -- 가격
    max_participants INT NOT NULL,    -- 최대 인원
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,           -- 어떤 코스 선택했는지
    name VARCHAR(50) NOT NULL,
    birth DATE NOT NULL,
    gender CHAR(1) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    size VARCHAR(5) NOT NULL,         -- S, M, L, XL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (course_id) REFERENCES courses(id)
);


ALTER TABLE courses CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE registrations CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO courses (name, description, price, max_participants) VALUES
('5km', '가족 러닝', 30000, 3000),
('10km', '일반 코스', 50000, 5000),
('42km', 'Full 코스', 70000, 2000),
('21km', 'Half 코스', 60000, 4000);

INSERT INTO registrations 
(course_id, name, birth, gender, phone, email, size, agree_rally, agree_info, agree_market)
VALUES

-- 5km (동의 O)
(1, '홍길동', '1995-01-01', 'M', '01012345678', 'hong@test.com', 'M', 1, 1, 1),

-- 5km (마케팅만 미동의)
(1, '김철수', '1992-03-10', 'M', '01022223333', 'kim@test.com', 'L', 1, 1, 0),

-- 10km
(2, '이영희', '1998-07-15', 'F', '01033334444', 'lee@test.com', 'S', 1, 1, 1),

-- Half
(3, '박민수', '1990-12-20', 'M', '01044445555', 'park@test.com', 'XL', 1, 1, 1),

-- Full
(4, '최지은', '2000-05-05', 'F', '01055556666', 'choi@test.com', 'M', 1, 1, 0);


SELECT 
                    c.*,
                    COUNT(r.id) AS registered
                FROM courses c
                LEFT JOIN registrations r 
                    ON c.id = r.course_id
                GROUP BY c.id
                
                
INSERT INTO registrations 
(course_id, name, birth, gender, phone, email, SIZE, agree_rally, 
agree_info, agree_market, ip, zipcode, addr1, addr2, pay_complete)
VALUES 

-- 5km 테스트 (마케팅만 동의)
(1, '박도융', '1998-12-03', 'M', '01068121234', 'pdy@gmail.com', 'M', 1,1,0, '172.0.0.1', 35578,'대전 대덕구 송촌동', '선비마을', 1)

ALTER TABLE registrations ADD participant_code VARCHAR(20) UNIQUE;

ALTER TABLE registrations 
ADD UNIQUE KEY unique_user (name, phone);

SELECT course_id, name, birth, phone, email, SIZE, agree_rally, agree_info, agree_market, DATE_FORMAT(created_at, '%Y년 %m월 %d일 %H시 %i분') AS created_at, zipcode, addr1, addr2, pay_complete, participant_code  
    FROM registrations
    WHERE name = "박도영" AND phone = "01068119219"
    LIMIT 1
    
     SELECT COUNT(*) 
                FROM registrations 
                WHERE name = "박도영" AND phone = "01068119219"
                
                
                SELECT id, max_participants 
                FROM courses 
                WHERE id = 1 
                FOR UPDATE
                
                
SELECT count(r.id) AS registered, c.max_participants  
FROM courses c 
LEFT JOIN registrations r ON c.id  = r.course_id 
WHERE c.id = 3

SELECT max_participants, 
       (max_participants - COUNT(r.id)) AS remaining
FROM courses c
LEFT JOIN registrations r ON c.id = r.course_id
WHERE c.id = 3


CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `userid` VARCHAR(50) UNIQUE NOT NULL COMMENT '관리자 아이디',
    `password` VARCHAR(255) NOT NULL COMMENT '비밀번호 (해시값)',
    `admin_name` VARCHAR(50) NOT NULL COMMENT '관리자 이름',
    `last_login` DATETIME COMMENT '마지막 로그인 일시',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


SELECT size, COUNT(*) as cnt FROM registrations GROUP BY size ORDER BY size
