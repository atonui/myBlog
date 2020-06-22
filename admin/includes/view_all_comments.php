<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapproved</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $posts_query = "SELECT * FROM comments";
    $results = mysqli_query($connection, $posts_query);

    while ($row = mysqli_fetch_assoc($results)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_date = $row['comment_date'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];

        $select_post_query = "SELECT * FROM posts WHERE post_id = '$comment_post_id' ";

        $post_results = mysqli_query($connection, $select_post_query);

        while ($rows = mysqli_fetch_assoc($post_results)) {
            $post_title = $rows['post_title'];
            $post_id = $rows['post_id'];
        }

        echo "<tr>";
        ?>

        <td><?php echo $comment_id ?></td>
        <td><?php echo $comment_author ?></td>
        <td><?php echo $comment_content ?></td>
        <td><?php echo $comment_email ?></td>
        <td><?php echo $comment_status ?></td>
        <td><a href="../post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a> </td>
        <td><?php echo $comment_date ?></td>
        <td><a href="comments.php?approve=<?php echo $comment_id ?>">Approve</a> </td>
        <td><a href="comments.php?unapprove=<?php echo $comment_id ?>">Unapproved</a> </td>
        <td><a onclick="javascript: return confirm('Are you sure you want to delete?')" href="comments.php?delete=<?php echo $comment_id ?>&p_id=<?php echo $comment_post_id?>">Delete</a> </td>

        <?php
    }
    echo "</tr>";
    ?>
    </tbody>
</table>

<?php
//disapprove comments
if (isset($_GET['unapprove'])) {
    $comment_id = $_GET['unapprove'];

    $sql = "UPDATE comments SET comment_status= 'Unapproved' WHERE comment_id = $comment_id";

    if (!mysqli_query($connection, $sql)) {
        die("Query failed " . mysqli_error($connection));
    } else {
        header('location:comments.php');
    }
}

//approve comments
if (isset($_GET['approve'])) {
    $comment_id = $_GET['approve'];

    $sql = "UPDATE comments SET comment_status= 'Approved' WHERE comment_id = $comment_id";

    if (!mysqli_query($connection, $sql)) {
        die("Query failed " . mysqli_error($connection));
    } else {
        header('location:comments.php');
    }
}
//delete comments
if (isset($_GET['delete'])) {
    $comment_id = $_GET['delete'];

    $sql = "DELETE FROM comments WHERE comment_id = $comment_id";

    if (!mysqli_query($connection, $sql)) {
        die("Query failed " . mysqli_error($connection));
    } else {
        $post_comment_id = $_GET['p_id'];
//        update the comment count in the posts table after deleting a comment
        $query = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = $post_comment_id ";
        $results = mysqli_query($connection, $query);
        confirmQuery($results);

        header('location:comments.php');
    }
}
?>