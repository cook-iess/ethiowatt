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

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comments on my book</title>
        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">
            <div class="lg:text-xl text-BrownLight grid grid-cols-2 w-full md:mt-28 mt-16" >
                <div class="md:col-span-1 col-span-2">
                    <p class="font-TitleFont bg-BrownDark w-fit lg:p-6 p-3"><b>Book Title: </b><?= $rss['Title'] ?></p>
                </div>
                <div class="self-end flex justify-end md:col-span-1 col-span-2 md:mt-0 mt-2">
                    <a href="mybookdetail.php?id=<?= $book_id; ?>" class="rounded-lg md:mr-4 mr-2 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-4 py-2 px-4 shadow-xl hover:shadow-2xl">
                        Back</a>
                </div>
            </div>

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
                        <div class="flex justify-center mt-6 mb-14 bg-BrownDark3 py-2">
                            <div class="md:w-4/5 w-[90%] mx-auto">

                                <div class="grid grid-cols-4 mb-4">
                                    <div class="col-span-3">
                                        <p class="md:text-xl text-lg"><i>Username: </i><a href="profileNu.php?UserName=<?php echo $result['User_ID']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['User_ID'] ?></a></p>
                                        <div class="px-4 md:text-lg text-sm">-<?= $result['Comment'] ?></div>
                                    </div>

                                    <div class="md:self-end col-span-1 my-auto">
                                    <form action="deletea.php?id=<?= $result['Comment_ID'] ?>&book_id=<?= $book_id ?>" method="post">
                                            <input type="hidden" name="ID" value="<?php echo $result['Comment_ID']; ?>">
                                            <button type="submit" class="md:mx-auto px-5 py-3 bg-red text-white rounded-xl cursor-pointer md:text-sm text-xs uppercase" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8); transition: background-color 0.3s ease;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<h2 class='text-center text-2xl font-bold mb-5 mt-12'>No comments yet</h2>";
                }
                ?>

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