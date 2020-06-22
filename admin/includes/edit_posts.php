<?php
//grab data from the URL using GET

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $posts_query = "SELECT * FROM posts WHERE post_id = $id";
    $results = mysqli_query($connection, $posts_query);

    while ($row = mysqli_fetch_assoc($results)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
    }

    if(isset($_POST['update_post'])){
        $post_title = cleanData($_POST['title']);
        $post_author = cleanData($_POST['post_author']);
        $post_category_id = cleanData($_POST['post_category']);
        $post_status = cleanData($_POST['post_status']);

        $post_image = $_FILES['post_image']['name'];
        $post_image = cleanData($post_image);
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = cleanData($_POST['post_tags']);
        $post_content = cleanData($_POST['post_content']);

        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = $post_id";
            $select_image = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_image)){
                $post_image = $row['post_image'];
            }
        }

        $update_query = "UPDATE `posts` SET post_category_id = '$post_category_id', post_title = '$post_title', post_author = '$post_author', post_image = '$post_image', post_content = '$post_content', post_tags = '$post_tags', post_status = '$post_status' WHERE post_id = '$post_id' ";

        if (mysqli_query($connection, $update_query)){
            move_uploaded_file($post_image_temp,"../images/$post_image");
            echo "<p class='alert alert-success'><a href='../post.php?p_id=$post_id'>Post Updated!</a></p>";
        }else{
            die("Query failed ".mysqli_error($connection));
        }


    }
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title ?>">
    </div>
    <div class="form-group">
    <select name="post_category" id="">
        <?php
            $select_query = "SELECT * FROM categories";

            $results = mysqli_query($connection, $select_query);

            confirmQuery($results);

            while ($row = mysqli_fetch_assoc($results)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo " <option value=\"$cat_id\">$cat_title</option>";

            }
        ?>

    </select>
    </div>
    <div class="form-group">
        <label>Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author ?>">
    </div>
    <div class="form-group">
        <select name="post_status">
            <label>Post Status</label><br>
           <?php
            if ($post_status == 'draft'){
                ?>
                <option value="<?php echo $post_status?>">Draft</option>
                <option value="published">Published</option>
                <?php
            }else{
                ?>
                <option value="<?php echo $post_status?>">Published</option>
                <option value="draft">Draft</option>
                <?php
            }
            ?>
        </select>
    </div>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>">
    </div>
    <div class="form-group">
        <label>Post Image</label>
        <input type="file" class="form-control" name="post_image">
    </div>
    <div class="form-group">
        <label>Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ?>">
    </div>
    <div class="form-group">
        <label>Post Content</label>
        <textarea class="form-control" name="post_content" cols="30" rows="10" id="body"><?php echo $post_content ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>



<?php
////update data in db
//if (isset($_POST['edit_post'])) {
//    $post_title = $_POST['title'];
//    $post_author = $_POST['post_author'];
//    $post_category_id = $_POST['post_category_id'];
//    $post_status = $_POST['post_status'];
//    $post_tags = $_POST['post_tags'];
//    $post_content = $_POST['post_content'];
//    $post_date = date('d-m-y');
//    $post_comment_count = 4;
//
//    if (isset($_POST['post_image'])){
//        $post_image = $_FILES['post_image']['name'];
//        $post_image_temp = $_FILES['post_image']['tmp_name'];
//    }
//
//    $sql = "UPDATE `posts` SET post_title = '$post_title', post_author = '$post_author', post_image, post_content, post_tags, post_comment_count, post_status) VALUES (NULL,$post_category_id,'$post_title','$post_author',now(),'$post_image','$post_content','$post_tags','$post_comment_count','$post_status')";
//
//    UPDATE `posts` SET `post_id`=[vat_comment_count`=[value-9],`post_status`=[value-10] WHERE 1
//
//    if (!mysqli_query($connection, $sql)) {
//        die("Query failed" . mysqli_error($connection));
//    } else {
//        move_uploaded_file($post_image_temp, "../images/$post_image");
//    }
//}
//?>