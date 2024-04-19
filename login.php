<?php
require_once('utils/db_conn.php'); 
require_once('classes/User.php');
$email = '';
$password = '';
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = User::findByEmail($email);

    if (!$user) {
        $error = 'user not found!';
    } else if (!password_verify($password, $user->password)) {
        $error = 'Wrong password';
    } else {
        $user->set_cookie();
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <?php require_once('default_head.php') ?>
</head>
<body class="text-center">
    <div class="card d-i-block" style="margin-top: 50px; padding: 10px;">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Email</td><td><input type="email" id="email" name="email" value="<?=$email?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td><td><input type="password" id="password" name="password" value="<?=$password?>" required>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" value="Login" class="btn-primary">
            <div style="color: red; text-size: 14px;"><?=$error;?></div>
        </form>
        <a href="register.php"><div>Don't have an account?Register Here</div></a>
        
    </div>
     <script src="utils/button-interaction.js"></script>
</body>
</html>
