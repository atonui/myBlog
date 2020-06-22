<?php
if (isset($_POST['create_user'])) {
    $firstname = cleanData($_POST['user_firstname']);
    $lastname = cleanData($_POST['user_lastname']);
    $username = cleanData($_POST['username']);
    $email = cleanData($_POST['user_email']);
    $role = cleanData($_POST['role']);

    $user_image = $_FILES['user_image']['name'];
    $user_image = cleanData($user_image);
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    $password = $_POST['user_password'];

//    hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users`(username, user_password, user_firstname, user_lastname, user_email, user_image, role) VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$user_image','$role')";

    if (!mysqli_query($connection, $sql)) {
        die("Query failed ". mysqli_error($connection));
    } else {
        move_uploaded_file($user_image_temp, "../images/$user_image");
        echo "<div class='alert alert-primary' role='alert'>
                <a href=',/users.php'>User Created</a>
            </div>";
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <label>Role</label><br>
        <select name="role">
            <option value="subscriber">Select Role</option>
            <option value="administrator">Administrator</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label>Profile Picture</label>
        <input type="file" class="form-control" name="user_image">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>