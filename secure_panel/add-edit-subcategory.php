<?php
include_once("inc/header.php");
include_once("com/Subcategory.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

$sel_adm = [[]];

if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
  $rec_id = siteDecrypt($_REQUEST["id"]);
  $sel_adm = $db->fetchAssoc($db->fireQuery("SELECT * FROM `subcategory` WHERE id='$rec_id'"));
}

if (isset($_POST["update"])) {
  $temp = new Subcategory();
  $temp->updatePhoto($_POST);
}
?>

<div class="row">
  <div class="col-md-12">
    <!-- Form Elements -->
    <div class="panel panel-default">
      <div class="panel-heading">Subcategory Management</div>

      <div class="errordiv">
        <?php
        if (!empty($_SESSION['msg'] ?? '')) {
          echo '<div class="msg">' . $_SESSION['msg'] . '</div>';
          unset($_SESSION['msg']);
        }
        if (!empty($_SESSION['errormsg'] ?? '')) {
          echo '<div class="errormsg">' . $_SESSION['errormsg'] . '</div>';
          unset($_SESSION['errormsg']);
        }
        ?>
      </div>

      <div class="panel-body">
        <div class="row">
          <form name="frm1" method="post" enctype="multipart/form-data">

            <!--  Category -->
            <div class="form-group">
              <label>Select Category</label>
              <select class="form-control" name="category" required>
                <option value="">Select option</option>
                <?php
                $sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM category"));
                foreach ($sel as $row) {
                  $selected = (($sel_adm[0]['category'] ?? '') == $row['id']) ? 'selected' : '';
                  echo "<option value='{$row['id']}' $selected>{$row['category']}</option>";
                }
                ?>
              </select>
            </div>

            <!--  Subcategory -->
            <div class="form-group">
              <label>Subcategory</label>
              <input class="form-control" type="text" name="subcategory"
                     value="<?php echo htmlspecialchars($sel_adm[0]['subcategory'] ?? '') ?>" required />
            </div>

            <!--  Photo -->
            <div class="form-group">
              <label>Photo</label>
              <input class="form-control" type="file" name="photo" />
              <input type="hidden" name="photo1"
                     value="<?php echo htmlspecialchars($sel_adm[0]['photo'] ?? '') ?>" />
            </div>

            <!--  Detail -->
            <div class="form-group">
              <label>Detail</label>
              <script src="../ckeditor1/ckeditor.js"></script>
              <textarea name="detail" id="detail"><?php echo htmlspecialchars($sel_adm[0]['detail'] ?? ''); ?></textarea>
              <script>
                CKEDITOR.replace('detail', { resize_enabled: false, height: "291", width: "500" });
              </script>
            </div>

            <input type="submit" name="update" class="btn btn-primary" value="Submit" />
            <button type="reset" class="btn btn-primary">Reset</button>

          </form>
        </div>
      </div>
    </div>
    <!-- End Form Elements -->
  </div>
</div>

<!-- Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
