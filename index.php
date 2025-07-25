<?php include_once 'includes/header.php'; ?>

<!-- ======= Hero Section ======= -->

<section id="hero" class="hero d-flex align-items-center">

  <?php 
  ?>

  <div class="container">

    <div class="row">

      <div class="col-lg-6 d-flex flex-column justify-content-center">

        <h1 data-aos="fade-up" style="color:#1c2b65;">Turning ideas into Impact, Dreams into Reality</h1>

        <h2 data-aos="fade-up" data-aos-delay="400">Personalized plans, Stronger futures, Smart financial solutions made for you!</h2>

        <div data-aos="fade-up" data-aos-delay="600">

          <div class="text-center text-lg-start">

            <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">

              <span>Get Started</span>

              <i class="bi bi-arrow-right"></i>

            </a>

          </div>

        </div>

      </div>

      <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">

        <img src="assets/img/hero-img.png" class="img-fluid" alt="">

      </div>

    </div>

  </div>



</section><!-- End Hero -->



<main id="main">

  <!-- ======= About Section ======= -->

  <section id="about" class="about">



    <div class="container" data-aos="fade-up">

      <div class="row gx-0">


        <?php $about = $db->fetchAssoc($db->fireQuery("select * from `content` where `category`='Home' order by id desc")); ?>
        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">

          <div class="content">

            <h3>Who We Are</h3>

            <h2><?php echo $about[0]['heading']; ?></h2>

            <p><?php echo $about[0]['detail']; ?>
            </p>

            <div class="text-center text-lg-start">

              <a href="about-us.php" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">

                <span>Read More</span>

                <i class="bi bi-arrow-right"></i>

              </a>

            </div>

          </div>

        </div>



        <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">

        <img src="<?php echo constant("LINK") . 'uploads/content/' . $about[0]['photo']; ?>" class="img-fluid" style="width:100%;height:400px;" alt="Image">


        </div>



      </div>

    </div>



  </section><!-- End About Section -->



  <!-- ======= Values Section ======= -->

  <section id="values" class="values">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>Our Services</h2>
        <p>The Core Services We Deliver For You</p>
      </header>
      
      
      <div class="row">
        <?php $sel = $db->fetchAssoc($db->fireQuery("select * from category order by id asc limit 0,3"));
        for ($i = 0; $i < count($sel); $i++) { ?>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">

            <div class="box">

            <img src="<?php echo constant("LINK") . 'uploads/category/' . $sel[$i]['photo']; ?>" style="height:200px;width:280px" class="img-fluid" alt="">


              <h3><?php echo $sel[$i]['category']; ?></h3>
              

              <p><?php echo substr(strip_tags($sel[$i]['detail']), 0, 150); ?></p>
              <a href="category.php?action=category&id=<?php echo $sel[$i]['id']; ?>" class="btn btn-primary getstarted " style="background: #43A03E;"><?php echo $sel[$i]['btn_name']; ?></a>
            </div>

          </div>
        <?php } ?>

      </div>



    </div>



  </section><!-- End Values Section -->



  <!-- ======= Counts Section ======= -->

  <section id="counts" class="counts">

    <div class="container" data-aos="fade-up">



      <div class="row gy-4">



        <div class="col-lg-3 col-md-6">

          <div class="count-box">

            <i class="bi bi-emoji-smile"></i>

            <div>

              <span data-purecounter-start="0" data-purecounter-end="5141" data-purecounter-duration="1" class="purecounter"></span>

              <p>Happy Clients</p>

            </div>

          </div>

        </div>



        <div class="col-lg-3 col-md-6">

          <div class="count-box">

            <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>

            <div>

              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>

              <p>Proposals booked</p>

            </div>

          </div>

        </div>



        <div class="col-lg-3 col-md-6">

          <div class="count-box">

            <i class="bi bi-headset" style="color: #15be56;"></i>

            <div>

              <span data-purecounter-start="0" data-purecounter-end="60" data-purecounter-duration="1" class="purecounter"></span>

              <p>Years Of Experience</p>

            </div>

          </div>

        </div>



        <div class="col-lg-3 col-md-6">

          <div class="count-box">

            <i class="bi bi-people" style="color: #bb0852;"></i>

            <div>

              <span data-purecounter-start="0" data-purecounter-end="1510" data-purecounter-duration="1" class="purecounter"></span>

              <p>Business Partners</p>

            </div>

          </div>

        </div>



      </div>



    </div>

  </section><!-- End Counts Section -->



  <!-- ======= Features Section ======= -->

  <section id="features" class="features">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>TECHFUND$ Features</h2>

        <p>Features Which Makes Us Different</p>

      </header>



      <div class="row">



        <div class="col-lg-6">

          <img src="assets/img/features.png" class="img-fluid" alt="">

        </div>



        <div class="col-lg-6 mt-5 mt-lg-0 d-flex">

          <div class="row align-self-center gy-4">



            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">

              <div class="feature-box d-flex align-items-center">

                <i class="bi bi-check"></i>

                <h3> Quality Service </h3>

              </div>

            </div>



            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">

              <div class="feature-box d-flex align-items-center">

                <i class="bi bi-check"></i>

                <h3>Real Time Assistance </h3>

              </div>

            </div>



            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">

              <div class="feature-box d-flex align-items-center">

                <i class="bi bi-check"></i>

                <h3>Quick  Approval </h3>

              </div>

            </div>



            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">

              <div class="feature-box d-flex align-items-center">

                <i class="bi bi-check"></i>

                <h3>Claim Assistance </h3>

              </div>

            </div>



            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">

              <div class="feature-box d-flex align-items-center">

                <i class="bi bi-check"></i>

                <h3>Expert Advice </h3>

              </div>

            </div>




          </div>

        </div>



      </div> <!-- / row -->





      <div class="row feature-icons" data-aos="fade-up">

        <h3>Why to choose our company</h3>



        <div class="row">



          <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">

            <img src="assets/img/features-3.png" class="img-fluid p-4" alt="">

          </div>



          <div class="col-xl-8 d-flex content">

            <div class="row align-self-center gy-4">

              <?php $sell = $db->fetchAssoc($db->fireQuery("select * from content where `category`='Why' order by id asc"));
              for ($j = 0; $j < count($sell); $j++) { ?>

                <div class="col-md-6 icon-box" data-aos="fade-up">

                  <i class="ri-line-chart-line"></i>

                  <div>

                    <h4><?php echo $sell[$j]['heading']; ?></h4>

                    <p><?php echo $sell[$j]['detail']; ?></p>

                  </div>

                </div>
              <?php } ?>

            </div>

          </div>



        </div>



      </div><!-- End Feature Icons -->



    </div>



  </section><!-- End Features Section -->



  <!-- ======= Services Section ======= -->

  <section id="services" class="services">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>Services</h2>

        <p>TECHFUND$ Unique Services</p>

      </header>



      <div class="row gy-4">

        <?php $arr = array('blue', 'orange', 'green', 'red', 'purple', 'pink'); ?>
        <?php $sell = $db->fetchAssoc($db->fireQuery("select * from product order by RAND() limit 0,6"));
        if (count($sell) > 0) {
          for ($j = 0; $j < count($sell); $j++) { ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">

              <div class="service-box <?php echo $arr[$j]; ?>">

                

                    </div>

            </div>


        <?php }
        } ?>
      </div>



    </div>



  </section><!-- End Services Section -->
  <section id="testimonials" class="testimonials">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>Testimonials</h2>

        <p>What they are saying about us</p>

      </header>



      <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">

        <div class="swiper-wrapper">


          <?php $sel = $db->fetchAssoc($db->fireQuery("select * from testimonial order by id desc "));
          for ($i = 0; $i < count($sel); $i++) { ?>
            <div class="swiper-slide">

              <div class="testimonial-item">

                <div class="stars">

                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>

                </div>

                <p>
                  <?php echo $sel[$i]['']; ?>

                </p>

                <div class="profile mt-auto">



                  <h4><?php echo $sel[$i]['post']; ?></h4>

                </div>

              </div>

            </div><!-- End testimonial item -->
          <?php } ?>

        </div>

        <div class="swiper-pagination"></div>

      </div>



    </div>



  </section><!-- End Testimonials Section -->


  <section id="clients" class="clients">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>Our Clients</h2>

      </header>



      <div class="clients-slider swiper">

        <div class="swiper-wrapper align-items-center">
          <?php $sel = $db->fetchAssoc($db->fireQuery("select * from partner order by id desc"));
          for ($i = 0; $i < count($sel); $i++) { ?>
            <div class="swiper-slide"><img src="<?php echo constant("LINK") . 'uploads/partner/' . $sel[$i]['photo']; ?>" class="img-fluid" style="opacity:1;" alt=""></div>

          <?php } ?>
        </div>

        <div class="swiper-pagination"></div>

      </div>

    </div>



  </section><!-- End Clients Section -->



  <!-- ======= Recent Blog Posts Section ======= -->

  <section id="recent-blog-posts" class="recent-blog-posts">



    <div class="container" data-aos="fade-up">



      <header class="section-header">

        <h2>Blog</h2>

        <p>Recent posts form our Blog</p>

      </header>



      <div class="row">

        <?php $sel = $db->fetchAssoc($db->fireQuery("select * from blog order by id desc limit 0,3"));
        for ($i = 0; $i < count($sel); $i++) { ?>

          <div class="col-lg-4">

            <div class="post-box">

              <div class="post-img"><img src="<?php echo constant("LINK") . 'uploads/blog/' . $sel[$i]['photo']; ?>" style="width:100%;height:240px;" class="img-fluid" alt=""></div>
              <?php $date = explode('-', $sel[$i]['date']);
              $monthName = date('F', mktime(0, 0, 0, $date['1'], 10)); ?>
              <span class="post-date"><?php echo $monthName; ?> <?php echo $date[2]; ?></span>

              <h3 class="post-title"><?php echo $sel[$i]['heading']; ?></h3>

              <a href="blog-detail.php?action=detail&id=<?php echo $sel[$i]['id']; ?>" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

            </div>

          </div>

        <?php } ?>
      </div>



    </div>



  </section><!-- End Recent Blog Posts Section -->


</main><!-- End #main -->

<?php include_once 'includes/footer.php'; ?>