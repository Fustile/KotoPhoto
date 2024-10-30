<?php

$env = parse_ini_file('.env');
$servername = $env["Servername"];
$username = $env["Username"];
$password = $env["Password"];
$dbname = $env["Dbname"];

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверяем, что данные пришли через POST и не пустые
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['message']);

    // Проверка на пустые данные
    if (empty($name) || empty($email) || empty($password)) {
        echo "Ошибка: Все поля должны быть заполнены.";
    } else {
        
        // SQL-запрос для вставки данных
        $sql = "INSERT INTO users (name, email, message) VALUES (?, ?, ?)";

        // Подготавливаем запрос
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        // Выполняем запрос
        if ($stmt->execute()) {
            echo "Данные успешно сохранены!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        // Закрываем запрос
        $stmt->close();
    }
} else {
    echo "Некорректный метод запроса.";
}

// Закрываем подключение
$conn->close();

?>
