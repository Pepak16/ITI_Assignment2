<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
        <?php
            require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/views/partials/top.php';
            //include '../partials/top.php';
            $homecontroller = new HomeController();
        ?>
        <script src="../../services/AjaxSearchbar.js"></script>
    </head>
    <body>
        <div id="content">
            <p>Type <b>the title</b> of a picture here to search for it automatically:</p>
            <input type="text" name="search" id="search" onkeyup="showHint(this.value)" placeholder="Search for a picture">
        </div>
            <?php 
                // AJAX attributes
                echo "<p style=\"color: white;\"><span id=\"txtHint\"></span></p>";
                echo '<span id="defaultpage">';
            ?>
       
    </body>
</html>