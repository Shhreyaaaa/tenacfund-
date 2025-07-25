<?php include_once 'includes/header.php'; ?>

<?php
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'category' && isset($_REQUEST['id'])) {
    $id = intval($_REQUEST['id']);

    $sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM category WHERE id = '$id'"));

    if (!$sel || count($sel) == 0) {
        echo "<p style='text-align:center;color:red;margin:50px;'>No category found.</p>";
    } else {
        $category = $sel[0]; 
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li><?php echo htmlspecialchars($category['category']); ?></li>
        </ol>
        <h2><?php echo htmlspecialchars($category['category']); ?></h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">
        <div class="row">

          <div class="col-lg-9 entries">
            <article class="entry">
              <h2 class="entry-title">
                <a href="#"><?php echo htmlspecialchars($category['category']); ?></a>
              </h2>
              <div class="entry-content">
                
              </div>

              
            </article><!-- End blog entry -->
          </div><!-- End blog entries list -->

          <div class="col-lg-3">
            <div class="sidebar">
              <h3 class="sidebar-title">Categories</h3>
              <div class="sidebar-item categories">
                <ul>
                  <?php
                  $otherCats = $db->fetchAssoc($db->fireQuery("SELECT * FROM category WHERE id != '$id' ORDER BY id ASC"));
                  foreach ($otherCats as $cat) {
                    echo '<li><a href="category.php?action=category&id=' . $cat['id'] . '">' . htmlspecialchars($cat['category']) . '</a></li>';
                  }
                  ?>
                </ul>
              </div><!-- End sidebar categories-->
            </div><!-- End sidebar -->
          </div><!-- End blog sidebar -->

        </div>
      </div>
    </section><!-- End Blog Section -->
</main>

<?php
    } 
} else {
    echo "<p style='text-align:center;color:red;margin:50px;'>Invalid category request.</p>";
}
?>

<?php include_once 'includes/footer.php'; ?>
