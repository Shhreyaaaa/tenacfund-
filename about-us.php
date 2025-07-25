<?php include_once 'includes/header.php';?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>About Us</li>
        </ol>
        <h2>About Us</h2>
      </div>
    </section><!-- End Breadcrumbs -->

<?php $about=$db->fetchAssoc($db->fireQuery("select * from `content` where `category`='About Us' order by id desc"));?>
   <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="about-description">
              <h2><?php echo $about[0]['heading'];?></h2>
              <p><?php echo $about[0]['detail'];?></p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End About Us Section -->

<?php $about=$db->fetchAssoc($db->fireQuery("select * from `content` where `category`='Mission' order by id desc"));?>
   <!-- ======= Mission Section ======= -->
    <section id="mission" class="mission">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="mission-description">
              <h2><?php echo $about[0]['heading'];?></h2>
              <p><?php echo $about[0]['detail'];?></p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Mission Section -->

<?php $about=$db->fetchAssoc($db->fireQuery("select * from `content` where `category`='Vision' order by id desc"));?>
   <!-- ======= Vision Section ======= -->
    <section id="vision" class="vision">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="vision-description">
              <h2><?php echo $about[0]['heading'];?></h2>
              
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Vision Section -->

</main><!-- End #main -->

<?php include_once 'includes/footer.php';?>