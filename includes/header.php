<?php
session_start();
include './admin/functions.php';
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kibet Koech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/cms/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="/cms/css/animate.css">

    <link rel="stylesheet" href="/cms/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/cms/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/cms/css/magnific-popup.css">

    <link rel="stylesheet" href="/cms/css/aos.css">

    <link rel="stylesheet" href="/cms/css/ionicons.min.css">

    <link rel="stylesheet" href="/cms/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/cms/css/jquery.timepicker.css">


    <link rel="stylesheet" href="/cms/css/flaticon.css">
    <link rel="stylesheet" href="/cms/css/icomoon.css">
    <link rel="stylesheet" href="/cms/css/style.css">
</head>
<body>
<div id="colorlib-page">
    <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
    <aside id="colorlib-aside" role="complementary" class="js-fullheight">
        <nav id="colorlib-main-menu" role="navigation">
            <ul>
                <?php
                if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                    echo "<li class=\"colorlib-active\"><a href=\"/cms/index\">Home</a></li>
                <li><a href=\"/cms/about\">About</a></li>
                <li><a href=\"/cms/contact\">Contact</a></li>";
                } elseif (basename($_SERVER['PHP_SELF']) == 'about.php') {
                    echo "<li><a href=\"/cms/index.php\">Home</a></li>
                <li class=\"colorlib-active\"><a href=\"/cms/about\">About</a></li>
                <li><a href=\"/cms/contact\">Contact</a></li>";
                } elseif (basename($_SERVER['PHP_SELF']) == 'contact.php') {
                    echo "<li><a href=\"/cms/index\">Home</a></li>
                <li><a href=\"/cms/about\">About</a></li>
                <li class=\"colorlib-active\"><a href=\"/cms/contact\">Contact</a></li>";
                } else {
                    echo "<li><a href=\"/cms/index\">Home</a></li>
                <li><a href=\"/cms/about\">About</a></li>
                <li><a href=\"/cms/contact\">Contact</a></li>";
                }
                ?>
            </ul>
        </nav>

        <?php
            if (isset($_POST['newsletter_submit'])) {
                if (!empty($_POST['newsletter_email'])) {
                    $newsletter_email = cleanData($_POST['newsletter_email']);
                    $newsletter_date = date('d-m-y');
                    $newsletter_sql = "INSERT INTO `newsletter`(`newsletter_id`, `newsletter_email`, `newsletter_date`) VALUES (NULL,'$newsletter_email','$newsletter_date')";
                    $newsletter_query_results = query($newsletter_sql);
                    confirmQuery($newsletter_query_results);
                }
            }
        ?>

        <div class="colorlib-footer">
            <h1 id="colorlib-logo" class="mb-4"><a href="/cms/index" style="background-image: url(/cms/images/bg1.jpg);">Allan
                    <span>Koech</span></a></h1>
            <div class="mb-4">
                <h3>Subscribe to the newsletter</h3>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="colorlib-subscribe-form" method="post">
                    <div class="form-group d-flex">
                        <input type="email" class="form-control" placeholder="Enter Email Address" name="newsletter_email">
                        <button type="submit" class="icon btn btn-outline" name="newsletter_submit"><span
                                    class="icon-paper-plane"></span></button>
                    </div>
                </form>
            </div>
            <a href="/cms/login"><span class="text-info">Login</span></a>
            <p class="pfooter">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                All rights reserved | by <a href="https://kibetkoech.com" target="_blank">kibetkoech.com</a>
            </p>
        </div>
    </aside>
    <!-- END ASIDE -->
