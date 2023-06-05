<?php require_once __SITE_PATH . '/view/_header.php';?>
    <form action="<?php echo __SITE_URL . 'index.php?rt=upload/processUpload'?>" method="post" enctype="multipart/form-data">
        <label for="naziv">Naziv atrakcije:</label>
        <input type="text" name="naziv" id="naziv" required><br>

        <label for="opis">Opis atrakcije:</label>
        <textarea name="opis" id="opis" required></textarea><br>

        <label for="x-koordinata">X-koordinata atrakcije:</label>
        <input type="number" name="x-koordinata" id="x-koordinata" required><br>

        <label for="y-koordinata">Y-koordinata atrakcije:</label>
        <input type="number" name="y-koordinata" id="y-koordinata" required><br>

        <label for="slika">Slika:</label>
        <input type="file" name="slika" id="slika" required><br>

        <input type="submit" value="Upload">
    </form>
</form>
<?php require_once __SITE_PATH . '/view/_footer.php';?>
