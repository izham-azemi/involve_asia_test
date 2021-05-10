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
}

$sql = "SELECT * FROM book WHERE b_id = ".$_GET['id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
	while($row = $result->fetch_assoc()) {
		$title = $row["title"];
		$year = $row["year_published"];
		$author = $row["author_name"];
	}
} else {
  echo "0 results";
}

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
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		  $status = false;
		}

		$sql = "UPDATE book SET title = '".$_POST["title"]."', year_published = ".$_POST["year"].", author_name = '".$_POST["author"]."' WHERE b_id = ".$_GET['id'];

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
<form method="post" action="http://localhost/involve_asia/form_update.php?id=<?php echo $_GET['id']; ?>">  
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