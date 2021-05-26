<?php
// Initialize the session
//session_start();
 
$msg = "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the user is already logged in, if yes then redirect him to admin page
/*if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.html");
    exit;
}*/
 
// Define variables and initialize with empty values
$username = "";
$password = "";
$username_err = "";
$password_err = "";
 
// Processing form data when form is submitted
if (isset($_POST['submit'])) {
	
	$username = $conn->real_escape_string($_POST['username']);
	$password = $conn->real_escape_string($_POST['password']);
	
	$sql = $conn->query("SELECT password FROM admin WHERE username='$username'");
	
	if ($sql->num_rows > 0) {
		$data = $sql->fetch_array();
		if ($password == $data['password']) {
			/*session_start();
			$_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;*/
			
			header("location: admin.php");
		} else {
			$msg = "Το όνομα χρήστη ή ο κωδικός δεν είναι σωστά.";
		}
	} else {
		$msg = "Ελέγξτε τις τιμές που εισάγατε.";
	}
}

$conn->close();

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<meta name="viewport", content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="rwdStyle.css" />

</head>

<body>

<div class="bgimg"></div>

<form class="box col-7 col-s-7" action="log.php" method="post">

<h1>Συνδεθειτε ως διαχειριστης</h1>

<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<input type="submit" name="submit" value="Είσοδος">
<?php echo "<p style='color: white;'>".$msg."</p>" ?>

</form>

</body>

</html>