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
                                            <h3 class="mb-4"><a href="#"><?php echo $post_title ?></a></h3>
                                            <div class="author mb-4 d-flex align-items-center">
                                                <a href="#" class="img"
                                                   style="background-image: url(/cms/images/<?php echo $author_image ?>);"></a>
                                                <div class="ml-3 info">
                                                    <span>Written by</span>
                                                    <h3><a href="/cms/author_posts/<?php echo $post_author_id; ?>"><?php echo $post_author ?></a>,
                                                        <span><?php echo date("F jS, Y", strtotime($post_date)) ?>, &nbsp;<span><i
                                                                        class="icon-eye"></i> <?php echo $post_views?> views</span></span>
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
                </div>
            </div>
            <!--            <div class="row">-->
            <!--                <div class="col text-center text-md-left">-->
            <!--                    <div class="block-27">-->
            <!--                        <ul>-->
            <!--                            <li><a href="#">&lt;</a></li>-->
            <!--                            <li class="active"><span>1</span></li>-->
            <!--                            <li><a href="#">2</a></li>-->
            <!--                            <li><a href="#">3</a></li>-->
            <!--                            <li><a href="#">4</a></li>-->
            <!--                            <li><a href="#">5</a></li>-->
            <!--                            <li><a href="#">&gt;</a></li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
    </section>
</div><!-- END COLORLIB-MAIN -->
</div><!-- END COLORLIB-PAGE -->

<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00"/>
    </svg>
</div>


<script src="/cms/js/jquery.min.js"></script>
<script src="/cms/js/jquery-migrate-3.0.1.min.js"></script>
<script src="/cms/js/popper.min.js"></script>
<script src="/cms/js/bootstrap.min.js"></script>
<script src="/cms/js/jquery.easing.1.3.js"></script>
<script src="/cms/js/jquery.waypoints.min.js"></script>
<script src="/cms/js/jquery.stellar.min.js"></script>
<script src="/cms/js/owl.carousel.min.js"></script>
<script src="/cms/js/jquery.magnific-popup.min.js"></script>
<script src="/cms/js/aos.js"></script>
<script src="/cms/js/jquery.animateNumber.min.js"></script>
<script src="/cms/js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="/cms/js/google-map.js"></script>
<script src="/cms/js/main.js"></script>

</body>
</html>