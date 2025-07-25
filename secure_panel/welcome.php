<?php 
include_once 'inc/header.php'; // include header
?>

<div class="row">
  


  <!-- Chart 1 -->
  <div class="col-md-5 widget widget1" style="border:0px solid #444333;border-radius:10px;margin-right:10px;width: 47%;">
    <div id="piechart1"></div>
  </div>

  <!-- Chart 2 -->
  <div class="col-md-5 widget widget1" style="border:0px solid #444333;border-radius:10px;margin-right:10px;width: 47%;">
    <div id="piechart2"></div>
  </div>

  <!-- Load Google Charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function () {
      drawChart1();
      drawChart2();
    });

    function drawChart1() {
      var data = google.visualization.arrayToDataTable([
        ['Category', 'Services Count'],
        <?php
        $sel_am = $db->fetchAssoc($db->fireQuery("SELECT * FROM category"));
        foreach ($sel_am as $row) {
          $catid = $row['id'];
          $cat = $row['category'];
          $count = $db->fetchAssoc($db->fireQuery("SELECT * FROM product WHERE category = '$catid'"));
          $count1 = count($count ?? []);
          echo "['$cat - $count1', $count1],";
        }
        ?>
        ['-', 0]
      ]);

      var options = {
        'title':'Category Wise Service Detail',
        'width':550,
        'height':400
      };
      var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
      chart.draw(data, options);
    }

    function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ['Service', 'Clicks Count'],
        <?php
        $sel_am = $db->fetchAssoc($db->fireQuery("SELECT * FROM product"));
        foreach ($sel_am as $row) {
          $id = $row['id'];
          $name = addslashes($row['name']); // safe name
          $countRow = $db->fetchAssoc($db->fireQuery("SELECT COUNT(*) AS total FROM clicks WHERE service_id = '$id'"));
          $count1 = $countRow[0]['total'] ?? 0;
          echo "['$name - $count1', $count1],";
        }
        ?>
        ['-', 0]
      ]);

      var options = {
        'title':'Click-wise Service Report',
        'width':550,
        'height':400
      };
      var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
      chart.draw(data, options);
    }
  </script>

  <div class="clearfix"></div>
  <br/><br/><br/>

  <?php if($_SESSION['admin-type'] =='Admin'){ ?>	

    <!-- ADMIN PANEL OPTIONS -->
    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-key"></i></span>
        <div class="text-box"><p class="text-muted"><a href="change-password.php">Change<br/> Password</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="category-mgmt.php">Category<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="subcategory-mgmt.php">Sub Category<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="service-mgmt.php">Service<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="user-mgmt.php">Register <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="caller-mgmt.php">Caller <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="content-mgmt.php">Content <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="partner-mgmt.php">Clients <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="advert-mgmt.php">Ads <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="testimonial-mgmt.php">Testimonial <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="blog-mgmt.php">Blog <br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="slider-mgmt.php">Slider <br/>Management</a></p></div>
      </div>
    </div>

    <?php } elseif($_SESSION['admin-type'] == 'Editor') { ?>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="category-mgmt.php">Category<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="subcategory-mgmt.php">Subcategory<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="service-mgmt.php">Service<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="user-mgmt.php">Register<br/>Management</a></p></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon"><i class="fa fa-cubes"></i></span>
        <div class="text-box"><p class="text-muted"><a href="caller-mgmt.php">Caller<br/>Management</a></p></div>
      </div>
    </div>

  <?php } ?>
</div> <!-- /.row -->

<hr />

<!-- Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>
<script src="assets/js/custom.js"></script>

</body>
</html>
