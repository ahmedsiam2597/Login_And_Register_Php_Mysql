<?php
session_start();
if (isset($_SESSION['username'])) {
    include __DIR__ . "/init.php";

    ?>
    <div class="container home">
        <div class="content">
            <h1>Welcome
                <?php echo $_SESSION['username'] ?>
            </h1>
            <h2>
                <?php
                echo $_SESSION['is_admin'] == 1 ? "You Are Admin" : "You Are User";
                ?>
            </h2>
            <a href="logout.php" class="logout">Log Out</a>
        </div>
    </div>
    <?php
    include __DIR__ . "/includes/temp/footer.php";
} else {
    header("location:login.php");
    exit;
}
?>