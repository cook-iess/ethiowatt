<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    $bookid = $_GET['book_id'];

    $sql2 = "SELECT * FROM `BOOK` WHERE `Book_ID` = '$bookid'";
    $rss = mysqli_query($con, $sql2);
    $resultt = mysqli_fetch_assoc($rss);

    if (isset($_POST['update'])) {

        $password = $_POST['Password'];

        if (!empty($password)) {

            $sql3 = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
            $rs2 = mysqli_query($con, $sql3);
            $resul = mysqli_fetch_assoc($rs2);
            if (password_verify($password, $resul['Password'])) {

                $story = $_POST['story'];

                // Use prepared statements to prevent SQL injection
                $stmt = "UPDATE BOOK SET Story = '$story' WHERE Book_ID = '$bookid'";
                $rs2 = mysqli_query($con, $stmt);

                if ($rs2) {
                    header("Location: viewMyBook.php?update=success");
                    exit();
                } else {
                    header("Location: viewMyBook.php?update=notsuccess");
                    exit();
                }
            } else {
                $error = "passinc";
            }
        } else {
            $error = "nopass";
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

        <div class="p-4 md:ml-12">
            <p class="md:text-xl bg-BrownDark text-BrownLight p-3 rounded-xl md:mb-6 mb-3 md:mt-6 mt-2 w-fit">Book Title: <?php echo $resultt['Title']; ?></p>

            <form action="editcontent.php?book_id=<?php echo $resultt['Book_ID'] ?>" method="post">
                <textarea name="story" id="" class="w-[95%] h-[500px] mb-4 bg-transparent border placeholder-BrownDark2 p-3 focus:outline-none focus:shadow-outline" placeholder="Start writing your book..."><?= $resultt['Story'] ?></textarea>
                <div class="w-full mx-auto">
                    <div class="mb-4 w-[95%]">
                        <label htmlFor="password">Current Password*</label>
                        <input id="Password" name="Password" minLength={8} type="password" placeholder="min 8 chars" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                    </div>
                    <div class="col-span-2 mb-2">
                        <?php
                        if (isset($error)) {
                            if ($error == "nopass") {
                        ?>
                                <div class="error text-red">Provide Current Password</div>
                            <?php
                            } elseif ($error == "passinc") {
                            ?>
                                <div class="error text-red">Incorrect Password</div>
                            <?php
                            } 
                        }
                        ?>
                    </div>
                    <input type="submit" value="Update" name="update" class="rounded-lg md:mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 md:px-12 px-6 shadow-xl hover:shadow-2xl">
                    <a href="editbook.php?book_id=<?php echo $resultt['Book_ID'] ?>" class="rounded-lg md:mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 md:px-12 px-6 shadow-xl hover:shadow-2xl">Cancel</a>
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