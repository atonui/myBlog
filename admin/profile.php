<?php
include 'includes/admin_header.php';

if (!isset($_SESSION['username'])){
    header('location:../index.php');
}
    $user_id = $_SESSION['user_id'];

    $users_query = "SELECT * FROM users WHERE user_id = $user_id";
    $results = mysqli_query($connection, $users_query);

    while ($row = mysqli_fetch_assoc($results)) {
        $firstname = $row['user_firstname'];
        $lastname = $row['user_lastname'];
        $username = $row['username'];
        $email = $row['user_email'];
        $user_image = $row['user_image'];
        $role = $row['role'];
    }


    if (isset($_POST['update_user'])) {
        $firstname = $_POST['user_firstname'];
        $lastname = $_POST['user_lastname'];
        $username = $_POST['username'];
        $email = $_POST['user_email'];
        $role = $_POST['role'];

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];

        if (empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = $user_id";
            $select_image = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_image)) {
                $user_image = $row['user_image'];
            }
        }

        $update_query = "UPDATE users SET username = '$username', user_firstname = '$firstname', user_lastname = '$lastname', user_email = '$email', user_image = '$user_image', role = '$role' WHERE user_id = $user_id";

        if (mysqli_query($connection, $update_query)) {
            move_uploaded_file($user_image_temp, "../images/$user_image");
            header('location:profile.php');
        } else {
            die("Query failed " . mysqli_error($connection));
        }

    }


?>
    <div id="wrapper">

    <!-- Navigation -->
<?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Profile Page
                    <small><?php echo $_SESSION['firstname']; ?></small>
                </h1>

            </div>
            <!-- /.row -->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="user_firstname" value="<?php echo $firstname?>">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="user_lastname" value="<?php echo $lastname?>">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $username?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="user_email" value="<?php echo $email?>">
                </div>
                <div class="form-group">
                    <label>Role</label><br>
                    <?php echo ucwords($role); ?>
                </div>
                <div class="form-group">
                    <img width="100" src="../images/<?php echo $user_image; ?>">
                </div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" class="form-control" name="user_image" value="<?php echo $user_image?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
                </div>
            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php'; ?>