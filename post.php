<?php
include 'includes/header.php';
?>
    <div id="colorlib-main">
        <section class="ftco-section ftco-no-pt ftco-no-pb">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-xl-8 px-md-5 py-5">
                        <div class="row pt-md-4">
                            <!--                Blog entries-->
                            <?php
                            if (isset($_GET['p_id'])) {
                                $post_id = $_GET['p_id'];
                                //                update the views on the post
                                $views_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                                $views_results = mysqli_query($connection, $views_query);

                                confirmQuery($views_results);

                                $comment_count_query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                                $comment_count = mysqli_query($connection, $comment_count_query);
                                $post_comment_count = mysqli_num_rows($comment_count);

                                $sql = "SELECT * FROM posts WHERE post_id = $post_id";

                                $results = mysqli_query($connection, $sql);
                                while ($row = mysqli_fetch_assoc($results)) {
                                    $post_title = $row['post_title'];
                                    $post_author = $row['post_author'];
                                    $post_image = $row['post_image'];
                                    $post_content = $row['post_content'];
                                    $post_date = $row['post_date'];
                                    $post_author_id = $row['post_author_id'];
                                    $post_views = $row['post_views_count'];
                                    $post_likes = $row['likes'];

                                    $author_sql = "SELECT * FROM users WHERE user_id = $post_author_id";
                                    $image_results = mysqli_query($connection, $author_sql);
                                    while ($image_row = mysqli_fetch_assoc($image_results)) {
                                        $author_image = $image_row['user_image'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="blog-entry-2 ftco-animate">
                                            <a href="single.html" class="img"
                                               style="background-image: url(/cms/images/<?php echo $post_image ?>);"></a>
                                            <div class="text pt-4">
                                                <h3 class="mb-4"><a
                                                            href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                                                </h3>
                                                <div class="author mb-4 d-flex align-items-center">
                                                    <a href="#" class="img"
                                                       style="background-image: url(/cms/images/<?php echo $author_image ?>);"></a>
                                                    <div class="ml-3 info">
                                                        <span>Written by</span>
                                                        <h3>
                                                            <a href="/cms/author_posts/<?php echo $post_author_id; ?>"><?php echo $post_author ?></a>,
                                                            <span><?php echo date("F jS, Y", strtotime($post_date)) ?>, &nbsp;<span><i
                                                                            class="icon-eye"></i> <?php echo $post_views ?> views</span></span>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <p class="mb-4"><?php echo $post_content ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                header("location:index.php");
                            }
                            ?>
                            <!--                End of articles-->
                        </div>
                        <!--                    Comments-->
                        <div class="pt-5 mt-5">
                            <h3 class="mb-5 font-weight-bold"><?php echo $post_comment_count; ?> Comments</h3>

                        <?php
                        // inserting comments to db
                        if (isset($_POST['create_comment'])) {
                            $post_comment_id = cleanData($_GET['p_id']);
                            $comment_author = cleanData($_POST['comment_author']);
                            $comment_email = cleanData($_POST['comment_email']);
                            $comment_content = cleanData($_POST['comment_content']);

                            if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                $comment_author = $_POST['comment_author'];
                                $comment_email = $_POST['comment_email'];
                                $comment_content = $_POST['comment_content'];

                                $sql = "INSERT INTO comments (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`) VALUES (NULL, $post_comment_id, '$comment_author','$comment_email','$comment_content')";
                                $results = mysqli_query($connection, $sql);
                                confirmQuery($results);
                            } else {
                                echo "<script>alert('Fields Cannot be empty')</script>";
                            }
                        }
                        ?>
                        <!--                        Begin comments-->
                        <?php
                        if (isset($_GET['p_id'])) {
                            $post_id = $_GET['p_id'];

                            $sql = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'Approved' ORDER BY comment_id DESC ";

                            $results = mysqli_query($connection, $sql);
                            confirmQuery($results);

                            while ($row = mysqli_fetch_assoc($results)) {
                                $comment_author = $row['comment_author'];
                                $comment_content = $row['comment_content'];
                                $comment_date = $row['comment_date'];

                                ?>

                                <!-- Comment -->
                                <ul class="comment-list">
                                    <li class="comment">
                                        <div class="comment-body">
                                            <h3><?php echo $comment_author ?></h3>
                                            <div class="meta"><?php echo date("F jS, Y", strtotime($comment_date)) ?></div>
                                            <p><?php echo $comment_content; ?></p>
                                            <p><a href="#" class="reply">Reply</a></p>
                                        </div>
                                    </li>
                                </ul>


                                <?php
                            }
                        }
                        ?>
                            <!-- END comment-list -->


                            <div class="comment-form-wrap pt-5">
                                <h3 class="mb-5">Leave a comment</h3>
                                <form action="/cms/post/--><?php echo $_GET['p_id'] ?>" class="p-3 p-md-5 bg-light" method="post">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" id="name" name="comment_author">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" class="form-control" id="email" name="comment_email">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea name="comment_content" id="message" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Post Comment" class="btn py-3 px-4 btn-primary" name="create_comment">
                                    </div>

                                </form>
                            </div>
                            <hr>
                        </div>




                        <!--                    End Commenting feature-->

                    </div>
<!--                    End comments-->
                    </div>
        </section>
    </div><!-- END COLORLIB-MAIN -->
    </div><!-- END COLORLIB-PAGE -->

<?php include 'includes/footer.php'; ?>