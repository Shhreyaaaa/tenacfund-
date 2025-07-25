<?php include_once 'includes/header.php'; ?>

<?php
if (isset($_REQUEST["action"]) && $_REQUEST["action"] === 'detail' && isset($_REQUEST['id'])) {

    $id = intval($_REQUEST['id']); 
    $sel = $db->fetchAssoc(
        $db->fireQuery("SELECT * FROM product WHERE id = '$id' AND status = 'Active' LIMIT 1")
    );

    if (!empty($sel) && isset($sel[0])) {
    $product = $sel[0];

    if (!empty($product['url'])) {
        header("Location: " . $product['url']);
        exit;
    }
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Services</li>
        </ol>
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry">
              <div class="entry-img">
                <img src="<?php echo constant("LINK") . 'uploads/product/' . htmlspecialchars($product['photo']); ?>" style="height:350px;width:860px;" alt="" class="img-fluid">
              </div>
              <h2 class="entry-title">
                <a href="#"><?php echo htmlspecialchars($product['name']); ?></a>
              </h2>

              <div class="entry-content">
                <p><?php echo nl2br(htmlspecialchars($product['detail'])); ?></p>
              </div>

            </article>

            <!-- Related Services -->
            <section id="services" class="services">
              <div class="container" data-aos="fade-up">
                <header class="section-header">
                  <h2>Other Related Services</h2>
                </header>

                <div class="row gy-4">
                  <?php
                  $arr = array('blue', 'orange', 'green', 'red', 'purple', 'pink');
                  $related = $db->fetchAssoc(
                    $db->fireQuery(
                      "SELECT * FROM product WHERE id != '$id' AND category = '" . intval($product['category']) . "' AND status = 'Active' ORDER BY id DESC"
                    )
                  );

                  if (!empty($related)) {
                      foreach ($related as $j => $rel) {
                  ?>
                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                      <div class="service-box <?php echo $arr[$j % count($arr)]; ?>">
                        <img src="<?php echo constant("LINK") . 'uploads/product/' . htmlspecialchars($rel['photo']); ?>" style="height:150px;width:150px;padding:15px;margin:0 auto;" alt="Image">
                        <h3><?php echo htmlspecialchars($rel['name']); ?></h3>
                        <?php
                        $link = !empty($rel['url']) ? htmlspecialchars($rel['url']) : "services.php?action=detail&id=" . intval($rel['id']);
                        ?>
                        <a href="<?php echo $link; ?>" class="read-more" target="<?php echo !empty($rel['url']) ? '_blank' : '_self'; ?>">
                        <span>Read More</span> <i class="bi bi-arrow-right"></i></a>
                      </div>
                    </div>
                  <?php
                      }
                  } else {
                      echo "<p></p>";
                  }
                  ?>
                </div>
              </div>
            </section>
            <!-- End Related Services -->

            <h3>Enquire Now</h3>
            <form action="forms/contact.php" method="post" class="contact">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="phone" placeholder="Phone No" required>
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-primary getstarted" style="background: #43A03E;">Enquire Now</button>
                </div>
              </div>
            </form>

          </div><!-- End blog entries -->

          <div class="col-lg-4">
            <!-- Loan Calculator -->
            <div class="sidebar">
              <h3 class="sidebar-title">Loan Calculator</h3>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
              <script src="https://emicalculator.net/widget/2.0/js/emicalc-loader.min.js" type="text/javascript"></script>
              <div id="ecww-widgetwrapper" style="min-width:250px;width:100%;">
                <div id="ecww-widget" style="position:relative;padding-top:0;padding-bottom:280px;height:0;overflow:hidden;"></div>
                <div id="ecww-more" style="background:#333;font:normal 13px/1 Helvetica, Arial, Verdana, Sans-serif;padding:10px 0;color:#FFF;text-align:center;width:100%;clear:both;margin:0;clear:both;float:left;">
                  <a style="background:#333;color:#FFF;text-decoration:none;border-bottom:1px dotted #ccc;" href="https://emicalculator.net/" title="Loan EMI Calculator" rel="nofollow" target="_blank">emicalculator.net</a>
                </div>
              </div>
            </div>

            <!-- Categories -->
            <div class="sidebar">
              <h3 class="sidebar-title">Categories</h3>
              <div class="sidebar-item categories">
                <ul>
                  <?php
                  $categories = $db->fetchAssoc($db->fireQuery("SELECT * FROM category ORDER BY id ASC"));
                  foreach ($categories as $cat) {
                    echo '<li><a href="category.php?action=category&id=' . intval($cat['id']) . '">' . htmlspecialchars($cat['category']) . '</a></li>';
                  }
                  ?>
                </ul>
              </div>
            </div>

          </div><!-- End sidebar -->

        </div>
      </div>
    </section>
</main>

<?php
    } else {
        echo "<p style='padding:50px;text-align:center;'>Service not found.</p>";
    }

} else {
    echo "<p style='padding:50px;text-align:center;'>Invalid request.</p>";
}

include_once 'includes/footer.php';
?>
