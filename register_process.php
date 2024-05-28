<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы регистрации
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postalCode'];
    $country = $_POST['country'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Хэшируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Подготавливаем запрос для вставки данных пользователя
        $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email, phone, address, city, postal_code, country, username, password) VALUES (:first_name, :last_name, :email, :phone, :address, :city, :postal_code, :country, :username, :password)");

        // Привязываем параметры
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        // Выполняем запрос
        if ($stmt->execute()) {
            echo "Пользователь успешно зарегистрирован!";
        } else {
            echo "Ошибка при регистрации пользователя.";
        }
    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
