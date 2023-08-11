<?php
session_start();
$title = "Login";
require __DIR__ . "/init.php";

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
$error = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $passwrd = filter_input(INPUT_POST, 'passwrd', FILTER_SANITIZE_STRING);

    $stmt = $db->prepare("SELECT id , username , passwrd , is_admin FROM users WHERE username = :uname ");
    $stmt->execute(["uname" => $username]);
    $data = $stmt->fetch();
    if ($stmt->rowCount() != 1) {
        $error = "Username Not exists !";
    }

    if (is_array($data)) {
        if (password_verify($passwrd, $data['passwrd']) && $data['username'] == $username) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['is_admin'] = $data['is_admin'];
            $_SESSION['id'] = $data['id'];
            echo $_SESSION['is_admin'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Check Username or Password !";
        }
    }
}

?>



<div class="container">
    <div class="card">
        <h3>Login</h3>
        <small>
            <?php show_error($error) ?>
        </small>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="username" value="<?php echo $username ?>" />
            </div>

            <div class="form-group">
                <input type="password" name="passwrd" placeholder="Password" />
            </div>
            <button type="submit">Login</button>
            <p>Create New Account  ? <a href="register.php">Click Here</a></p>
        </form>
    </div>
</div>

<?php

require __DIR__ . "/includes/temp/footer.php";
