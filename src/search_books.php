<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

// Retrieve query parameter
$query = $_GET['query'];

// Query to fetch books based on search query
$sql = "SELECT * FROM BOOK WHERE Title LIKE ? ORDER BY Title ASC";
$stmt = $con->prepare($sql);
$searchParam = '%' . $query . '%';
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$books = $result->fetch_all(MYSQLI_ASSOC);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($books);

?>

