<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['UserName'])) {

    $UserName = $_SESSION['UserName'];

    $sql = "DELETE FROM Announcements WHERE UserName = '$UserName'";
    $sql2 = "DELETE FROM Comments WHERE User_ID = '$UserName'";
    $sql3 = "DELETE FROM Favorite WHERE User_ID = '$UserName'";
    $sql4 = "DELETE FROM LIKES WHERE User_ID = '$UserName'";
    $sql5 = "DELETE FROM BOOK WHERE UserName = '$UserName'";
    $sql6 = "DELETE FROM USER WHERE UserName = '$UserName'";

    $rs = mysqli_query($con, $sql);

    $rs2 = mysqli_query($con, $sql2);

    $rs3 = mysqli_query($con, $sql3);

    $rs4 = mysqli_query($con, $sql4);

    $rs5 = mysqli_query($con, $sql5);

    $rs6 = mysqli_query($con, $sql6);

    if ($rs && $rs2 && $rs3 && $rs4 && $rs5 && $rs6) {
        header("Location: index.php?lang=" . $lang);
      } else {
        echo "Error deleting record: " . $conn->error;
      }

}

?>