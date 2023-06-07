<?php require_once __SITE_PATH . '/view/_header.php';
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login/processLoginForm' ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" id="username" name="username" type="text" required>
        </div>
        <br>
        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" id="password" name="password" type="password" required>
        </div>
        <br>
        <div class="float-end">
            <input class="btn btn-primary" type="submit" name="login" value="Login"/>
        </div>
        <br>
</form>

<div class="form-group">
            <label>First time here?</label>
            <form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login/register' ?>">
            <div class="float-end">
            <br>
            <input class="btn btn-secondary" type="submit" name="register" value="Register"/>
        </div>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
