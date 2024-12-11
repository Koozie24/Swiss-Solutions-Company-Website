<!DOCTYPE HTML>

<?php
    include("config.php");
    session_start();

    //checking user is logged in
    if (!isset ($_SESSION['login_user'])){
        header("location:login.php");
        die();
    }
    
    $submitted_new_message = false;
    $submitted_new_reply = false;

    //get the username of the current logged in user
    $current_user = $_SESSION['login_user'];

    //track errors and success
    $error = '';
    $success = '';

    //check if new message was submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //get submission for new message
        if(isset($_POST['Subject'])){
            //get message contents
            $new_message_subject = mysqli_real_escape_string($db, $_POST['Subject']);

            if($new_message_subject != ''){
                //format query 
                $conv_query = "INSERT INTO conversation (Subject, User) values ('$new_message_subject', '$current_user')";
                //send query
                $conversation_submit = mysqli_query($db, $conv_query);

                //check response
                if($conversation_submit){
                    $submitted_new_message = true;
                    $success = 'Message Sent!';
                    //https://stackoverflow.com/questions/8335828/how-to-delete-post-variable-upon-pressing-refresh-button-on-browser-with-php
                    //redirect user to clear $_POST
                    header("location:account_home.php");
                }
                elseif(!$conversation_submit){
                    $error = 'Message Failed to send.';
                }
            }
            else{
                $error = 'Cant send blank message.';
            }
        }

        //check if reply was submitted 
        if(isset($_POST['ReplyMessage'])){
            //get reply and id
            $new_reply = mysqli_real_escape_string($db, $_POST['ReplyMessage']);
            if($new_reply != ''){
                $which_conv = mysqli_real_escape_string($db, $_POST['ConversationId']);
                //format and run query 
                $reply_query = "INSERT INTO swiss_replies (ConversationId, ReplyMessage, Sender) values ('$which_conv', '$new_reply', '$current_user')";
                $reply_submit = mysqli_query($db, $reply_query);
                //check if successful insertion
                if($reply_submit){
                    $submitted_new_reply = true;
                    $success = 'Reply Sent!';
                    //redirect user to clear $_POST
                    header("location:account_home.php");
                }
                elseif(!$reply_submit){
                    $error = 'Reply Failed to send.';
                }
           }
            else{
                $error = 'Cant send blank reply.';
            }
        }
        else{
            $error = 'No Reply Sent';
        }

    }

    if($current_user){
        $my_qry = "SELECT Email, FirstName, LastName, Created FROM swiss_users WHERE UserName = '$current_user'";
        $ret = mysqli_query($db, $my_qry);
        $ret_row = mysqli_fetch_array($ret, MYSQLI_ASSOC);

        $count = mysqli_num_rows($ret);

        if($count){
            $current_email = $ret_row['Email'];
            $current_first = $ret_row['FirstName'];
            $current_last = $ret_row['LastName'];
            $current_created = $ret_row['Created'];
        
        }
    }

