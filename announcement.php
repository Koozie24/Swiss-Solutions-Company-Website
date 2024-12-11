<!DOCTYPE HTML>

<?php
    include("config.php");
    session_start();

    //checking user is logged in
    if (isset ($_SESSION['login_user'])){
        //get the username of the current logged in user
        $current_user = $_SESSION['login_user'];
    }
    else{
        $current_user = '';
    }
?>

<style>

    /*Genereal top navigation and body style standard across site */
    body{
        /*font: 14px "Open Sans", Arial, "Helvetica Neue", Helvetica, sans-serif;*/
        font: 14px Courier, monospace;
        color: black;
        background-color: #ececec;
    }
    a, a:active{
        color: black;
        text-decoration: none;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
        text-align: center;
        padding: 12px;
        float: left;
        border: 2px solid black;
        margin: 1px;
        background-color: white;
    }
    .top-row, .user-btn, #top-about{
        font-weight: bold;
        font-size: 18px;
        background-color: #ececec;
        border: 2px solid black;
    }
    #top-about:hover, a:hover{
        background-color: #b22222;
        /*background-color: #ff474c;*/
        border: 3px solid black;
        filter: brightness(200%);
        color: black;
    }
    .top-navigation{
        width: 100%;
        display: flex;
        overflow: hidden;
        align-items: center;
        justify-content: space-between;
        /*background-color: #cd5c5c;*/
        background-color: white;
        height: auto;
        margin: 0;
    }
    .left-head{
        float: left;
        align-items: center;
    }
    .right-head{
        float: right;
        align-items: center;
        display: flex;
    }
    .burger{
        width: 30px;
        height: 5px;
        background-color: black;
        margin: 4px 0;
    }
    .burger-link{
        border: none;
    }
    .logo{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        font-size: 18px;
        margin-top: 1%;
        font-weight: bold;
        color: red;
        width: auto;
        height: auto;
        font-size: 1.5rem;
        white-space: wrap;
        padding: 10px 10px;
        border: 3px solid white;
    }
    .logo:hover{
        border: 3px solid black;
    }
    .swiss-title{
        display: block;
    }
    #swiss{
        margin-top: -6%;
        margin-bottom: 4%;
    }
    .swiss-bear{
        height: 100%;
        max-height: 8rem;
        width: auto;
        float: left;
        background-color: white;
    }
    .icon-bar{
        display: none;
        background-color: #555;
        float: right;
        width: 20%;
        overflow: hidden;
        margin-right: 1%;
        padding: 10px;
        align-items: center;
        position: absolute;
        right: 1px;
    }
    .icon-bar a{
        font-weight: bold;
        display: block;
        overflow: hidden;
        width: 90%;
        margin-right: 5%;
    }
    /*  #######                                     ####### 
        #######    STANDARD CSS BOILDERPLATE STOPS  ####### 
        #######                                     ####### 
        */
    .account-menu{
        display: none;
        background-color: #555;
        float: right;
        width: 10%;
        overflow: hidden;
        margin-right: 1%;
        padding: 10px;
        align-items: center;
        position: absolute;
        right: 1px;
    }
    .account-menu a{
        font-weight: bold;
        display: block;
        overflow: hidden;
        width: 85%;
    }
    @media screen and (max-width: 1025px){
        .account-menu a{
            width: 75%;
        }
        .account-menu{
            width: 15%;
        }
        .icon-bar a{
            width: 85%;
        }
    }
    .post-container{
        width: 60%;
        margin-top: 1%;
        margin-bottom: 1%;
        margin-left: 20%;
        margin-right: 20%;
        background-color: white;
        border-radius: 4px;
        padding: 5px;
        font-weight: bold;
    }
    h2, .main-title{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        width: 100%;
        color: red;
        text-align: center;
        font-size: 24px;
    }
    .post-body, .post-created{
        margin-left: 1%;
        margin-right: 1%;
    }
    .main-title{
        font-size: 40px;
    }
</style>

