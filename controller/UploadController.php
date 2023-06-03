<?php 

class UploadController extends BaseController {
    public function index(){
        $this->registry->template->title = "Upload";
        $this->registry->template->error = false;
        $this->registry->template->show("upload");
    }

    public function processUpdate(){
        require_once __SITE_PATH . '/app/start.php';
        if(isset($_FILES['file'])) {
            
            $file = $_FILES['file'];
            $name = $file['name'];
            $tmp_name = $file['tmp_name'];
            $extension = explode('.',$name);
            $extension =strtolower(end($extenstion));
            $key = md5((uniqid()));
            $tmp_file_name = "{$key}.{$extension}";
            $tmp_file_path = "files/{$tmp_file_name}";
            move_uploaded_file($tmp_name, $mp_file_path);
            
            try {
                $s3->putObject([
                    'Bucket' => $config['s3']['bucket'],
                    'Key' => "uploads/{$name}",
                    'Body' => fopen($tmp_file_path, 'rb'),
                    'ACL' => 'public-read'
                ]);
                unlink($tmp_file_path);
            }
            catch(exception $e){
                die("There was an exception");
            }
            // } catch(S3Exception $e) {
            //     die("There was an error uploading that file");
            // }
        }
    }

}

?>