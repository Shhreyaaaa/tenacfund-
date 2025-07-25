<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required files
include_once("com/sqlConnection.php");
include_once("com/Admin.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");
include_once("inc/header.php");

// DB connection
$db = new sqlConnection();

// Fetch logged-in admin details
$sel_uname = $db->fetchAssoc(
    $db->fireQuery("SELECT * FROM `admin` WHERE id = " . $_SESSION["user_id"])
);

// Password change logic
if (isset($_POST["change"])) {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation
    if ($new_password !== $confirm_password) {
        $_SESSION['errormsg'] = "New and confirm passwords do not match.";
        header("Location: change-password.php");
        exit;
    }

    $current = $sel_uname[0]['password'];

    if ($old_password !== $current) {
        $_SESSION['errormsg'] = "Old password is incorrect.";
        header("Location: change-password.php");
        exit;
    }

    // Update password
    $update = $db->fireQuery("UPDATE admin SET password = '$new_password' WHERE id = " . $_SESSION["user_id"]);

    if ($update) {
        session_unset();
        session_destroy();

        // Handle redirect based on host
        $host = $_SERVER['HTTP_HOST'];
        $basePath = (strpos($host, 'localhost') !== false)
            ? "http://$host/my_project/secure_panel/index.php"
            : "https://$host/secure_panel/index.php";

        header("Location: {$basePath}?msg=" . urlencode("Password changed successfully"));
        exit;
    } else {
        $_SESSION['errormsg'] = "Failed to update password. Try again.";
        header("Location: change-password.php");
        exit;
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Change Password</div>

            <div class="errordiv">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo '<div class="alert alert-success" style="cursor:pointer">' . $_SESSION['msg'] . '</div>';
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['errormsg'])) {
                    echo '<div class="alert alert-danger" style="cursor:pointer">' . $_SESSION['errormsg'] . '</div>';
                    unset($_SESSION['errormsg']);
                }
                ?>
            </div>

            <div class="panel-body">
                <div class="row">
                    <form role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>User Name</label>
                            <input class="form-control" type="text" name="username" readonly value="<?php echo htmlspecialchars($sel_uname[0]['username']); ?>" />
                        </div>
                        <div class="form-group">
                            <label>Old Password</label>
                            <input class="form-control" type="password" name="old_password" required />
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" type="password" name="new_password" required />
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" type="password" name="confirm_password" required />
                        </div>
                        <input type="submit" name="change" class="btn btn-primary" value="Submit" />
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
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
