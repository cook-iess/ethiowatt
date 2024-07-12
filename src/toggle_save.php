<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$response = ['success' => false];

if (isset($_GET['book_id']) && isset($_GET['username'])) {
    $book_id = mysqli_real_escape_string($con, $_GET['book_id']);
    $username = mysqli_real_escape_string($con, $_GET['username']);

    // Check if the item is already saved
    $select = "SELECT COUNT(*) as count FROM Favorite WHERE Book_ID = '$book_id' AND User_ID = '$username'";
    $rs = mysqli_query($con, $select);
    $row = mysqli_fetch_assoc($rs);
    $is_saved = $row['count'] > 0;

    if ($is_saved) {
        // Unsave the item
        $delete = "DELETE FROM Favorite WHERE Book_ID = '$book_id' AND User_ID = '$username'";
        $rs = mysqli_query($con, $delete);
        if ($rs) {
            $response['success'] = true;
        }
    } else {
        // Save the item
        $insert = "INSERT INTO Favorite (Book_ID, User_ID) VALUES ('$book_id', '$username')";
        $rs = mysqli_query($con, $insert);
        if ($rs) {
            $response['success'] = true;
        }
    }
}

echo json_encode($response);
mysqli_close($con);
?>
