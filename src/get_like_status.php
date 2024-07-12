<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$response = ['liked' => false, 'likeCount' => 0];

if (isset($_GET['book_id']) && isset($_GET['username'])) {
    $book_id = mysqli_real_escape_string($con, $_GET['book_id']);
    $username = mysqli_real_escape_string($con, $_GET['username']);

    // Check if the item is liked
    $select = "SELECT COUNT(*) as count FROM LIKES WHERE Book_ID = '$book_id' AND User_ID = '$username'";
    $rs = mysqli_query($con, $select);
    $row = mysqli_fetch_assoc($rs);
    $response['liked'] = $row['count'] > 0;

    // Get the like count
    $count_query = "SELECT Likes FROM BOOK WHERE Book_ID = '$book_id'";
    $count_rs = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_rs);
    $response['likeCount'] = $count_row['Likes'];
}

echo json_encode($response);
?>
