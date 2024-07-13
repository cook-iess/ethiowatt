<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$response = ['success' => false];

if (isset($_GET['book_id']) && isset($_GET['username'])) {
    $book_id = mysqli_real_escape_string($con, $_GET['book_id']);
    $username = mysqli_real_escape_string($con, $_GET['username']);

    // Check if the item is already liked
    $select = "SELECT COUNT(*) as count FROM LIKES WHERE Book_ID = '$book_id' AND User_ID = '$username'";
    $rs = mysqli_query($con, $select);
    if ($rs) {
        $row = mysqli_fetch_assoc($rs);
        $is_liked = $row['count'] > 0;

        if ($is_liked) {
            // Unlike the item
            $delete = "DELETE FROM LIKES WHERE Book_ID = '$book_id' AND User_ID = '$username'";
            $rs = mysqli_query($con, $delete);
            if ($rs) {
                // Decrease like count
                $update = "UPDATE BOOK SET Likes = Likes - 1 WHERE Book_ID = '$book_id'";
                $rs_update = mysqli_query($con, $update);
                if ($rs_update) {
                    $response['success'] = true;
                }
            }
        } else {
            // Like the item
            $insert = "INSERT INTO LIKES (Book_ID, User_ID) VALUES ('$book_id', '$username')";
            $rs = mysqli_query($con, $insert);
            if ($rs) {
                // Increase like count
                $update = "UPDATE BOOK SET Likes = Likes + 1 WHERE Book_ID = '$book_id'";
                $rs_update = mysqli_query($con, $update);
                if ($rs_update) {
                    $response['success'] = true;
                }
            }
        }
    }
}

echo json_encode($response);
