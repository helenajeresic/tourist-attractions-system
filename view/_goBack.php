<h3>Ako ne želiš raditi promjene atrakciju vrati se</h3>
<div>
    <br>
    <button onclick="goBack()" name="go-back" value="go-back!">Vrati se!</button>
</div>

<script>
    function goBack() {
        window.location.href = "<?php echo __SITE_URL . 'index.php?rt=sights/index'?>";
}
</script>