<?php
// $host = $_ENV['MYSQL_HOST'];
// $username = $_ENV['MYSQL_USER'];
// $password = $_ENV['MYSQL_PASSWORD'];
// $dbname = $_ENV['MYSQL_DATABASE'];
// $port = $_ENV['MYSQL_PORT'];

// try {
//     $dbh = new PDO(
//         "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
//         $username,
//         $password
//     );

//     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $e) {
//     echo "Connection failed : " . $e->getMessage();
// }
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=pdydb;charset=utf8mb4', 'pdy', 'pdy11@#');
    // echo "Connected successfully";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>