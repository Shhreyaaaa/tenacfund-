	<?php 
	class Category extends sqlConnection{
		public $database;
		public $page;
		# Initialise Admin Class
		public function __construct(){
			$this->database = new sqlConnection();
			$this->page = $_SERVER['REQUEST_URI'];
		}
			
	# Activate
	public function checkActivate( $qry ){
		$db = $this->database;
			extract( $qry );
			$rec_id=$_REQUEST['id'];	
			$qry = $db->fireQuery("update `category` set `status`='Active' where id = '$rec_id'");
			if($qry)
			{
				$_SESSION['msg'] = "Record(s) Status Changed successfully!";
				header("location:category-mgmt.php");die();
			}
			else
			{
			$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
			header("location:category-mgmt.php");die();
			}
		}

	//Deactivate
		
	public function checkDeactivate( $qry ){
		$db = $this->database;
			extract( $qry );
			$rec_id=$_REQUEST['id'];	
			$qry = $db->fireQuery("update `category` set `status`='Inactive' where id = '$rec_id'");
			
			if($qry)
			{
				$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
			header("location:category-mgmt.php");die();
			}
			else
			{
			$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
			header("location:category-mgmt.php");die();
			}
		}
		
		
		//delete rowwise
		
		public function deletePhoto( $qry ){
			$db = $this->database;
			extract( $qry );
			$rec_id=siteDecrypt($_REQUEST['id']);		
			$qry = $db->fireQuery("delete from `category` where id = '$rec_id'");
			
			if($qry)
			{
				$_SESSION['msg'] = "Record(s) deleted successfully!";
				header("location:category-mgmt.php");die();
			}
			else
			{
			$_SESSION['errormsg'] = "Record(s) Not deleted successfully!";
			header("location:category-mgmt.php");die();
			}
			
			
		}
		
			
		# delete record	  
		public function deleteRecord( $qry ){
			$db = $this->database;
			extract( $qry );		  
		foreach( $checkAll as $id )
		{
			$qry = $db->fireQuery("delete from `category` where id = '$id'");
			
			if($qry)
			{
				$_SESSION['msg'] = "Record(s) deleted successfully!";
			}
			else
			{
				$_SESSION['errormsg'] = "Error in deleting record(s)!";
			}
		} header("location:$this->page");die();
		}
		
		
		public function Resize( $tmp, $path ,$photo , $width,$height ){
				extract($_POST);
				$photo = $tmp ;
				$handle = fopen ($photo, "r");
				$org = fread ($handle, filesize ($photo));
				fclose ($handle);
				$photo = imagecreatefromstring( $org );
				$wth = imagesx( $photo );
				$hgt = imagesy( $photo );
				$nw =$width;
				$nh =$height;
		
				$img2 = imagecreatetruecolor( $nw, $nh );
				imagecopyresampled ( $img2, $photo, 0,0,0,0, $nw, $nh, $wth, $hgt );
		
						
				$fimg = $photo;
				$real_tpath = realpath($path);
				$file = $real_tpath . "\\" . $fimg;
				imagejpeg( $img2, $file );
				return $file;
		
		}
		//update records
		public function updatePhoto($qry) {
			$db = $this->database;
			extract($qry);

			$action = $_REQUEST["action"];
			$detail = trim($detail);
			$category = trim($category);
			$btn_name = trim($btn_name);
			$title = trim($title ?? $category); 
			$status = trim($status ?? 'Active');

			$photo = $_FILES['photo']['name'] ?? '';
			$size = $_FILES['photo']['size'] ?? 0;
			$path = "uploads/category/";

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
					$_SESSION['errormsg'] = "Upload failed";
					}
				} else {
					$_SESSION['errormsg'] = "Image file size max 1 MB";
				}
				} else {
				$_SESSION['errormsg'] = "Invalid file format.";
				}
			}

			if ($action == 'add') {
				$insert = $db->fireQuery(
					"INSERT INTO category(`photo`, `category`, `btn_name`, `detail`, `title`, `descp`) 
					VALUES ('$photo', '$category', '$btn_name', '$detail', '$category', '$detail')"
				);
				if ($insert) {
					$_SESSION['msg'] = "Record inserted successfully!";
					header("location:$this->page");
					die();
				}
				}


			if ($action == 'edit') {
				$photoField = ($photo != '') ? "`photo`='$photo'" : "`photo`='$photo1'";
				$update = $db->fireQuery("UPDATE `category` SET 
											$photoField, 
											`title`='$title',
											`category`='$category',
											`btn_name`='$btn_name',
											`detail`='$detail',
											`status`='$status'
										WHERE id=" . siteDecrypt($_REQUEST['id']));
				if ($update) {
				$_SESSION['msg'] = "Record updated successfully!";
				header("location:$this->page");
				die();
				}
			}
		}


	
		
	}
	?>   
		
		
		
		