?>
<style>
    /*Genereal top navigation and body style standard across site */
    body{
        /*font: 14px "Open Sans", Arial, "Helvetica Neue", Helvetica, sans-serif;*/
        font: 14px Courier, monospace;
        color: black;
        background-color: #d8d8d8;
        padding: 0;
        margin: 0;
    }
    a, a:active{
        color: black;
        text-decoration: none;
        line-height: 25px;
        border-radius: 4px;
        text-align: center;
        padding: 12px;
        float: left;
        margin: 1px;
        background-color: white;
    }
    .top-row, #top-about, #user-top{
        font-weight: bold;
        font-size: 18px;
        background-color: #ececec;
        border: 2px solid black;
    }
    #user-top:hover, #top-about:hover, a:hover{
        background-color: #b22222;
        /*background-color: #ff474c;*/
        border: 3px solid black;
        filter: brightness(200%);
        color: black;
    }
    .logo:hover{
        background-color: #b22222;
        color: black;
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
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
        width: 92%;
        margin-right: 5%;
    }

    /*  #######                                     ####### 
        #######    STANDARD CSS BOILDERPLATE STOPS  ####### 
        #######                                     ####### 
    */


    /*  #######                                         ####### 
        #######    Styles that cover account dropdown   ####### 
        #######                                         ####### 
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

    /*  #######                                                 ####### 
        #######    Begin styles that hold messages in account   ####### 
        #######                                                 ####### 
    */
    .display-messages{
        font-family: "Avenir Next Condensed Medium", Calibri, "Gill Sans", sans-serif;
        display: flex;
        flex-direction: column;
        margin: 1%;
        margin-top: 0;
        height: 100%;
    }

    /*  #######                                                 ####### 
        #######    Styles that cover new chat button and form   ####### 
        #######                                                 ####### 
    */
    .msg-titles{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1%;
    }
    h2{
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        width: 100%;
        color: red;
        text-align: center;
    }
    .new-message-container{
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
    }
    .new-form{
        width: 100%;
        display: flex;
        align-items: center;
        font-weight: bold;
        flex-direction: column;
        border: 2px solid black;
        background-color: white;
        padding: 2%;
    }
    .new-message{
        width: 50%;
        display: none;
        align-items: center;
    }
    .author{
        display: flex;
        width: 100%;
        justify-content: center;
    }
    .auth-message, .auth-message:active{
        color: black;
        display: inline-block;
        font-family: Courier, monospace;
        width: 20%;
        font-size: 24px;
        text-align: center;
        font-weight: bold;
        background-color: white;
        margin-top: 10px;
        margin-bottom: 10px;
        border: 3px solid #d8d8d8;
    }
    .input-btn, .reply-btn{
        margin-top: 10px;
        width: 25%;
        color: black;
        font-weight: bold;
        
    }
    .input-btn{
        background-color: #b22222;
        filter: brightness(200%);
    }
    .message-header{
        width: 100%;
        background-color: #b22222;
        filter: brightness(200%);
        color: black;
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
        border: 2px solid black;
        margin-bottom: 10px;
    }
    .box{
        background-color: #ececec;
        width: 98%;
    }

    /*  #######                                                 ####### 
        #######    Begin styles for message history conatiner   ####### 
        #######                                                 ####### 
    */
    .message-box{
        float: left;
        background-color: grey;
    }
    .conversation-box{
        background-color: white;
        /*
        took from styles in inspect https://css-tricks.com/newsletters/ 
        https://stackoverflow.com/questions/21227287/make-div-scrollable*/
        overflow-y: auto;
        max-height: 40vw;
        width: 45%;
        display: flex;
        flex-direction: column;
        padding: 10px;
        font-weight: bold;
        align-items: flex-start;
        border-top: 1px solid grey;
        border-bottom: 1px solid grey;
        margin-top: -11px;
        margin-bottom: 10px;
        float: right;
    }
    @media screen and (max-width: 1441px){
        .conversation-box{
            margin-left: 1%;
            width: 40%;
        }
    }
    .just-messages{
        display: flex;
        flex-direction: column;
        width: 100%;
        font-family: "Avenir Next Condensed Medium", Calibri, "Gill Sans", sans-serif;
    }
    .message-box, .user-pov, .first-msg, .first-msg-admin{
        background-color: #aeb9cc;
        color: black;
        width: 65%;
        margin: 5px 0;
        border-radius: 8px;
    }
    .user-pov, .first-msg, .first-msg-admin{
        background-color: #218AFF;
        margin-left: 10%;
        float: right;
    }
    
    .msg-from-user, .time-sent{
        margin-left: 1%;
        margin-right: 1%;
    }
    .reply-form{
        display: flex;
        width: 100%;
    }
    .box-reply{
        margin-top: 2.4%;
        margin-bottom: 2%;
        background-color: #ececec;
        width: 100%;
    }
    .reply-btn{
        width: 10%;
        background-color: white;
        margin-bottom: 2%;
        margin-top: 2.4%;
        padding: 10px 5px;
        margin-right: 1%;
    }
    .reply-btn:hover{
        filter: brightness(110%);
        background-color: #218AFF;
    }
    .toggle-container{
        width: 50%;
        display: block;
    }
    .toggle{
        display: flex;
        flex-direction: column;
        width: 100%;
        background-color: none;
        height: 100%;
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        border: 4px solid #d8d8d8;
    }
    .history{
        width: 50%;
        height: 2vw;
        color: #b22222;
        margin-bottom: 1%;
        text-align: center;
        filter: brightness(150%);
        font-size: 2.5rem;
    }
    @media screen and (max-width: 1025px){
        .history{
            margin-bottom: 4%;
        }
    }
    .show-message, .show-message:active{
        margin-left: 3%;
        margin-right: 3%;
    }
  
    .message-row{
        width: 100%;
    }
    .error{
        display: block;
        color: red;
        font-weight: bold;
        margin-bottom: 1%;
        margin-left: 2%;
        margin-top: 3%;
    }

    /*  #######                                                 ####### 
        #######    Styles that cover account infromation        ####### 
        #######                                                 ####### 
    */

    .account-welcome{
        display: flex;
        margin-top: 1%;
        font-weight: bold;
    }
    .welcome-text{
        width: 75%;
        padding: 5px;
        border-radius: 4px;
        margin-left: 1%;
        margin-right: 1%;
        font-size: 20px;
        font-weight: bold;
        background-color: white;
    }
    .account-info{
        width: 25%;
        padding: 5px;
        border-radius: 4px;
        margin-left: 1%;
        margin-right: 1%;
        font-size: 20px;
        font-weight: bold;
        background-color: white;
    }
    h2{
        text-align: center;
    }
    .aip, .wp{
        font-family: "Avenir Next Condensed Medium", Calibri, "Gill Sans", sans-serif;
        text-decoration: underline;
        font-weight: bold;
    }
    .wp{
        padding: 5px;
        text-decoration: none;
    }
