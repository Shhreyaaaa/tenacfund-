<?php 
  define( "PHP_DISPLAY_ERROR",NULL ); /* value NULL default, 0 to hide errors */
  # Server Constants
  $server = $_SERVER["HTTP_HOST"];
  # SERVER DATABASE CONSTANTS 
 
  
  define("MODELS_ROOT","Models");
  define("VIEWS_ROOT","Views");
  #DB Table Constants
  
  #other constants
  define('rows_per_page',10);
  define("links_per_page", 5 );
  # Sesion logout duration
  define("SESSION_LOGOUT_DURATION","10");
  define("SESSION_LOGOUT_ADMIN","admin");
  define("SESSION_LOGOUT_USER","user");
  # SITE SETTINGS    
  #define Website Title
  define("IMAGE_ROOT","cropped/");
  define("DOC_ROOT","manager/files/");
  define("WEBSITE_TITLE","e-shop");
  define("THUMB_WIDTH",100);
  define("THUMB_HEIGHT",100);
  //print_r($_SESSION["admin_type"]);
?>