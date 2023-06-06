<?php require_once __SITE_PATH . '/view/_header.php';?>
    <form action="<?php echo __SITE_URL . 'index.php?rt=update/processUpdate'?>" method="post" enctype="multipart/form-data">
        <h3>Odaberi atrakciju kojoj želiš promijeniti podatke:</h3>
        <select name="lang"  class="form-control">
                 
            <?php foreach( $data as $d ) {?>
                    <option value="<?php echo $d->__get('id')?>"><?php echo $d->__get('name')?></option>
            <?php } ?>

        </select><br>

        <label for="naziv">Naziv atrakcije:</label>
        <input type="text" name="naziv" id="naziv" ><br>

        <label for="opis">Opis atrakcije:</label>
        <textarea name="opis" id="opis"></textarea><br>

        <label for="x-koordinata">X-koordinata atrakcije:</label>
        <input type="number" name="x-koordinata" id="x-koordinata" ><br>

        <label for="y-koordinata">Y-koordinata atrakcije:</label>
        <input type="number" name="y-koordinata" id="y-koordinata"><br>

        <label for="slika">Slika:</label>
        <input type="file" name="slika" id="slika"><br>

        <input type="submit" value="Update">
    </form>
</form>

<?php require_once __SITE_PATH . '/view/_goBack.php';?>
<?php require_once __SITE_PATH . '/view/_footer.php';?>