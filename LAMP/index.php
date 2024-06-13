<?php
include 'config.php';

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, surname, age, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>MyApp</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h1>User List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Age</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td>
                      <td><a href='user.php?id=" . $row["id"]. "'>" . $row["name"]. "</a></td>
                      <td>" . $row["surname"]. "</td>
                      <td>" . $row["age"]. "</td>
                      <td>" . $row["email"]. "</td>
                      <td>
                          <a href='edit_user.php?id=" . $row["id"]. "'>Edit</a> | 
                          <a href='delete_user.php?id=" . $row["id"]. "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                      </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>0 results</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <br>
    <a href="add_user.php">Add New User</a>
</body>
</html>
