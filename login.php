<?php include_once 'includes/header.php'; ?>

<main id="main">
  <section class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Sign In/Sign Up</li>
      </ol>
      <h2>Sign In/Sign Up</h2>
    </div>
  </section>

  <section id="portfolio-details" class="portfolio-details">
    <div class="container">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>
        $(document).ready(function () {
          //  LOGIN
          $("#login").click(function () {
              var form_email = $("#form_email").val();
              var form_password = $("#form_password").val();

              if (form_email === '') {
                  $("#form_email").focus();
                  $("#msg").html("<p class='alert alert-danger'>Email id cannot be blank</p>");
                  return false;
              }

              if (form_password === '') {
                  $("#form_password").focus();
                  $("#msg").html("<p class='alert alert-danger'>Password cannot be blank</p>");
                  return false;
              }

              $.ajax({
                  url: "api.php",
                  method: "GET",
                  data: {
                      action: "login",
                      email: form_email,
                      password: form_password
                  },
                  success: function (response) {
                      let result;
                      try {
                          result = JSON.parse(response);
                      } catch (e) {
                          $("#msg").html("<p class='alert alert-danger'>Unexpected error occurred.</p>");
                          return;
                      }

                      if (result.status === "success") {
                          window.location.href = "profile.php";
                      } else {
                          $("#msg").html("<p class='alert alert-danger'>" + result.msg + "</p>");
                      }
                  }
              });
          });


          //  REGISTER
          $("#register").click(function () {
            const name = $("#form_name").val().trim();
            const email = $("#form_email1").val().trim();
            const phone = $("#form_phone").val().trim();
            const age = $("#form_age").val().trim();
            const address = $("#form_address").val().trim();
            const password = $("#form_choose_password").val().trim();
            const confirm = $("#form_re_enter_password").val().trim();

            if (!name || !email || !phone || !age || !address || !password || !confirm) {
              $("#msg1").html("<p class='alert alert-danger'>All fields are required.</p>");
              return;
            }

            if (password !== confirm) {
              $("#msg1").html("<p class='alert alert-danger'>Passwords do not match.</p>");
              return;
            }

            $.ajax({
              url: "api.php",
              type: "GET",
              data: {
                action: "register",
                name: name,
                email: email,
                phone: phone,
                age: age,
                address: address,
                password: password,
                confirmpassword: confirm,
                refereal: "",
                login_type: "User"
              },
              success: function (response) {
                $("#msg1").html(response);
              },
              error: function () {
                $("#msg1").html("<p class='alert alert-danger'>Server error. Please try again.</p>");
              }
            });
          });
        });
      </script>

      <div class="row gy-4">
        <!-- Login -->
        <div class="col-lg-6">
          <div id="msg"></div>
          <h4>Already Registered? Login Now</h4>
          <form class="php-email-form">
            <div class="row gy-4">
              <div class="col-md-12">
                <input id="form_email" class="form-control" type="email" placeholder="Your Email ID">
              </div>
              <div class="col-md-12">
                <input id="form_password" class="form-control" type="password" placeholder="Your Password">
              </div>
              <div class="col-md-12 text-center">
                <button type="button" id="login" class="btn btn-primary getstarted" style="background: #43A03E;">Login</button>
              </div>
              <div class="clear text-center pt-20">
                <a href="forgot.php">Forgot Your Password?</a>
              </div>
            </div>
          </form>
        </div>

        <!-- Register -->
        <div class="col-lg-6">
          <div id="msg1"></div>
          <h4>New Here? Please Register</h4>
          <form class="php-email-form">
            <div class="row gy-4">
              <div class="col-md-6">
                <input id="form_name" class="form-control" type="text" placeholder="Your Name">
              </div>
              <div class="col-md-6">
                <input id="form_email1" class="form-control" type="email" placeholder="Your Email">
              </div>
              <div class="col-md-6">
                <input id="form_phone" class="form-control" type="text" placeholder="Your Phone">
              </div>
              <div class="col-md-6">
                <input id="form_age" class="form-control" type="number" placeholder="Your Age">
              </div>
              <div class="col-md-12">
                <textarea id="form_address" class="form-control" placeholder="Your Address"></textarea>
              </div>
              <div class="col-md-6">
                <input id="form_choose_password" class="form-control" type="password" placeholder="Choose Password">
              </div>
              <div class="col-md-6">
                <input id="form_re_enter_password" class="form-control" type="password" placeholder="Re-enter Password">
              </div>
              <div class="col-md-12 text-center">
                <button type="button" id="register" class="btn btn-primary getstarted" style="background: #43A03E;">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include_once 'includes/footer.php'; ?>
