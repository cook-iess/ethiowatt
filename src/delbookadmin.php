<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_GET["id"])) {

    $ID = $_GET["id"];

    $sql = "DELETE FROM Favorite WHERE Book_ID = $ID";
    $rs = mysqli_query($con, $sql);

    $sql2 = "DELETE FROM Comments WHERE Book_ID = $ID";
    $rs2 = mysqli_query($con, $sql2);

    $sql3 = "DELETE FROM Likes WHERE Book_ID = $ID";
    $rs3 = mysqli_query($con, $sql3);

    $sql4 = "DELETE FROM BOOK WHERE Book_ID = $ID";
    $rs4 = mysqli_query($con, $sql4);

    if ($rs && $rs2 && $rs3 && $rs4) {
        echo "Record deleted successfully";
        header("Location: bookman.php?delete=success&lang=" .$lang);
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

?>