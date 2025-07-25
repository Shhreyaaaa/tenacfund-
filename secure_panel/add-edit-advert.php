<?php
include_once("inc/header.php");
include_once("com/Advert.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit' )
{
$rec_id=siteDecrypt($_REQUEST["id"]);
$sel_adm=$db->fetchAssoc($db->fireQuery("select * from `advert` where id='$rec_id'"));
}
if(isset($_POST["update"])){
$temp = new Advert();
$temp->updatePhoto( $_POST );
$temp->Resize($_POST);
}
?>

               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Advertisment Management
                        </div>
                             <div class="errordiv">
<?php
if ($_SESSION['msg']){echo '<div class="msg" style="cursor:pointer">'.$_SESSION['msg'].'</div>';$_SESSION['msg']='';unset($_SESSION['msg']);}
if ($_SESSION['errormsg']){echo '<div class="errormsg" style="cursor:pointer">'.$_SESSION['errormsg'].'</div>';$_SESSION['errormsg']='';unset($_SESSION['errormsg']);
}	
?>
</div>
 
<SCRIPT>
function addMore() {
	$("<DIV>").load("input.php", function() {
			$("#product").append($(this).html());
	});	
}
function deleteRow() {
	$('DIV.product-item').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</SCRIPT>          
                        <div class="panel-body">
                            <div class="row">
                                    
                                    <form  form name="frm1" method="post" enctype="multipart/form-data">
                                      <div class="form-group">
                                            <label>Select Category</label>
                                            <select class="form-control" name="category" id="category">
                                                <option value="">Select option</option>
											<?php $sel=$db->fetchAssoc($db->fireQuery("select * from category"));
											for($i=0;$i<count($sel);$i++){
											?>	
                                                <option value="<?php echo $sel[$i]['id'];?>" <?php if($sel_adm[0]['category']==$sel[$i]['id']){echo "selected";}?>><?php echo $sel[$i]['category'];?></option>
                                           <?php } ?>
										   </select>
                                        </div>
									
                                     <div class="form-group">
                                            <label>Photo</label>
                                            <input class="form-control" type="file" name="photo" value="<?php echo $sel_adm[0]['photo']?>" />
                                            <input class="form-control" type="hidden" name="photo1" value="<?php echo $sel_adm[0]['photo']?>" />
                                        </div>
                    
                                        </div>
   <div class="form-group">
                                            <label>URL</label>
                               <input class="form-control" type="text" name="url" value="<?php echo $sel_adm[0]['url']?>"  required=""/>
                                        </div>	
  
                                       
                                           <?php if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'add' ){?>

                        <?php }else{?><?php }?>
						<input type="submit" name="update" class="btn btn-primary" id="Save"  value="Submit"/>
                                        
                                        <button type="reset" class="btn btn-primary">Reset Button</button>

                                    </form>
                                   
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
