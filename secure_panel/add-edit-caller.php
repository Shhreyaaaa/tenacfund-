<?php
include_once("inc/header.php");
include_once("com/Admin.php");
include_once("inc/checksession.inc.php");


$sel_caller = [];

// Add: default empty
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'add') {
    $sel_caller[0] = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
        'status' => ''
    ];
}

// Edit: fetch existing
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
    $sel_caller = $db->fetchAssoc($db->fireQuery("SELECT * FROM `caller` WHERE id='$rec_id'"));
}

//  Secure submit: Only Admin allowed
if (isset($_POST["update"])) {
    if($_SESSION['admin-type'] != 'Admin') {
        die('Unauthorized action.');
    }
    $temp = new Admin();
    $temp->updateCaller($_POST);
}
?>

<div class="row">
    <div class="col-md-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-heading">Caller Management</div>

            <div class="errordiv">
                <?php
                if (!empty($_SESSION['msg'])) {
                    echo '<div class="msg">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (!empty($_SESSION['errormsg'])) {
                    echo '<div class="errormsg">' . $_SESSION['errormsg'] . '</div>';
                    unset($_SESSION['errormsg']);
                }
                ?>
            </div>

            <div class="panel-body">
                <div class="row">
                    <?php if($_SESSION['admin-type'] == 'Admin') { ?>
                    <form name="frm1" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" value="<?php echo $sel_caller[0]['name'] ?>" required />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" value="<?php echo $sel_caller[0]['email'] ?>" required />
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" type="text" name="phone" value="<?php echo $sel_caller[0]['phone'] ?>" />
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" name="message"><?php echo $sel_caller[0]['message'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">Select</option>
                                <option value="Active" <?php if ($sel_caller[0]['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                <option value="Inactive" <?php if ($sel_caller[0]['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                        <input type="submit" name="update" class="btn btn-primary" value="Submit" />
                        <button type="reset" class="btn btn-default">Reset</button>
                    </form>
                    <?php } else { ?>
                      <p><strong>Only Admin can edit or add records.</strong></p>
                      <table class="table table-bordered">
                        <tr><th>Name</th><td><?php echo htmlspecialchars($sel_caller[0]['name']); ?></td></tr>
                        <tr><th>Email</th><td><?php echo htmlspecialchars($sel_caller[0]['email']); ?></td></tr>
                        <tr><th>Phone</th><td><?php echo htmlspecialchars($sel_caller[0]['phone']); ?></td></tr>
                        <tr><th>Message</th><td><?php echo htmlspecialchars($sel_caller[0]['message']); ?></td></tr>
                        <tr><th>Status</th><td><?php echo htmlspecialchars($sel_caller[0]['status']); ?></td></tr>
                      </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
