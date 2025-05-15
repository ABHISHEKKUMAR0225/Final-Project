<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "userdb";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pass = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($email) && !empty($pass)) {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            echo "User saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Email or password is empty.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}

echo "User saved successfully! Redirecting to home page...";
header("Refresh:4; url=index.html"); 
exit();

?>
