<?php
include_once("inc/header.php");
include_once("com/Blog.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit' )
{
$rec_id=siteDecrypt($_REQUEST["id"]);
$sel_adm=$db->fetchAssoc($db->fireQuery("select * from `blog` where id='$rec_id'"));
}
if(isset($_POST["update"])){
$temp = new Blog();
$temp->updatePhoto( $_POST );
$temp->Resize($_POST);
}
?>

               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Blog Management
                        </div>
                             <div class="errordiv">
<?php
if ($_SESSION['msg']){echo '<div class="msg" style="cursor:pointer">'.$_SESSION['msg'].'</div>';$_SESSION['msg']='';unset($_SESSION['msg']);}
if ($_SESSION['errormsg']){echo '<div class="errormsg" style="cursor:pointer">'.$_SESSION['errormsg'].'</div>';$_SESSION['errormsg']='';unset($_SESSION['errormsg']);
}	
?>
</div>
         <script type="text/javascript">
$(document).ready(function()
{//alert();
$("#category").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#subcategory").html(html);
}
});

});
});
</script>              
                        <div class="panel-body">
                            <div class="row">
                                    
                                    <form  form name="frm1" method="post" enctype="multipart/form-data">
                                 
										
                                     <div class="form-group">
                                            <label>Photo</label>
                                            <input class="form-control" type="file" name="photo" value="<?php echo $sel_adm[0]['photo']?>" />
                                            <input class="form-control" type="hidden" name="photo1" value="<?php echo $sel_adm[0]['photo']?>" />
                                        </div>
                                        
                                      <div class="form-group">
                                            <label>Heading</label>
                               <input class="form-control" type="text" name="heading" value="<?php echo $sel_adm[0]['heading']?>"  required=""/>
                                        </div>
						        <div class="form-group">
                                            <label>Written By</label>
                               <input class="form-control" type="text" name="writtenby" value="<?php echo $sel_adm[0]['writtenby']?>"  required=""/>
                                        </div>	
     <div class="form-group">
                                            <label>Date</label>
                               <input class="form-control" type="date" name="date" value="<?php echo $sel_adm[0]['date']?>"  required=""/>
                                        </div>	
										
  <div class="form-group">
                                            <label>Detail</label>
                                            <script type="text/javascript" src="../ckeditor1/ckeditor.js"></script>
                   <textarea name="detail" id="detail" class="{validate:{required:true,minlength:5}}"  style=" width:200px;"><?php echo $sel_adm[0]['detail']?></textarea>
                    <script type="text/javascript">
                    var editor = CKEDITOR.replace( 'detail',{resize_enabled : false,height:"291", width:"500"});
                    </script>
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
