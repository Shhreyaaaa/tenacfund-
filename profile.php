<?php
session_start();

//  Check login status
if (!isset($_SESSION['userdetail']) || !is_array($_SESSION['userdetail'])) {
    header("Location: login.php");
    exit;
}

//  Store the user array once
$user = $_SESSION['userdetail'][0];

include_once 'includes/header.php';

// ✅ Fetch fresh details from DB
include_once("secure_panel/com/sqlConnection.php");
$db = new sqlConnection();
$sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM user WHERE id='" . $user['id'] . "'"));
$user = $sel[0]; // override with fresh DB data
?>

<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <section class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Profile</li>
      </ol>
      <h2>Welcome <?php echo htmlspecialchars($user['name'] ?? ''); ?></h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-8 entries">
          <!-- Your main content here -->
        </div><!-- End blog entries list -->

        <div class="col-lg-4">
          <div class="sidebar">
            <?php if (!empty($user['photo'])): ?>
              <img style="height:230px;width:90%;margin-left:5%;margin-bottom:5%;"
                   src="<?php echo htmlspecialchars(constant("LINK") . 'uploads/user/' . $user['photo']); ?>"
                   class="attachment-large mt-30" alt="Profile photo">
            <?php else: ?>
              <img style="height:230px;width:90%;margin-left:5%;margin-bottom:5%;"
                   src="assets/img/user.png" class="attachment-large mt-30" alt="Default profile">
            <?php endif; ?>

            <div class="sidebar-item categories">
              <ul>
                <li><a><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($user['name'] ?? ''); ?></a></li>
                <li><a><i class="bi bi-envelope-check-fill"></i> <?php echo htmlspecialchars($user['email'] ?? ''); ?></a></li>
                <li><a><i class="bi bi-phone"></i> <?php echo htmlspecialchars($user['phone'] ?? ''); ?></a></li>
              </ul>
            </div><!-- End sidebar categories-->
          </div><!-- End sidebar -->

          <div class="sidebar">
            <h3 class="sidebar-title">Useful Links</h3>
            <div class="sidebar-item categories">
              <ul>
                <li><a href="edit-profile.php">Edit Profile</a></li>
                <li><a href="certificate.php">Certificate</a></li>
                <li><a href="change-password.php">Change Password</a></li>
              </ul>
            </div><!-- End sidebar categories-->
          </div><!-- End sidebar -->
        </div><!-- End blog sidebar -->
      </div>
    </div>
  </section><!-- End Blog Section -->
</main>

<?php include_once 'includes/footer.php'; ?>
