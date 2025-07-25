<?php
include_once 'com/sqlConnection.php';
$db=new sqlConnection();
if($_POST['status'])
{ 
$status=$_POST['status'];
$remark=$_POST['remark'];
$id=$_POST['cid'];
$userid=$_POST['userid'];
$update=$db->fireQuery("update `clicks` set `status`='".$status."',`remark`='".$remark."',`userid`='".$userid."',`updatedate`=NOW() where `id`='".$id."'");
	echo "profile updated";									

}
?>