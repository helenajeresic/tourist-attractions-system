<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($title)) echo $title; else echo "Znamenitosti" ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL . 'css/style.css';?>">
</head>
<body>  

    <?php  if(isset($_SESSION['user'])){?>
        <div class="topnav" id="myTopnav">
			<a href="index.php?rt=sights">Naslovna</a>
            <a href="index.php?rt=sights/choose">Odabir atrakcija</a>
            <?php  if(isset($_SESSION['admin'])){?>
      		<a href="index.php?rt=upload"> Učitaj novu atrakciju</a>
      		<a href="index.php?rt=update"> Promijeni podatke atrakcije </a>
			<a href="index.php?rt=delete"> Izbriši atrakciju </a>
            <?php } ?>
			<a href="index.php?rt=login/out"> Odjavi se </a>
        </div>
        <br>
    <?php } ?>