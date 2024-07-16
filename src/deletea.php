<?php

include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {

  $ID = $_POST["ID"];
  $book_id = $_GET["book_id"];


  // SQL to delete record
  $sql = "DELETE FROM Comments WHERE Comment_ID = $ID";

  if ($con->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header("Location: mycommentsadmin.php?&book_id=" . $book_id);
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}

?>