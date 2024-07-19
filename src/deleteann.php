<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$ID = $_GET["id"];

$select = "SELECT * FROM Announcements WHERE id = $ID";
$rs = mysqli_query($con, $select);

if ($rs && mysqli_num_rows($rs) > 0) {
    $result = mysqli_fetch_assoc($rs);
    $oldPhoto = $result['AnnPhoto'];

    $sql = "DELETE FROM Announcements WHERE id = $ID";
    $rss = mysqli_query($con, $sql);

    if ($rss) {
        if (file_exists($oldPhoto)) {
            if (unlink($oldPhoto)) {
                header("Location: annman.php");
            } else {
                echo "Error: Could not delete the file '$oldPhoto'.";
            }
        } else {
            echo "Error: File '$oldPhoto' does not exist.";
        }
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    echo "Error: Record not found.";
}

?>
