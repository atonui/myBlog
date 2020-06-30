<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($message, $email, $subject) {
// Load Composer's autoloader
    require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'batian.webhostultima.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'noreply@kibetkoech.com';                     // SMTP username
        $mail->Password   = 'Siri2020';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above 587

        //Recipients
        $mail->setFrom('noreply@kibetkoech.com', 'Mailer');
        $mail->addAddress($email, 'Joe User');     // Add a recipient
//        $mail->addAddress('ellen@example.com');               // Name is optional
//        $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');
//
//        // Attachments
//        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if ($mail->send()) {
            echo "
                <div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
                 Please check your email inbox for instructions.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
            ";
        } else {
            echo "
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                 Email sending failed. Initiating self destruct in 10 seconds...
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
            ";
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function insertCategory(){

    global $connection;
    if(isset($_POST['add_category'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" or empty($cat_title)){
            echo "<small style='color:red;'>* Please enter a category</small>";
        }else{
            $sql = "INSERT INTO `categories`(`cat_id`, `cat_title`) VALUES (NULL,'$cat_title')";
            $result = mysqli_query($connection, $sql);
            if(!$result){
                die('Query failed'. mysqli_error($connection));
            }
        }
    }
}

function findAllCategories(){
    global $connection;

    $sql = "SELECT * FROM categories";
    $results = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_assoc($results)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a href='categories.php?delete=$cat_id'>Delete</a></td>";
        echo "<td><a href='categories.php?update=$cat_id'>Edit</a></td>";

        echo "</tr>";
    }
}

function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $delete_query = "DELETE FROM `categories` WHERE cat_id = '$id'";

        mysqli_query($connection,$delete_query);

        header('location:categories.php');
    }
}

function confirmQuery($result){
    global $connection;
    if(!$result){
        die("Query failed ".mysqli_error($connection));
    }
}

function deletePosts($post_id){
    global $connection;
    $delete_query = "DELETE FROM posts WHERE post_id = $post_id";
    if (!mysqli_query($connection, $delete_query)) {
        die("Query failed " . mysqli_error($connection));
    } else {
//        delete all comments associated with the post
        $delete_comment = "DELETE FROM comments WHERE comment_post_id = $post_id";
        $results = mysqli_query($connection, $delete_comment);
        confirmQuery($results);
        header('location:posts.php');
    }
}

function cleanData($data){
    global $connection;

    //$data = strtolower($data);
    //$data = stripslashes($data);
    //$data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($connection, $data); // escapes special characters usually used for SQL statements, it helps prevent sql injections

    return $data;
}

//function to verify password strength and matches
function passwordChecker($password, $confirm_password){
    $password_err ='';
    if ($password != $confirm_password) {
        $password_err = 'Oops! Your passwords do not seem to match';
    } elseif (strlen($password) < 8) {
        $password_err = 'Your password is less than 8 characters';

        //check for password strength using regex
    } elseif (!(preg_match('/[\'^£$!%&*()}{@#~?><>,|=_+¬-]/', $password))) { //regex pattern to check if password contains special characters
        $password_err = 'Your password does not contain any special characters';
    }
    return $password_err;
}

//function to securely hash passwords
function passwordHash($password){
    $password = password_hash($password, PASSWORD_DEFAULT);
    return $password;
}

function countUsers(){
    if (isset($_GET['onlineusers'])) {
        global $connection;
        if (!$connection){
            session_start();
            include '../includes/db.php';
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 5;
            $time_out = $time - $time_out_in_seconds;
            $user_id = $_SESSION['user_id'];

            $query = "SELECT * FROM users_online WHERE session = '$session'";

            $results = mysqli_query($connection, $query);

            $count = mysqli_num_rows($results);

            if ($count == NULL) { //user is not found so start tracking the logged in user
                $query = "INSERT INTO users_online(session, time, user_id) VALUES('$session', '$time', $user_id)";
                $results = mysqli_query($connection, $query);
                confirmQuery($results);
            } else { //user is already logged in
                $query = "UPDATE users_online SET time = $time WHERE session = '$session'";
                $results = mysqli_query($connection, $query);
                confirmQuery($results);
            }

            $query = "SELECT * FROM users_online WHERE time > $time_out";
            $results = mysqli_query($connection, $query);
            confirmQuery($results);
            echo mysqli_num_rows($results);
        }
    }
}

countUsers();

//function to query the database
function query($query){
    global $connection;
    return mysqli_query($connection, $query);
}

//function to see if user liked a post
function userLikedPost($post_id){
    session_start();
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    $result = query($query);
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1;
}