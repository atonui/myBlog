<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/cms/admin/index">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
<!--        <li><a href="online_users.php">--><?php //echo countUsers();?><!--: Online</a></li>-->
        <li><a href="#">Users Online: <span class="usersonline"></span></a></li>
        <li><a href="/cms/index">Home</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                <?php
                    if (isset($_SESSION['firstname'])){
                        echo $_SESSION['firstname'];
                    }
                ?>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="/cms/includes/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts" class="collapse">
                    <li>
                        <a href="./posts.php">View all posts</a>
                    </li>
                    <li>
                        <a href="./posts.php?source=add_post">Add post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/cms/admin/categories"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>

            <li class="">
                <a href="/cms/admin/comments"><i class="fa fa-fw fa-file"></i> Comments </a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="users" class="collapse">
                    <li>
                        <a href="users.php">View Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            </li>

            <li class="">

                <a href="profile"><i class="fa fa-fw fa-file"></i> Profile </a>

            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>