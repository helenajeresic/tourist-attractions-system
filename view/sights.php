<?php 
    require_once __SITE_PATH . '/view/_header.php';
    require_once __SITE_PATH . '/model/sight.class.php';
?>

<form action="<?php echo __SITE_URL . 'index.php?rt=sights/processSelectForm'?>" method="post" class="mb-3">
                <h3>Odaberi atrakciju koju želis posjetiti:</h3>
                <select name="lang[]" multiple class="form-control">
                 
                    <?php foreach( $data as $d ) {?>
                        <option value="<?php echo $d->__get('id')?>"><?php echo $d->__get('name')?></option>
                    <?php } ?>

                </select>

                <h3>Koju zelis da ti bude prva:</h3>
                <select name="lan" class="form-control">

                 
                    <?php foreach( $data as $d ) { ?>
                        <option value="<?php echo $d->__get('name')?>"><?php echo $d->__get('name')?></option>
                    <?php } ?>

                </select>
                
                <div>
                    <br>
                    <input type="submit" name="submit" value="Odaberi!">
                </div>
</form>

<?php foreach( $show as $d ) { 
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
