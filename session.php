<?php

include('config.php');
session_start();

$user_check = $_SESSION['login_user'];
$ses_sql = mysqli_query($db, "select UserName, Email, FirstName, LastName from swiss_users where UserName = '$user_check' ");

$row = mysqli_fetch_array($ses_sql, MYSQL_ASSOC);

//$login_session = $row['UserName'];
$_SESSION['user_name'] = $row['UserName'];

if (!isset ($_SESSION['login_user'])){
    header("location:login.php");
    die();
}

?>