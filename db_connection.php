<?php
// Параметры подключения к базе данных
$servername = "mysql-175725-0.cloudclusters.net";
$username = "admin";
$password = "vv5sgBoT";
$dbname = "smapp_db";
$port = 19948; // Порт для подключения

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
