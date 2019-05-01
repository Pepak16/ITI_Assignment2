<!DOCTYPE html>
<html>
    <head>
        <title>Registration Succeeded!</title>
        <?php require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/views/partials/top.php'; ?>
    </head>
    <body>
        
        <div id="content">
            <br><br>
            <h1 style="color: green">Sign up succeeded</h1>
            <p>Well done! You followed the guidelines for user registration!</p>
        </div>
        <?php
            header("Refresh: 1; url=index.php");
        ?>
    </body>
</html>
