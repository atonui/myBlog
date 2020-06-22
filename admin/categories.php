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
                        Categories
                        <small>
                            <?php
                            if (isset($_SESSION['firstname'])){
                                echo $_SESSION['firstname'];
                            }
                            ?>
                        </small>
                    </h1>
                    <div class="col-xs-6">
                        <?php
                        //add categories function
                        insertCategory();
                        ?>

                        <form action="" method="POST">
                            <label for="cat_title">Add Category</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="cat_title">

                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="add_category" value="Add Category">

                            </div>

                        </form>
                        <!-- Update Form -->
                        <?php //update query
                        if (isset($_GET['update'])) {
                            $id = $_GET['update'];

                            $select_query = "SELECT * FROM categories WHERE cat_id = '$id' ";

                            $results = mysqli_query($connection, $select_query);

                            while ($row = mysqli_fetch_assoc($results)) {
                                $title = $row['cat_title'];

                        ?>
                                <form action="" method="POST">
                                    <label for="cat_title">Update Category</label>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="cat_title" value="<?php echo $title ?>">
                                        <input type="hidden" name="id_value" value="<?php echo $id ?>">

                                    </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">

                                    </div>

                                </form>
                        <?php
                            }
                        } //update query
                        if (isset($_POST['update_category'])) {
                            $new_cat_title = $_POST['cat_title'];
                            $id = $_POST['id_value'];
                            $update_query = "UPDATE `categories` SET `cat_title`= '$new_cat_title'WHERE cat_id = '$id' ";
                            if (mysqli_query($connection, $update_query)) {
                                header('location:categories.php');
                            } else {
                                die("Query failed " . mysqli_error($connection));
                            }
                        }
                        ?>

                    </div>

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //select all categories
                                findAllCategories();

                                //delete query
                                deleteCategories()
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include 'includes/admin_footer.php'; ?>