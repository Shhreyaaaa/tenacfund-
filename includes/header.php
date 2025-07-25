<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once 'config.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
    </a>

      <nav id="navbar" class="navbar">
  <!--  Your menu list -->
  <ul>
    <li><a class="nav-link scrollto active" href="index.php">Home</a></li>

    <!--  Categories -->
    <?php 
    try {
      $cat = $db->fetchAssoc($db->fireQuery("SELECT * FROM category ORDER BY id ASC LIMIT 0,4"));
      for ($h = 0; $h < count($cat); $h++) {
        if (isset($cat[$h]['category'])) {
          echo '<li class="dropdown megamenu">';
          echo '<a href="#"><span>' . $cat[$h]['category'] . '</span> <i class="bi bi-chevron-down"></i></a>';
          echo '<ul class="vertical-menu">';

          $subcat = $db->fetchAssoc($db->fireQuery("SELECT * FROM subcategory WHERE category = '" . $cat[$h]['id'] . "'"));
          if ($subcat && count($subcat) > 0) {
            foreach ($subcat as $sc) {
              $subsubcat = $db->fetchAssoc($db->fireQuery("SELECT * FROM subsubcategory WHERE subcategory = '" . $sc['id'] . "'"));
              if ($subsubcat && count($subsubcat) > 0) {
                echo '<li class="dropdown dropdown-submenu">';
                echo '<a href="#">' . $sc['subcategory'] . ' <i class="bi bi-chevron-right"></i></a>';
                echo '<ul>';
                foreach ($subsubcat as $ssc) {
                  $subsub_links = [
                    "Standard FDs" => "standard_fds.php",
                    "Senior Citizen FDs" => "senior_citizen_fds.php",
                    "Cumulative FDs" => "cumulative_fds.php",
                    "Women Deposits" => "women_deposits.php",
                    "Equity" => "equity.php",
                    "Debt" => "debt.php",
                    "Hybrid" => "hybrid.php",
                    "Money Market" => "money_market.php",
                    "Index" => "indexx.php",
                    "Premium Finance" => "premium_finance.php",
                    "Medical Loan" => "medical_loan.php",
                  ];
                  $subsub_name = $ssc['subsubcategory'];
                  if (array_key_exists($subsub_name, $subsub_links)) {
                    echo '<li><a href="' . $subsub_links[$subsub_name] . '">' . $subsub_name . '</a></li>';
                  } else {
                    echo '<li><a href="products.php?subsubcategory=' . $ssc['id'] . '">' . $subsub_name . '</a></li>';
                  }
                }
                echo '</ul></li>';
              } else {
                $links = [
                  "Secured Loans" => "secured_loans.php",
                  "Home Loan" => "home_loans.php",
                  "Gold Loans" => "gold_loans.php",
                  "Loans against investments" => "loans_against_investments.php",
                  "Car Loan" => "car_loan.php",
                  "Balance Transfer" => "balance_transfer.php",
                  "Unsecured Loans" => "unsecured_loans.php",
                  "Flexi Loans" => "flexi_loans.php",
                  "Portfolio Management" => "portfolio_management.php",
                  "Investment Management" => "investment_management.php",
                  "Risk Management" => "risk_management.php",
                ];
                $subcat_name = $sc['subcategory'];
                if (array_key_exists($subcat_name, $links)) {
                  echo '<li><a href="' . $links[$subcat_name] . '">' . $subcat_name . '</a></li>';
                } else {
                  echo '<li><a href="subcategory_content.php?subcategory=' . $sc['id'] . '">' . $subcat_name . '</a></li>';
                }
              }
            }
          } else {
            echo '<li><a href="category_content.php?category=' . $cat[$h]['id'] . '">' . $cat[$h]['category'] . '</a></li>';
          }

          echo '</ul></li>';
        }
      }
    } catch (Exception $e) {
      echo "<div style='color:red;'>Error: " . $e->getMessage() . "</div>";
    }
    ?>

    <li><a class="nav-link scrollto" href="about-us.php">About Us</a></li>
    <li><a class="nav-link scrollto" href="contact-us.php">Contact Us</a></li>

    <?php if (!empty($_SESSION['userdetail'])): ?>
      <li class="dropdown">
        <a class="getstarted scrollto dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <?php echo htmlspecialchars($_SESSION['userdetail'][0]['name']); ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    <?php else: ?>
      <li><a class="getstarted scrollto" href="login.php">Sign In/Sign Up</a></li>
    <?php endif; ?>

  </ul> 

  <i class="bi bi-list mobile-nav-toggle"></i>

</nav>

    </div>
  </header><!-- End Header -->

<!-- content -->
<script>

const navbar = document.querySelector('.navbar');

// Existing handler for parent
document.querySelectorAll('.navbar .dropdown > a').forEach(function(el) {
  el.addEventListener('click', function(e) {
    if (navbar.classList.contains('navbar-mobile')) {
      e.preventDefault();
      const dropdown = this.nextElementSibling;
      dropdown.classList.toggle('dropdown-active');
      this.classList.toggle('dropdown-toggle-active');
    }
  });
});

//  Handle nested dropdowns on mobile
document.querySelectorAll('.navbar .dropdown .dropdown > a').forEach(function(el) {
  el.addEventListener('click', function(e) {
    if (navbar.classList.contains('navbar-mobile')) {
      e.preventDefault();
      this.nextElementSibling.classList.toggle('dropdown-active');
      this.classList.toggle('dropdown-toggle-active');
    }
  });
});


</script>



</body>
</html>
