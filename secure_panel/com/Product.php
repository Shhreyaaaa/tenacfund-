<?php 
class Product extends sqlConnection {
    public $database;
    public $page;

    public function __construct() {
        $this->database = new sqlConnection();
        $this->page = $_SERVER['REQUEST_URI'];
    }

    public function checkActivate($qry) {
        $db = $this->database;
        extract($qry);
        $rec_id = $_REQUEST['id'];
        $qry = $db->fireQuery("UPDATE `product` SET `status`='Active' WHERE id = '$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:service-mgmt.php"); die();
        } else {
            $_SESSION['errormsg'] = "Record(s) Status NOT Changed!";
            header("location:service-mgmt.php"); die();
        }
    }

    public function checkDeactivate($qry) {
        $db = $this->database;
        extract($qry);
        $rec_id = $_REQUEST['id'];
        $qry = $db->fireQuery("UPDATE `product` SET `status`='Inactive' WHERE id = '$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:service-mgmt.php"); die();
        } else {
            $_SESSION['errormsg'] = "Record(s) Status NOT Changed!";
            header("location:service-mgmt.php"); die();
        }
    }

    public function deletePhoto($qry) {
        $db = $this->database;
        extract($qry);
        $rec_id = siteDecrypt($_REQUEST['id']);
        $qry = $db->fireQuery("DELETE FROM `product` WHERE id = '$rec_id'");
        if ($qry) {
            $_SESSION['msg'] = "Record deleted successfully!";
            header("location:service-mgmt.php"); die();
        } else {
            $_SESSION['errormsg'] = "Error deleting record!";
            header("location:service-mgmt.php"); die();
        }
    }

    public function deleteRecord($qry) {
        $db = $this->database;
        extract($qry);
        foreach ($checkAll as $id) {
            $qry = $db->fireQuery("DELETE FROM `product` WHERE id = '$id'");
            if ($qry) {
                $_SESSION['msg'] = "Record(s) deleted successfully!";
            } else {
                $_SESSION['errormsg'] = "Error deleting record(s)!";
            }
        }
        header("location:$this->page"); die();
    }

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

        $fimg = $photo;
        $real_tpath = realpath($path);
        $file = $real_tpath . "\\" . $fimg;
        imagejpeg($img2, $file);
        return $file;
    }

    public function updatePhoto($qry) {
        $db = $this->database;
        extract($qry);
        $action = $_REQUEST["action"];

        //  New fields:
        $title = isset($title) ? trim($title) : '';
        $metatag = isset($metatag) ? trim($metatag) : '';
        $descp = isset($descp) ? trim($descp) : '';

        $detail = $detail;
        $photo = $_FILES['photo']['name'];
        $size = $_FILES['photo']['size'];
        $path = "uploads/product/";

        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "JPEG", "JPG", "PNG", "GIF", "BMP");
        if (strlen($photo)) {
            list($txt, $ext) = explode(".", $photo);
            if (in_array($ext, $valid_formats)) {
                if ($size < (1024 * 1024)) {
                    $actual_image_name = $photo;
                    $tmp = $_FILES['photo']['tmp_name'];

                    if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                        $_SESSION['msg'] = 'Image uploaded successfully';
                    } else {
                        $_SESSION['errormsg'] = "Image upload failed!";
                    }
                } else {
                    $_SESSION['msg'] = "Image file size max 1 MB";
                }
            }
        }

        if ($action == 'add') {
            $page = $this->page;
            $date = date('Y-m-d');

            $insert = $db->fireQuery("
                INSERT INTO product 
                (`photo`, `name`, `url`, `category`, `subcategory`, `detail`, `page`, `date`, `title`, `metatag`, `descp`) 
                VALUES 
                ('$photo', '$name', '$url', '$category', '$subcategory', '$detail', '$page', '$date', '$title', '$metatag', '$descp')
            ");

            if ($insert) {
                $_SESSION['msg'] = "Record inserted successfully!";
                header("location:$this->page");
                die();
            }
        }

        if ($action == 'edit') {
            if ($photo != '') {
                $update = $db->fireQuery("
                    UPDATE `product` 
                    SET `photo`='$photo', `name`='$name', `url`='$url', `category`='$category', `subcategory`='$subcategory', `detail`='$detail',
                        `title`='$title', `metatag`='$metatag', `descp`='$descp'
                    WHERE id=" . siteDecrypt($_REQUEST['id']));
            } else {
                $update = $db->fireQuery("
                    UPDATE `product` 
                    SET `photo`='$photo1', `name`='$name', `url`='$url', `category`='$category', `subcategory`='$subcategory', `detail`='$detail',
                        `title`='$title', `metatag`='$metatag', `descp`='$descp'
                    WHERE id=" . siteDecrypt($_REQUEST['id']));
            }
            if ($update) {
                $_SESSION['msg'] = "Record updated successfully!";
                header("location:$this->page");
                die();
            }
        }
    }
}
?>
