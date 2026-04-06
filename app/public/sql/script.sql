-- pdydb.registrations definition

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '이름',
  `birth` date NOT NULL COMMENT '생년월일',
  `gender` char(1) NOT NULL COMMENT '성별',
  `phone` varchar(20) NOT NULL COMMENT '휴대폰번호',
  `email` varchar(100) NOT NULL COMMENT '이메일',
  `size` varchar(5) NOT NULL COMMENT '기념품 (티셔츠) 사이즈',
  `agree_rally` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 미동의 1: 동의 [대회 참가]',
  `agree_info` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 미동의 1: 동의 [개인정보]',
  `agree_market` tinyint(1) DEFAULT '0' COMMENT '0: 미동의 1: 동의 [마케팅]',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- pdydb.courses definition

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '5km, 10km 등 코스이름',
  `description` varchar(100) DEFAULT NULL COMMENT '설명',
  `price` int(11) NOT NULL COMMENT '가격',
  `max_participants` int(11) NOT NULL COMMENT '최대 인원',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;