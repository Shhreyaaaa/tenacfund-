function returnLangContent( txt ){
	langTxt = $.cookie("sitelang");
	var lang = getLangContent(langTxt);
	var arrayLang = new Array();
	
    $.each(lang, function(key, value) {
      arrayLang[key] = value
    });
	
	return (arrayLang[txt]);  
}

function changeLang( txt )
{     
	  $.cookie("sitelang","",{expires:-100});
      $.cookie("sitelang",txt);	 
	  window.location.href=window.location.href; 	
}

function handleError()
{ return true; }

window.onerror = handleError;

$(document).ready(function()
{

  $(".flag").live("click",function()																			
  {	        
	 changeLang( $(this).attr("rel") ); 
  });	
		
  $("#selectall").click(function()
  {	  
	status =  $("#selectall").attr("checked") ;
	if(!status){ status=false; }
    $(".checkBox").each( function() {
	$(this).attr("checked",status );
	})			
  });	
  
  $(".checkBox").click(function()
  {
	$("#selectall").attr("checked",false);
  });
  // Back Button
  $( ".back" ).click(function()
  { 
    history.go(-1);
  });
  //Monthly Report
  if($('#start_date').length) 
  {
	  $('#start_date').datepicker({changeMonth: true,changeYear: true});
  }
  if($('#end_date').length) {	
	$('#end_date').datepicker({
	changeMonth: true,
	changeYear: true
	});
  }
  
  if( $("#searchby_date").length )
  {
	 $('#searchby_date').click(function(event)
	 {
	  var frmData = $("#searchby_date_frm").serializeArray();	  
	  $.ajax({
		type : 'POST',
		data : frmData,
		url : 'monthly_report_ajax.php',
		success: function(data){ $("#show_monthly_report").html(data) },
		error: function(){alert("Ajax Error !!!")},
	 });
	  event.preventDefault();
   });
  }
  //**************//
  
  //Package Report
  if($('#start_date').length) {
	  $('#start_date').datepicker({
		changeMonth: true,
		changeYear: true
		});
  }
  if($('#end_date').length) {	
	$('#end_date').datepicker({
	changeMonth: true,
	changeYear: true
	});
  }
  
  if( $("#package_type").length ){
	 $('#package_type').change(function(){ 
	  var frmData = $("#searchby_date_frm").serializeArray();
	  $.ajax({type : 'POST',data : frmData,url : 'package_report_ajax.php',success: function(data){ $("#show_package_report").html(data) },
		error: function(){alert("Ajax Error !!!")},
	 });
   });
  }
  //****************//
  // view_page_block
  if( $("#searchByPage").length ){
	 $('#searchByPage').change(function(){
	  var frmData = $("#frm").serializeArray();
	  $.ajax({
		type : 'POST',
		data : frmData,
		url : 'view_page_block_ajax.php',
		success: function(data){$("#show_page_block").html(data) },
		error: function(){alert("Ajax Error !!!")},
	 });
   });
  }
  //**************//
  //Add Content
  if( $("#add_content").length ){
	 $('#add_content').click(function(){alert("first");
	  var frmData = $("#frm").serializeArray();
	  $.ajax({
		type : 'POST',
		data : frmData,
		url : 'add_page_content_ajax.php',
		success: function(data){alert(data);$("#show_add_form").html(data) },
		error: function(){alert("Ajax Error !!!")},
	 });
   });
  }
  /*****************************/
  /******* Logo Image Upload ********/
  $('#UploadLogoImage').live('click', function(){
	$("#frm").attr("action",'includes/action_logo_image.php'); 
	$("#previewLogoImage").html('');
	$("#previewLogoImage").html('<img src="images/loader.gif" alt="Uploading.."/>');
	$("#frm").ajaxSubmit({
	success: function(data) {								  									
	var content = data.split("||");
	if( content.length > 2 )
	{
	$('#org_logo').slideUp();
	$('#UploadLogoImage').slideUp();
	}
	$("#previewLogoImage").html('<span class="error">'+content[0]+'</span>');
	$("#logo_image").val(content[1]);		
	$("#frm").attr("action",'');
	},
	error: function(data) {
	$("#frm").attr("action",'');;	
	}
	});		
	});
			
  $(".remove_logo_image").live('click', function(event){	
    var conMsg = returnLangContent("confirmUploadFile");			
	var con = confirm(conMsg);
	if( con ){
	$("#logoImageDiv").html('');	
	$("#logoImageDiv").append('<input name="org_logo" type="file" id="org_logo" size="30" />&nbsp;<input type="button" name="UploadLogoImage" id="UploadLogoImage" value="Upload" /><div id="previewLogoImage"></div>');
	}
	event.preventDefault();
	});
  //**************//
  
  /******* Site Image Upload ********/
  $('#UploadSiteImage').live('click', function(){
	$("#frm").attr("action",'includes/action_site_image.php'); 
	$("#previewSiteImage").html('');
	$("#previewSiteImage").html('<img src="images/loader.gif" alt="Uploading.."/>');
	$("#frm").ajaxSubmit({
	success: function(data) {								  									
	var content = data.split("||");
	if( content.length > 2 )
	{
	$('#org_site').slideUp();
	$('#UploadSiteImage').slideUp();
	}
	$("#previewSiteImage").html('<span class="error">'+content[0]+'</span>');
	$("#site_image").val(content[1]);		
	$("#frm").attr("action",'');
	},
	error: function(data) {
	$("#frm").attr("action",'');;	
	}
	});		
	});
			
  $(".remove_site_image").live('click', function(event){
	var conMsg = returnLangContent("confirmUploadFile");		
	var con = confirm(conMsg);
	if( con ){
	$("#siteImageDiv").html('');	
	$("#siteImageDiv").append('<input name="org_site" type="file" id="org_site" size="30" />&nbsp;<input type="button" name="UploadSiteImage" id="UploadSiteImage" value="Upload" /><div id="previewSiteImage"></div>');
	}
	event.preventDefault();
	});
  //**************//
  
  //Export to PDF

	 $('#export_to_pdf').live("click",function(){
	  var frmData = $("#searchby_date_frm").serialize();
	  window.location.href = "convert_to_pdf.php?"+frmData;	  	 
   });

  //**************//
});


