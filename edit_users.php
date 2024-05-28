<?php
require_once "db_connection.php";

// Проверяем, был ли отправлен запрос на редактирование
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы редактирования
    $user_id = $_POST['user_id'];
    $fields = array('first_name', 'last_name', 'email', 'phone'); // Список полей для обновления

    // Подготовка запроса для обновления данных пользователя
    $sql = "UPDATE customers SET ";
    foreach ($fields as $field) {
        $sql .= $field . "=?, ";
    }
    $sql = rtrim($sql, ", "); // Удаляем последнюю запятую и пробел
    $sql .= " WHERE id=?";
    $stmt = $conn->prepare($sql);

    // Собираем значения полей данных пользователя
    $params = array();
    foreach ($fields as $field) {
        $params[] = &$_POST[$field]; // Привязываем переменные к параметрам для bind_param
    }
    $params[] = &$user_id; // Добавляем user_id в конец массива параметров
    call_user_func_array(array($stmt, 'bind_param'), array_merge(array(str_repeat('s', count($fields))), $params)); // Вызываем bind_param с динамическим количеством параметров

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "<p>Данные пользователя успешно обновлены.</p>";
    } else {
        echo "<p>Ошибка при обновлении данных пользователя: " . $conn->error . "</p>";
    }
}

// Получение списка пользователей из базы данных
$sql = "SELECT * FROM customers";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование данных пользователя</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Редактирование данных пользователя</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Действия</th>
        </tr>
        <?php
        if ($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                foreach ($row as $key => $value) {
                    echo "<td><input type='text' name='" . $key . "' value='" . $value . "'></td>";
                }
                echo "<td><button onclick='updateUser(" . $row["id"] . ")'>Сохранить</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>0 результатов</td></tr>";
        }
        ?>
    </table>

    <script>
        function updateUser(userId) {
            // Получаем значения из полей ввода
            var formData = new FormData();
            var inputs = document.querySelectorAll("input[type='text']");
            inputs.forEach(function(input) {
                formData.append(input.name, input.value);
            });
            formData.append('user_id', userId);

            // Отправляем запрос на обновление данных пользователя
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Выводим ответ сервера
                    console.log(this.responseText);
                }
            };
            xhr.open("POST", "edit_users.php", true);
            xhr.send(formData);
        }
    </script>
</body>
</html>
