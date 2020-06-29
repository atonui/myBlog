<?php
require 'includes/db.php';
include 'includes/header.php';
include 'admin/functions.php';

$username_err = $password_err = '';

if (isset($_POST['submit'])) {

    if (isset($_POST['username'])) {
        $username = cleanData($_POST['username']);
    } else {
        $username_err = 'Please fill in your username';
    }

    if (isset($_POST['password'])) {
        $password = cleanData($_POST['password']);
    } else {
        $password_err = 'Please fill in your password';
    }

    $sql = "SELECT * FROM users WHERE `username` = '$username'";
    $results = mysqli_query($connection, $sql);
    confirmQuery($results);

    if (mysqli_num_rows($results) > 0) {

        while ($row = mysqli_fetch_assoc($results)) {
            $user_id = $row['user_id'];
            $firstname = $row['user_firstname'];
            $lastname = $row['user_lastname'];
            $email = $row['user_email'];
            $role = $row['role'];
            $user_image = $row['user_image'];
            $password_hash = $row['user_password'];
        }
        if (password_verify($password, $password_hash)) { //if passwords match, login user
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $role;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            header('location:/cms/admin');
        } else {
//        header('location:/cms/index');
            $password_err = "Incorrect password!";
        }
    } else {
        $username_err = "Incorrect username!";
    }
    }
?>
<div id="colorlib-main">
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-xl-8 px-md-5 py-5">
                    <div class="row pt-md-4">
                        <div class="col-xs-6 col-xs-offset-3">
                            <form class="colorlib-subscribe-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                                <div class="form-group">
                                    <label for="username" class="sr-only">Username</label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $username_err ?></small>
                                    <input type="text" name="username" id="username" class="form-control"
                                           placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $password_err ?></small>
                                    <input type="password" name="password" id="key" class="form-control"
                                           placeholder="Password" required>
                                </div>
                                <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>