<?php
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы оформления заказа
    $product_id = $_POST['product_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    try {
        // Подготавливаем запрос для вставки данных заказа в базу данных
        $sql = "INSERT INTO orders (product_id, first_name, last_name, email, phone, address, city, postal_code, country) 
                VALUES (:product_id, :first_name, :last_name, :email, :phone, :address, :city, :postal_code, :country)";
        $stmt = $conn->prepare($sql);

        // Привязываем параметры
        $stmt->bindValue(':product_id', $product_id);
        $stmt->bindValue(':first_name', $first_name);
        $stmt->bindValue(':last_name', $last_name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':postal_code', $postal_code);
        $stmt->bindValue(':country', $country);

        // Выполняем запрос
        $stmt->execute();

        echo "Заказ успешно оформлен.";
    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
