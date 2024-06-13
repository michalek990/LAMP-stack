<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    // Połączenie z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Dodanie nowego użytkownika
    $sql_user = "INSERT INTO users (name, surname, age, email) VALUES ('$name', '$surname', '$age', '$email')";
    if ($conn->query($sql_user) === TRUE) {
        $user_id = $conn->insert_id;
        $sql_profile = "INSERT INTO profiles (user_id, bio) VALUES ('$user_id', '$bio')";
        if ($conn->query($sql_profile) === TRUE) {
            echo "New user and profile created successfully";
        } else {
            echo "Error: " . $sql_profile . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Add New User</h1>
    <form method="post" action="add_user.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required>
        <br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"></textarea>
        <br><br>
        <input type="submit" value="Add User">
    </form>
    <br>
    <a href="index.php">Back to User List</a>
</body>
</html>
