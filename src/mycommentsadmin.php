<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == 'Admin321') {

    $loguser = $_SESSION['UserName'];

    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);
    $pp = $result['Photo'];

    if (isset($_GET['book_id'])) {
        $username = $_SESSION['UserName'];
        $book_id = $_GET['book_id'];

        $select = "SELECT Title FROM BOOK WHERE Book_ID = ?";
        $stmt = $con->prepare($select);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $rs = $stmt->get_result();
        $rss = $rs->fetch_assoc();

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
                <title>Admin view Comments</title>
                <link rel="stylesheet" href="output.css">
                <style>
                    .navel:hover {
                        --tw-bg-opacity: 1;
                        color: rgb(229 211 179 / var(--tw-text-opacity));
                        padding: 25px;
                        background-color: rgb(102 66 41 / var(--tw-bg-opacity));
                    }

                    .pp:hover {
                        transform: scale(1.1);
                    }
                </style>
            </head>

            <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
                <div class="flex w-full justify-center">
                    <nav class="fixed top-0 bg-BrownLight z-[9999] duration-300 md:mt-2 md:w-[93%] w-full md:py-4 py-2 md:pl-4 pl-2 pr-2">
                        <div class="flex justify-between items-center">
                            <div class="flex">
                                <img src="img/logo.png" alt="logo" class="md:w-10 md:h-8 w-8 h-7 my-auto" />
                                <h1 class="ml-1 font-extrabold font-TitleFont md:text-xl my-auto cursor-default">
                                    <?php echo $translations[$lang]['logo']; ?>
                                </h1>
                            </div>

                            <div class="my-auto flex">
                                <a href="?lang=en&book_id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                    <img src="img/usa.png" alt="ethio"></a>
                                <a href="?lang=am&book_id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                    <img src="img/ethio.png" alt="usa"></a>
                            </div>

                            <div class="my-auto flex">
                                <div class="my-auto">
                                    <a id="vb" href="bookman.php" class="navel md:mr-4 mr-2 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                        <?php echo $translations[$lang]['vbookss']; ?></a>
                                </div>
                                <div class="my-auto">
                                    <a href="adminHome.php" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                        <?php echo $translations[$lang]['home']; ?></a>
                                </div>
                                <a href="ppadmin.php?UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center md:ml-3 ml-2 duration-300 md:mr-3">
                                    <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                                </a>
                            </div>
                        </div>

                    </nav>
                </div>




            <?php
        }
            ?>
            <div class="lg:text-xl text-BrownLight grid grid-cols-2 w-full md:mt-28 mt-16">
                <div class="md:col-span-1 col-span-2">
                    <p class="font-TitleFont bg-BrownDark w-fit lg:p-6 p-3"><b><?php echo $translations[$lang]['btitle']; ?>: </b><?= $rss['Title'] ?></p>
                </div>
                <div class="self-end flex justify-end md:col-span-1 col-span-2 md:mt-0 mt-2">
                    <a href="bookdetailadmin.php?id=<?= $book_id; ?>&lang=<?php echo $_GET['lang']; ?>" class="rounded-lg md:mr-4 mr-2 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-4 py-2 px-4 shadow-xl hover:shadow-2xl">
                    <?php echo $translations[$lang]['back']; ?></a>
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
                                    <p class="md:text-xl text-lg"><i><?php echo $translations[$lang]['username']; ?>: </i><a href="profileAd.php?UserName=<?php echo $result['User_ID']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['User_ID'] ?></a></p>
                                    <div class="px-4 md:text-lg text-sm">-<?= $result['Comment'] ?></div>
                                </div>

                                <div class="md:self-end col-span-1 my-auto">
                                    <form action="deletea.php?id=<?= $result['Comment_ID'] ?>&book_id=<?= $book_id ?>" method="post">
                                        <input type="hidden" name="ID" value="<?php echo $result['Comment_ID']; ?>">
                                        <button type="submit" class="md:mx-auto px-5 py-3 bg-red text-white rounded-xl cursor-pointer md:text-sm text-xs uppercase" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8); transition: background-color 0.3s ease;">
                                        <?php echo $translations[$lang]['del']; ?>
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

            <script>
                window.addEventListener('scroll', function() {
                    const header = document.querySelector('nav');
                    if (window.pageYOffset > 0) {
                        header.classList.add('shadow-2xl');
                    } else {
                        header.classList.remove('shadow-2xl');
                    }
                });
            </script>

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