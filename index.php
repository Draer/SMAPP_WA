<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<header>
    <h1>ООО Поставщик</h1>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Поиск по таблице...">
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="#">Каталог</a></li>
            <?php
            if(isset($_SESSION['user_id'])) {
                // Если пользователь вошел в систему, отображаем его логин и иконку пользователя
                echo "<li><span>Привет, ".$_SESSION['username']."!</span></li>";
                // Добавьте код для отображения иконки пользователя
                if ($_SESSION['role'] === 'admin') {
                    echo "<li><a href='edit_users.php'>Редактировать пользователей</a></li>";
                }
            } else {
                // Если пользователь не вошел в систему, отображаем кнопки входа и регистрации
                echo "<li><a href='#' onclick='openModal(\"login\")'>Вход</a></li>";
                echo "<li><a href='#' onclick='openModal(\"register\")'>Регистрация</a></li>";
            }
            if (isset($_SESSION['user_id'])) {
                // Если пользователь вошел в аккаунт, отображаем кнопку выхода
                echo '<li><a href="logout.php">Выход</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>

<main>
    <?php
    require_once "db_connection.php";

    // Проверяем, была ли уже выведена таблица товаров
    if (!isset($_SESSION['table_rendered']) || !$_SESSION['table_rendered']) {
        try {
            // Запрос на получение списка товаров
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            // Проверяем, есть ли результаты запроса
            if ($result->rowCount() > 0) {
                // Выводим данные о товарах
                echo "<table id='productTable' border='1'>";
                echo "<tr>
                        <th>ID</th>
                        <th>Товар</th>
                        <th>Поставщик</th>
                        <th>Цена</th>
                        <th>Продажи</th>
                        <th>В наличии</th>
                        <th>Заказать</th>
                      </tr>";

                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["product"]."</td>";
                    echo "<td>".$row["supplier"]."</td>";
                    echo "<td>".$row["price"]."</td>";
                    echo "<td>".$row["sales"]."</td>";
                    echo "<td>".$row["stock"]."</td>";
                    echo "<td><a href='order.php?id=".$row["id"]."'>Заказать</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                $_SESSION['table_rendered'] = true; // Устанавливаем флаг, что таблица была выведена
            } else {
                echo "<p>0 результатов</p>";
            }
        } catch(PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    } else {
        unset($_SESSION['table_rendered']); // Сбрасываем флаг
    }
    ?>
</main>

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('login')">&times;</span>
        <h2>Вход</h2>
        <form action="login_process.php" method="post">
            <label for="email">Электронная почта:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Войти">
        </form>
    </div>
</div>

<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('register')">&times;</span>
        <h2>Регистрация</h2>
        <form action="register_process.php" method="post">
            <label for="email">Электронная почта:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="username">Логин:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>

            <label for="confirmPassword">Повторите пароль:</label><br>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br>

            <label for="firstName">Имя:</label><br>
            <input type="text" id="firstName" name="firstName" required><br>

            <label for="lastName">Фамилия:</label><br>
            <input type="text" id="lastName" name="lastName" required><br>

            <label for="city">Город:</label><br>
            <input type="text" id="city" name="city" required><br>

            <label for="phone">Номер телефона:</label><br>
            <input type="tel" id="phone" name="phone" required><br>

            <label for="address">Адрес:</label><br>
            <input type="text" id="address" name="address" required><br>

            <label for="postalCode">Почтовый индекс:</label><br>
            <input type="text" id="postalCode" name="postalCode" required><br>

            <label for="country">Страна:</label><br>
            <input type="text" id="country" name="country" required><br><br>

            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>
</div>


<footer>
    <p>&copy; 2024 ООО Поставщик</p>
</footer>

<script src="script.js"></script>

</body>
</html>
