<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "SELECT id, name FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Details</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <h1>User Details</h1>
    <?php if ($row) : ?>
        <p>ID: <?php echo $row["id"]; ?></p>
        <p>Name: <?php echo $row["name"]; ?></p>
    <?php else : ?>
        <p>User not found.</p>
    <?php endif; ?>
    <a href="index.php">Back to User List</a>
</body>

</html>

<?php
$conn->close();
?>