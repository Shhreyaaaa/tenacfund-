<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'com/sqlConnection.php';
$db = new sqlConnection();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <!-- BOOTSTRAP STYLES -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES -->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <br /><br />
            <h2>Welcome to Admin Panel</h2>
            <h5>( Login yourself to get access )</h5>
            <br />
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Enter Details To Login</strong>
                </div>

                <?php
                if (isset($_POST['login'])) {
                    $username = trim($_POST['email']);
                    $password = trim($_POST['password']);

                    if ($username == "" || $password == "") {
                        $_SESSION['msg'] = "Email & Password must not be blank.";
                    } else {
                        $result = $db->fireQuery("SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'");
                        if ($rows = $db->fetchAssoc($result)) {
                            $_SESSION['user_id'] = $rows[0]['id'];
                            $_SESSION['category'] = $rows[0]['category'];
                            $_SESSION['username'] = $rows[0]['username'];
                            $_SESSION['admin-type'] = $rows[0]['admin_type'];
                            $_SESSION['email'] = $rows[0]['email'];
                            header("Location: welcome.php");
                            exit;
                        } else {
                            $_SESSION['msg'] = "Wrong Email or Password";
                        }
                    }
                }
                ?>

                <div class="panel-body">
                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success" style="cursor:pointer"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['msg'])): ?>
                        <div class="alert alert-danger" style="cursor:pointer"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
                    <?php endif; ?>

                    <form role="form" method="post" action="">
                        <br />
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" name="email" class="form-control" placeholder="Your Email" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Your Password" required />
                        </div>
                        <input type="submit" name="login" value="Login Now" class="btn btn-primary" />
                        <hr />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS - AT THE BOTTOM TO REDUCE LOAD TIME -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
