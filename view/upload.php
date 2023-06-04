<?php require_once __SITE_PATH . '/view/_header.php';?>
<form action="<?php echo __SITE_URL . 'index.php?rt=upload/processUpdate'?>" method="post" enctype="multipart/form-data">
    <!--<div>
        <label for="name">Naziv atrakcije:</label>
        <input type="text" name="name" id="name">
    </div>
    
    <div>
        <label for="name">Opis atrakcije:</label>
        <textarea name="description" id="description"></textarea>
    </div>

    <label for="xcoordinate">x koordinata:</label>
    <input type="text" name="xcoordinate" id="xcoordinate">
    </div>

    <div>
    <label for="ycoordinate">y koordinata:</label>
    <input type="text" name="ycoordinate" id="ycoordinate">-->

    <div> 
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </div>

    <!--<input type="submit" value="Submit">-->
</form>
<?php require_once __SITE_PATH . '/view/_footer.php';?>
