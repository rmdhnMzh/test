<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: welcome.php');
    exit;
}

if (isset($_POST['login-btn'])) {
    $email = $_POST['user_email'];
    $password = ($_POST['user_password']);

    $query = "SELECT * FROM users WHERE user_email = ? AND user_password = ? LIMIT 1";

    $stmt_login = $conn->prepare($query);
    $stmt_login->bind_param('ss', $email, $password);

    if ($stmt_login->execute()) {
        $stmt_login->bind_result($user_id, $user_name, $user_email, $user_password, $user_phone, $user_address, $user_city, $user_photo);
        $stmt_login->store_result();

        if ($stmt_login->num_rows() == 1) {
            $stmt_login->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_phone'] = $user_phone;
            $_SESSION['user_address'] = $user_address;
            $_SESSION['user_city'] = $user_city;
            $_SESSION['user_photo'] = $user_photo;
            $_SESSION['logged_in'] = true;

            header('location: welcome.php?message=Logged in successfuly');
        } else {
            header('location: login.php?error=Could not verify your account');
        }
    } else {
        //Error
        header('location: login.php?error=Something went wrong');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <h2>Login Page</h2>
    <br>
    <div class="login">
        <form class="formulir" id="login-form" method="POST" action="login.php">
            <?php if (isset($_GET['error'])) ?>
            <div role="alert">
                <?php if (isset($_GET['error'])) {
                    echo $_GET['error'];
                }
                ?>
            </div>

            <label> <b>Email</b> </label>
            <br>
            <input type="email" name="user_email">
            <br>
            <br>
            <label> <b>Password</b></label>
            <br>
            <input type="password" name="user_password">
            <br>
            <br>
            <input class="tombol" type="submit" class="site-btn" id="login-btn" name="login-btn" value="LOGIN">
        </form>
    </div>
</body>

</html>