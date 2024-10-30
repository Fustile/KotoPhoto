<?php

$env = parse_ini_file('.env');
$servername = $env["Servername"];
$username = $env["Username"];
$password = $env["Password"];
$dbname = $env["Dbname"];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        echo "Ошибка: Все поля должны быть заполнены.";
    } else {

        $sql = "INSERT INTO users (name, email, message) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Данные успешно сохранены!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "Некорректный метод запроса.";
}

$conn->close();

?>
