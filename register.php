<?php
require_once('classes/User.php');
require_once('utils/db_conn.php'); 

$username = '';
$email = '';
$password = '';
$cpassword = '';
$error = '';
$invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new DatabaseConnection(); 

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["confirm-password"];

    if ($password != $cpassword) {
        $error = 'Passwords do not match';
    } else {

        $user = User::findByEmail($email);
        if ($user) {
            $error = 'Email is already registered';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUser = new User($email, $username, $hashedPassword, "");
            $success = $newUser->save();
            if ($success) {
                header('Location: index.php');
                exit();
            } else {
                $error = 'An error occurred during registration. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Page</title>
    <?php require_once('default_head.php') ?>
</head>
<body class="text-center">
    <div class="card d-i-block" style="margin-top: 50px; padding: 10px;">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input type="email" id="email" name="email" value="<?=$email?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>
                            <input type="text" id="username" name="username" value="<?=$username?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>
                            <input type="password" id="password" name="password" value="<?=$password?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td>
                            <input type="password" id="confirm-password" name="confirm-password" value="<?=$cpassword?>" required>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" value="Register" class="btn-primary">
            <div style="color: red; text-size: 14px;">
            <?php
                if($invalid) {
                    echo "Invalid username or password";
                } else if (!empty($error)) {
                    echo $error;
                }
            ?>
            </div>
        </form>
        <a href="login.php"><div>Already have an account? login</div></a>
    </div>
     <script src="utils/button-interaction.js"></script>
</body>
</html>
