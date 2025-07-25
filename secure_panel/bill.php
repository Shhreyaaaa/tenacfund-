<?php
include_once("inc/header.php");
include_once("com/User.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'view' )
{
	$rec_id=$_REQUEST['id'];
$sel_adm=$db->fetchAssoc($db->fireQuery("select b.*,m.name as pname from booking as b join membership as m on b.serviceid=m.id where b.id='".$rec_id."' order by b.id desc"));
}
if(isset($_POST["update"])){
$temp = new User();
$temp->updatePhoto( $_POST );
$temp->Resize($_POST);
}
?>

               <div class="row">
                <div class="col-md-12">
                   <script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}</script>
<script>
function goBack() {
    window.history.back();
}
</script>
<input type="button" onclick="printDiv('challan1')" value="print a div!" /><button onclick="goBack()">Go Back</button>
<br/>

<div style="border: 1px solid;padding: 1px;" id="challan1">
    <div style="width:98%;margin: 0px auto;border:1px solid #00539F;font-family: arial;text-align: center;background: #fff;color: #055a7f;font-size:13px;" id="challan">
<div style="width:98%;min-height:100px;margin: 0px auto;">      
	  <div style="width: 36%;border:0px solid;padding:10px;float:left;text-align: left;">
		<a href="">
		<img src="https://www.spectrumprime.in/images/Spectrum_Partner_Logo.png" style="width:30%;display:inline-block;"/>
		</a>
		</div>
		<div style="width: 8%;border:0px solid;padding:10px;float:left;text-align: center;">
		<div style="width:100%;color:#00539F;font-size:20px;text-align: center;border: 0px solid #00539F;"><b>Invoice</b></div>
		</div>
		<div style="width: 47%;border:0px solid;padding:10px;float:left;text-align: right;">
Reg. Off.:- C-91/10, 1st floor,<br/> Wazirpur Industrial Area, <br/>Ring Road Delhi-110052, India
 <b>CIN: U65929dl2020ptc361677</b><br/>
		</div>
     </div>
    <div style="width:98%;min-height:120px;margin: 0px auto;">
    <div style="width: 47%;border-right:1px solid;padding:10px;float:left;text-align: left;">
 <h4 style="padding: 0px ;">Bill To</h4>
   <?php  $cilt=$sel_adm[0]['userid'];
 $sel_adm1=$db->fetchAssoc($db->fireQuery("select * from `user` where id='".$cilt."'"));
  ?><?php echo $sel_adm1[0]['name'];?><br/><?php echo $sel_adm1[0]['address'];?><br/>
 <br/>  

    </div>
    <div style="width: 47%;border:0px solid;padding:8px;float:left;text-align: left;"><br/>
	Invoice No:-SPECT-<?php echo $sel_adm[0]['date']?>-<?php echo $sel_adm[0]['id']?><br/>
        Date:<?php echo $sel_adm[0]['date']?><br/>
              
    </div>
    </div>

    <style>
#customers {
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
  border: 1px solid #055a7f;
    padding: 8px;
}
#customers tr:nth-child(even){background-color: #fff;}
#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #055a7f;
    color: white;
}
</style>
     <div style="width:100%;border:1px solid #00539F;font-size:20px;text-align: left;padding:0;"></div>
 <table id="customers" style="border:1px solid #055a7f">
            <tr >
            <th scope="col">S no.</th>
                <th scope="col">Plan Name</th>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Tax</th>
                <th scope="col">Total</th>
                
            </tr>
 
             <tr>
      <td><?php echo 1;?></td>
                <td><?php echo $sel_adm[0]['pname'];?></td>
                <td><?php echo $sel_adm[0]['date'];?></td>
                <td>₹ <?php echo $sel_adm[0]['amount'];?></td>
                <td>₹ <?php echo $sel_adm[0]['tax'];?></td>
                <td>₹ <?php echo $no=($sel_adm[0]['amount']+$sel_adm[0]['tax']);?></td>
                
                
            </tr>

      </table>
 <div style="width:98%;line-height: 1.7em;margin: 0px auto;border: 1px solid;text-align: left;padding-left: 2%;">
            <div style="width:58%;display: inline-block;border-right:0px solid;">
        <p style="margin-top: -30px;"> Number in words:-
<?php 

	function convert_digit_to_words($no)  
	{   

	 $words = array('0'=> 'Zero' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
 
	$cash=(int)$no;  //take number wihout decimal
	$decpart = $no - $cash; //get decimal part of number
	
	$decpart=sprintf("%01.2f",$decpart); //take only two digit after decimal
	
	$decpart1=substr($decpart,2,1); //take first digit after decimal
	$decpart2=substr($decpart,3,1);   //take second digit after decimal  
	
	$decimalstr='';
	
	//if given no. is decimal than  preparing string for decimal digit's word
	
	if($decpart>0)
	{
	 $decimalstr.=" ".$numbers[$decpart1]." ".$numbers[$decpart2];
	}
	 
	    if($no == 0)
	        return ' ';
	    else {
	    $novalue='';
	    $highno=$no;
	    $remainno=0;
	    $value=100;
	    $value1=1000;       
	            while($no>=100)    {
	                if(($value <= $no) &&($no  < $value1))    {
	                $novalue=$words["$value"];
	                $highno = (int)($no/$value);
	                $remainno = $no % $value;
	                break;
	                }
	                $value= $value1;
	                $value1 = $value * 100;
	            }       
	          if(array_key_exists("$highno",$words))  //check if $high value is in $words array
	              return $words["$highno"]." ".$novalue." ".convert_digit_to_words($remainno).$decimalstr;  //recursion
	          else {
	             $unit=$highno%10;
	             $ten =(int)($highno/10)*10;
	             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".convert_digit_to_words($remainno
	             ).$decimalstr; //recursion
	           }
	    }
	}
	?>

	<?php
        echo convert_digit_to_words($no);
?></p><br/> 
</div>
            <div style="width:41%;display: inline-block;border-left: 1px solid;">
                <div style="width:100%;border-bottom: 1px solid;">
                    <div style="width:49%;display: inline-block;">Sub Total:</div>  
                     <div style="width:49%;display: inline-block;">₹ <?php echo ($sel_adm[0]['amount']);?></div> 
                 <div style="width:49%;display: inline-block;">Tax:</div>  
                     <div style="width:49%;display: inline-block;">₹ <?php echo ($sel_adm[0]['tax']);?></div> 
                       <div style="width:49%;display: inline-block;">Total After Tax:</div>  
                     <div style="width:49%;display: inline-block;">₹ <?php echo ($sel_adm[0]['amount']+$sel_adm[0]['tax']);?></div> 
                </div>
           
            </div>
             
           
        </div>
           <div style="width:98%;line-height: 1.7em;margin: 0px auto;border: 1px solid;text-align: left;padding-left: 2%;">
            <div style="width:56%;display: inline-block;border-right: 0px solid;">For Spectrum Prime Pvt. Ltd.<br/>
            Auth. Signature<br/><img src="images/vai-sig1.jpg" style="height:90px;"/>
           </div>
            <div style="width:40%;display: inline-block;"></div>
        </div>
 
    </div>
</div>
  
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
    <script>
	$(document).ready(function(){
		$("#showbtn").click(function(){
		$(".showpass").hide();	
		$(".hidepass").show();	
		})
			$("#hidebtn").click(function(){
		$(".showpass").show();	
		$(".hidepass").hide();	
		})
	})
	</script>
   
</body>
</html>
