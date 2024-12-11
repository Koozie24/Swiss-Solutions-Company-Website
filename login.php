<!DOCTYPE HTML>
<?php
    include("config.php");
    session_start();

    $error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //username and password sent from form

        $myusername = mysqli_real_escape_string($db, $_POST['UserName']);
        $mypassword = mysqli_real_escape_string($db, $_POST['UserPw']);

        $sql = "SELECT UserID FROM swiss_users WHERE UserName = '$myusername' and UserPw = '$mypassword'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        //if result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1){
            $_SESSION['login_user'] = $myusername;

            header("location:account_home.php");
        }
        else {
            $error = "Username or Password is invalid";
        }
    }
?>
<head>
    <title>Login Page</title>

    <style type="text/css">
        input{
            margin: 1%;
        }
        body{
            font: 14px Courier, monospace;
            color: black;
            background-color: white;
        }
        .login-header{
            width: 50%;
            background-color: red;
            color: black;
            text-align: center;
            font-weight: bold;
            border: 2px solid black;
        }
        .login-box{
            width: 30vw;
            padding: 2%;
            border: 4px solid black;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #ececec;
        }
        .box{
            display: flex;
            flex-direction: column;
            padding: 2%;
        }
        .input-btn{
            margin-left: 2.5%;
            width: 100%;
            background-color: red;
            color: black;
            font-weight: bold;
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
        label{
            font-weight: bold;
        }
        .options{
            border-top: 4px solid black;
            border-bottom: 4px solid black;
            text-align: center;
            padding: 10px;
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
        @media screen and (max-width: 1025px) {
            .left-head{
                margin-right: 10%;
                width: 20vw;
                float: top;
            }
            .logo{
                font-size: 1rem;
            }
            .swiss-bear{
                max-height: 5rem;
                margin-top: 10%;
            }
        }
        .error{
            color: red;
            background-color: black;
            font-weight: bold;
            margin-bottom: 1%;
        }
    </style>
</head>

<!--I referenced your login page HTML code that you showed in the most recent SQL video on https://cs.indstate.edu/~cs609ka/examples.html*/-->
<body>
    <div class='main'>
        <div class='left-head'>
                    <img src='./img/swiss_bear_no_bg.png' class='swiss-bear'>
                    <a href='index.php' class='logo'>
                        <h1><span class='swiss-title' id='swiss'>Swiss</span> <span class='swiss-title'>Solutions</span></h1></a>
        </div>
        <div class="login-box">
            <div class="login-header"> <b>Login</b> </div>

            <div class="login-form">
                <form action="" method="post">
                    <label>Username:</label><input type="text" name="UserName" class="box"/>
                    <label>Password:</label><input type="password" name="UserPw" class="box"/>
                    <input class="input-btn" type="submit" value=" Submit "/><br />
                </form>
            </div>

            <div class="error">
                    <?php echo $error; ?>
            </div>

            <div class='options'>
                    <h4><a href="create_new_user.php" id="create">Create Account</a></h4>
            </div>
        </div>
    </div>

</body>
</html>