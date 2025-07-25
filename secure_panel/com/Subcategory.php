<?php 
  class Subcategory extends sqlConnection{
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
	 	$qry = $db->fireQuery("update `subcategory` set `status`='Active' where id = '$rec_id'");
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:subcategory-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:subcategory-mgmt.php");die();
		}
	  }

//Deactivate
    
public function checkDeactivate( $qry ){
	   $db = $this->database;
		  extract( $qry );
		  $rec_id=$_REQUEST['id'];	
	 	$qry = $db->fireQuery("update `subcategory` set `status`='Inactive' where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
           header("location:subcategory-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:subcategory-mgmt.php");die();
		}
	  }
	  
	   
	   //delete rowwise
	   
	   public function deletePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $rec_id=siteDecrypt($_REQUEST['id']);		
	 	$qry = $db->fireQuery("delete from `subcategory` where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) deleted successfully!";
            header("location:subcategory-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not deleted successfully!";
         header("location:subcategory-mgmt.php");die();
		}
		 
		
	  }
	  
	  	
	  # delete record	  
	  public function deleteRecord( $qry ){
		  $db = $this->database;
		  extract( $qry );		  
	  foreach( $checkAll as $id )
	   {
		$qry = $db->fireQuery("delete from `subcategory` where id = '$id'");
		
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

		$subcategory = trim($qry['subcategory'] ?? '');
		$category = trim($qry['category'] ?? '');
		$detail = trim($qry['detail'] ?? '');
		$status = 'Active'; 

		//  Auto SEO data
		$title = "Subcategory - " . $subcategory;
		$metatag = "Meta for " . $subcategory;
		$descp = "Auto generated description for " . $subcategory;

		$photo = $_FILES['photo']['name'] ?? '';
		$path = "uploads/subcategory/";
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		if ($photo) {
			$tmp = $_FILES['photo']['tmp_name'];
			move_uploaded_file($tmp, $path . $photo);
		} else {
			$photo = $qry['photo1'] ?? '';
		}

		$action = $_REQUEST['action'] ?? '';
		if ($action == 'add') {
			$insert = $db->fireQuery(
			"INSERT INTO subcategory (`category`, `subcategory`, `photo`, `detail`, `status`, `title`, `metatag`, `descp`)
			VALUES ('$category', '$subcategory', '$photo', '$detail', '$status', '$title', '$metatag', '$descp')"
			);
			$_SESSION['msg'] = $insert ? 'Subcategory inserted!' : 'Insert failed!';
		} elseif ($action == 'edit') {
			$id = siteDecrypt($_REQUEST['id']);
			$update = $db->fireQuery(
			"UPDATE subcategory SET
				`category` = '$category',
				`subcategory` = '$subcategory',
				`photo` = '$photo',
				`detail` = '$detail',
				`status` = '$status',
				`title` = '$title',
				`metatag` = '$metatag',
				`descp` = '$descp'
			WHERE id = '$id'"
			);
			$_SESSION['msg'] = $update ? 'Subcategory updated!' : 'Update failed!';
		}
		header("Location: " . $this->page);
		exit;
		}

		
    
}
?>   
     
     
     
     