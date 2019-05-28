<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/layout.css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <style>
            #productCompany {
                background-color: transparent;
                border-style: solid;
                padding: 0.5em 4em;
                font-size: 14px;
            }
            #addToCart {
                background-color: darkblue;
                color: white;
                font-style: italic;
                padding: 0.5em 1.5em;
                font-size: 12px;
                border-style: dotted;
            }

            @media (min-width: 72em) {
                .product {
                    display:inline-table;
                    margin-left: 5%;
                    margin-right: 5%;
                    margin-bottom: 5%;
                    width: 15%;
                }
            }

            @media (min-width: 48em) and (max-width: 72em) {
                .product {
                    display:inline-table;
                    margin-left: 8%;
                    margin-right: 8%;
                    margin-bottom: 5%;
                    width: 17%;
                }
            }

            @media (min-width: 34em) and (max-width: 48em){
                .product {
                    display:inline-table;
                    margin-left: 15%;
                    margin-right: 15%;
                    margin-bottom: 5%;
                    width: 20%;
                }
            }

            @media (max-width: 34em){
                .product {
                    display:inline-table;
                    margin-left: 25%;
                    margin-right: 25%;
                    margin-bottom: 5%;
                    width: 50%;
                }

                #productCompany {
                    width: 50%;
                    padding: 0.5em 0em 0.5em 1em;
                    font-size: 14px;
                }
            }
        </style>
        <title>ShoppingCart</title>
    </head>
    <body>
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
                <div class="panel-heading"><span class="heading">ShoppingList</span></div>
                <div class="panel-body">
                    <!-- Selector -->
                    Category: <?php require 'database/retrieveProductCategory.php'; ?>

                    <hr />

                    <!-- Content -->
                    <div id="product">                        
                        <?php require 'database/retrieveProduct.php'; ?>
                    </div>
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
                $("#menuBar ul li:nth-child(2)").addClass("active");

                $("#logout").click(function () {
                    $.removeCookie("login", {path: '/'});
                    $.removeCookie("loginTime", {path: '/'});
                    $.removeCookie("userID", {path: '/'});
                    $.removeCookie("username", {path: '/'});
                })

                $("#productCompany").change(function () {
                    $.ajax({
                        data: 'productCompany=' + $(this).val(),
                        url: 'database/retrieveProduct.php',
                        method: 'POST',
                        success: function (string) {
                            $("#product").html(string);
                        }
                    });
                });

                $("button").click(function () {
                    var button = $(this);
                    $.ajax({
                        data: 'productID=' + $(this).val(),
                        url: 'database/insertProduct.php',
                        method: 'POST',
                        success: function (string) {
                            button.css('background-color', 'white');
                            button.css('color', 'darkblue');
                            setTimeout(function () {
                                button.css('background-color', 'darkblue');
                                button.css('color', 'white');
                            }, 100);
                        }
                    });
                });
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
