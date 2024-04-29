<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./registration.css">
    <title>Registration</title>
</head>
<body>
    <div class="regi">
     
        <form action = "registration.php" method = "POST">
            <a href="./index.php">Home</a>
            <h2>Registration</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="password">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required>

             <a href="./login.php">Already a User/Sign In</a>
		<input type = "submit" name = "submit" value = "Register">
        </form>
    </div>
</body>
</html>

<?php

	session_start();

	function checkRecord(){
		$fp = @fopen("users.csv", "r");
		if ($fp){
			while (($row = fgetcsv($fp)) != false){
				if ($row[0] == $_POST["name"]){
					fclose($fp);
					return false;
				}
				if ($row[1] == $_POST["email"]){
					fclose($fp);
					return false;
				}
			}
			fclose($fp);
			return true;
		}
		return true;
	}

	function writeRecord(){
		if (checkRecord()){
			$row = array();
			$fp = fopen("users.csv", "a");
			$row[0] = $_POST["name"];
			$row[1] = $_POST["email"];
			$row[2] = hash("sha256", $_POST["password"]);
			fputcsv($fp, $row);
			fclose($fp);
			return true;
		}
		else {
			echo "<script>alert(\"Username or email id already taken!\");</script>";
			return false;
		}
	}

	if (isset($_POST["submit"])){
		$_POST["submit"] = null;
		if (writeRecord()){
			$_SESSION["userid_created"] = true;
			header('Location: '.$uri.'login.php');
		}
	}
?>