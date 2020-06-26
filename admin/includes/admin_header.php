<?php
ob_start();
session_start();
include '../includes/db.php';
include 'functions.php';

if (isset($_SESSION['user_role'])){
    $role = $_SESSION['user_role'];
    if ($role == 'subscriber') {
        header('location:../index');
    }
} else{
    header('location:../index');
}

//to add logic of allowing only administrators to login here

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS</title>

    <!-- Bootstrap Core CSS -->
    <link href="/cms/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/cms/admin/css/sb-admin.css" rel="stylesheet">

    <link href="/cms/admin/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!--    charts js-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!--WYSWYG editor js-->
    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>