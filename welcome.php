<?php
session_start();
include('server/connection.php');

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        header('location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/welcome.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tugas</title>
</head>

<body>
    <br>
    <div class="card">
        <h1 class="judul">WELCOME</h1>
        <img class="foto" src="<?php echo $row['user_photo']; ?>" alt="">
        <h4><?php echo $row['user_name']; ?></h4>
        <h3 class="email"><?php echo $row['user_email']; ?></h3>
        <h4><?php echo $row['user_city']; ?></h4>
        <br>
        <a class="logout" href="welcome.php?logout=1" id="logout-btn" class="btn btn-danger">Log Out</a>

    </div>
</body>

</html>