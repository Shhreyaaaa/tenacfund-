<?php
include_once("inc/header.php");
include_once("com/Offers.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

$sel_adm = [];
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
    $sel_adm = $db->fetchAssoc($db->fireQuery("SELECT * FROM `offers` WHERE id='$rec_id'"));
}

if (isset($_POST["update"])) {
    $temp = new Offers();
    $temp->updatePhoto($_POST);
    $temp->Resize($_POST);
}
?>

<div class="row">
    <div class="col-md-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Offers Management
            </div>

            <div class="errordiv">
                <?php
                if (isset($_SESSION['msg']) && $_SESSION['msg']) {
                    echo '<div class="msg" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['errormsg']) && $_SESSION['errormsg']) {
                    echo '<div class="errormsg" style="cursor:pointer">' . $_SESSION['errormsg'] . '</div>';
                    unset($_SESSION['errormsg']);
                }
                ?>
            </div>

            <script>
                $(document).ready(function () {
                    $("#category").change(function () {
                        var id = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "ajax.php",
                            data: { id: id },
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
                            <label>Photo</label>
                            <input class="form-control" type="file" name="photo" />
                            <input type="hidden" name="photo1" value="<?php echo isset($sel_adm[0]['photo']) ? htmlspecialchars($sel_adm[0]['photo']) : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" value="<?php echo isset($sel_adm[0]['name']) ? htmlspecialchars($sel_adm[0]['name']) : ''; ?>" required />
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input class="form-control" type="text" name="url" value="<?php echo isset($sel_adm[0]['url']) ? htmlspecialchars($sel_adm[0]['url']) : ''; ?>" required />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Select Type</label>
                            <select class="form-control" name="offertype" id="offertype" required>
                                <option value="">Select type</option>
                                <option value="inclusive" <?php echo (isset($sel_adm[0]['offertype']) && $sel_adm[0]['offertype'] == 'inclusive') ? 'selected' : ''; ?>>Inclusive</option>
                                <option value="exclusive" <?php echo (isset($sel_adm[0]['offertype']) && $sel_adm[0]['offertype'] == 'exclusive') ? 'selected' : ''; ?>>Exclusive</option>
                            </select>
                        </div>

                        <input type="submit" name="update" class="btn btn-primary" id="Save" value="Submit" />
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Elements -->
    </div>
</div>

<!-- JS Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