function validateDelete()
{
	var len = document.frm.elements.length;
	var i=0;j=0;
	for(i=0;i<len;i++)	
		if(document.frm.elements[i].type == 'checkbox' && document.frm.elements[i].checked == true)
	j++;
	if(j==0 && document.frm.checkAll.checked == true)
	{
		
		var atleastOneRecord = returnLangContent("atleasrDeleteOne");
		var delMsg = confirm(atleastOneRecord);
		//alert("Select atleast one to delete!");
		return false;	
	}
	else if(j>0)
	{
		var deleteRe = returnLangContent("deleteRecord");
		var deleteRec = confirm(deleteRe);
		return deleteRec;
	}
	else
	{
		var atleastOne = returnLangContent("atleasrDeleteOne");
		var delMsg = confirm(atleastOne);
		//alert("select atleast one to delete");
		return false;	
	}
}

function dialogText( txt ){
	$("#dialog").html( txt );
}

/******* Case-1 Image Upload ********/
  $('#UploadCase1_Image').live('click', function(){
	$("#frm").attr("action",'includes/action_case1_image.php'); 
	$("#previewCase1_Image").html('');
	$("#previewCase1_Image").html('<img src="images/loader.gif" alt="Uploading.."/>');
	$("#frm").ajaxSubmit({
	success: function(data) {								  									
	var content = data.split("||");
	if( content.length > 2 )
	{
	$('#org_case1').slideUp();
	$('#UploadCase1_Image').slideUp();
	}
	$("#previewCase1_Image").html('<span class="error">'+content[0]+'</span>');
	$("#case1_image").val(content[1]);		
	$("#frm").attr("action",'');
	},
	error: function(data) {
	$("#frm").attr("action",'');;	
	}
	});		
	});
			
  $(".remove_case1_image").live('click', function(event){
	  var con = returnLangContent("confirmUploadFile");	
	  var conMsg = confirm(con);			
	//var con = confirm("Are you sure you want to remove uploaded file");
	if( con ){
	$("#Case1_ImageDiv").html('');	
	$("#Case1_ImageDiv").append('<input name="org_case1" type="file" id="org_case1" size="30" />&nbsp;<input type="button" name="UploadCase1_Image" id="UploadCase1_Image" value="Upload" /><div id="previewCase1_Image"></div>');
	}
	event.preventDefault();
	});
