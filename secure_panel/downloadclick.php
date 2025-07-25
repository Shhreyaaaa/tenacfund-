<?php ob_start();
session_start();
include_once 'com/sqlConnection.php';
$db=new sqlConnection();
	$filename = "phpzag_data_export_".date('Ymd') . ".xls";			
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");	
	$show_coloumn = false;
	$select = $db->fetchAssoc($db->fireQuery("select s.name as servicename,u.name as username,c.date,c.status,c.remark,c.updatedate from `clicks` as c 
	join product as s on c.service_id=s.id 
	join user as u on c.user_id=u.id 
	order by c.id desc"));
	if(!empty($select)) {
	  foreach($select as $record) {//print_r($record);
		if(!$show_coloumn) {
		  // display field/column names in first row
		  echo implode("\t", array_keys($record)) . "\n";
		  $show_coloumn = true;
		}
		echo implode("\t", array_values($record)) . "\n";
	  }
	}
	exit;  
?>