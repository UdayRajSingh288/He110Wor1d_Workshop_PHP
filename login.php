<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <form action = "login.php" method = "POST">
            <a href="./index.php">Home</a>
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <a href="./registration.php">New User/Sign Up</a>
		<input type = "submit" name = "submit" value = "Login">
        </form>
    </div>
</body>
</html>

<?php
	session_start();

	if (!isset($_SESSION["logged_in"])){
		$_SESSION["logged_in"] = false;
	}

	if (isset($_POST["submit"])){
		if ($_SESSION["logged_in"] == false){
			$fp = @fopen("users.csv", "r");
			$un = $_POST["username"];
			$pw = hash("sha256", $_POST["password"]);
			if ($fp){
				while (($row = fgetcsv($fp)) != false){
					if ($row[0] == $un && $row[2] == $pw){
						$_SESSION["logged_in"] = true;
						/*echo "<script>alert(\"You are now logged in!\");</script>";*/
						header('Location: '.$uri.'/website/');
						break;
					}
				}
				if ($_SESSION["logged_in"] == false){
					echo "<script>alert(\"Username or password incorrect!\");</script>";
				}
				fclose($fp);
			}
			else {
				echo "<script>alert(\"No users!!\");</script>";
			}
		}
		else {
			echo "<script>alert(\"You are already logged in!\");</script>";
		}
		$_POST["submit"] = null;
	}
?>