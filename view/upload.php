<?php require_once __SITE_PATH . '/view/_header.php';?>
<form action="<?php echo __SITE_URL . 'index.php?rt=upload/processUpdate'?>" method="post" enctype="multipart/form/data">
    <input type="file" name="file">
    <input type="submit" value="Upload">
</form>
<?php require_once __SITE_PATH . '/view/_footer.php';?>