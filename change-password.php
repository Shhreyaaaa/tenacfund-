<?php
session_start();

if (!isset($_SESSION['userdetail']) || !is_array($_SESSION['userdetail'])) {
    header("Location: login.php");
    exit;
}

include_once 'includes/header.php';
include_once("secure_panel/com/sqlConnection.php");

$db = new sqlConnection();
$user = $_SESSION['userdetail'][0];

$msg = "";
$showSuccessAlert = false; // Flag to trigger JS alert

if (isset($_POST['change'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $msg = "<div class='alert alert-danger'>New password and confirm password do not match.</div>";
    } else {
        $sel = $db->fetchAssoc($db->fireQuery("SELECT password FROM user WHERE id = '" . $user['id'] . "'"));
        $current = $sel[0]['password'];

        if ($old !== $current) {
            $msg = "<div class='alert alert-danger'>Old password is incorrect.</div>";
        } else {
            $update = $db->fireQuery("UPDATE user SET password = '$new' WHERE id = '" . $user['id'] . "'");
            if ($update) {
                session_unset();
                session_destroy();
                $showSuccessAlert = true; //  Trigger the JS alert
            } else {
                $msg = "<div class='alert alert-danger'>Failed to update password. Try again.</div>";
            }
        }
    }
}
?>

<div class="container mt-5">
    <br><br>
    <h3>Change Password</h3>
    <?php echo $msg; ?>
    <form method="POST">
        <div class="form-group">
            <label>Old Password</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        <br>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <br>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <br>
        <button type="submit" name="change" class="btn btn-primary">Update Password</button>
        <br><br>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>

<!--  Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($showSuccessAlert): ?>
<script>
    Swal.fire({
        title: 'Success!',
        text: 'Password changed successfully. Please login again.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'login.php';
        }
    });
</script>
<?php endif; ?>
