<?php require_once __SITE_PATH . '/view/_header.php';?>

<form action="<?php echo __SITE_URL . 'index.php?rt=delete/processDelete'?>" method="post" class="mb-3">
                <h3>Odaberi atrakciju koju želis obrisati:</h3>
                <select name="lang"  class="form-control">
                 
                    <?php foreach( $data as $d ) {?>
                        <option value="<?php echo $d->__get('id')?>"><?php echo $d->__get('name')?></option>
                    <?php } ?>

                </select>
                
                <div>
                    <br>
                    <input type="submit" name="submit" value="Izbriši">
                </div>

</form>

<?php require_once __SITE_PATH . '/view/_footer.php';?>