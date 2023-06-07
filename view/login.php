<?php require_once __SITE_PATH . '/view/_header.php';
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login/processLoginForm' ?>">
        <div class="form-group">
            <label for="username">Korisničko ime</label><br>
            <input class="form-control" id="username" name="username" type="text" placeholder="Korisničko ime.." required>
        </div>
        <br>
        <div class="form-group">
            <label for="password">Lozinka</label><br>
            <input class="form-control" id="password" name="password" type="password" placeholder="Lozinka.." required>
        </div>
        <br>
        <div class="float-end">
            <input class="btn btn-primary" type="submit" name="login" value="Prijavi se"/>
        </div>
        <br>
</form>

<div class="form-group">
            <label>Registriraj se</label>
            <form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login/register' ?>">
            <div class="float-end">
            <br>
            <input class="btn btn-secondary" type="submit" name="register" value="Registracija"/>
        </div>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
