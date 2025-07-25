<?php include_once 'includes/header.php';?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Sign In/Sign Up</li>
        </ol>
        <h2>Sign In/Sign Up</h2>

      </div>
    </section><!-- End Breadcrumbs -->
   <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
 $(document).ready(function(){
	$("#forgot").click(function(){
	var form_email=$("#form_email").val();	
	var form_password=$("#form_password").val();
	if($("#form_id").val()!=''){
	var form_id=$("#form_id").val();
	}else{var form_id='';}
var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;   	
	if(form_email==''){
	$("#form_email").focus();
    $("#msg").html("<p class='alert alert-danger'>Email id cannot be blank</p>");	
    return false;
	}
	
	else if(!regex.test(form_email)){
	$("#form_email").focus();
    $("#msg").html("<p class='alert alert-danger'>Enter Email id in correct Format</p>");	
    return false;
	}

	else{
	 $.ajax({
                    url: "api.php?action=forgotpass&email="+form_email,
                    success: function (result) {
                     var res = result.length;
					 if(res>5){
					 $("#msg").html(result);		 
					 }
					 else{//alert(form_id);
					
					window.location.href = "login.php";	
					
					 }
                    }
                });
	}
	});
	});
	</script>     

        <div class="row gy-4">
<div class="col-lg-3"></div>
  <div class="col-lg-6"> <div id="msg"></div>
 <h4> Forgot Password??</h4>
            <form action="" method="post" class="php-email-form">

              <div class="row gy-4">



                <div class="col-md-12">
				  <input id="form_email" name="form_username_email" placeholder="Email" class="form-control" type="text">

                </div>

                <div class="col-md-12 text-center">

                  <button type="button" name="forgot" id="forgot" class="btn btn-primary getstarted " style="background: #43A03E;">Forgot Password</button>
                </div>
				   <div class="clear text-center pt-20">
                  <a class="text-theme-colored1 font-weight-600 font-size-12" href="login.php">Login?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
	  
	  
    </section><!-- End Portfolio Details Section -->


  </main><!-- End #main -->

<?php include_once 'includes/footer.php';?>