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

    // Pobranie danych użytkownika
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];

        // Aktualizacja danych użytkownika
        $sql = "UPDATE users SET name='$name', surname='$surname', age='$age', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            // Aktualizacja danych w tabeli profiles
            $sql_profile = "UPDATE profiles SET bio='$bio' WHERE user_id=$id";
            if ($conn->query($sql_profile) === TRUE) {
                echo "User updated successfully";
            } else {
                echo "Error updating profile: " . $conn->error;
            }
        } else {
            echo "Error updating user: " . $conn->error;
        }

        $conn->close();

        // Przekierowanie z powrotem do listy użytkowników
        header("Location: index.php");
        exit();
    }
} else {
    echo "No user ID specified.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>Edit User</h1>
    <form method="post" action="edit_user.php?id=<?php echo $id; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
        <br><br>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" value="<?php echo $row['surname']; ?>" required>
        <br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        <br><br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"><?php
            $sql_profile = "SELECT bio FROM profiles WHERE user_id = $id";
            $result_profile = $conn->query($sql_profile);
            $row_profile = $result_profile->fetch_assoc();
            echo $row_profile['bio'];
        ?></textarea>
        <br><br>
        <input type="submit" value="Update User">
    </form>
    <br>
    <a href="index.php">Back to User List</a>
</body>
</html>
