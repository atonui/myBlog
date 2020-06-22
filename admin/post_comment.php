<?php include 'includes/admin_header.php' ?>
    <div id="wrapper">

    <!-- Navigation -->
<?php
    include 'includes/admin_navigation.php';
    if (isset($_GET['id']) && isset($_GET['title'])){
        $post_id = $_GET['id'];
        $post_title  = $_GET['title'];
    }
?>
    <div id="page-wrapper">

    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Comments for:
                    <small>
                        <?php echo $post_title ?>
                    </small>
                </h1>
                <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Disapprove</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $posts_query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $results = mysqli_query($connection, $posts_query);

                    while ($row = mysqli_fetch_assoc($results)) {
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_email = $row['comment_email'];
                        $comment_content = $row['comment_content'];
                        $comment_status = $row['comment_status'];

                        echo "<tr>";
                        ?>

                        <td><?php echo $comment_id ?></td>
                        <td><?php echo $comment_author ?></td>
                        <td><?php echo $comment_content ?></td>
                        <td><?php echo $comment_email ?></td>
                        <td><?php echo $comment_status ?></td>
                        <td><?php echo $comment_date ?></td>
                        <td><a href="post_comment.php?approve=<?php echo $comment_id ?>&id=<?php echo $post_id ?>&title=<?php echo $post_title ?>">Approve</a> </td>
                        <td><a href="post_comment.php?unapprove=<?php echo $comment_id ?>&id=<?php echo $post_id ?>&title=<?php echo $post_title ?>">Disapprove</a> </td>
                        <td><a onclick="javascript: return confirm('Are you sure you want to delete?')" href="comment.php?delete=<?php echo $comment_id ?>&p_id=<?php echo $comment_post_id?>&id=<?php echo $post_id ?>&title=<?php echo $post_title ?>">Delete</a> </td>

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
                        //echo "<p class='alert alert-success'>Comment disapproved!</p>";
                        header('location:post_comment.php?id='.$post_id.'&title='.$post_title);
                    }
                }

                //approve comments
                if (isset($_GET['approve'])) {
                    $comment_id = $_GET['approve'];

                    $sql = "UPDATE comments SET comment_status= 'Approved' WHERE comment_id = $comment_id";

                    if (!mysqli_query($connection, $sql)) {
                        die("Query failed " . mysqli_error($connection));
                    }else{
                        header('location:post_comment.php?id='.$post_id.'&title='.$post_title);
                    }
                }
                //delete comments
                if (isset($_GET['delete'])) {
                    $comment_id = $_GET['delete'];

                    $sql = "DELETE FROM comments WHERE comment_id = $comment_id";

                    if (!mysqli_query($connection, $sql)) {
                        die("Query failed " . mysqli_error($connection));
                    } else {
                        echo "<p class='alert alert-warning'>Comment deleted!</p>";;
                    }
                }
                ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php'; ?>