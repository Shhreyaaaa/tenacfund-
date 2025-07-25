<?php 
  class Ads extends sqlConnection{
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
	 	$qry = $db->fireQuery("update `ads` set `status`='Active' where id = '$rec_id'");
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:ads-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:ads-mgmt.php");die();
		}
	  }

//Deactivate
    
public function checkDeactivate( $qry ){
	   $db = $this->database;
		  extract( $qry );
		  $rec_id=$_REQUEST['id'];	
	 	$qry = $db->fireQuery("update `ads` set `status`='Inactive' where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
           header("location:ads-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:ads-mgmt.php");die();
		}
	  }
	  
	   
	   //delete rowwise
	   
	   public function deletePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $rec_id=siteDecrypt($_REQUEST['id']);		
	 	$qry = $db->fireQuery("delete from `ads` where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) deleted successfully!";
            header("location:ads-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not deleted successfully!";
         header("location:ads-mgmt.php");die();
		}
		 
		
	  }
	  
	  	
	  # delete record	  
	  public function deleteRecord( $qry ){
		  $db = $this->database;
		  extract( $qry );		  
	  foreach( $checkAll as $id )
	   {
		$qry = $db->fireQuery("delete from `ads` where id = '$id'");
		
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
	
			//$fimg = $name.'.'.'jpg';		
			$fimg = $photo;
			$real_tpath = realpath($path);
			$file = $real_tpath . "\\" . $fimg;
			imagejpeg( $img2, $file );
			return $file;
	
	}
	 //update records
	   public function updatePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
	      $action = $_REQUEST["action"]; 
              $detail=$detail;
            
                  $photo = $_FILES['photo']['name'];
		$size = $_FILES['photo']['size'];
               // $id = siteDecrypt($_REQUEST["id"]);
                 $status =trim($status);
		$path = "uploads/ads/";
                  
		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPEG","JPG","PNG","GIF","BMP","webp","WEBP");
		if(strlen($photo))
		{
			list($txt, $ext) = explode(".", $photo);
			if(in_array($ext,$valid_formats))
			{
			if($size<(1024*1024))
				{
					 $actual_image_name =$photo; 
					 $tmp = $_FILES['photo']['tmp_name'];
                                  
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
						 $_SESSION['msg']='Image uploaded successfully';
					   }
					else
						echo $_SESSION['errormsg']="failed";
				}
				else
				echo $_SESSION['msg']="Image file size max 1 MB";					
				}
                         //else
				//echo $_SESSION['errormsg']="Invalid file format..";	
		}
		//print_r($_POST);
		  $title1 = ($_POST['title']);
	   $title = implode("}",$title);
  $value1 = ($_POST['value']);
  $valu = implode("}",$value1);
	  if($action=='add'){

		 $insert=$db->fireQuery("insert into ads(`photo`,`category`,`name`,`company`,`color`,`heading`,`valu`,`url`) values ('$photo','$category','$name','$company','$color','$title','$valu','$url')");
	 if($insert) 
	  {
		
			 $_SESSION['msg'] = "Record inserted successfully!";
                     header("location:$this->page");die();

	  }
	  }
	  if($action=='edit')
	  {
	                     if($photo!=''){
                           $update=(trim($db->fireQuery("update `ads` set `photo`='$photo',`category`='$category',`name`='$name',`company`='$company',`color`='$color',`heading`='$title',`valu`='$valu',`url`='$url'  where id=".siteDecrypt($_REQUEST['id'])."")));
		    }else{
                         $update=(trim($db->fireQuery("update `ads` set `photo`='$photo1',`category`='$category',`name`='$name',`company`='$company',`color`='$color',`heading`='$title',`valu`='$valu',`url`='$url'  where id=".siteDecrypt($_REQUEST['id'])."")));
		 	
                    } if($update) 
	  {
			 $_SESSION['msg'] = "Record Updated successfully!";
			header("location:$this->page");die();

	   } 
	  }

 }

 
    
}
?>   
     
     
     
     