<?php 
include_once("inc/header.php");
include_once("com/Admin.php");
include_once("inc/checksession.inc.php");

$temp = new Admin();

$action = $_REQUEST["action"];
$id = isset($_REQUEST['id']) ? siteDecrypt($_REQUEST['id']) : '';

$adminData = [
    "username" => "",
    "email" => "",
    "admin_type" => "",
    "status" => "",
    "category" => "0",
    "password" => ""
];

if ($action == 'edit' && $id) {
    $record = $db->fetchAssoc($db->fireQuery("SELECT * FROM `admin` WHERE id = '$id'"));
    if ($record) {
        $adminData = $record[0];
    }
}

// Save data on submit
if (isset($_POST['save'])) {
    $temp->updateAdmin($_POST);
}

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= ($action == 'add') ? 'Add New Admin' : 'Edit Admin'; ?>
    </div>

    <div class="panel-body">
        <form method="post" action="">
            <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" value="<?= $adminData['username']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" value="<?= $adminData['email']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input name="password" type="text" value="<?= $adminData['password']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Admin Type</label>
                <select name="admin_type" class="form-control">
                    <option value="Admin" <?= ($adminData['admin_type'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Editor" <?= ($adminData['admin_type'] == 'Editor') ? 'selected' : ''; ?>>Editor</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Active" <?= ($adminData['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?= ($adminData['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <input type="hidden" name="category" value="0">

            <button type="submit" name="save" class="btn btn-primary">Save</button>
            <a href="admin-mgmt.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
