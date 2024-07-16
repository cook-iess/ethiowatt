<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    if (isset($_GET['book_id'])) {

        $book_id = $_GET['book_id'];

        $select = "SELECT * FROM BOOK WHERE Book_ID ='$book_id'";
        $rs = mysqli_query($con, $select);
        while ($result = mysqli_fetch_assoc($rs)) {

?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Start Reading Admin</title>
                <link rel="stylesheet" href="output.css">

                <style>

                    .container {
                        margin: 30px auto;
                    }

                    .fixed-header {
                        padding: 10px 20px;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .story {
                        font-size: 1.1rem;
                        color: #4a4a4a;
                        line-height: 1.6;
                        margin-top: 25px;
                    }

                </style>

            </head>

            <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

                <div class="fixed-header bg-BrownDark3 text-BrownDark w-full fixed top-0 shadow">
                    <p class="title text-sm md:text-base"><b>Title: </b><?= $result['Title'] ?></p>
                    <a href="bookdetailadmin.php?id=<?= $book_id ?>" class="exit-btn bg-BrownDark2 hover:bg-BrownDark duration-300 md:px-4 px-3 md:py-2 py-1 md:rounded-xl rounded-md text-BrownDark3 shadow-2xl text-sm md:text-base">Exit</a>
                </div>

                <div class="container md:px-8 md:pb-8 md:pt-8 px-6 pb-6 pt-3  rounded-lg bg-white shadow-xl md:w-[85%] w-[93%]">
                    <div class="story">
                        <p><?= $result['Story'] ?></p>
                    </div>
                </div>

            </body>

            </html>

<?php
        }
    } else {
        echo "Book ID not provided.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>