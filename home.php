<?php include 'includes/header.php';
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

if (mysqli_num_rows($results) < 1){
    echo "<h1 class='centered'>No posts yet, come back later!</h1>";

}else {
?>
<div id="colorlib-main">
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-xl-8 py-5 px-md-5">
                    <div class="row pt-md-4">
                        <!--                        START POST-->
                        <?php
                        while ($row = mysqli_fetch_assoc($results)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 100);
                            $post_date = $row['post_date'];
                            $post_author_id = $row['post_author_id'];
                            $post_views = $row['post_views_count'];
                        ?>
                        <div class="col-md-12">
                            <div class="blog-entry ftco-animate d-md-flex">
                                <a href="single.php" class="img img-2"
                                   style="background-image: url(images/image_1.jpg);"></a>
                                <div class="text text-2 pl-md-4">
                                    <h3 class="mb-2"><a href="single.php"><?php echo $post_title ?></a>
                                    </h3>
                                    <div class="meta-wrap">
                                        <p class="meta">
                                            <span><i class="icon-calendar mr-2"></i><?php echo $post_date ?></span>
                                            <span><a href="single.php"><i
                                                            class="icon-folder-o mr-2"></i>Travel</a></span>
                                            <span><i class="icon-comment2 mr-2"></i>5 Comment</span>
                                        </p>
                                    </div>
                                    <p class="mb-4"><?php echo $post_content ?></p>
                                    <p><a href="/cms/post/<?php echo $post_id; ?>" class="btn-custom">Read More <span
                                                    class="ion-ios-arrow-forward"></span></a></p>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        }?>
                    </div>
                    <!-- END-->
                    <div class="row">
                        <div class="col">
                            <div class="block-27">
                                <ul>
                                    <?php
                                    for ($i=1; $i<=$post_count; $i++) {
                                        if ($i == $page) {
                                            echo "<li><a class='active_link' href=\"index.php?page=$i\">$i</a></li>";
                                        } else {
                                            echo "<li><a href=\"index.php?page=$i\">$i</a></li>";
                                        }
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                            <li><a href="#">Fashion <span>(6)</span></a></li>
                            <li><a href="#">Technology <span>(8)</span></a></li>
                            <li><a href="#">Travel <span>(2)</span></a></li>
                            <li><a href="#">Food <span>(2)</span></a></li>
                            <li><a href="#">Photography <span>(7)</span></a></li>
                        </ul>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Popular Articles</h3>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control</a>
                                </h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> June 28, 2019</a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control</a>
                                </h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> June 28, 2019</a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/image_3.jpg);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control</a>
                                </h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> June 28, 2019</a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Tag Cloud</h3>
                        <ul class="tagcloud">
                            <a href="#" class="tag-cloud-link">animals</a>
                            <a href="#" class="tag-cloud-link">human</a>
                            <a href="#" class="tag-cloud-link">people</a>
                            <a href="#" class="tag-cloud-link">cat</a>
                            <a href="#" class="tag-cloud-link">dog</a>
                            <a href="#" class="tag-cloud-link">nature</a>
                            <a href="#" class="tag-cloud-link">leaves</a>
                            <a href="#" class="tag-cloud-link">food</a>
                        </ul>
                    </div>

                    <div class="sidebar-box subs-wrap img py-4" style="background-image: url(images/bg1.jpg);">
                        <div class="overlay"></div>
                        <h3 class="mb-4 sidebar-heading">Newsletter</h3>
                        <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia</p>
                        <form action="#" class="subscribe-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email Address">
                                <input type="submit" value="Subscribe" class="mt-2 btn btn-white submit">
                            </div>
                        </form>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Archives</h3>
                        <ul class="categories">
                            <li><a href="#">Decob14 2018 <span>(10)</span></a></li>
                            <li><a href="#">September 2018 <span>(6)</span></a></li>
                            <li><a href="#">August 2018 <span>(8)</span></a></li>
                            <li><a href="#">July 2018 <span>(2)</span></a></li>
                            <li><a href="#">June 2018 <span>(7)</span></a></li>
                            <li><a href="#">May 2018 <span>(5)</span></a></li>
                        </ul>
                    </div>


                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Paragraph</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                            necessitatibus voluptate quod mollitia delectus aut.</p>
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