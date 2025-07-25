<?php
include_once("inc/header.php");
include_once("com/User.php");
include_once("com/PS_Pagination.php");
include_once("inc/checksession.inc.php");

$sel_adm = [];

if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit') {
    $rec_id = siteDecrypt($_REQUEST["id"]);
    $sel_adm = $db->fetchAssoc($db->fireQuery("SELECT * FROM `user` WHERE id='$rec_id'"));
    if (empty($sel_adm)) {
        $_SESSION['errormsg'] = '⚠️ No user found for the given ID.';
    }
}


if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'add') {
    $sel_adm[0] = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'age' => '',
        'dob' => '',
        'gender' => '',
        'address' => '',
        'city' => '',
        'pincode' => '',
        'state' => '',
        'country' => '',
        'sum_insured' => '',
        'panno' => '',
        'aadharno' => '',
        'password' => '',
        'pan' => '',
        'aadhar' => '',
        'aadharback' => ''
    ];
}

if (isset($_POST["update"])) {
    $temp = new User();
    $temp->updatePhoto($_POST); 
}


?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <?= ($_REQUEST["action"] == 'edit') ? "Edit User" : "Add New User" ?>
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

            <div class="panel-body">

                <?php if (!empty($sel_adm)) : ?>
                    <!--  USER FORM -->
                    <!--  USER FORM (MINIMAL FIELDS ADDED) -->
                    <form method="post">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td><input type="text" name="name" value="<?= htmlspecialchars($sel_adm[0]['name']) ?>" required></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="email" name="email" value="<?= htmlspecialchars($sel_adm[0]['email']) ?>" required></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" name="phone" value="<?= htmlspecialchars($sel_adm[0]['phone']) ?>" required></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="text" name="password" value="<?= htmlspecialchars($sel_adm[0]['password']) ?>" required></td>
                            </tr>

                            <!--  ONLY MINIMAL FIELDS ADDED -->
                            <tr>
                                <th>Age</th>
                                <td><input type="number" name="age" value="<?= htmlspecialchars($sel_adm[0]['age']) ?>"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" name="address" value="<?= htmlspecialchars($sel_adm[0]['address']) ?>"></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <button type="submit" name="update" class="btn btn-primary">
                                        <?= ($_REQUEST["action"] == 'edit') ? "Update User" : "Add User" ?>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <!--  SHOW USER DETAILS ONLY FOR EDIT -->
                    <?php if ($_REQUEST["action"] == 'edit'): ?>
                        <h4>User Details</h4>
                        <table class="table table-striped">
                            <tr><th>Name</th><td><?= $sel_adm[0]['name'] ?></td></tr>
                            <tr><th>Email</th><td><?= $sel_adm[0]['email'] ?></td></tr>
                            <tr><th>Phone</th><td><?= $sel_adm[0]['phone'] ?></td></tr>
                            <tr><th>Age</th><td><?= $sel_adm[0]['age'] ?></td></tr>
                            <tr><th>DOB</th><td><?= $sel_adm[0]['dob'] ?></td></tr>
                            <tr><th>Gender</th><td><?= $sel_adm[0]['gender'] ?></td></tr>
                            <tr><th>Address</th><td><?= $sel_adm[0]['address'] ?></td></tr>
                            <tr><th>City</th><td><?= $sel_adm[0]['city'] . ' ' . $sel_adm[0]['pincode'] ?></td></tr>
                            <tr><th>State</th><td><?= $sel_adm[0]['state'] ?></td></tr>
                            <tr><th>Country</th><td><?= $sel_adm[0]['country'] ?></td></tr>
                            <tr><th>Sum Insured</th><td><?= $sel_adm[0]['sum_insured'] ?></td></tr>
                            <tr><th>Pan No</th><td><?= $sel_adm[0]['panno'] ?></td></tr>
                            <tr><th>Aadhar No</th><td><?= $sel_adm[0]['aadharno'] ?></td></tr>
                            <tr><th>Pan Photo</th><td><img src="uploads/user/<?= $sel_adm[0]['pan'] ?>" style="width:150px;"></td></tr>
                            <tr><th>Aadhar Front</th><td><img src="uploads/user/<?= $sel_adm[0]['aadhar'] ?>" style="width:150px;"></td></tr>
                            <tr><th>Aadhar Back</th><td><img src="uploads/user/<?= $sel_adm[0]['aadharback'] ?>" style="width:150px;"></td></tr>
                        </table>

                        <!--  BOOKINGS -->
                        <h5>Bookings</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S no.</th><th>Plan Name</th><th>Date</th><th>Amount</th>
                                    <th>Tax</th><th>Total</th><th>Method</th><th>Invoice</th><th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bookings = $db->fetchAssoc($db->fireQuery("SELECT b.*, m.name AS pname FROM booking b JOIN membership m ON b.serviceid=m.id WHERE b.userid='" . $sel_adm[0]['id'] . "' ORDER BY b.id DESC"));
                                if (!empty($bookings)) {
                                    foreach ($bookings as $i => $b) {
                                        echo "<tr>
                                            <td>" . ($i + 1) . "</td>
                                            <td>{$b['pname']}</td>
                                            <td>{$b['date']}</td>
                                            <td>₹ {$b['amount']}</td>
                                            <td>₹ {$b['tax']}</td>
                                            <td>₹ " . (floatval($b['amount']) + floatval($b['tax'])) . "</td>
                                            <td>{$b['method_type']} | {$b['promocode']}</td>
                                            <td><a href='bill.php?action=view&id={$b['id']}'>Invoice</a></td>
                                            <td><a href='certificate.php?action=view&id={$b['id']}'>Certificate</a></td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>No bookings found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!--  REFERRALS -->
                        <h5>Referred By Me</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Name</th><th>Phone</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                $refers = $db->fetchAssoc($db->fireQuery("SELECT * FROM user WHERE refereal='" . $sel_adm[0]['phone'] . "' ORDER BY id DESC"));
                                if (!empty($refers)) {
                                    foreach ($refers as $ref) {
                                        echo "<tr>
                                            <td>{$ref['name']}</td>
                                            <td>{$ref['phone']}</td>
                                            <td>
                                                <a href='add-edit-user.php?action=edit&id=" . siteEncrypt($ref['id']) . "'>
                                                    <img src='images/edit_icon.png' alt='Edit' />
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No referrals found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="alert alert-warning">⚠️ No user found for the given ID.</div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
