<?php
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 접속을 허용할 파일들 
$allowed_pages = [
    '/', 
    '/index.php', 
    '/agree.php', 
    '/cors.php', 
    '/info.php', 
    '/pay.php', 
    '/list.php', 
    '/login.php', 
    '/admin_dashboard.php', 
    '/details.php', 
    '/send_message.php'
];

// 만약 허용 목록에 없고, 실제 존재하는 파일도 아니라면 404
if (!in_array($request_uri, $allowed_pages) && !file_exists($_SERVER['DOCUMENT_ROOT'] . $request_uri)) {
    echo $_SERVER['DOCUMENT_ROOT'];
    echo $request_uri;
    if(http_response_code(404)){
        include "./404.php";
        exit;
    };
}
?>