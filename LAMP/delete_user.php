<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Połączenie z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Usunięcie użytkownika
    $sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();

    // Przekierowanie z powrotem do listy użytkowników
    header("Location: index.php");
    exit();
} else {
    echo "No user ID specified.";
}
?>
