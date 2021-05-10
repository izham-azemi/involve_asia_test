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
  $status = false;
}

$sql = "DELETE FROM book WHERE b_id = ".$_GET["id"];

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
  $status = false;
}

// sql to delete a record
$sql_review = "DELETE FROM book_review WHERE b_id = ".$_GET["id"];

if ($conn->query($sql_review) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
  $status = false;
}

$conn->close();

if ($status == true){
	header('Location: http://localhost/involve_asia/index.php');
}
?>