<?php
include 'includes/header.php';
include 'includes/db.php';
include 'admin/functions.php';

if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    if ($message == 'registered') {
        echo "<p class='alert alert-success'>Your are already registered, please login here!</p>";
    }
    if ($message == 'inserted') {
        echo "<p class='alert alert-success'>You have been registered, please login here!</p>";
    }
}
//pagination code
$per_page = 5; //create button for results per page

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "";
}

if ($page == "" || $page == 1) { //means this is the homepage
    $page_1 = 0;
} else {
    $page_1 = ($page * $per_page) - $per_page;
}
$post_count_query = "SELECT * FROM posts";

$post_count_results = mysqli_query($connection, $post_count_query);

$post_count = mysqli_num_rows($post_count_results);

$post_count = ceil($post_count / $per_page);

$sql = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, $per_page";

$results = mysqli_query($connection, $sql);

if (mysqli_num_rows($results) < 1) {
    echo "<h1 class='centered'>No posts yet, come back later!</h1>";

} else {
?>
<div id="colorlib-main">
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-xl-8 px-md-5 py-5">
                    <div class="row pt-md-4">
                        <!--                        Start of Posts-->
                        <?php
                        while ($row = mysqli_fetch_assoc($results)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 200);
                            $post_date = $row['post_date'];
                            $post_author_id = $row['post_author_id'];
                            $post_views = $row['post_views_count'];

                            $user_sql = "SELECT * FROM users WHERE user_id = $post_author_id";
                            $image_results = mysqli_query($connection, $user_sql);
                            while ($image_row = mysqli_fetch_assoc($image_results)) {
                                $user_image = $image_row['user_image'];
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="blog-entry-2 ftco-animate">
                                    <a href="/cms/post/<?php echo $post_id; ?>" class="img"
                                       style="background-image: url(images/<?php echo $post_image ?>);"></a>
                                    <div class="text pt-4">
                                        <h3 class="mb-4"><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a></h3>
                                        <p class="mb-4"><?php echo $post_content ?></p>
                                        <div class="author mb-4 d-flex align-items-center">
                                            <a href="#" class="img"
                                               style="background-image: url(images/<?php echo $user_image ?>);"></a>
                                            <div class="ml-3 info">
                                                <span>Written by</span>
                                                <h3><a href="/cms/author_posts/<?php echo $post_author_id; ?>"><?php echo $post_author ?></a>,
                                                    <span><?php echo date("F jS, Y", strtotime($post_date)) ?></span>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="meta-wrap d-md-flex align-items-center">
                                            <div class="half order-md-last text-md-right">
                                                <p class="meta">
<!--                                                    <span><i class="icon-heart"></i>3</span>-->
                                                    <span><i class="icon-eye"></i><?php echo $post_views ?></span>
                                                    <span><i class="icon-comment"></i>5</span>
                                                </p>
                                            </div>
                                            <div class="half">
                                                <p><a href="/cms/post/<?php echo $post_id; ?>"
                                                      class="btn btn-primary p-3 px-xl-4 py-xl-3">Continue
                                                        Reading</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        } ?>

                    </div>
                    <!-- END POSTS-->
<!--                    START PAGINATION-->
                    <div class="row">
                        <div class="col">
                            <div class="block-27">
                                <ul>
                                    <li><a href="#">&lt;</a></li>
                                    <?php
                                    for ($i = 1; $i <= $post_count; $i++) {
                                        if ($i == $page) {
                                            echo "<li class='active'><a href=\"index.php?page=$i\">$i</a></li>";
                                        } else {
                                            echo "<li><a href=\"index.php?page=$i\">$i</a></li>";
                                        }
                                    }
                                    ?>
                                    <li><a href="#">&gt;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
<!--                    END PAGINATION-->
                </div>
                <div class="col-xl-4 sidebar ftco-animate bg-light pt-5">
                    <div class="sidebar-box pt-md-4">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Categories</h3>
                        <ul class="categories">
                            <?php
                            $sql = "SELECT * FROM categories";
                            $results = mysqli_query($connection, $sql);

                            while ($row = mysqli_fetch_assoc($results)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                $category_count_query = "SELECT * FROM posts WHERE post_category_id = $cat_id ";
                                $category_count_results = mysqli_query($connection, $category_count_query);
                                $category_counts = mysqli_num_rows($category_count_results);
                                if ($category_counts > 0) {
                                    echo "<li>
                                                <a href='/cms/category/$cat_id'>$cat_title<span>($category_counts)</span></a>
                                            </li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
<!--POPULAR ARTICLES-->
                    <?php
                    $popular_articles_sql = "SELECT * FROM posts WHERE post_views_count > 5 ORDER BY post_date DESC LIMIT 3";
                    $popular_articles_results = mysqli_query($connection, $popular_articles_sql);
                    confirmQuery($popular_articles_results);
                    if (mysqli_num_rows($popular_articles_results) < 1) {
                        echo "<div class=\"sidebar-box ftco-animate\">
                        <h3 class=\"sidebar-heading\">Popular Articles Will Appear Here</h3>
                    </div>";
                    } else {
                        ?>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Popular Articles</h3>
                        <?php
                        while ($row = mysqli_fetch_assoc($popular_articles_results)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_image = $row['post_image'];
                            $post_date = $row['post_date'];
                            $post_author_id = $row['post_author_id'];
                            $post_views = $row['post_views_count'];
                        ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/<?php echo $post_image;?>);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title;?></a></h3>
                                <div class="meta">
                                    <div><span class="icon-calendar"></span> <?php echo date("F jS, Y", strtotime($post_date))?></div>
                                    <div><a href="author_posts/<?php echo $post_author_id; ?>"><span class="icon-person"></span><?php echo $post_author;?></a></div>
                                    <div><span class="icon-eye"></span> <?php echo $post_views;?></div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    echo "</div>";
                    }

                    ?>
                    <!--                    TAGS-->
<!--                    <div class="sidebar-box ftco-animate">-->
<!--                        <h3 class="sidebar-heading">Tag Cloud</h3>-->
<!--                        <ul class="tagcloud">-->
<!--                            <a href="#" class="tag-cloud-link">animals</a>-->
<!--                            <a href="#" class="tag-cloud-link">human</a>-->
<!--                            <a href="#" class="tag-cloud-link">people</a>-->
<!--                            <a href="#" class="tag-cloud-link">cat</a>-->
<!--                            <a href="#" class="tag-cloud-link">dog</a>-->
<!--                            <a href="#" class="tag-cloud-link">nature</a>-->
<!--                            <a href="#" class="tag-cloud-link">leaves</a>-->
<!--                            <a href="#" class="tag-cloud-link">food</a>-->
<!--                        </ul>-->
<!--                    </div>-->
<!---->
<!--                    <div class="sidebar-box subs-wrap img py-4" style="background-image: url(images/bg1.jpg);">-->
<!--                        <div class="overlay"></div>-->
<!--                        <h3 class="mb-4 sidebar-heading">Newsletter</h3>-->
<!--                        <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia</p>-->
<!--                        <form action="#" class="subscribe-form">-->
<!--                            <div class="form-group">-->
<!--                                <input type="text" class="form-control" placeholder="Email Address">-->
<!--                                <input type="submit" value="Subscribe" class="mt-2 btn btn-white submit">-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!---->
<!--                    <div class="sidebar-box ftco-animate">-->
<!--                        <h3 class="sidebar-heading">Archives</h3>-->
<!--                        <ul class="categories">-->
<!--                            <li><a href="#">December 2018 <span>(10)</span></a></li>-->
<!--                            <li><a href="#">September 2018 <span>(6)</span></a></li>-->
<!--                            <li><a href="#">August 2018 <span>(8)</span></a></li>-->
<!--                            <li><a href="#">July 2018 <span>(2)</span></a></li>-->
<!--                            <li><a href="#">June 2018 <span>(7)</span></a></li>-->
<!--                            <li><a href="#">May 2018 <span>(5)</span></a></li>-->
<!--                        </ul>-->
<!--                    </div>-->


                    <div class="sidebar-box ftco-animate">
<!--                        <h3 class="sidebar-heading">Paragraph</h3>-->
                        <p><q>There is a tide in the affairs of men. Which, taken at the flood, leads on to fortune. Omitted, all the voyage of their life is bound in shallows and miseries.</q></p>
                        <cite>William Shakespeare</cite>
                    </div>
                </div><!-- END COL -->
            </div>
        </div>
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


<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>

</body>
</html>