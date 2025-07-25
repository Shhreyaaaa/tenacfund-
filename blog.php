<?php include_once 'includes/header.php';?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Blogs</li>
        </ol>
        <h2>Blogs</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="recent-blog-posts" class="recent-blog-posts">



      <div class="container" data-aos="fade-up">



        <header class="section-header">

          <h2>Blog</h2>

          <p>Recent posts form our Blog</p>

        </header>



        <div class="row">

		<?php $sel=$db->fetchAssoc($db->fireQuery("select * from blog order by id desc"));
        for($i=0;$i<count($sel);$i++){?>

          <div class="col-lg-4">

            <div class="post-box">

              <div class="post-img"><img src="<?php echo constant("LINK").'uploads/blog/'.$sel[$i]['photo'];?>" style="width:100%;height:240px;" class="img-fluid" alt=""></div>
<?php $date=explode('-',$sel[$i]['date']);
					  $monthName = date('F', mktime(0, 0, 0, $date['1'], 10)); ?>
              <span class="post-date"><?php echo $monthName;?> <?php echo $date[2];?></span>

              <h3 class="post-title"><?php echo $sel[$i]['heading'];?></h3>

              <a href="blog-detail.php?action=detail&id=<?php echo $sel[$i]['id'];?>" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

            </div>

          </div>

<?php } ?>
        </div>



      </div>



    </section><!-- End Recent Blog Posts Section -->


  
	
	<?php include_once 'includes/footer.php';?>