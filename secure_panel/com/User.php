<?php 
class User extends sqlConnection {
    public $database;
    public $page;

    # Initialise User Class
    public function __construct() {
        $this->database = new sqlConnection();
        $this->page = $_SERVER['REQUEST_URI'];
    }

    # Activate user
    public function checkActivate($qry) {
        $db = $this->database;
        $rec_id = $_REQUEST['id'];
        $qry = $db->fireQuery("UPDATE `user` SET `status`='Active' WHERE id='$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record status changed successfully!";
        } else {
            $_SESSION['errormsg'] = "Status change failed!";
        }
        header("location:user-mgmt.php");
        die();
    }

    # Deactivate user
    public function checkDeactivate($qry) {
        $db = $this->database;
        $rec_id = $_REQUEST['id'];
        $qry = $db->fireQuery("UPDATE `user` SET `status`='Inactive' WHERE id='$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record status changed successfully!";
        } else {
            $_SESSION['errormsg'] = "Status change failed!";
        }
        header("location:user-mgmt.php");
        die();
    }

    # Delete single user (for delete icon)
    public function deletePhoto($qry) {
        $db = $this->database;
        $rec_id = siteDecrypt($_REQUEST['id']);
        $qry = $db->fireQuery("DELETE FROM `user` WHERE id='$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record deleted successfully!";
        } else {
            $_SESSION['errormsg'] = "Record not deleted!";
        }
        header("location:user-mgmt.php");
        die();
    }

    # Delete multiple users (checkbox)
    public function deleteRecord($qry) {
        $db = $this->database;
        extract($qry);
        if (!empty($checkAll)) {
            foreach ($checkAll as $id) {
                $qry = $db->fireQuery("DELETE FROM `user` WHERE id='$id'");
                if ($qry) {
                    $_SESSION['msg'] = "Record(s) deleted successfully!";
                } else {
                    $_SESSION['errormsg'] = "Error deleting record(s)!";
                }
            }
        }
        header("location:$this->page");
        die();
    }

    # Resize method — (keep as is if used elsewhere)
    public function Resize($tmp, $path, $photo, $width, $height) {
        extract($_POST);
        $photo = $tmp;
        $handle = fopen($photo, "r");
        $org = fread($handle, filesize($photo));
        fclose($handle);
        $photo = imagecreatefromstring($org);
        $wth = imagesx($photo);
        $hgt = imagesy($photo);
        $nw = $width;
        $nh = $height;

        $img2 = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($img2, $photo, 0, 0, 0, 0, $nw, $nh, $wth, $hgt);

        $real_tpath = realpath($path);
        $file = $real_tpath . "\\" . $photo;
        imagejpeg($img2, $file);
        return $file;
    }

    # Insert/update user
    public function updatePhoto($qry) {
        $db = $this->database;
        extract($qry);
        $action = $_REQUEST["action"];

        $photo = $_FILES['photo']['name'] ?? '';
        $size = $_FILES['photo']['size'] ?? 0;
        $path = "uploads/user/";

        $valid_formats = ["jpg", "png", "gif", "bmp", "jpeg", "JPEG", "JPG", "PNG", "GIF", "BMP"];
        if (strlen($photo)) {
            list($txt, $ext) = explode(".", $photo);
            if (in_array($ext, $valid_formats)) {
                if ($size < (1024 * 1024)) {
                    $actual_image_name = $photo;
                    $tmp = $_FILES['photo']['tmp_name'];
                    if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                        $_SESSION['msg'] = 'Image uploaded successfully';
                    } else {
                        $_SESSION['errormsg'] = "Image upload failed";
                    }
                } else {
                    $_SESSION['errormsg'] = "Image file size max 1 MB";
                }
            } else {
                $_SESSION['errormsg'] = "Invalid file format";
            }
        }

        if ($action == 'add') {
            $insert = $db->fireQuery("INSERT INTO `user` (`pan`,`name`,`phone`,`email`,`address`,`age`,`password`,`status`,`added_on`) 
                VALUES ('$photo','$name','$phone','$email','$address','$age','$password','Active',NOW())");
            if ($insert) {
                $_SESSION['msg'] = "Record inserted successfully!";
            } else {
                $_SESSION['errormsg'] = "Insert failed!";
            }
        }

        if ($action == 'edit') {
            $id = siteDecrypt($_REQUEST['id']);
            if ($photo != '') {
                $update = $db->fireQuery("UPDATE `user` SET `pan`='$photo',`name`='$name',`phone`='$phone',`email`='$email',
                    `address`='$address',`age`='$age',`password`='$password',`status`='Active' WHERE id='$id'");
            } else {
                $update = $db->fireQuery("UPDATE `user` SET `name`='$name',`phone`='$phone',`email`='$email',
                    `address`='$address',`age`='$age',`password`='$password',`status`='Active' WHERE id='$id'");
            }
            if ($update) {
                $_SESSION['msg'] = "Record updated successfully!";
            } else {
                $_SESSION['errormsg'] = "Update failed!";
            }
        }

        header("location:$this->page");
        die();
    }
}
?>
