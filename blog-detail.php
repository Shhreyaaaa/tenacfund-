<?php include_once 'includes/header.php';?>
<?php if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'detail' )
{
	$sel=$db->fetchAssoc($db->fireQuery("select * from blog where id='".$_REQUEST['id']."'"));?>
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Blogs</li>
        </ol>
        <h2><?php echo $sel[0]['heading'];?></h2>

      </div>
    </section><!-- End Breadcrumbs -->
  <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry entry-single">

              <div class="entry-img">
                <img src="<?php echo constant("LINK").'uploads/blog/'.$sel[0]['photo'];?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href=""><?php echo $sel[0]['heading'];?></a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#"><?php echo $sel[0]['writtenby'];?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime=""><?php $date=explode('-',$sel[0]['date']);
					  $monthName = date('F', mktime(0, 0, 0, $date['1'], 10)); ?>
					<?php echo $monthName;?> <?php echo $date[2];?>, <?php echo $date[0];?></time></a></li>
             
                </ul>
              </div>

              <div class="entry-content">
                <p><?php echo $sel[0]['detail'];?></p>

              </div>


            </article><!-- End blog entry -->

   </div><!-- End blog entries list -->

          <div class="col-lg-4">

            <div class="sidebar">

              <h3 class="sidebar-title">Categories</h3>
              <div class="sidebar-item categories">
                <ul>
                <?php $sel=$db->fetchAssoc($db->fireQuery("select * from category order by id asc"));
                     for($i=0;$i<count($sel);$i++){?>
                  <li><a href="category.php?action=category&id=<?php echo $sel[$i]['id'];?>"><?php echo $sel[$i]['category'];?></a></li>
                <?php } ?>
                </ul>
              </div><!-- End sidebar categories-->

              <h3 class="sidebar-title">Recent Posts</h3>
              <div class="sidebar-item recent-posts">
	<?php $sel=$db->fetchAssoc($db->fireQuery("select * from blog where `id`!='".$_REQUEST['id']."' order by id desc limit 0,4"));
        for($i=0;$i<count($sel);$i++){?>	  
                <a href="blog-detail.php?action=detail&id=<?php echo $sel[$i]['id'];?>"><div class="post-item clearfix">
                  <img src="<?php echo constant("LINK").'uploads/blog/'.$sel[$i]['photo'];?>" style="width:80px;height:80px;margin-bottom:10px;" alt="">
                  <h4><a href="blog-detail.php?action=detail&id=<?php echo $sel[$i]['id'];?>"><?php echo $sel[$i]['heading'];?></a></h4><?php $date=explode('-',$sel[$i]['date']);
					  $monthName = date('F', mktime(0, 0, 0, $date['1'], 10)); ?>
                  <time datetime=""><?php echo $monthName;?> <?php echo $date[2];?></time>
                </div><a>

<?php } ?>

              </div><!-- End sidebar recent posts-->


            </div><!-- End sidebar -->

          </div><!-- End blog sidebar -->

        </div>

      </div>
    </section><!-- End Blog Single Section -->

 
	<?php } include_once 'includes/footer.php';?>