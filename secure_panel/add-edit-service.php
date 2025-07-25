<?php
include_once("inc/header.php");
include_once("com/Product.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

$sel_adm = [];
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
    $sel_adm = $db->fetchAssoc($db->fireQuery("SELECT * FROM `product` WHERE id='$rec_id'"));
}

if (isset($_POST["add"]) || isset($_POST["update"])) {
    $temp = new Product();
    $temp->updatePhoto($_POST);
    $temp->Resize($_POST);
}

?>

<div class="row">
    <div class="col-md-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Service Management
            </div>
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

            <script type="text/javascript">
                $(document).ready(function () {
                    $("#category").change(function () {
                        var id = $(this).val();
                        var dataString = 'id=' + id;
                        $.ajax({
                            type: "POST",
                            url: "ajax.php",
                            data: dataString,
                            cache: false,
                            success: function (html) {
                                $("#subcategory").html(html);
                            }
                        });
                    });
                });
            </script>

            <div class="panel-body">
                <div class="row">
                    <form name="frm1" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">Select option</option>
                                <?php
                                $sel = $db->fetchAssoc($db->fireQuery("SELECT * FROM category"));
                                foreach ($sel as $cat) {
                                    ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php if (!empty($sel_adm) && $sel_adm[0]['category'] == $cat['id']) echo "selected"; ?>>
                                        <?php echo $cat['category']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select SubCategory</label>
                            <select class="form-control" id="subcategory" name="subcategory">
                                <option value="">Select Sub category</option>
                                <!-- This will be filled by AJAX -->
                            </select>
                            <input type="hidden" name="subcategory1" value="<?php echo !empty($sel_adm) ? $sel_adm[0]['subcategory'] : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" name="photo" />
                            <input type="hidden" name="photo1" value="<?php echo !empty($sel_adm) ? $sel_adm[0]['photo'] : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" value="<?php echo !empty($sel_adm) ? $sel_adm[0]['name'] : ''; ?>" required />
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input class="form-control" type="text" name="url" value="<?php echo !empty($sel_adm) ? $sel_adm[0]['url'] : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label>Detail</label>
                            <script src="../ckeditor1/ckeditor.js"></script>
                            <textarea name="detail" id="detail" style="width:200px;"><?php echo !empty($sel_adm) ? $sel_adm[0]['detail'] : ''; ?></textarea>
                            <script>
                                CKEDITOR.replace('detail', { resize_enabled: false, height: "291", width: "500" });
                            </script>
                        </div>

                        <input type="submit" name="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') ? 'update' : 'add'; ?>" class="btn btn-primary" value="Submit" />
                        <button type="reset" class="btn btn-primary">Reset Button</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Elements -->
    </div>
</div>

<!-- SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
