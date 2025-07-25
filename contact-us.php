
<?php include_once 'includes/header.php';?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Contact Us</li>
        </ol>
        <h2>Contact Us</h2>

      </div>
    </section><!-- End Breadcrumbs -->
<?php $about=$db->fetchAssoc($db->fireQuery("select * from `content` where `category`='Contact Us' order by id desc"));?>
   <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15792.57121598199!2d93.0985183495452!3d8.288583651613418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3065a7e5208730c7%3A0x840166fa1640af9c!2sKalasi%2C%20Andaman%20and%20Nicobar%20Islands%20744303!5e0!3m2!1sen!2sin!4v1753260368277!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

      
        </div>

      </div>
	  
	  
    </section><!-- End Portfolio Details Section -->

  <!-- ======= Contact Section ======= -->

    <section id="contact" class="contact">



      <div class="container" data-aos="fade-up">



        <header class="section-header">

          <h2>Contact</h2>

          <p>Contact Us</p>

        </header>



        <div class="row gy-4">



          <div class="col-lg-6">



            <div class="row gy-4">

              <div class="col-md-6">

                <div class="info-box">

                  <i class="bi bi-geo-alt"></i>

                  <h3>Address</h3>

                  <p>YOUR_OFFICE_ADDRESS<br/>


                </div>

              </div>

              <div class="col-md-6">

                <div class="info-box">

                  <i class="bi bi-telephone"></i>

                  <h3>Call Us</h3>

                  <p> <strong>Phone:</strong> + 91 XXXXXXXXXX<br/></p>

                </div>

              </div>

              <div class="col-md-6">

                <div class="info-box">

                  <i class="bi bi-envelope"></i>

                  <h3>Email Us</h3>

                  <p>support@mail.in</p>

                </div>

              </div>

              <div class="col-md-6">

                <div class="info-box">

                  <i class="bi bi-clock"></i>

                  <h3>Open Hours</h3>

                  <p>Monday - Friday<br>10:00AM - 06:00PM</p>

                </div>

              </div>

            </div>



          </div>



          <div class="col-lg-6">

            <form action="forms/contact.php" method="post" class="php-email-form">

              <div class="row gy-4">



                <div class="col-md-6">

                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>

                </div>



                <div class="col-md-6 ">

                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>

                </div>



                <div class="col-md-12">

                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>

                </div>



                <div class="col-md-12">

                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>

                </div>



                <div class="col-md-12 text-center">

                  <div class="loading">Loading</div>

                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                  <button type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->




  </main><!-- End #main -->

<?php include_once 'includes/footer.php';?>