<?php

 class activityLog {
	 
	  public $sessType;
	  public $duration;
	  public $page;
	  public function __construct( $type ){
		$this->page = basename($_SERVER['REQUEST_URI']);  
		$this->duration = SESSION_LOGOUT_DURATION *60*60;
		$this->sessType = $type;
		if( isset( $this->sessType ) && $this->sessType == SESSION_LOGOUT_ADMIN ){
           if( isset( $_SESSION['admin_last_active'] ) ) {
			   $timeGap = time() - $_SESSION['admin_last_active'];
			   if( $timeGap > $this->duration ){
				 unset($_SESSION["user_id"]);
                 unset($_SESSION["admin_type"]);
				 $_SESSION["login_error"] = "Your session has expired after ".SESSION_LOGOUT_DURATION." minutes of inactivity<br/><br/>Please <a style='color:lime' href='logout.php'>Login</a> again to continue !!";
				 if( $this->page != 'index.php'){
					 header("location:index.php");
				     die();
				 }
			   }
			   else{
				 $_SESSION['admin_last_active'] = time();  
			   }			   
		   }
		   else{
			 $_SESSION['admin_last_active'] = time();  
		   }		   
		}
		else if( isset( $this->sessType ) && $this->sessType == SESSION_LOGOUT_USER ){
			
           if( isset( $_SESSION['user_last_active'] ) ) {
			   $timeGap = time() - $_SESSION['user_last_active'];
			   if( $timeGap > $this->duration ){
				 unset($_SESSION["user_id"]);
                 //unset($_SESSION["admin_type"]);
				 $_SESSION["login_error"] = "Your session has expired after ".SESSION_LOGOUT_DURATION." of inactivity<br/><br/>Please login again to continue !!";
				 if( $this->page != 'index.php'){
					 header("location:index.php");
				     die();
				 }
			   }
			   else{
				 $_SESSION['user_last_active'] = time();  
			   }			   
		   }
		   else{
			 $_SESSION['user_last_active'] = time();  
		   }
		}
	  }	 
	  
 }
  
?>