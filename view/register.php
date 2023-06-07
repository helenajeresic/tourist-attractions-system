<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form action="<?php echo __SITE_URL . 'index.php?rt=login/processRegister' ?>" method="post">		
    <label for="fname">Ime</label><br />
    <input type="text" id="fname" name="first_name" placeholder="Vaše ime.." required>
    <br />
    <label for="lname">Prezime</label><br />
    <input type="text" id="lname" name="last_name" placeholder="Vaše prezime.." required>
    <br />
    <label for="rusername">Korisničko ime</label><br />
    <input type="text" id="rusername" name="username" placeholder="Korisničko ime.." required>
    <br />
    <label for="rpassword">Lozinka</label><br />
    <input type="password" id="rpassword" name="password" placeholder="Vaša lozinka.." required>
    <br />
    <br />
    <label for="lmail">e-mail</label><br />
    <input type="email" id="lmail" name="email" placeholder="Vaš e-mail.." required>
    <br />
    <br />
    <input type="submit" name="submit" value="Pošalji" />
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>