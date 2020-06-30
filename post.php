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
                        <h6>Leave us a comment below...</h6>
                        <div class="row block-9">
                            <div class="col-lg-12">
                                <form action="/cms/post/<?php echo $_GET['p_id'] ?>" class="bg-light p-5 contact-form"
                                      method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name"
                                               name="comment_author" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Email"
                                               name="comment_email" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="comment_content" id="" cols="30" rows="7" class="form-control"
                                                  placeholder="Comment"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary py-3 px-5" name="create_comment">
                                        Submit
                                    </button>
                                </form>

                            </div>

                        </div>
                        <hr>
                        <!--                    End Commenting feature-->
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
                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="media-heading"><?php echo $comment_author ?>
                                            <small><?php echo date("F jS, Y", strtotime($comment_date)) ?></small>
                                        </h6>

                                        <?php echo $comment_content; ?>
                                    </div>
                                </div>
                                <hr>

                                <?php
                            }
                        }
                        ?>
                    </div>
<!--                    End comments-->
                    </div>
        </section>
    </div><!-- END COLORLIB-MAIN -->
    </div><!-- END COLORLIB-PAGE -->

<?php include 'includes/footer.php'; ?>