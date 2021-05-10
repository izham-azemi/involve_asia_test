<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<h2>Book List</h2>
<a href="http://localhost/involve_asia/form_add.php">Add Book</a>
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

$sql = "SELECT * FROM book";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
	while($row = $result->fetch_assoc()) {
		echo "Title: " . $row["title"]. " - Year Published: " . $row["year_published"]. " - Author Name: " . $row["author_name"]. " <a href='http://localhost/involve_asia/view.php?id=".$row["b_id"]."'>View</a> | <a href='http://localhost/involve_asia/form_update.php?id=".$row["b_id"]."'>Edit</a> | <a href='http://localhost/involve_asia/delete_book.php?id=".$row["b_id"]."'>Delete</a><br>";
	}
} else {
  echo "0 results";
}
$conn->close();
?>

</body>
</html>