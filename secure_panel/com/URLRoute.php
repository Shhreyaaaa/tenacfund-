<?php
  class URLRoute{
	  public $params;
	  public $model;
	  public function __construct(){		  
		  $uri = $_SERVER['REQUEST_URI'];
		  $uriParams = explode("/",$uri);
		  $params =  $uriParams ;
		  $server = $_SERVER['SERVER_NAME'];
		  if( $server == 'localhost' || $server == '127.0.0.1' ) {
			 $this->model = $params[3]; 
			 $count = count($params);
			 for( $i = 4; $i< $count; $i++ ){
				  if( !empty($params[$i]) ) { 
					 $this->params[] = strtolower($params[$i]); 
				  }
		      }			  
		  }
		  else {
			  $this->model = $params[1];
			  foreach( $params as $key => $value ){
				  if( $key >1 && !empty($value) ) { 
					 $this->params[] = strtolower($value); 
				  }
		      }	
		  }
	  }
  }
?>