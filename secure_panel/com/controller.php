<?php
 ob_start();
 session_start();
 //ini_set("display_errors","Off");
 //set_magic_quotes_runtime(0);
 # Content Headers #
 header("Content-Type: text/html; charset=UTF-8");
 header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
 header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
 ##################
include_once("settings.php");
//error_reporting( PHP_DISPLAY_ERROR );

 define('APPLICATION_PATH' , realpath('../'));
 $paths = array(APPLICATION_PATH ,get_include_path());
 set_include_path(implode(PATH_SEPARATOR, $paths));
 implode(PATH_SEPARATOR, $paths);
 set_include_path(implode(PATH_SEPARATOR, $paths));
 
 if( !isset($_COOKIE["sitelang"]) ){
	 setcookie("sitelang",'english');
	 header("location:index.php");
 }
function __autoload($className) 
{
	$fileName = str_replace('\\', '/', $className) . '.php'; 				
	require_once ( "com"."/".$fileName );
}	
include_once("functions.php");	
$siteContent = new siteLanguage($_COOKIE["sitelang"]);
$cont = json_encode($siteContent->content);
$siteContent = json_decode($cont);
?>