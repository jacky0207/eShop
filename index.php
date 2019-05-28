<?php
if (isset($_POST['submit'])) {
    require 'database/dbConnect.php';

    $query = 'SELECT userID, username, password FROM ACCOUNT ORDER BY USERID';
    $result = $mysqli->query($query, MYSQLI_STORE_RESULT);

    while ($datas = $result->fetch_object()) {
        if ($_POST['username'] == $datas->username && $_POST['password'] == $datas->password) {
            // 10 minutes limit
            setcookie('login', "1", time() + 60 * 30, "/");
            setcookie('loginTime', time(), time() + 60 * 30, "/");
            setcookie('userID', $datas->userID, time() + 60 * 30, "/");
            setcookie('username', $datas->username, time() + 60 * 30, "/");
            header('Location: ' . $_SERVER['PHP_SELF']);
        }
    }

    $mysqli->close();
}
?>
<?php require 'database/checkLogin.php'; ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/layout.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <style>
            #rowButtom {                
                font-size: 15px;
                padding-bottom: 20px;
            }

            #input {
                padding: 6px 75px 12px 10px; 
            }

            #login {
                background-color: forestgreen;
                color: white;
                padding: 10px 20px;
                font-size: 15px;
                border: none;
            }
        </style>
        <title>ShoppingCart</title>
    </head>
    <body>
        <!-- Check login -->

        <!-- Login -->

        <!-- Menu -->
        <?php require 'layout/header.php'; ?>

        <!-- content -->
        <?php if (!isset($_COOKIE['login']) || $_COOKIE['login'] == "0") { ?>
            <div class="container page-body">
                <!-- Account -->
                <div class="panel-heading"><span class="heading">PhoneCart Login</span></div>
                <div class="panel-body">
                    <!-- Login form -->
                    <table>
                        <form method="POST">
                            <tr><td><h4><b>Username</b></h4></td></tr>
                            <tr><td id="rowButtom"><input type="text" name="username" placeholder="Username" id="input" required></td></tr>
                            <tr><td><h4><b>Password</b></h4></td></tr>
                            <tr><td id="rowButtom"><input type="password" name="password" placeholder="Password" id="input" required></td></tr>

                            <tr><td><input type="submit" name="submit" value="Login" id="login"></td></tr>
                        </form>        
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="container page-body">
                <div class="alert alert-success" role="alert">Welcome to use PhoneCart</div>
                <div class="panel panel-info">
                    <div class="panel-heading">Transaction Record</div>
                    <div class="panel-body"><?php require 'database/retrieveRecord.php'; ?></div>
                </div>
            </div>
        <?php } ?>

        <!-- footer -->
        <?php require 'layout/footer.php'; ?>


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                // Add active class to menu of current page
                $("#menuBar ul li:first-child").addClass("active");

                $("#logout").click(function () {
                    $.removeCookie("login", {path: '/'});
                    $.removeCookie("loginTime", {path: '/'});
                    $.removeCookie("userID", {path: '/'});
                    $.removeCookie("username", {path: '/'});
                })
            });
            // Add Login/Logout function
<?php if (!isset($_COOKIE['login']) || $_COOKIE['login'] == "0") { ?>
                $(".navbar-left").after("<ul class = \"nav navbar-nav navbar-right\"><li><p class=\"navbar-text\">Welcome Guest (<a href = \"index.php\">Log in</a>)</p></li></ul>");
<?php } else { ?>
                $(".navbar-left").after("<ul class = \"nav navbar-nav navbar-right\"><li><p class=\"navbar-text\">Welcome " + $.cookie("username") + " (<a href = \"index.php\" id=\"logout\">Log out</a>)</p></li></ul>");
<?php } ?>
        </script>
    </body>
</html>
