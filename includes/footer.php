<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>COMPANY_NAME</title>
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css?v=2">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<footer id="footer" class="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-info">
          <a href="#" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="Logo" style="width: 200px; height: 70px;">
          </a>
          <?php
            $about = $db->fetchAssoc($db->fireQuery("SELECT * FROM `content` WHERE `category`='About Us' ORDER BY id DESC"));
          ?>
          <p class="footer-about"><?php echo substr(strip_tags($about[0]['detail']), 0, 250); ?>...</p>
          
          <div class="social-links mt-3">
            <a href="" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
            <a href="" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="" target="_blank" class="instagram"><i class="fab fa-instagram"></i></a>
            <a href="" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
            <a href="" target="_blank" class="youtube"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><i class="fas fa-chevron-right"></i> <a href="index.php">Home</a></li>
            <li><i class="fas fa-chevron-right"></i> <a href="about-us.php">About us</a></li>
            <li><i class="fas fa-chevron-right"></i> <a href="blog.php">Blog</a></li>
            <li><i class="fas fa-chevron-right"></i> <a href="terms.php">Terms of service</a></li>
            <li><i class="fas fa-chevron-right"></i> <a href="privacy.php">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <?php
              $cat = $db->fetchAssoc($db->fireQuery("SELECT * FROM `category` ORDER BY id ASC LIMIT 0,6"));
              foreach ($cat as $c) {
                echo '<li><i class="fas fa-chevron-right"></i> <a href="#">' . $c['category'] . '</a></li>';
              }
            ?>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact">
          <h4>Contact Us</h4>
          <p class="contact-details" style="color:rgb(31, 30, 30);">
            <i class="fas fa-map-marker-alt"></i>YOUR_OFFICE_ADDRESS<br>
            <i class="fas fa-phone-alt"></i> <strong>+91 XXXXXXXXXX</strong><br>
            <i class="fas fa-envelope"></i> <strong>support@mail.in</strong><br>
          </p>
          
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <div class="copyright">
        <p></p>
        <p>&copy; Copyright <?php echo date('Y'); ?> . All Rights Reserved</p>
      </div>
    </div>
  </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
  <i class="fas fa-arrow-up"></i>
</a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>