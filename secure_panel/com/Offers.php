<?php 
  class Offers extends sqlConnection{
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
	 	$qry = $db->fireQuery("update `offers` set `status`='Active' where id = '$rec_id'");
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:offers-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:offers-mgmt.php");die();
		}
	  }

//Deactivate
    
public function checkDeactivate( $qry ){
	   $db = $this->database;
		  extract( $qry );
		  $rec_id=$_REQUEST['id'];	
	 	$qry = $db->fireQuery("update `offers` set `status`='Inactive' where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
           header("location:offers-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:offers-mgmt.php");die();
		}
	  }
	  
	   
	   //delete rowwise
	   
	   public function deletePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $rec_id=siteDecrypt($_REQUEST['id']);		
	 	$qry = $db->fireQuery("delete from `offers` where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) deleted successfully!";
            header("location:offers-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not deleted successfully!";
         header("location:offers-mgmt.php");die();
		}
		 
		
	  }
	  
	  	
	  # delete record	  
	  public function deleteRecord( $qry ){
		  $db = $this->database;
		  extract( $qry );		  
	  foreach( $checkAll as $id )
	   {
		$qry = $db->fireQuery("delete from `offers` where id = '$id'");
		
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
	


	  public function AssignRecord( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $rec_id=siteDecrypt($_REQUEST['id']);		
		  $userid=$_REQUEST['userid'];		echo "insert into assign_offer (`offerid`,`userid`,`date`) values ('$rec_id','$userid',NOW())";
	 	$insert=$db->fireQuery("insert into assign_offer (`offerid`,`userid`,`date`) values ('$rec_id','$userid',NOW())");
		die;
		if($insert)
		{
			$_SESSION['msg'] = "Record(s) assigned successfully!";
            header("location:offers.php?action=view&&id=".$_REQUEST['id']);die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not assigned successfully!";
         header("location:offers.php?action=view&&id=".$_REQUEST['id']);die();
		}
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
		$path = "uploads/offers/";
                  
		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPEG","JPG","PNG","GIF","BMP");
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
	  if($action=='add'){//echo "insert into product(`photo`,`name`,`url`,`category`,`subcategory`) values ('$photo','$name','$url','$category','$subcategory')";
		 $insert=$db->fireQuery("insert into offers(`photo`,`name`,`url`,`status`,`offertype`) values ('$photo','$name','$url','Active','$offertype')");
	 if($insert) 
	  {
		
			 $_SESSION['msg'] = "Record inserted successfully!";
                     header("location:$this->page");die();

	  }
	  }
	  if($action=='edit')
	  {
	                     if($photo!=''){
                           $update=(trim($db->fireQuery("update `offers` set `photo`='$photo',`name`='$name',`url`='$url',`status`='Active',`offertype`='$offertype' where id=".siteDecrypt($_REQUEST['id'])."")));
		    }else{
                         $update=(trim($db->fireQuery("update `offers` set `photo`='$photo1',`name`='$name',`url`='$url',`status`='$status',`offertype`='$offertype'  where id=".siteDecrypt($_REQUEST['id'])."")));
		 	
                    } if($update) 
	  {
			 $_SESSION['msg'] = "Record Updated successfully!";
			header("location:$this->page");die();

	   } 
	  }

 }

 
    
}
?>   
     
     
     
     