<?php
// Параметры подключения к базе данных
$servername = "sql.freedb.tech";
$username = "freedb_pryme491";
$password = "8WE8Px#84P3Yy?2";
$dbname = "freedb_smapp491";

try {
    // Создаем подключение через PDO с указанием кодировки
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Устанавливаем режим обработки ошибок для PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Выводим сообщение об ошибке, если не удалось подключиться к базе данных
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
