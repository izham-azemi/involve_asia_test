<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<h2>Book List</h2>
<a href="http://localhost/involve_asia/index.php">Back</a>
<br><br>
<?php
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
		echo "id: " . $row["b_id"]. " - Title: " . $row["title"]. " - Year Published: " . $row["year_published"]. " - Author Name: " . $row["author_name"]."<br>";
	}
} else {
  echo "0 results";
}

echo '<br><br>';
echo '<h2>Review</h2>';

$sql_review = "SELECT * FROM book_review WHERE b_id = ".$_GET['id'];
$result_review = $conn->query($sql_review);

if ($result_review->num_rows > 0) {
  // output data of each row
	while($row_review = $result_review->fetch_assoc()) {
		echo "Review: " . $row_review["review"]. " - Posted By: " . $row_review["posted_by"]." <a href='http://localhost/involve_asia/delete_review.php?id=".$row_review["br_id"]."&b_id=".$_GET['id']."'>Delete</a><br>";
	}
} else {
  echo "0 results";
}

$conn->close();

$reviewErr = $posted_byErr = "";
$review = $posted_by = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["review"])) {
		$reviewErr = "Review is required";
	} else {
		$review = test_input($_POST["review"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$review)) {
		  $reviewErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["posted_by"])) {
		$posted_byErr = "Posted by is required";
	} else {
		$posted_by = test_input($_POST["posted_by"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$posted_by)) {
		  $posted_byErr = "Only letters and white space allowed";
		}
	}
  
	if ($reviewErr == "" && $posted_byErr == ""){
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		  $status = false;
		}

		$sql = "INSERT INTO book_review (b_id, review, posted_by)
		VALUES (".$_GET['id'].", '".$_POST["review"]."', '".$_POST["posted_by"]."')";

		if ($conn->query($sql) === TRUE) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		  $status = false;
		}

		$conn->close();
		
		if ($status == true){
			header('Location: http://localhost/involve_asia/view.php?id='.$_GET['id']);
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

<h2>Add Review</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="http://localhost/involve_asia/view.php?id=<?php echo $_GET['id']; ?>">  
	Review: <input type="text_area" name="review" value="<?php echo $review;?>">
	<span class="error">* <?php echo $reviewErr;?></span>
	<br><br>
	Posted By: <input type="text" name="posted_by" value="<?php echo $posted_by;?>">
	<span class="error">* <?php echo $posted_byErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>