</style>

<html>

    <head>
        <title>Account Home</title>
    </head>

    <body>
        <div class='top-navigation'>
            <span class='left-head'>
                <img src='./img/swiss_bear_no_bg.png' class='swiss-bear'>
                <a href='index.php' class='logo'>
                    <h1 class='swiss-title' ><span class='swiss-title' id='swiss'>Swiss</span> <span class='swiss-title'>Solutions</span></h1></a>
            </span>
            <div class='right-head'>
                <?php
                    echo" <a href='' class='user-btn' id='user-top'><b>$current_user</b></a>" ;
                ?>

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
    
    <div class='account-welcome'>
        <div class='welcome-text'>
        <?php
            echo "<h2> Welcome $current_user!</h2>";
        
        ?>

        <p class='wp'>On this page, you will find information about your account, as well as be able to communicate directly with Jake from Swiss Solutions.</p>
        <p class='wp'>Asking a question or beginning an inquiry for our services is as simple as starting a new conversation with us by clicking the new chat button below and typing your message. For each conversation,
            message history and replies are visible by selecting the chat that you wish to display. You may also submit and view replies to messages here. 
            
            Messages that you have sent to us will appear in blue, and our responses will be shown in grey. 
        </p>
        <p class='wp'>We are happy that you are here and are excited to being working with you right away!</p>
        </div>

        <div class='account-info'>
            <h2>Account Information</h2>
            <?php
                echo "<p class='aip'>Username: <i>$current_user</i> </p>";
                echo "<p class='aip'>Email Address:<i> $current_email</i> </p>";
                echo "<p class='aip'>First Name:<i> $current_first </i></p>";
                echo "<p class='aip'>Last Name: <i>$current_last </i></p>";
                echo "<p class='aip'>Date Joined: <i>$current_created </i></p>";
            
            ?>
        </div>
    </div>

    <div class='display-messages'>
        <div class='new-message-container'>
            <div class='author'>
                <a href='' class='auth-message'><i class="fa fa-plus"></i> New Chat</a>
            </div>

            <div class="new-message">
                <form class='new-form' action="" method="post">
                    <label class='message-header'>Message:</label>
                    <input type="text" name="Subject" class="box"/>
                    <button type="submit" class="input-btn">
                        <i class="fa fa-paper-plane"></i> Send
                    </button>

                    <div class="error">
                        <?php echo $error; 
                        echo $success; ?>
                    </div>
                    
                </form>
            </div>

        </div>
        <div class='msg-titles'>
            <h2 class='history'>Message History</h2>
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
        
        //checking user is logged in
        if (!isset ($_SESSION['login_user'])){
            header("location:login.php");
            die();
        }

        //variable to toggle between first message blue or grey
        $admin_status = 'first-msg';

        //check if user is administrator
        if($current_user == 'Jadmin'){
            //display all conversations
            $check_for_conversations = "SELECT ConversationId, Subject, User, Created FROM conversation ORDER BY ConversationId DESC";
            $admin_status = 'first-msg-admin';
        }
        //display only conversations between current user and admin
        else{
            $check_for_conversations = "SELECT ConversationId, Subject, User, Created FROM conversation WHERE User = '$current_user' ORDER BY ConversationId DESC";
        }
        //run query
        $return_conversations = mysqli_query($db, $check_for_conversations);
        
        
        //check if rows returned
        if(mysqli_num_rows($return_conversations) > 0){
            //loop through conversation rows
            while($conv_row = mysqli_fetch_assoc($return_conversations)){
                //get current convo id
                $current_convo = $conv_row['ConversationId'];
                //get date and format
                $full_time_string = format_timestamp($conv_row['Created'], $num_to_mo);
                
                //display first message and conversation container
                echo "<div class='toggle-container'>";
                    echo " <div class='toggle'>
                    <a href='' class='show-message' id='conv-$current_convo' onmouseover='example(this)'> " . $conv_row['Subject'] ."<h4>Sent $full_time_string</h4></a>
                            
                        </div>";

                echo"</div>";

                echo "<div class='conversation-box' id='boxconv-$current_convo' onmouseover='example(this)'>";
                echo "<div class='just-messages'>";
                echo "<div class='message-row'>";
                    echo "<div class='$admin_status'>";
                            echo "<p class='msg-from-user' >" .$conv_row['Subject'] . "</p>";
                            echo "<p class='time-sent' ><i>". $conv_row['User'] . "</i> | " .$full_time_string ."| </p>";
                        echo "</div>";
                echo "</div>";

                //format reply query
                $check_for_replies = "SELECT ReplyId, ConversationId, ReplyMessage, Sender, Created FROM swiss_replies WHERE ConversationId = '$current_convo' ORDER BY ReplyId ASC";
                //run query
                $return_replies = mysqli_query($db, $check_for_replies);
                //check if query returns rows
                if(mysqli_num_rows($return_replies) > 0){
                    //loop through replies to display
                    while($reply_row = mysqli_fetch_assoc($return_replies)){
                        $current_reply = $reply_row['ReplyId'];
                        //get date and format
                        $full_time_string = format_timestamp($reply_row['Created'], $num_to_mo);
                        //check if reply is sent by current logged in user
                        //will display in blue and on the right
                        if($reply_row['Sender'] == $current_user){
                            echo "<div class='message-row'>";
                            echo "<div class='user-pov'>";
                            echo "<p class='msg-from-user' >" .$reply_row['ReplyMessage'] . "</p>";
                            echo "<p class='time-sent' ><i>You </i>| " .$full_time_string ."|</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                        //otherwise, displays in grey on the left
                        else{
                            echo "<div class='message-row'>";
                            echo "<div class='message-box'>";
                            echo "<p class='msg-from-user' >" .$reply_row['ReplyMessage'] . "</p>";
                            echo "<p class='time-sent' > <i>". $reply_row['Sender'] ."</i> | " .$full_time_string ."|</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                }

                echo "</div>";
                //display reply form to reply to message
                echo "
                <form class='reply-form' action='account_home.php' method='post'>
                    <button type='submit' class='reply-btn'>
                        <i class='fa fa-paper-plane'></i>
                    </button>
                    <input type='text' name='ReplyMessage' class='box-reply'/>
                    <input type='hidden' name='ConversationId' value='$current_convo' class='box-reply'/>
                    <input type='hidden' name='Sender' value='$current_user' class='box-reply'/>
                    
                    <div class='error'>
                        $error
                        $success
                    </div>
                </form>";

                echo "</div>";
            }
        }
    ?>
        </div>
    </div>

    <!--<script src='./js/show_message.js'></script>-->
    <script src='./js/new_message.js'></script>
    <script src='./js/user_name.js'></script>
    <script src='./js/sidenav.js'></script>
    </body>

</html>