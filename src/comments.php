<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");


// session_start();
require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {
    $username = $_SESSION['UserName'];

    if (isset($_GET['book_id'])) {
        $book_id = $_GET['book_id'];

        $select = "SELECT Title FROM BOOK WHERE Book_ID = ?";
        $stmt = $con->prepare($select);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $rs = $stmt->get_result();
        $rss = $rs->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
            $comment = $_POST['comment'];
            $comment = mysqli_real_escape_string($con, $comment);

            $insert = "INSERT INTO Comments (Comment, Book_ID, User_ID) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insert);
            $stmt->bind_param("sis", $comment, $book_id, $username);
            $yes = $stmt->execute();

            if ($yes) {
                header("Location: comments.php?book_id=$book_id&post=success");
            } else {
                header("Location: comments.php?book_id=$book_id&post=failed");
            }
            exit();
        }
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comments</title>

        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
            <div class="lg:text-xl text-BrownLight grid grid-cols-2 w-full md:mt-28 mt-20">
                <div class="md:col-span-1 col-span-2">
                    <p class="font-TitleFont bg-BrownDark w-fit lg:p-6 p-3" style="padding: 20px;"><b>Title: </b><?= $rss['Title'] ?></p>
                </div>
                <div class="self-end flex justify-end md:col-span-1 col-span-2 md:mt-0 mt-2">
                    <a href="bookdetail.php?id=<?= $book_id; ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-4 py-2 px-4 shadow-xl hover:shadow-2xl">
                        Back</a>
                </div>
            </div>

            <div class="bg-BrownDark3 md:pb-36 pb-28">
                <?php
                $select = "SELECT * FROM Comments WHERE Book_ID = ?";
                $stmt = $con->prepare($select);
                $stmt->bind_param("i", $book_id);
                $stmt->execute();
                $rs = $stmt->get_result();
                $count = $rs->num_rows;
                if ($count > 0) {
                    while ($result = $rs->fetch_assoc()) {
                ?>
                        <div class="flex justify-center mt-8 mb-5">
                            <div class="md:w-4/5 w-[90%] mx-auto">
                                <p class="md:text-xl text-lg"><i>Username: </i><a href="profileNu.php?UserName=<?php echo $result['User_ID']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['User_ID'] ?></a></p>
                                <div class="px-4 md:text-lg text-sm">-<?= $result['Comment'] ?></div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<h2 class='text-center text-2xl font-bold mb-5 mt-12'>No comments yet</h2>";
                }
                ?>
            </div>


            <div class="fixed bottom-0 w-full flex justify-center bg-BrownDark3 border-t-2">
                <form action="comments.php?book_id=<?= $book_id ?>" method="post" class="grid grid-cols-4 mx-auto" style="margin: 10px; width: 95%;">
                    <textarea name="comment" class="shadow-lg col-span-3 block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" required></textarea>
                    <input type="submit" value="Post" name="post" class="rounded-lg bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                </form>
            </div>
        </body>

        </html>
<?php
    } else {
        echo "Book ID not provided.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>