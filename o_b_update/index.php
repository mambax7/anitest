<?php
//print_r($_POST); //exit;
if (($_POST[username] === 'admin') && ($_POST[password] === 'admin')) {
    session_start();
    $_SESSION['username'] = $_POST[username]; ?>
    <script type="text/javascript">
        document.location = 'http://thepetglider.com/pedigree/modules/animal/o_b_update/mainpage.php';
    </script>
    <?php

} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!-----Meta----->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Owner/Breeder login Form</title>

    <!--ANALYTICS CODE-->
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-29231762-1']);
        _gaq.push(['_setDomainName', 'dzyngiri.com']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>


    <!--Stylesheets-->
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="css/dzyngiri.css" rel="stylesheet" type="text/css">
    <link href="fonts/pacifico/stylesheet.css" rel="stylesheet" type="text/css"/>

    <!--Scripts-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!--Sliding icons-->
    <script type="text/javascript">
        $(document).ready(function () {
            $(".username").focus(function () {
                $(".user-icon").css("left", "-48px");
            });
            $(".username").blur(function () {
                $(".user-icon").css("left", "0px");
            });

            $(".password").focus(function () {
                $(".pass-icon").css("left", "-48px");
            });
            $(".password").blur(function () {
                $(".pass-icon").css("left", "0px");
            });
        });
    </script>

</head>
<body>

<div class="heading">
    Owner/Breeder Update Process
</div>

<div id="wrapper">
    <!--Sliding icons-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END Sliding icons-->

    <!--login form inputs-->
    <form name="login-form" class="login-form" action="" method="post">

        <!--Header-->
        <div class="header">
            <h1>Login Form</h1>
            <!--<span>Please login by using this beautiful login form or if you dont have an account, you can Register!</span>-->
        </div>
        <!--END header-->

        <!--Input fields-->
        <div class="content">
            <!--USERNAME--><input name="username" type="text" class="input username" placeholder="Username"/><!--END USERNAME-->
            <!--PASSWORD--><input name="password" type="password" class="input password" placeholder="Password"/><!--END PASSWORD-->
        </div>
        <!--END Input fields-->

        <!--Buttons-->
        <div class="footer">
            <!--Login button--><input type="submit" name="submit" value="Login" class="button"/><!--END Login button-->
            <!--Register button--><input type="submit" name="submit" value="Register" class="register"/><!--END Register button-->
        </div>
        <!--END Buttons-->

    </form>
    <!--end login form-->

</div>

<!--bg gradient-->
<div class="gradient"></div><!--END bg gradient-->

<!-- dzyngiri bottom bar (Only for demo) -->
<!-- <div class="dzyngiri-bottom">
     <a href="http://www.dzyngiri.com/index.php/creating-beautiful-login-form/"><strong>&laquo; Back to the Dzyngiri article</strong></a>

     <span>Background image by,
     <a href="http://dribbble.com/shots/520512-Rainbow-wallpaper" target="_blank">
         <strong style="font-style:italic;">Florin Gorgan</strong>
     </a>
     </span>

     <span class="right">
         <a href="http://www.dzyngiri.com">
             <img src="images/DGlogo.png" style=" margin-top:6px;" title="To home" alt="Dzyngiri" />
         </a>
     </span>
     <div class="clr"></div>
 </div>-->
<!--/ dzyngiri bottom bar -->

</body>
</html>
