<?php include_once("com/sqlConnection.php");
$db=new sqlConnection();
 $_SESSION['admin-type'];

 ?>
<DIV class="product-item float-clear" style="clear:both;margin-bottom:3%;">

<DIV class="float-left" style="width:43%;margin-right: 0.2%;float:left;display:inline-block"><input type="text" placeholder="Title" name="title[]" value="" id="input1<?php echo $if;?>" class="form-control ng-invalid ng-valid-email ng-invalid-required ng-touched" /></DIV>
<DIV class="float-left" style="width:43%;margin-right: 0.2%;float:left;display:inline-block"><input type="text" placeholder="Data" name="value[]" value="" class="form-control ng-invalid ng-valid-email ng-invalid-required ng-touched" /></DIV>


<DIV class="float-left" style="width:10%;margin-right: 0.2%;float:left;display:inline-block">
<input type="checkbox" name="check" value="" style="float:left;"/></DIV>
</DIV>

    