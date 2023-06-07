<?php require_once __SITE_PATH . '/view/_header.php'; 
if (isset($_SESSION['registrationFail'])) {
    echo $_SESSION['registrationFail'];
    unset($_SESSION['registrationFail']);
}
else if (isset($_SESSION['registrationError'])) {
    echo $_SESSION['registrationError'];
    unset($_SESSION['registrationError']);
}

?>

<form action="<?php echo __SITE_URL . 'index.php?rt=login/processRegister' ?>" method="post">		
    <label for="fname">Ime</label><br>
    <input type="text" id="fname" name="first_name" placeholder="Vaše ime.." required><br>
    <br>
    <label for="lname">Prezime</label><br>
    <input type="text" id="lname" name="last_name" placeholder="Vaše prezime.." required><br>
    <br>
    <label for="rusername">Korisničko ime</label><br>
    <input type="text" id="rusername" name="username" placeholder="Korisničko ime.." required><br>
    <br>
    <label for="rpassword">Lozinka</label><br>
    <input type="password" id="rpassword" name="password" placeholder="Vaša lozinka.." required><br>
    <br>
    <label for="lmail">e-mail</label><br>
    <input type="email" id="lmail" name="email" placeholder="Vaš e-mail.." required><br>
    <br>
    <br>
    <input type="submit" name="submit" value="Pošalji" />
</form>

<br>
<div class="form-group">
            <form method="post" action="<?php echo __SITE_URL . 'index.php?rt=login' ?>">
            <br>
            <div class="float-end">
            <br>
            <input class="btn btn-secondary" type="submit" name="register" value="Vrati se na prijavu"/>
        </div>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>