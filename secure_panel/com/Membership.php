<?php 
  class Membership extends sqlConnection{
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
	 	$qry = $db->fireQuery("update `membership` set `status`='Active' where id = '$rec_id'");
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:membership-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:membership-mgmt.php");die();
		}
	  }

//Deactivate
    
public function checkDeactivate( $qry ){
	   $db = $this->database;
		  extract( $qry );
		  $rec_id=$_REQUEST['id'];	
	 	$qry = $db->fireQuery("update `membership` set `status`='Inactive' where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
           header("location:membership-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:membership-mgmt.php");die();
		}
	  }
	  
	   
	   //delete rowwise
	   
	   public function deletePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $rec_id=siteDecrypt($_REQUEST['id']);		
	 	$qry = $db->fireQuery("delete from `membership` where id = '$rec_id'");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) deleted successfully!";
            header("location:membership-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not deleted successfully!";
         header("location:membership-mgmt.php");die();
		}
		 
		
	  }
	  
	  	
	  # delete record	  
	  public function deleteRecord( $qry ){
		  $db = $this->database;
		  extract( $qry );		  
	  foreach( $checkAll as $id )
	   {
		$qry = $db->fireQuery("delete from `membership` where id = '$id'");
		
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
	 
 
	 # delete record	  
	  public function updatePhoto( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  echo $action = $_REQUEST["action"];
		$detail=$detail;
		  if($action=='add'){
$insert=$db->fireQuery("insert into membership(`name`,`amount`,`detail`,`discount`,`actualprice`) values ('$name','$amount','$detail','$discount','$actualprice')");
		// $last_id = mysql_insert_id();
		  if($insert) 
		  {
				 $_SESSION['msg'] = "Record inserted successfully!";
				 header("location:$this->page");die();

		  }
                 
		  }
                
		  if($action=='edit'){
		  $update=$db->fireQuery("update `membership` set `name`='$name',`amount`='$amount',`detail`='$detail',`discount`='$discount',`actualprice`='$actualprice' where id=".siteDecrypt($_REQUEST['id'])."");
    	  if($update) 
		  {
				 $_SESSION['msg'] = "Record Updated successfully!";
				 header("location:$this->page");die();

		   } 
		  }

     }
	 
	 public function getuserDetails(){
		 $qry = "SELECT * FROM `contact` ";
		 return $qry;
	 }
	 
	 
  }
?>
     