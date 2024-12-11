<!DOCTYPE HTML>
<?php
    include("config.php");
    session_start();

    //bool if post submitted or not, default false
    $submitted = false;
    $error = '';

    //check form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //escape special chars and assign values from form 
        $user = mysqli_real_escape_string($db, $_POST['UserName']);
        $user_pw = mysqli_real_escape_string($db, $_POST['UserPw']);
        $user_email = mysqli_real_escape_string($db, $_POST['Email']);
        $first_name= mysqli_real_escape_string($db, $_POST['FirstName']);
        $last_name = mysqli_real_escape_string($db, $_POST['LastName']);

        //query swiss_users to check for duplicate usernames
        $query = "SELECT UserName FROM swiss_users WHERE UserName='$user'";
        $check_identical = mysqli_query($db, $query);

        //preg_match and regex's from https://stackoverflow.com/questions/9587907/how-to-check-if-string-has-at-least-one-letter-number-and-special-character-in
        $ucl = preg_match('/[A-Z]/', $user_pw); // Uppercase Letter
        $lcl = preg_match('/[a-z]/', $user_pw); // Lowercase Letter
        $dig = preg_match('/\d/', $user_pw); // Numeral
        $nos = preg_match('/\W/', $user_pw); // Non-alpha/num characters (allows underscore)
        
        //check password and user not blank
        if($user == '' or $user_pw == ''){
            $error = "* Username and/or password cannot be left blank.";
        }
        elseif($first_name == '' or $last_name == '' or $user_email == ''){
            $error = "* Name and/or email fields cannot be left blank.";
        }
        elseif(strlen($user) < 5){
            $error = "* Username must be a minimum of 5 characters.";
        }
        //check user and password are correct complexity
        elseif(strlen($user_pw) <= 8 or !$ucl or !$lcl or !$dig or !$nos){
            $error = nl2br("* Password complexity requirements: \n
                    - Longer than 8 characters \n
                    - One uppercase and one lowercase letter\n    
                    - One number\n    
                    - One special character");
        }
        //check if query returns rows
        elseif(mysqli_num_rows($check_identical) > 0){
            $error = "* Username is already in use. Please enter a differnt username.";
        }
        elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            $error = nl2br("* Not a valid email address.\n
                            Format: email@domain.com\n
                            Your input: ". $user_email ."");
        }

        else{
            //format insert statement
            $sql = "INSERT INTO swiss_users (UserName, UserPw, Email, FirstName, LastName) values ('$user', '$user_pw', '$user_email', '$first_name', '$last_name')";

            //run query and check if true
            if(mysqli_query($db, $sql)){
                $posted = true;
                //redirect to login page
                header("location: login.php");
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
    body{
        font: 14px Courier, monospace;
        color: black;
        background-color: white;
    }
    a, a:active{
        color: black;
        text-decoration: none;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
        text-align: center;
        padding: 12px;
        border: 2px solid black;
        margin: 1px;
        background-color: white;
    }
    a:hover{
        filter: brightness(150%);
        background-color: red;
        color: black;
    }
    .options{
        border: 4px solid black;
        text-align: center;
        padding: 10px;
        background-color: #ececec;
    }
    label{
        font-weight: bold;
        color: black;
        margin-top: 1%;
        margin-bottom: 1%;
    }
    form{
        display: flex;
        flex-direction: column;
        margin-left: 2%;
        width: 25%;
        justify-content: center;
        background-color: #ececec;
        border: 2px solid black;
        padding: 10px;
        margin-bottom: 2%;
    }
    
    .input-btn{
        height: 2vw;
        width: 100%;
        background-color: white;
        color: black;
        font-weight: bold;
    }
    .input-btn:hover{
        filter: brightness(150%);
        background-color: red;
        color: black;
        font-weight: bold;
    }
    .logo{
        font-weight: bold;
        color: red;
        width: 100%;
        height: auto;
        font-size: 1.5rem;
        white-space: wrap;
        padding: 10px 10px;
        border: 3px solid white;
        float: left;
    }
    .logo:hover{
        border: 3px solid black;
    }
    .left-head{
        width: 30vw;
        float: top;
        background-color: white;
        display: flex;
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
    }
    .main{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .error{
        color: red;
        background-color: black;
        font-weight: bold;
    }
</style>
<html>
<head>
    <title>Submit a Post</title>
</head>

<body>
    <div class='main'>
        <div class='left-head'>
            <img src='./img/swiss_bear_no_bg.png' class='swiss-bear'>
            <a href='index.php' class='logo'>
            <h1><span class='swiss-title' id='swiss'>Swiss</span> <span class='swiss-title'>Solutions</span></h1></a>
        </div>

        <form action="create_new_user.php" method="post">
            <label class="form-label"><b>Username: </b></label>
                <input type="text" class="text-inp" name="UserName"><br />
            
            <label class="form-label"><b>Password: </b></label>
                <input type="text" class="text-inp" name="UserPw"><br />

            <label class="form-label"><b>First Name: </b></label>
                <input type="text" class="text-inp" name="FirstName"><br />

            <label class="form-label"><b>Last Name: </b></label>
                <input type="text" class="text-inp" name="LastName"><br />

            <label class="form-label"><b>Email Address: </b></label>
                <input type="text" class="text-inp" name="Email"><br />

            <input class="input-btn" type="submit" value="Submit"/><br />
            <div class="error">
                    <?php echo $error; ?>
            </div>
        </form>

        <div class='options'>
            <h4><a href="login.php" id="login">Return to Login</a></h4>
        </div>
       

      
    </div>
</body>

</html>