<html>

    <head>
        <title>Swiss Announcements</title>
    </head>

    <body>
        <div class='top-navigation'>
            <span class='left-head'>
                <img src='./img/swiss_bear_no_bg.png' class='swiss-bear'>
                <a href='index.php' class='logo'>
                    <h1><span class='swiss-title' id='swiss'>Swiss</span> <span class='swiss-title'>Solutions</span></h1></a>
            </span>
            <div class='right-head'>
                <?php
                    if($current_user != ''){
                        echo" <a href='' class='user-btn' id='user-top'><b>$current_user</b></a>" ;
                    }
                    else{
                        echo "<a href='login.php' class='top-row'><b>Sign In/Sign-Up</b></a>";
                    }
                ?>
                <!--<a href='login.php' class='top-row'><b>Sign In/Sign-Up</b></a>-->
                <a class='active' id='top-about' href='about_us.php'><b>About</b></a>
                <a href='contact.php' class='top-row'><b>Contact</b></a>
                <div class='burg-container'>
                    <a href='' class='burger-link'>
                        <div class='burger'></div>
                        <div class='burger'></div>
                        <div class='burger'></div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class='account-menu'>
                    <a href="account_home.php"><i class="fa fa-user"></i> Account</a>
                    <a href="logout.php"><i class="fa fa-ghost"></i> Sign Out</a>
                    <a href="switch_user.php"><i class="fa fa-user"></i> Switch User</a>
        </div>
        
        <!-- icon bar from https://www.w3schools.com/howto/howto_css_icon_bar.asp -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

        <div class='icon-bar' id='side-icon'>
            <a class="active" href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="services.php"><i class="fa fa-list"></i> Our Services</a>
            <a href="announcement.php"><i class="fa fa-bullhorn"></i> Announcements</a>
            <a href="account_home.php"><i class="fa fa-user"></i> Account</a>
        </div>
        
        <div class='announcement-feed'>
            <h1 class='main-title'>Announcement Feed</h1>
            <?php

                        //https://stackoverflow.com/questions/6490482/are-there-dictionaries-in-php
                //declare associative array to get month from number
                $num_to_mo = [
                    '01' => 'January',
                    '02' => 'February',
                    '03' => 'March',
                    '04' => 'April',
                    '05' => 'May',
                    '06' => 'June',
                    '07' => 'July',
                    '08' => 'August',
                    '09' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December'
                ];

                //get 24 hour time and convert to 12, decide if am or pm and return string
                function get_twelve_hour_time($hour, $minutes){
                    $hour = (int)$hour;
                    $form_time = '';
                    $val = '';
                    if($hour < 12){
                        $val = 'AM';
                        $form_time = "$hour$minutes $val";
                    }
                    else if($hour == 12){
                        $val = 'PM';
                        $form_time = "$hour$minutes $val";
                    }
                    else{
                        $hour = $hour - 12;
                        $val = 'PM';
                        $form_time = "$hour$minutes $val";
                    }

                    return $form_time;
                }

                function format_timestamp($current_row_created, $num_to_mo){
                    //get date section
                    $get_date = strlen($current_row_created) - 9;
                    $date = substr($current_row_created, 0, $get_date);

                    $year = substr($date, 0, 4);
                    $get_month = substr($date, 5, 2);
                    $display_month = $num_to_mo[$get_month];
                    $day_of_month = substr($date, 8);

                    $time = substr($current_row_created, 11);
                    $hour = substr($time, 0, 2);
                    $minutes = substr($time, 2, 3);
                    $formatted_twelve_hour_time = get_twelve_hour_time($hour, $minutes);

                    $full_string = "$display_month $day_of_month, $year at $formatted_twelve_hour_time";

                    return $full_string;
                }

                $announce_query = "SELECT PostId, Subject, Body, Created FROM swiss_announcements";

                $result = mysqli_query($db, $announce_query);
                
                $count = mysqli_num_rows($result);
                if($count > 0){
                    while($curr_post = mysqli_fetch_assoc($result)){
                        $post_id = $curr_post['PostId'];
                        $post_title = $curr_post['Subject'];
                        $post_body = $curr_post['Body'];
                        $post_created = $curr_post['Created'];
                        //get date and format
                        $full_time_string = format_timestamp($curr_post['Created'], $num_to_mo);

                        echo "<div class='post-container'>";
                            echo"<p class='post-created'><i>$full_time_string</i><p>";
                            echo"<h2 class='post-title'>$post_title</h2>";
                            echo"<p class='post-body'>$post_body</p>";
                            echo"<p class='post-created'><i> - Site Administrator</i><p>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    
    <script src='./js/user_name.js'></script>
    <script src='./js/sidenav.js'></script>
    </body>
<html>