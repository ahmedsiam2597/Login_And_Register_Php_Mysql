<?php
$title = "Register";

require __DIR__ . "/init.php";
$email = "";
$username = "";
$passwrd = "";
$error_username = "";
$error_email = "";
$error_passwrd = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $passwrd = filter_input(INPUT_POST, 'passwrd', FILTER_SANITIZE_STRING);
    $hash_passwrd = password_hash($passwrd, PASSWORD_DEFAULT);

    if (empty($username)) {
        $error_username = "* Username is required";
    } elseif (strlen($username) < 3) {
        $error_username = "* Username Must Be 3 Character or More";
    }


    if (empty($email)) {
        $error_email = "* Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "* Invalid Email";

    }

    if (empty($passwrd)) {
        $error_passwrd = "* Password is required";
    } elseif (strlen($passwrd) < 8) {
        $error_passwrd = "* Password Must Be 8 Character or More ";
    }

    $row_username = row_count('username', 'users',$username);
    $row_email = row_count('email','users' ,$email);
    
    if($row_username == 1){
        $error_username = "* Username is Exists";
    }
    if($row_email == 1){
        $error_email = "* email is Exists";
    }

    if (!$error_username && !$error_email && !$error_passwrd) {
        
        if ($row_username == 0 && $row_email == 0) {
            $stmt = $db->prepare("INSERT INTO users (username , email , passwrd) VALUES (:uname , :email , :passwrd)");
            $stmt->execute([
                ":uname" => $username,
                ":email" => $email,
                ":passwrd" => $hash_passwrd
            ]);
            header("Location: login.php");
            exit;
        }



    }

}


?>


<div class="container">
    <div class="card">
        <h3>Register</h3>
        <small>
            <?php show_error($error) ?>
        </small>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

            <div class="form-group">
                <input type="text" name="username" placeholder="username" value="<?php echo $username ?>">
                <span class="star">*</span>
                <small>
                    <?php show_error($error_username) ?>
                </small>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
                <span class="star">*</span>
                <small>
                    <?php show_error($error_email) ?>
                </small>
            </div>
            <div class="form-group">
                <input type="password" name="passwrd" placeholder="Password">
                <span class="star">*</span>
                <small>
                    <?php show_error($error_passwrd) ?>
                </small>
            </div>
            <button type="submit">Register</button>
            <p>Go To Login ? <a href="login.php">Click Here</a> </p>
        </form>
    </div>
</div>

<?php

require __DIR__ ."/includes/temp/footer.php";