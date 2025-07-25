 <?php

  class Admin extends sqlConnection{	  	  
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
	 	$qry = $db->fireQuery("update `admin` set `status`='Active' where id = '$rec_id'");
		$qr="update `admin` set `status`=Active where id = $rec_id";
		//echo "insert into logs(`user_id`,`action_type`,`action_performed`,`date`) values ('".$_SESSION['user_id']."','StatusChanged','".$qr."',NOW())";
		$insert=$db->fireQuery("insert into logs(`user_id`,`action_type`,`action_performed`,`date`) values ('".$_SESSION['user_id']."','StatusChanged','".(string)$qr."',NOW())");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) Status Changed successfully!";
            header("location:user-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:user-mgmt.php");die();
		}
	  }

//Deactivate
    
public function checkDeactivate( $qry ){
	   $db = $this->database;
		  extract( $qry );
		  $rec_id=$_REQUEST['id'];	
	 	$qry = $db->fireQuery("update `admin` set `status`='Inactive' where id = '$rec_id'");
		$qr="update `admin` set `status`=Inactive where id = $rec_id";
		$insert=$db->fireQuery("insert into logs (`user_id`,`action_type`,`action_performed`,`date`) values ('".$_SESSION['user_id']."','StatusChanged','".$qr."',NOW())");
		
		if($qry)
		{
			$_SESSION['msg'] = "Record(s) StatusChanged successfully!";
           header("location:user-mgmt.php");die();
		}
		else
		{
		$_SESSION['errormsg'] = "Record(s) Not Status Changed successfully!";
         header("location:user-mgmt.php");die();
		}
	  }
	  
	  
		public function deleteAdmin() {
		$db = $this->database;
		$rec_id = siteDecrypt($_REQUEST['id']);

		if ($_SESSION['user_id'] != $rec_id) {
			$qry = $db->fireQuery("DELETE FROM `admin` WHERE id = '$rec_id'");
			if ($qry) {
				$_SESSION['msg'] = "Record(s) deleted successfully!";
			} else {
				$_SESSION['errormsg'] = "Record(s) could not be deleted!";
			}
			header("location:admin-mgmt.php"); // 
			die();
		} else {
			$_SESSION['errormsg'] = "You cannot delete your own login!";
			header("location:admin-mgmt.php"); // 
			die();
		}
	}


	   
	   //update password
	   
	   
	    public function changePassword( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $_SESSION["user_id"];
		  $oldpass=(trim($old_password));
		  $newpass=(trim($new_password));
		  $selpass=$db->fetchAssoc($db->fireQuery("select `password` from `admin` where id=".$_SESSION["user_id"].""));
		  if($selpass[0]["password"]==$oldpass){
     		  $updateqry = $db->fireQuery("update `admin` set `password`='$newpass' where id =".$_SESSION["user_id"]."");	  }
	 	
		if($updateqry)
		{
		  $_SESSION['msg'] = "Record(s) updated successfully!";
                  header("location:$this->page");die(); 
		}else
		{
	          $_SESSION['errormsg'] = "Record(s) Not updated successfully!";
                  header("location:$this->page");die(); 
		
		}
		 
		
	  }
	   //
	   //forgot password
	   
	     
	   /* public function forgotPassword( $qry ){
		$db = $this->database;
		extract( $qry );
		$email=trim($email);
		$get_rec=$db->fetchAssoc($db->fireQuery("select * from ".TBL_ADMIN." where email='$email'"));
		$count_rec = count($get_rec); 
		if($count_rec > 0)
		{
					$mail_user = $get_rec[0]['username']; 
					$mail_pass = base64_decode($get_rec[0]['password']); 
					$to      =  $email;
					$subject = 'Your Login Details';
					$message = 'Hello '.$get_rec[0]['username'].'';
					$message.= 'Your Password is '.$mail_pass;
					$headers = 'From: MyApp' . "\r\n" .
					'Reply-To: test@example.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
			
					$mail = @mail($to, $subject, $message, $headers); 
		
		if(count($mail) > 0 )
		{
			
			$_SESSION['msg'] = "Check Your Mail To Get Password !";
            header("location:$this->page");die(); 
		}
		
		
		}
		else
		{
			$_SESSION['errormsg'] = "Mail Not Sent Successfully!";
            header("location:$this->page");die(); 
		
		}
		
		}
		*/ 
		
		
	   //
	   public function forgotPassword( $frmElements ){
		 if( isset( $frmElements ) ){
		   extract( $frmElements );
		  $db = $this->database;
		  $email = trim($email);	
	      $sel_query=$db->fetchAssoc($db->fireQuery("SELECT * FROM `admin` WHERE `email` =\"$email\""));
		  $email = $sel_query[0]["email"];
		  $pass  = ($sel_query[0]['password']);
		  $fullname = $sel_query[0]['username'];
		  $arr1 = array("%name%","%pass%","%email%");
		  $arr2 = array($fullname,$pass,$email) ;
		  $sq2  = $db->fetchAssoc($db->fireQuery("SELECT * FROM `tbl_cms_users` WHERE `title` = 'RetrievePassword'"));
		  $mailformat = str_replace($arr1,$arr2,$sq2[0]['mailformat']);
		  $subject=str_replace($arr1,$arr2,$sq2[0]['subject']);
		  $headers = "MIME-Version: 1.0\r\n";
		  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		  $mailSender = @mail($email,$subject,$mailformat,$headers);
		 if( $mailSender )
		 {
		 $_SESSION['msg'] = "Check Your Mail To Get Password !";
                  header("location:$this->page");die(); 
		 }
		 else
		 {
		  $_SESSION['errormsg'] = "Your email id is not found !";
		  header("location:$this->page");die(); 
		 }
	 }
	 	 }
   
	   
	    # delete record	  
	  public function deleteRecord( $qry ){
		print_r($qry);  $db = $this->database;
		  extract( $qry );		  
	  foreach( $checkAll as $id )
	   {
		   if($_SESSION['user_id']!=$id){
		   $qry = $db->fireQuery("delete from `admin` where id = '$id'");
		   }
		
		if($qry && $_SESSION['user_id']!=$id)
		{
			$_SESSION['msg'] = "Record(s) deleted successfully!";
			header("location:$this->page");die();
		}
		else
		{
			//$_SESSION['msg'] = "Error in deleting record(s)!";
		}
	   } header("location:$this->page");die();
     }
	 
	 
	 //update records
	 
	  public function updateAdmin( $qry ){
		  $db = $this->database;
		  extract( $qry );
		  $action = $_REQUEST["action"];
		  $type = trim($user_type); 
		  $username = trim($username);
		  $email = trim($email);
		  $password = trim($password);
		  $status = trim($status);

		  if($action == 'add'){
			$insert = $db->fireQuery("INSERT INTO `admin` (`username`,`password`,`email`,`admin_type`,`status`,`category`) VALUES ('$username','$password','$email','$admin_type','$status','$category')");
			if($insert) {
				$_SESSION['msg'] = "Record inserted successfully!";
				header("location:admin-mgmt.php"); die(); 
			}
			}

			if($action == 'edit'){
			$update = $db->fireQuery("UPDATE `admin` SET `username`='$username', `password`='$password', `email`='$email', `admin_type`='$admin_type', `status`='$status', `category`='$category' WHERE id=".siteDecrypt($_REQUEST['id'])."");
			if($update) {
				$_SESSION['msg'] = "Record Updated successfully!";
				header("location:admin-mgmt.php"); die(); 
			}
			}



     }

	 // In Admin.php


	//  NEW METHOD for Callers
	public function updateCaller($qry) {
		$db = $this->database;
		extract($qry);

		$action = $_REQUEST["action"];

		$name = trim($name);
		$email = trim($email);
		$phone = trim($phone); 
		$message = trim($message); 
		$status = trim($status);

		if ($action == 'add') {
			$insert = $db->fireQuery("INSERT INTO `caller` (`name`, `email`, `phone`, `message`, `status`) VALUES ('$name', '$email', '$phone', '$message', '$status')");
			if ($insert) {
				$_SESSION['msg'] = "Caller added successfully!";
				header("location:caller-mgmt.php"); die();
			}
		}

		if ($action == 'edit') {
			$rec_id = siteDecrypt($_REQUEST['id']);
			$update = $db->fireQuery("UPDATE `caller` SET `name`='$name', `email`='$email', `phone`='$phone', `message`='$message', `status`='$status' WHERE id='$rec_id'");
			if ($update) {
				$_SESSION['msg'] = "Caller updated successfully!";
				header("location:caller-mgmt.php"); die();
			}
		}
	}

		public function deleteCaller() {
		$db = $this->database;
		$rec_id = siteDecrypt($_REQUEST['id']);
		$qry = $db->fireQuery("DELETE FROM `caller` WHERE id = '$rec_id'");
		if ($qry) {
			$_SESSION['msg'] = "Caller deleted successfully!";
		}
		header("location:caller-mgmt.php");
		die();
	}

  }
?>