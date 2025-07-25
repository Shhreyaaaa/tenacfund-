<?php ob_start();
session_start();
include_once 'com/sqlConnection.php';
 $db=new sqlConnection();
if($_POST['id'])
{
 $id=$_POST['id'];
$sel_am=$db->fetchAssoc($db->fireQuery("select * from subcategory  where `category`='".$id."' order by id asc"));

  echo '<option value="">Sub category</option>';
 for($i=0 ; $i < count($sel_am); $i++) {
echo '<option value="'.$sel_am[$i]['id'].'">'.$sel_am[$i]['subcategory'].'</option>';
}

}
?>