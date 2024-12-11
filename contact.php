<!DOCTYPE HTML>

<?php
    include("config.php");
    session_start();

    $submitted = false;
    $error = '';
    $success = '';
    //checking user is logged in
    if (isset ($_SESSION['login_user'])){
        //get the username of the current logged in user
        $current_user = $_SESSION['login_user'];
    }
    else{
        $current_user = '';
    }

    //check for post
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //format variables
        $form_title = mysqli_real_escape_string($db, $_POST['Title']);
        $form_body = mysqli_real_escape_string($db, $_POST['Body']);
        $form_email = mysqli_real_escape_string($db, $_POST['Email']);
        $form_phone = mysqli_real_escape_string($db, $_POST['Phone']);
        $form_fname = mysqli_real_escape_string($db, $_POST['Fname']);
        $form_lname = mysqli_real_escape_string($db, $_POST['Lname']);
        
        //check fields are not left blank
        if($form_title == '' or $form_body == '' or $form_email == '' or $form_phone == '' or $form_fname == '' or $form_lname == ''){
            $error = 'Form fields cannot be left blank.';
        }
        //check for valid email format
        else if(!filter_var($form_email, FILTER_VALIDATE_EMAIL)){
            $error = nl2br("* Not a valid email address.\n
                            Format: email@domain.com\n
                            Your input: ". $form_email ."");
        }
        else{
            $contact_query = "INSERT INTO contact_swiss (Title, Body, Email, Phone, Fname, Lname) values ('$form_title', '$form_body', '$form_email', '$form_phone', '$form_fname', '$form_lname')";
            
            if(mysqli_query($db, $contact_query)){
                $submitted = true;
                header("location:contact.php");
                $success = 'Form Submitted Successfully!';
            }
            else{
                $error = "Form submission failed ";
                exit;
            }
        }
    }
    mysqli_close($db);
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
    input{
        background-color: #ececec;
        width: 75%;
    }
    label{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        width: 100%;
        color: red;
        text-align: center;
        font-size: 20px;
    }
    form{
        margin: 10px;
        display: flex;
        flex-direction: column;
        margin-left: 20%;
        margin-right: 20%;
        width: 60%;
        background-color: white;
        padding: 10px;
        margin-bottom: 2%;
        align-items: center;
    }
    .form-area{
        width: 100%;
    }
    .input-btn{
        height: 2vw;
        width: 50%;
        background-color: #ececec;
        color: black;
        font-size: 20px;
        font-weight: bold;
        margin-left: 25%;
        margin-right: 25%;
        border: 2px solid black;
    }
    .input-btn:hover{
        filter: brightness(150%);
        background-color: #b22222;
        color: black;
        font-size: 20px;
        font-weight: bold;
        border: 2px solid black;
    }
    .main-page-container{
        margin-top: 1%;
        width: 100%;
        font-family: "Avenir Next Condensed Medium", Calibri, "Gill Sans", sans-serif;
        display: flex;
    }
    h2{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        width: 100%;
        color: red;
        text-align: center;
        font-size: 24px;
    }
    .left-half{
        width: 60%;
        border-radius: 6%;
        background-color: white;
        margin-right: 1%;
        margin-left: 1%;
    }
    .right-half{
        padding: 10px;
        height: 100%;
        width: 40%;
        align-items: center;
        text-align: center;
        border-radius: 6%;
        background-color: white;
        margin-right: 1%;
    }
    .top-msg{
        text-align: center;
        border-radius: 6%;
        background-color: white;
        width: 80%;
        margin-bottom: 1%;
        padding: 5px;
        margin-left: 10%;
        margin-right: 10%;
    }
    #create{
        width: 50%;
        margin-left: 25%;
        margin-right: 25%;
        font-size: 20px;
        font-weight: bold;
        background-color: #ececec;
    }
    #create:hover{
        font-size: 20px;
        font-weight: bold;
        background-color: #b22222;
        /*background-color: #ff474c;*/
        border: 3px solid black;
        filter: brightness(200%);
        color: black;
    }
    p{
        font-weight: bold;
        margin-left: 2px;
    }
</style>

<html>

    <head>
        <title>Contact Swiss</title>
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
            
        <div class='left-half'>
                <div class='top-msg'>
                    <h2>New Here? Get in Touch!</h2>

                    <p>Feel free to enter your contact information below and leave us a brief description of what you are inquiring about. 
                        We will do out best to respond to your inquiry within 24 hours and schedule time to speak.
                    </p>
                </div>

                <div class='form-area'>
                    <form action="contact.php" method="post">
                        <label class="form-label"><b>Email Address: </b></label>
                            <input type="text" class="text-inp" name="Email"><br />

                        <label class="form-label"><b>Phone Number: </b></label>
                            <input type="text" class="text-inp" name="Phone"><br />

                        <label class="form-label"><b>First Name: </b></label>
                            <input type="text" class="text-inp" name="Fname"><br />

                        <label class="form-label"><b>Last Name: </b></label>
                            <input type="text" class="text-inp" name="Lname"><br />

                        <label class="form-label"><b>Subject: </b></label>
                            <input type="text" class="text-inp" name="Title"><br />
                        
                        <label class="form-label"><b>Tell us about how we can assist you: </b></label>
                            <input type="text" class="text-bod" name="Body"><br />

                            <button type="submit" class="input-btn">
                        <i class="fa fa-paper-plane"></i> Send
                    </button>
                        <div class="error">
                                <?php
                                    echo $error;
                                    echo $success;
                                ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class='right-half'>
                <h2>Create a Swiss Account</h2>
                <p>Want to be able to send and recieve messages directly on our website? All you need to do is create an account with us!
                    You will be able to send a message to Jake and the Swiss team right here in your browser. View message history and other account information by creating an account 
                    and heading over to the account page.</p>
                <h4><a href="create_new_user.php" id="create">Create Account</a></h4>
            </div>
        </div>
    
    <script src='./js/user_name.js'></script>
    <script src='./js/sidenav.js'></script>
    </body>
<html>