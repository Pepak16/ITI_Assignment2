<!-- <?php include '../app/views/partials/menu.php'; ?>

You are now logged in!
<br><br>
<form method="POST" action="/mvc/public/home/logout">
	<input type="submit" />
</form> -->

<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
</head>
    <body>
		<?php 
			include '../app/views/partials/top.php';

			$username = $_POST['username'];
			$password = $_POST['password'];

			if (isset($_POST['submit'])) {
				if (loginUser($username,$password)) {    
						$_SESSION["logged_in"] = true;
						echo 'You are now logged in';
						$warningtext = "";
						header('Location: login_succes_page.php');
				} else {
					$warningtext = "Wrong info.. Please try again.";
				}
			}
        ?>
		
        <div id="content">
            <h1>Login</h1>
            <form method="post" action="">
                <label title="Username">Username</label>
                <br>
                <br>
                <input type="text" name="username" id="username"/> 
                <br>  
                <br>
                <label title="Password" for="password">Password</label>
                <br>
                <br>
                <input type="password" name="password" id="password"/> 
                <br>
                <br>
                <br>
                <br>
                <input type="submit" name="submit" id="submit" value="Submit"/> 
                <br>
                <br>
                <input type="button" value="Go back" onclick="history.back()">
                <br>
                <br>
            </form> 
            <?php 
            echo '<span style="color: red;">'.$warningtext.'</span>'; ?>
        </div>
    </body>
</html>


