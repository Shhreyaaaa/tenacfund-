<?php
include_once("inc/header.php");
include_once("com/Category.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

// 
$sel_adm = [[]];

if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
    $result = $db->fetchAssoc($db->fireQuery("SELECT * FROM `category` WHERE id='$rec_id'"));

    if (!empty($result)) {
        $sel_adm[0] = $result;  // wrap in array
    }
}


if (isset($_POST["update"])) {
    $temp = new Category();
    $temp->updatePhoto($_POST);
    $temp->Resize($_POST);
}
?>

<div class="row">
    <div class="col-md-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-heading">Category Management</div>

            <div class="errordiv">
                <?php
                if (!empty($_SESSION['msg'])) {
                    echo '<div class="msg" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (!empty($_SESSION['errormsg'])) {
                    echo '<div class="errormsg" style="cursor:pointer">' . $_SESSION['errormsg'] . '</div>';
                    unset($_SESSION['errormsg']);
                }
                ?>
            </div>

            <div class="panel-body">
                <div class="row">
                    <form name="frm1" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" name="photo" value="" />
                            <input class="form-control" type="hidden" name="photo1" value="<?php echo htmlspecialchars($sel_adm[0]['photo'] ?? ''); ?>" />
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <input class="form-control" type="text" name="category" value="<?php echo htmlspecialchars($sel_adm[0]['category'] ?? ''); ?>" required />
                        </div>

                        <div class="form-group">
                            <label>Button Name</label>
                            <input class="form-control" type="text" name="btn_name" value="<?php echo htmlspecialchars($sel_adm[0]['btn_name'] ?? ''); ?>" required />
                        </div>

                        <div class="form-group">
                            <label>Detail</label>
                            <script src="../ckeditor1/ckeditor.js"></script>
                            <textarea name="detail" id="detail" class="{validate:{required:true,minlength:5}}" style="width:200px;"><?php echo htmlspecialchars($sel_adm[0]['detail'] ?? ''); ?></textarea>
                            <script>
                                var editor = CKEDITOR.replace('detail', { resize_enabled: false, height: "291", width: "500" });
                            </script>
                        </div>

                        <input type="submit" name="update" class="btn btn-primary" value="Submit" />
                        <button type="reset" class="btn btn-primary">Reset Button</button>

                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Elements -->
    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
