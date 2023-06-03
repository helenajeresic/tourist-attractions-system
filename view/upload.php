<?php
require_once __SITE_PATH . '/app/start.php';

if(isset($_FILES['file'])) {
/*
    $file = $_FILES['file'];
    $name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $extension = exploade('.',$name);
    $extension =strtolower(end($extenstion));
    $key = md5((uniqid()));
    $tmp_file_name = "{$key}.{$extension}";
    $tmp_file_path = "files/{$tmp_file_name}";
    move_uploaded_file($tmp_name, $mp_file_path);
    
    try {
        $s3->putObject([
            'Bucket' => $config['s3']['bucket'];
            'Key' => "uploads/{$name}",
            'Body' => fopen($tmp_file_path, 'rb'),
            'ACL' => 'public-read'
        ]);
        unlink($tmp_file_path);
        
    } catch(S3Exception $e) {
        die("There was an error uploading that file");
    }*/
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form/data">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>
</body>
</html>