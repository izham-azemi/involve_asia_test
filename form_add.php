<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
$titleErr = $yearErr = $authorErr = "";
$title = $year = $author = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["title"])) {
		$titleErr = "Title is required";
	} else {
		$title = test_input($_POST["title"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$title)) {
		  $titleErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["year"])) {
		$yearErr = "Year is required";
	} else {
		$year = test_input($_POST["year"]);
		if (!preg_match("/^[1-9][0-9]*$/",$year)) {
		  $yearErr = "Only Numbers allowed";
		}
	}

	if (empty($_POST["author"])) {
		$authorErr = "Author is required";
	} else {
	$author = test_input($_POST["author"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$author)) {
		  $authorErr = "Only letters and white space allowed";
		}
	}
  
	if ($titleErr == "" && $yearErr == "" && $authorErr == ""){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "involve_asia";
		$status = true;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		  $status = false;
		}

		$sql = "INSERT INTO book (title, year_published, author_name)
		VALUES ('".$_POST["title"]."', ".$_POST["year"].", '".$_POST["author"]."')";

		if ($conn->query($sql) === TRUE) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		  $status = false;
		}

		$conn->close();
		
		if ($status == true){
			header('Location: http://localhost/involve_asia/index.php');
		}
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<h2>Add Book</h2>
<a href="http://localhost/involve_asia/index.php">Back</a>
<br><br>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	Title: <input type="text" name="title" value="<?php echo $title;?>">
	<span class="error">* <?php echo $titleErr;?></span>
	<br><br>
	Year Published: <input type="text" name="year" value="<?php echo $year;?>">
	<span class="error">* <?php echo $yearErr;?></span>
	<br><br>
	Author Name: <input type="text" name="author" value="<?php echo $author;?>">
	<span class="error">* <?php echo $authorErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>