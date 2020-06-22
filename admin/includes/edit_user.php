<?php
//grab data from the URL using GET

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

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
        $firstname = cleanData($_POST['user_firstname']);
        $lastname = cleanData($_POST['user_lastname']);
        $username = cleanData($_POST['username']);
        $email = cleanData($_POST['user_email']);
        $role = cleanData($_POST['role']);

        $user_image = $_FILES['user_image']['name'];
        $user_image = cleanData($user_image);
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
            header('location:users.php');
        } else {
            die("Query failed " . mysqli_error($connection));
        }

    }
}

?>
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
        <label>Change Role</label><br>
        <select name="role">
            <?php
                if ($role == 'administrator'){
                    ?>
                    <option value="<?php echo $role?>">Administrator</option>
                    <option value="subscriber">Subscriber</option>
            <?php
                }else{
                    ?>
                    <option value="<?php echo $role?>">Subscriber</option>
                    <option value="administrator">Administrator</option>
                <?php
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $user_image; ?>">
    </div>
    <div class="form-group">
        <label>Profile Picture</label>
        <input type="file" class="form-control" name="user_image" value="<?php echo $user_image?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>