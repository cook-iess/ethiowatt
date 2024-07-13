<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $title = $_GET['title'];

    if (isset($_POST['save'])) {
        
        if (!empty($title)) {

            $story = $_POST['story'];

            // Use prepared statements to prevent SQL injection
            $stmt = $con->prepare("UPDATE BOOK SET Story = ? WHERE Title = ?");
            $stmt->bind_param("ss", $story, $title);

            if ($stmt->execute() === TRUE) {
                header("Location: viewMyBook.php?update=success");
                exit();
            } else {
                header("Location: startWriting.php?update=notsuccess");
                exit();
            }

            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Writing</title>
    <link rel="stylesheet" href="output.css">
</head>

<body class="bg-BrownLight w-full h-screen text-BrownDark font-TextFont">

    <div class="p-4 ml-12">
        <p class="text-xl bg-BrownDark text-BrownLight p-3 rounded-xl mb-6 mt-6 w-fit">Book Title: <?php echo htmlspecialchars($title); ?></p>

        <form action="startWriting.php?title=<?php echo urlencode($title); ?>" method="post">
            <textarea name="story" id="" style="height: 500px; width: 96%;" class="mb-4 bg-transparent border placeholder-BrownDark2 p-3 focus:outline-none focus:shadow-outline" placeholder="Start writing your book..."></textarea>
            <div class="w-full mx-auto" style="margin-left: auto; margin-right: auto;">
                <input type="submit" value="Save" name="save" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-12 shadow-xl hover:shadow-2xl">
                <a href="postBook.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-12 shadow-xl hover:shadow-2xl">Cancel</a>
            </div>
        </form>
    </div>

</body>

</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
