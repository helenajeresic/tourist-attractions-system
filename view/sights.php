<?php require_once __SITE_PATH . '/view/_header.php';
    require_once __SITE_PATH . '/model/sight.class.php';?>

<form action="" method="post" class="mb-3">
                <h3>Odaberi atrakciju koju želis posjetiti:</h3>
                <select name="lang[]" multiple class="form-control">
                 
                    <?php foreach( $data as $d ) { ?>
                        <option value="<?php $d->__get('name')?>"><?php echo $d->__get('name')?></option>
                    <?php } ?>
                </select>

                <h3>Koju zelis da ti bude prva:</h3>
                <select name="lang" multiple class="form-control">
                 
                    <?php foreach( $data as $d ) { ?>
                        <option value="<?php $d->__get('name')?>"><?php echo $d->__get('name')?></option>
                    <?php } ?>
                </select>
                
                <div>
                    <br>
                    <input type="submit" name="submit" value="Odaberi!">
                </div>
</form>

<?php foreach( $data as $d ) { 
    $src = "https://tourist-attractions-system-images.s3.eu-north-1.amazonaws.com/" . $d->__get( 'image' ); ?>

        <div class="responsive" >
        <div class="gallery">
            <a target="_blank" href="<?php echo $src?>">
            <img src="<?php echo $src?>" alt="<?php echo $d->__get( 'name' );?>">
            </a>
            <div class="desc"><?php echo $d->__get( 'name' );?></div>
        </div>
        </div>

<?php } ?>

<?php require_once __SITE_PATH . '/view/_footer.php';?>

<!--<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Multiple Select Dropdown in PHP</title>

        <style>
            .myform-container{
                width: 600px;
                margin: 50px auto;
            }

            .myform-container select{
                width: 300px;
            }
        </style>

    </head>
    <body>

        <div class="myform-container">


            <form action="" method="post" class="mb-3">
                <h3>Choose your favorite languages</h3>
                <select name="lang[]" multiple class="form-control">
                    <option value=""disabled selected>Choose option</option>
                    <option value="Laravel">Laravel</option>
                    <option value="Php">Php</option>
                    <option value="Jquery">Jquery</option>
                    <option value="Node Js">NodeJs</option>
                    <option value="Bootstrap">Bootstrap</option>
                </select>

                <div>
                    <br>
                    <input type="submit" name="submit" vlaue="Choose options">
                </div>

            </form>

            <?php
            /*if (isset($_POST['submit'])) {
                if (!empty($_POST['lang'])) {
                    foreach ($_POST['lang'] as $selected) {
                        echo '<p class="select-tag mt-3">' . $selected . '</p>';
                    }
                } else {
                    echo '<p class="error alert alert-danger mt-3">Please select any value</p>';
                }
            }*/
            ?>

        </div>

    </body>
</html>-->