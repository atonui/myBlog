<?php include 'includes/admin_header.php' ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard
                        <small>
                            <?php
                            if (isset($_SESSION['firstname'])) {
                                echo $_SESSION['firstname'];
                            }
                            ?>
                        </small>
                    </h1>

                </div>
            </div>
            <!-- /.row -->
            <?php
            //            find the number of posts in db
            $sql = "SELECT * FROM posts";
            $results = mysqli_query($connection, $sql);
            $post_counts = mysqli_num_rows($results);

            //            find the number of comments in db
            $sql = "SELECT * FROM comments";
            $results = mysqli_query($connection, $sql);
            $comment_counts = mysqli_num_rows($results);

            //            find the number of users in db
            $sql = "SELECT * FROM users";
            $results = mysqli_query($connection, $sql);
            $user_counts = mysqli_num_rows($results);

            //            find the number of categories in db
            $sql = "SELECT * FROM categories";
            $results = mysqli_query($connection, $sql);
            $category_counts = mysqli_num_rows($results);

            ?>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $post_counts ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $comment_counts ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $user_counts ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $category_counts ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php

            $sql = "SELECT * FROM posts WHERE post_status = 'draft'";
            $get_draft_posts = mysqli_query($connection, $sql);
            $post_draft_count = mysqli_num_rows($get_draft_posts);

            $get_published_query = "SELECT * FROM posts WHERE post_status = 'published'";
            $get_published_posts = mysqli_query($connection, $get_published_query);
            $post_published_count = mysqli_num_rows($get_published_posts);

            $comments_query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
            $get_comments = mysqli_query($connection, $comments_query);
            $unapproved_comments = mysqli_num_rows($get_comments);

            $users_query = "SELECT * FROM users WHERE role = 'subscriber'";
            $get_subscribers = mysqli_query($connection, $users_query);
            $subscriber_count = mysqli_num_rows($get_subscribers);

            ?>

            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawStuff);

                    function drawStuff() {
                        var data = new google.visualization.arrayToDataTable([
                            ['Data', 'Count'],

                            <?php
                            $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Draft Comments', 'Total Users', 'Subscribers', 'Categories'];
                            $element_count = [$post_counts, $post_published_count, $post_draft_count, $comment_counts, $unapproved_comments, $user_counts, $subscriber_count, $category_counts];

                            for ($i = 0; $i < 8; $i++) {
                                echo "['$element_text[$i]'" . "," . "$element_count[$i]],";
                            }

                            ?>
                            //["Posts", 44],

                        ]);

                        var options = {
                            width: 800,
                            legend: {
                                position: 'none'
                            },
                            chart: {
                                title: 'CMS Data',
                                subtitle: 'Count'
                            },
                            axes: {
                                y: {
                                    0: {
                                        side: 'top',
                                        label: 'Content Data'
                                    } // Top x-axis.
                                }
                            },
                            bar: {
                                groupWidth: "40%"
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                        // Convert the Classic options to Material options.
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    };
                </script>
                <div id="top_x_div" style="width: auto; height: 600px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include 'includes/admin_footer.php'; ?>