<?php
include_once("inc/body.php");
include_once("admin/inc/checksession.inc.php");
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit' )
{
$rec_id=siteDecrypt($_REQUEST["id"]);
$sel_adm=$db->fetchAssoc($db->fireQuery("select * from `training` where id='$rec_id'"));
}
if(isset($_POST["update"])){
$temp = new Training();
$temp->updatePhoto( $_POST );
$temp->Resize($_POST);
}
?>
<div class="holder">
<?php include_once("inc/dash-header.php");?> 	
<div class="cboth"></div>
<div class="cantenar">			
<div class="cantent">
<h1>Training Management</h1>
<span class="footer-line"></span>
<div class="errordiv">
<?php
if ($_SESSION['msg']){echo '<div class="msg" style="cursor:pointer">'.$_SESSION['msg'].'</div>';$_SESSION['msg']='';unset($_SESSION['msg']);}
if ($_SESSION['errormsg']){echo '<div class="errormsg" style="cursor:pointer">'.$_SESSION['errormsg'].'</div>';$_SESSION['errormsg']='';unset($_SESSION['errormsg']);
}	
?>
</div>
 <?php include_once 'inc/left.php'; ?> 
          <div class="quick" style="width:700px;"><span style="margin-left: 10px;">Add/Edit Detail</span><a href="training-mgmt.php"  style="float:right; padding-right:10px;"><h3>View Details</h3></a></div>
            <div class="link-name-box menu_bar" style="width:700px;float:right;height:900px;">
                 <div class="box">
                  <form name="frm1" method="post" enctype="multipart/form-data">
                  <table width="100%" cellpadding="0" cellspacing="5">
                       <tr><td class="tdclass">Service : </td><td> <select name="service" class="textbox" id="service">
                                <option value="">---Select---</option>
                                <option value="Classroom program">Classroom program</option>
                                <option value="Online class">Online class</option>
                                <option value="E-learning">E-learning</option>
                            </select><script type="text/javascript">
					 				var f1 = new LiveValidation('service');
					 				f1.add(Validate.Presence);
		          					</script>
                 </td></tr>
 <tr><td class="tdclass">Training : </td><td> <select name="category" class="textbox" id="category">
                                <option value="">---Select---</option>
                                  <?php
                                  $sel_cat=$db->fetchAssoc($db->fireQuery("select * from training_name"));
                                  for($k=0 ; $k < count($sel_cat); $k++) {
                                  ?>
                                  <option value="<?php echo $sel_cat[$k]["training_name"];?>" <?=($sel_adm[0]['id']==$sel_cat[$k]["id"])?'selected=selected':'' ?><?php echo $sel_cat[$k]["training_name"]?></option>
                                  <?php } ?>
                            </select><script type="text/javascript">
					 				var f1 = new LiveValidation('training_name');
					 				f1.add(Validate.Presence);
		          					</script>
                 </td></tr>
                      <tr><td class="tdclass">Image : </td><td><input type="file" style="width:220px" value="<?php echo $sel_adm[0]["photo"];?>" name="photo" id="photo" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('photo');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                      <tr><td class="tdclass">place : </td><td><input type="text" style="width:220px" value="<?php echo $sel_adm[0]["place"];?>" name="place" id="place" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('place');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                        <tr><td class="tdclass">Date : </td><td><input type="text" style="width:220px" value="<?php echo $sel_adm[0]["date"];?>" name="date" id="date" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('place');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                         <tr><td class="tdclass">Begin At : </td><td><input type="text" style="width:220px" value="<?php echo $sel_adm[0]["begin"];?>" name="begin" id="begin" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('begin');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                     <tr><td class="tdclass">Ends At : </td><td><input type="text" style="width:220px" value="<?php echo $sel_adm[0]["end"];?>" name="end" id="end" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('end');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                     <tr><td class="tdclass">Price: </td><td><input type="text" style="width:220px" value="<?php echo $sel_adm[0]["price"];?>" name="price" id="price" class="textbox"/>
                      <script type="text/javascript">
			var f1 = new LiveValidation('price');
			f1.add(Validate.Presence);
		       </script>
                  </td></tr>
                       <tr><td class="tdclass"> Detail : </td><td><script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
                   <textarea name="detail" id="detail" class="{validate:{required:true,minlength:5}}"  style=" width:200px;"><?=$sel_adm[0]['detail']?></textarea>
                    <script type="text/javascript">
                    var editor = CKEDITOR.replace( 'detail',{resize_enabled : false,height:"291", width:"500"});
                    </script>
                  </td></tr>
                        	<td class="tdclass"></td>
                            <td>

                            </td>
                        </tr>
                        <?php if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'add' ){?>
                        <?php }else{?><?php }?>
                <tr><td></td><td><input type="submit" name="update" class="button" id="Save"  value="Submit"/></td></tr>
                  </table>  </form></div>
           <div class="cboth"></div>
</div>
 </div>
    <div class="cboth"></div>
</div>
<div class="cboth" style="height:120px"></div>

<?php include_once("inc/dash-footer.php");?>