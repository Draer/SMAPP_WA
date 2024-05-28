<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы входа
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Подготавливаем запрос для получения пользователя по его email
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = :email");

        // Привязываем параметр
        $stmt->bindParam(':email', $email);
        // Выполняем запрос
        $stmt->execute();

        // Получаем результат
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Проверяем, существует ли пользователь с таким email
        if ($user) {
            // Проверяем правильность введенного пароля
            if (password_verify($password, $user['password'])) {
                // Пароль верный, устанавливаем сессию для пользователя
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Сохраняем роль пользователя в сессии
                // Сохраняем остальные данные пользователя в сессии
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['city'] = $user['city'];
                $_SESSION['postal_code'] = $user['postal_code'];
                $_SESSION['country'] = $user['country'];
        
                // Перенаправляем пользователя на главную страницу или другую страницу после входа
                header("Location: index.php");
                exit();
            } else {
                echo "Неправильный пароль.";
            }
        } else {
            echo "Пользователь с таким email не найден.";
        }
    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