//**************//

/******* Case-2 Image Upload ********/
  $('#UploadCase2_Image').live('click', function(){
	$("#frm").attr("action",'includes/action_case2_image.php'); 
	$("#previewCase2_Image").html('');
	$("#previewCase2_Image").html('<img src="images/loader.gif" alt="Uploading.."/>');
	$("#frm").ajaxSubmit({
	success: function(data) {								  									
	var content = data.split("||");
	if( content.length > 2 )
	{
	$('#org_case2').slideUp();
	$('#UploadCase2_Image').slideUp();
	}
	$("#previewCase2_Image").html('<span class="error">'+content[0]+'</span>');
	$("#case2_image").val(content[1]);		
	$("#frm").attr("action",'');
	},
	error: function(data) {
	$("#frm").attr("action",'');;	
	}
	});		
	});
			
  $(".remove_case2_image").live('click', function(event){
	  
	  var Msg = returnLangContent("confirmUploadFile");	
	  var conMsg = confirm(Msg);				
	//var con = confirm("Are you sure you want to remove uploaded file");
	if( con ){
	$("#Case2_ImageDiv").html('');	
	$("#Case2_ImageDiv").append('<input name="org_case2" type="file" id="org_case2" size="30" />&nbsp;<input type="button" name="UploadCase2_Image" id="UploadCase2_Image" value="Upload" /><div id="previewCase2_Image"></div>');
	}
	event.preventDefault();
	});
//**************//

/******* Case-3 Image Upload ********/
  $('#UploadCase3_Image').live('click', function(){
	$("#frm").attr("action",'includes/action_case3_image.php'); 
	$("#previewCase3_Image").html('');
	$("#previewCase3_Image").html('<img src="images/loader.gif" alt="Uploading.."/>');
	$("#frm").ajaxSubmit({
	success: function(data) {								  									
	var content = data.split("||");
	if( content.length > 2 )
	{
	$('#org_case3').slideUp();
	$('#UploadCase3_Image').slideUp();
	}
	$("#previewCase3_Image").html('<span class="error">'+content[0]+'</span>');
	$("#case3_image").val(content[1]);		
	$("#frm").attr("action",'');
	},
	error: function(data) {
	$("#frm").attr("action",'');;	
	}
	});		
	});
			
  $(".remove_case3_image").live('click', function(event){	
  
	  var msgCon = returnLangContent("confirmUploadFile");	
	  var con = confirm(msgCon);				
	//var con = confirm("Are you sure you want to remove uploaded file");
	if( con ){
	$("#Case3_ImageDiv").html('');	
	$("#Case3_ImageDiv").append('<input name="org_case3" type="file" id="org_case3" size="30" />&nbsp;<input type="button" name="UploadCase3_Image" id="UploadCase3_Image" value="Upload" /><div id="previewCase3_Image"></div>');
	}
	event.preventDefault();
	});

//**ashish******//

$("#showit").click(function () {
	$(".login-box-1").show("slow");
 });
 


$(document).ready(function(){
  $(".msg").click(function(){
		$(this).hide(600);
		});

	$(".infomsg").click(function(){
	$(this).hide(600);
	});

	$(".errormsg").click(function(){
	$(this).hide(600);
	});
});

//NEWS LETTER
	$(function() {
		$( "#delivery_date" ).datepicker();
	});
	
$("#subscriber").live('change',function(){
	var email = $(this).val();
	if(email == '-1')
	{
		alert('Please Select Receiver');
		return false;
	}else
	{
		$("#sendto").val(email);
	}
});
//

  
 //js for image upload//
$(document).ready(function(){
	$("#logout").click(function(event){
	  var logout = confirm("Are you sure you want to logout ?");
	  if( logout ) 
	   window.location.href='logout.php'	
	   event.preventDefault();
  });
 });
	