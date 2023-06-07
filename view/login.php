<?php require_once __SITE_PATH . '/view/_header.php';
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login/processLoginForm' ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" id="username" name="username" type="text">
        </div>
        <br>
        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" id="password" name="password" type="password">
        </div>
        <br>
        <div class="float-end">
            <input class="btn btn-primary" type="submit" name="login" value="Login"/>
        </div>
        <br>

        <div class="form-group">
            <h3>First time here?</h3>
            <!-- reroute to register.php -->
            <!-- <a class="btn btn-secondary" href="< ?php echo __SITE_URL . 'index.php?rt=register.php' ?>">Register</a> -->
          
        </div>
        <br>
</form>

<form action="< ?php echo __SITE_URL . 'index.php?rt=login/processRegister' ?>" method="post">		
    <label for="fname">Ime</label><br />
    <input type="text" id="fname" name="first_name" placeholder="Vaše ime..">
    <br />
    <label for="lname">Prezime</label><br />
    <input type="text" id="lname" name="last_name" placeholder="Vaše prezime..">
    <br />
    <label for="rusername">Korisničko ime</label><br />
    <input type="text" id="rusername" name="username" placeholder="Korisničko ime..">
    <br />
    <label for="rpassword">Lozinka</label><br />
    <input type="password" id="rpassword" name="password" placeholder="Vaša lozinka..">
    <br />
    <br />
    <label for="lmail">e-mail</label><br />
    <input type="email" id="lmail" name="email" placeholder="Vaš e-mail..">
    <br />
    <br />
    <input type="submit" name="submit" value="Pošalji" />
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
