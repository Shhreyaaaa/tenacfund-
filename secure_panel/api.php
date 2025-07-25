<?php header("Content-Type:application/json");
include_once("com/sqlConnection.php");
$db=new sqlConnection();
//print_r($db);

if (isset($_GET['action']) && $_GET['action']=="test") {
    $msg->message="Coaching Found";
	$msg->status="1";
    echo json_encode($msg);
}
?>