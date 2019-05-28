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
        <title>ShoppingCart</title>
        <style>
            #button, #buy {
                background-color: darkblue;
                color: white;
                font-style: italic;
                padding: 0.5em 5em;
                font-size: 12px;
                border-style: dotted;
            }

            #number {
                font-style: italic;
                font-size: 14px;
                border-color: gray;
                border-style: double;
                width: 5em;
            }

            #label {
                border-style: dotted;
            }

            @media (min-width: 62em) {
                #button, #buy, #label {
                    display:inline-table;
                }
            }

            @media (min-width: 46em) and (max-width: 62em) {
                #button, #buy {
                    display:inline-table;
                    width: 26%;
                    margin-right: 6%;
                }

                #label {
                    display:inline-table;
                    width: 26%;
                    margin-right: 38%;
                }
            }

            @media (min-width: 34em) and (max-width: 46em) {
                #buy {
                    display:inline-table;
                    width: 40%;
                    margin-right: 60%;
                }

                #button, #label {
                    display:inline-table;
                    width: 40%;
                    margin-right: 9%;
                }
            }

            @media (max-width: 34em) {
                #buy {
                    display:inline-table;
                    width: 25%;
                    padding: 0.5em 0em 0.5em 0em;
                }

                #label {
                    display:inline-table;
                    font-size: 90%;
                    width: 65%;
                }

                #number {
                    font-size: 90%;
                    width: 30%;
                }

                #button {
                    display:inline-table;
                    width: 90%;
                    margin-right: 10%;
                }

                .table {
                    width: 20%;
                }
            }
        </style>
    </head>
    <body>
        <!-- Update Function -->
        <?php
        if (isset($_POST['buy'])) {
            // Call in jQuery
        } else if (isset($_POST['delete'])) {
            if (isset($_POST['option'])) {
                foreach ($_POST['option'] as $option) {
//                    echo $option.'<br/>';
                    require 'database/deleteSelectedProduct.php';
                }
            }
        } else if (isset($_POST['deleteRow'])) {
            if (isset($_POST['option'])) {
                foreach ($_POST['option'] as $option) {
//                    echo $option.'<br/>';
                    require 'database/deleteAllSelectedProduct.php';
                }
            }
        } else if (isset($_POST['clearCart'])) {
            require 'database/clearSelectedProduct.php';
        }
        ?>
        <!-- Log in -->
        <?php require 'database/checkLogin.php'; ?>

        <!-- Menu -->
        <?php require 'layout/header.php'; ?>

        <!-- content -->
        <?php if (!isset($_COOKIE['login']) || $_COOKIE['login'] == "0") { ?>
            <div class="container page-body">
                <div class="alert alert-warning" role="alert">You haven't login</div>
            </div>
        <?php } else { ?>
            <div class="container page-body">
                <!-- product -->
                <div class="panel-heading"><span class="heading">MyCart</span></div>
                <div class="container" id="selectedProduct">
                    <!-- Content -->
                    <form method="POST">
                        <input type="submit" name="buy" value="Buy" id="buy">
                        <span id="label">Delete Amount: <input type="number" name="quantity" value="1" min="1" max="100" id="number"></span> <input type="submit" name="delete" value="Delete" id="button">
                        <input type="submit" name="deleteRow" value="DeleteRow" id="button">
                        <input type="submit" name="clearCart" value="ClearCart" id="button">
                        <?php require 'database/retrieveSelectedProduct.php'; ?>
                    </form>
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
                $("#menuBar ul li:nth-child(3)").addClass("active");

                $("#logout").click(function () {
                    $.removeCookie("login", {path: '/'});
                    $.removeCookie("loginTime", {path: '/'});
                    $.removeCookie("userID", {path: '/'});
                    $.removeCookie("username", {path: '/'});
                })

                $('.checkboxs').click(function () {
                    $('.checkbox').prop('checked', $('.checkboxs').is(':checked'));
                });

<?php if (isset($_COOKIE['login']) && $_COOKIE['login'] == "1") { ?>
                    $('#buy').click(function () {
                        var rowExist = '<?php echo $rowExist; ?>';
                        if (rowExist) {
                            // record
                            // YYYY-MM-DD HH:MI:
                            var productList = '<?php echo $productList; ?>';
                            var productSum = <?php echo $sum; ?>;
                            var date = new Date().getFullYear() + "-" + (new Date().getMonth() + 1) + "-" + new Date().getDate() + " " + new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();
                            $.ajax({
                                data: 'productList=' + productList + '&productSum=' + productSum + '&recordTime=' + date,
                                url: 'database/insertRecord.php',
                                method: 'POST',
                                async: false,
                                success: function (string) {
                                    $.get('database/clearSelectedProduct.php');
                                    $('#selectedProduct').html("<div><h4>Thank you for buying our products. 1 transactions is completed at " + Date() + "</h4></div>");
                                }
                            });
                        }
                    });
<?php } ?>
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
