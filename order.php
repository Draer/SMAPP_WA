<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <style>
        form {
            margin: 20px;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
session_start(); // Начинаем сессию, чтобы получить данные пользователя

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Проверяем, вошел ли пользователь в аккаунт
    if(isset($_SESSION['user_id'])) {
        // Проверяем, существуют ли переменные с данными пользователя в сессии
        if(isset($_SESSION['first_name']) && isset($_SESSION['last_name']) && isset($_SESSION['email']) && isset($_SESSION['phone']) && isset($_SESSION['address']) && isset($_SESSION['city']) && isset($_SESSION['postal_code']) && isset($_SESSION['country'])) {
            // Если все переменные существуют, присваиваем их соответствующим переменным
            $first_name = $_SESSION['first_name'];
            $last_name = $_SESSION['last_name'];
            $email = $_SESSION['email'];
            $phone = $_SESSION['phone'];
            $address = $_SESSION['address'];
            $city = $_SESSION['city'];
            $postal_code = $_SESSION['postal_code'];
            $country = $_SESSION['country'];

            // Форма для ввода данных покупателя с данными из сессии
            echo "<h2>Оформление заказа для товара с ID ".$product_id."</h2>";
            echo "<form action='process_order.php' method='post'>";
            echo "<input type='hidden' name='product_id' value='".$product_id."'>";
            echo "<label for='first_name'>Имя:</label><br>";
            echo "<input type='text' id='first_name' name='first_name' value='".$first_name."' required><br>";
            echo "<label for='last_name'>Фамилия:</label><br>";
            echo "<input type='text' id='last_name' name='last_name' value='".$last_name."' required><br>";
            echo "<label for='email'>Email:</label><br>";
            echo "<input type='email' id='email' name='email' value='".$email."' required><br>";
            echo "<label for='phone'>Телефон:</label><br>";
            echo "<input type='tel' id='phone' name='phone' value='".$phone."' required><br>";
            echo "<label for='address'>Адрес доставки:</label><br>";
            echo "<input type='text' id='address' name='address' value='".$address."' required><br>";
            echo "<label for='city'>Город:</label><br>";
            echo "<input type='text' id='city' name='city' value='".$city."' required><br>";
            echo "<label for='postal_code'>Почтовый индекс:</label><br>";
            echo "<input type='text' id='postal_code' name='postal_code' value='".$postal_code."' required><br>";
            echo "<label for='country'>Страна:</label><br>";
            echo "<input type='text' id='country' name='country' value='".$country."' required><br>";
            echo "<input type='submit' value='Отправить заказ'>";
            echo "</form>";
        } else {
            // Если какие-то переменные отсутствуют в сессии, выводим ошибку
            echo "<p>Ошибка: отсутствуют данные пользователя</p>";
        }
    } else {
        echo "<p>Ошибка: пользователь не вошел в аккаунт</p>";
    }
} else {
    echo "<p>Ошибка: товар не выбран</p>";
}
?>

</body>
</html>
