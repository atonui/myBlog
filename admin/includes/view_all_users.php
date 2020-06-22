<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date Created</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $users_query = "SELECT * FROM users ORDER BY user_id DESC";
    $results = mysqli_query($connection, $users_query);

    while ($row = mysqli_fetch_assoc($results)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_first_name = $row['user_firstname'];
        $user_last_name = $row['user_lastname'];
        $user_email = $row['user_email'];
        $role = $row['role'];
        $date_created = $row['date_created'];

        echo "<tr>";
        ?>

        <td><?php echo $user_id ?></td>
        <td><?php echo $username ?></td>
        <td><?php echo $user_first_name ?></td>
        <td><?php echo $user_last_name ?></td>
        <td><?php echo $user_email ?></td>
        <td><?php echo ucwords($role) ?></td>
        <td><?php echo $date_created ?></td>
        <td><a href="users.php?source=edit_user&id=<?php echo $user_id ?>">Edit</a> </td>
        <td><a onclick="javascript: return confirm('Are you sure you want to delete?')" href="users.php?delete=<?php echo $user_id ?>">Delete</a> </td>

        <?php
    }
    echo "</tr>";
    ?>
    </tbody>
</table>

<?php

//delete users
if (isset($_GET['delete'])) {
    if ($_SESSION['user_role'] == 'administrator') {
        $user_id = mysqli_real_escape_string($connection, $_GET['delete']);

        $sql = "DELETE FROM users WHERE user_id = $user_id";

        $results = mysqli_query($connection, $sql);

        confirmQuery($results);

        header('location:users.php');
    }else{
        echo "<p class='alert alert-warning'>Illegal Operation!</p>";
    }
}

?>