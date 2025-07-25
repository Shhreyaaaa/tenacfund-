<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['userdetail']) || !is_array($_SESSION['userdetail'])) {
    header("Location: login.php");
    exit;
}

include_once 'includes/header.php';
include_once("secure_panel/com/sqlConnection.php");

$db = new sqlConnection();
$user = $_SESSION['userdetail'][0];

$msg = "";

// On form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $age = $_POST['age'];


    $update = $db->fireQuery("
        UPDATE user 
        SET name = '$name', phone = '$phone', address = '$address', age = '$age' 
        WHERE id = '" . $user['id'] . "'
    ");

    if ($update) {
        // Fetch updated data and refresh session
        $updatedUser = $db->fetchAssoc($db->fireQuery("SELECT * FROM user WHERE id = '" . $user['id'] . "'"));
        $_SESSION['userdetail'] = $updatedUser;
        $user = $updatedUser[0];
        $msg = "<div class='alert alert-success'>Profile updated successfully.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Failed to update profile. Please try again.</div>";
    }
}
?>

<div class="container mt-5">
  <br><br>
    <h3>Edit Profile</h3>
    <?php echo $msg; ?>
    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
        </div>
        <br>
        <div class="form-group">
            <label>Email (read-only)</label>
            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" readonly>
        </div>
        <br>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="form-control" required>
        </div>
        <br>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>
        <br>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" class="form-control" required>
        </div>
        <br>
        <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
        <br><br>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>
