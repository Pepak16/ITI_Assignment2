<link rel="stylesheet" type="text/css" href="/pepak16/mvc/app/views/style/style.css">

<script src="ajax.js"></script>

<div id="headertitle"><h1>Photoshare</h1></div>

<?php
    include '../app/controllers/HomeController.php';
    $homecontroller = new HomeController();
    
    if (isset($_GET['option'])) {
        echo $_GET['option'];
        $homecontroller->changeMenuOptionTo($urlpart);
    }
?>

<ul>
    <li><a href="?option=home">Home</a></li>
    <?php 

        if ($_SESSION["logged_in"] == true) {
            
            echo "<li><a href=\"logout.php\">Logout</a></li>";
            echo "<li><input type=\"text\" name=\"search\" id=\"search\" onkeyup=\"showHint(this.value)\" placeholder=\"Search\"></li>";
            // echo "<li><p>You are logged in as:".$_SESSION["logged_in"]."</p></li>";
            
        } else {
            echo "<li><a href=\"?option=login\">Login</a></li>";
            echo "<li><a href=\"?option=register\">Signup</a></li>";
        }

    ?>
</ul>