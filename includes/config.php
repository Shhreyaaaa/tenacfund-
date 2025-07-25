<?php ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define("LINK","http://localhost/my_project/secure_panel/");

include_once(__DIR__ . "/../secure_panel/com/sqlConnection.php");

$db=new sqlConnection();
?>