<?php
include_once 'C:\xampp\htdocs\my_project\includes\config.php';
include_once 'includes/header.php';

// Fetch Secured Loans data from `subcategory` table
$loansAgainstInv = $db->fetchAssoc($db->fireQuery("SELECT * FROM `subcategory` WHERE `subcategory`='Loans Against Investments' ORDER BY id DESC LIMIT 1"));
$productName = $loansAgainstInv[0]['subcategory'];
?>
<style>
.enquiry-box {
  max-width: 70%; 
  margin: 0;
  margin-bottom: 20px;
  padding-right: 20px;  
}
</style>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Loans Against Investments</li>
        </ol>
        <h2>Loans Against Investments</h2>
      </div>
    </section>
    <!-- End Breadcrumbs -->

<?php $loansAgainstInvestments=$db->fetchAssoc($db->fireQuery("select * from `subcategory` where `subcategory`='Loans against investments' order by id desc"));?>
   <!-- ======= loans against investments Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="about-description">
              <
            </div>
          </div>
        </div>
      </div>
    </section><!-- End loans against investments Section -->


<!-- ======= Enquiry Form ======= -->
  <div class="container" data-aos="fade-up">
    <h3>Enquire Now</h3>

    <div class="enquiry-box">
      <form id="enquiryForm" action="forms/enquiry.php" method="post" class="contact">

        <input type="hidden" name="product" value="<?php echo htmlspecialchars($productName ?? ''); ?>">

        <div class="row gy-4">
          <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="col-md-6">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="col-md-12">
            <input type="text" name="phone" class="form-control" placeholder="Phone No" required>
          </div>
          <div class="col-md-12">
            <textarea name="message" class="form-control" rows="6" placeholder="Message" required></textarea>
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary getstarted" style="background: #43A03E;">Enquire Now</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</main><!-- End #main -->

<!--  Add jQuery & SweetAlert2 CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--  AJAX handler -->
<script>
  $('#enquiryForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          text: 'We have received your enquiry.'
        });
        $('#enquiryForm')[0].reset();
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Oops!',
          text: 'Something went wrong. Please try again.'
        });
      }
    });
  });
</script>

<?php include_once 'includes/footer.php'; ?>
