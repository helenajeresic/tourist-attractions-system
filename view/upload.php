<?php require_once __SITE_PATH . '/view/_header.php';
if(isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<script src="<?php echo __SITE_URL . 'util/validateRequiredForm.js'; ?>"></script>
    <form action="<?php echo __SITE_URL . 'index.php?rt=upload/processUpload'?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
         <h3>Učitaj novu atrakciju:</h3>
        <label for="naziv">Naziv atrakcije:</label>
        <input type="text" name="naziv" id="naziv" required><br>
        <br>
        <label for="opis">Opis atrakcije:</label>
        <textarea name="opis" id="opis" required></textarea><br>
        <br>
        <label for="x-koordinata">x koordinata atrakcije:</label>
        <input type="number" name="x-koordinata" id="x-koordinata" required><br>
        <br>
        <label for="y-koordinata">y koordinata atrakcije:</label>
        <input type="number" name="y-koordinata" id="y-koordinata" required><br>
        <br>
        <label for="slika">Slika:</label>
        <input type="file" name="slika" id="slika" required><br>
        <br>
        <input type="submit" value="Učitaj">
    </form>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php';?>
