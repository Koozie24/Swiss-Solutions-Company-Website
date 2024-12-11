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
    .burg-container{
        border: 3px solid white;
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
    .main-page-container{
        font-family: "Avenir Next Condensed Medium", Calibri, "Gill Sans", sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h2{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        width: 100%;
        color: red;
        text-align: center;
        font-size: 24px;
    }
    .about-us, .why-us, .our-offer, .our-mission{
        border-radius: 6%;
        background-color: white;
        width: 80%;
        margin: 1%;
        padding: 5px;
    }
    p, li{
        font-weight: bold;
    }
    p{
        margin-left: 2px;
    }
    .action{
        float: right;
        margin-bottom: 1%;
    }
    .bottom-contact{
        border: none;
        border-radius: 40%;
        font-weight: bold;
    }
</style>

<html>

    <head>
        <title>About Us</title>
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
        
        <div class='main-page-container'>
            <div class='about-us'>
                <h2>Who Are We?</h2>

                <p>Founded in 2024 by Jake McKenzie, a computer science graduate student and seasoned network and systems administrator, Swiss Solutions is at
                    the forefront of automation and programming services. Based in Berne, Indiana, we pride outselves on our local roots while embracing projects 
                    both near and far, regardless of their size or nature. 
                </p>
            </div>

            <div class='our-mission'>
                <h2>Our Mission</h2>

                <p> At Swiss Solutions, we are driven by a simple yet powerful mission: to solve complex problems through innovative programming solutions.
                    Whether you're a small business owner in need of processs automation or a large company looking for custom software, our goal is to transform
                    your vision  into reality with scalable and maintainable programmed solutions. 
                </p>
            </div>

            <div class='our-offer'>
                <h2>What We Offer</h2>

                <p>At Swiss Solutions we offer our clients  a variety of programming services tailored to meet the diverse needs of individuals and companies across different domains:</p>
                <ul>
                    <li><i><b>Process Automation:</i></b> Streamline your repetitive tasks by having us automate them for you, saving time and money.</li>
                    <li><i><b>Custom Software Development:</i></b> We create tailored results that match the unique needs of your business.</li>
                    <li><i><b>Consulting and Strategy:</i></b> Expert guidance to optimize your technological operations.</li>
                </ul>
                <p>No project is too big, too small, or too unconventional. We live off of the thrill of solving complex challenges and developing standout solutions.
                    We are eager to get to work tackling your project with a calculated, creative approach.</p>
            </div>

            <div class='why-us'>
                <h2>Why Choose Swiss?</h2>
                <p>Choosing Swiss Solutions means opting for a highly skilled and fresh approach to programming challenges. Our founder brings 
                    cutting edge knowledge from his ongoing avanced studies in computer science, ensuring you recieve the latest technologies 
                    and software development methodology.</p>
                <p>Here are the reasons clients choose Swiss:</p>

                <ul>
                    <li><i><b>Personal Commitment:</i></b> Each project benefits from Jake's personal dedication and innovative problem solving. </li>
                    <li><i><b>Customized Client Focus:</i></b> We provide personalized attention to each client that a larger comapny simply cannot match, adpating our solutions to meet your specific needs. </li>
                    <li><i><b>Agility and Adaptability:</i></b> We are a young company that can learn and adapt swiftly, ensuring that work products are up-to-date, concise, and effective. </li>
                </ul>

                <p>We invite you to experience the difference that passion and cutting-edge knowledge can make in your business or next project. Contact us 
                today to discuss how we can bring your ideas to life.
                </p>
            </div>
        
        </div>
        <div class='action'>
            <a class='bottom-contact' href='contact.php'>Contact us</a>
        </div>
    <script src='./js/user_name.js'></script>
    <script src='./js/sidenav.js'></script>
    </body>
<html>