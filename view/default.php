<?php 
    require_once __SITE_PATH . '/view/_header.php';
    require_once __SITE_PATH . '/model/sight.class.php';
    if($shortest_path === true) {
        require_once __SITE_PATH . '/view/path.php';
    }

    if($welcome === true) {
        require_once __SITE_PATH . '/view/welcome.php';
    }
?>

<br><br>

<?php foreach( $show_attractions as $index => $d ) { 
    $src = "https://tourist-attractions-system-images.s3.eu-north-1.amazonaws.com/" . $d->__get( 'image' );
    $popupID = 'popup-' . $index;?>
        <div class="responsive">
        <div class="gallery">
        <div class="container">
        <div class="content">
            <img src="<?php echo $src?>" alt="<?php echo $d->__get( 'name' );?>">
            <div class="name"><?php echo $d->__get( 'name' );?></div>
            <div class="showmore"><a href="#" onclick="toggle('<?php echo $popupID; ?>')">Vidi više</a></div>
        </div>
        </div>
        </div>
        </div>

        <div id="<?php echo $popupID; ?>" class="popup">
            <p><?php echo $d->__get( 'desc' );?></p>
            <a href="#" onclick="toggle('<?php echo $popupID; ?>')">Zatvori</a>
        </div>

        <script>
            function toggle(popupID){
                var popup = document.getElementById(popupID);
                popup.classList.toggle('active');
            }
        </script>
<?php } ?>

<?php require_once __SITE_PATH . '/view/_footer.php';?>