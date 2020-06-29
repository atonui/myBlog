<?php
include 'includes/header.php';
include 'includes/db.php';
include 'admin/functions.php';
?>
<div id="colorlib-main">
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-xl-8 px-md-5 py-5">
                    <div class="row pt-md-4">
                        <!--                Blog entries-->
                        <?php
                        if (isset($_GET['author_id'])) {
                            $author_id = $_GET['author_id'];

                            $sql = "SELECT * FROM posts WHERE post_author_id = $author_id";

                            $results = mysqli_query($connection, $sql);
                            while ($row = mysqli_fetch_assoc($results)) {
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'], 0, 200);
                                $post_date = $row['post_date'];
                                $post_views = $row['post_views_count'];
                                $post_likes = $row['likes'];
                                $post_id = $row['post_id'];

                                $author_sql = "SELECT * FROM users WHERE user_id = $author_id";
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
                                            <h3 class="mb-4"><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a></h3>
                                            <div class="author mb-4 d-flex align-items-center">
                                                <a href="#" class="img"
                                                   style="background-image: url(/cms/images/<?php echo $author_image ?>);"></a>
                                                <div class="ml-3 info">
                                                    <span>Written by</span>
                                                    <h3><a href="/cms/author_posts/<?php echo $author_id; ?>"><?php echo $post_author ?></a>,
                                                        <span><?php echo date("F jS, Y", strtotime($post_date)) ?>, &nbsp;<span><i
                                                                    class="icon-eye"></i> <?php echo $post_views?> views</span></span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <p class="mb-4"><?php echo $post_content ?></p>
                                            <div class="half">
                                                <p><a href="/cms/post/<?php echo $post_id; ?>" class="btn btn-primary p-3 px-xl-4 py-xl-3">Continue
                                                        Reading</a></p>
                                            </div>
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
                </div>
            </div>
        </div>
    </section>
</div><!-- END COLORLIB-MAIN -->
</div><!-- END COLORLIB-PAGE -->

<?php include 'includes/footer.php'; ?>