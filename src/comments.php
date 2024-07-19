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

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {
    $loguser = $_SESSION['UserName'];
    $username = $_SESSION['UserName'];
    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);
    $pp = $result['Photo'];

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
                header("Location: comments.php?book_id=$book_id&post=success&lang=<?php echo $lang; ?>");
            } else {
                header("Location: comments.php?book_id=$book_id&post=failed&lang=<?php echo $lang; ?>");
            }
            exit();
        }

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $translations[$lang]['comment']; ?></title>
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

                .menu-icon,
                .close-icon {
                    cursor: pointer;
                }
            </style>
        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
            <div class="flex w-full justify-center">
                <nav class="shadow-2xl fixed md:mt-2 top-0 bg-BrownLight z-[9999] duration-300 lg:w-[93%] w-full md:py-5 py-4 pl-4 pr-2">
                    <div class="flex justify-between items-center">
                        <div class="flex">
                            <img src="img/logo.png" alt="logo" class="md:w-10 md:h-8 w-8 h-6 my-auto" />
                            <h1 class="ml-1 font-extrabold font-TitleFont md:text-xl my-auto cursor-default">
                                <?php echo $translations[$lang]['logo']; ?>
                            </h1>
                        </div>
                        <div class="flex md:hidden items-center">
                            <img src="img/menu-icon.png" alt="menu" id="menu-icon" class="menu-icon w-8 h-8" />
                            <img src="img/close-icon.png" alt="close" id="close-icon" class="close-icon w-8 h-8 hidden" />
                            <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>" class="pp flex items-center ml-3 duration-300 mr-3">
                                <img class="rounded-full md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                            </a>
                        </div>
                        <div class="my-auto flex">
                            <a href="?lang=en&book_id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                <img src="img/usa.png" alt="ethio"></a>
                            <a href="?lang=am&book_id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                <img src="img/ethio.png" alt="usa"></a>
                        </div>
                        <div class="hidden md:flex my-auto">
                            <div class="my-auto">
                                <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-xl">
                                    <?php echo $translations[$lang]['home']; ?></a>
                            </div>
                            <div class="my-auto">
                                <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                    <?php echo $translations[$lang]['books']; ?></a>
                            </div>
                            <div class="my-auto">
                                <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                    <?php echo $translations[$lang]['mybooks']; ?></a>
                            </div>
                            <div class="my-auto">
                                <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                    <?php echo $translations[$lang]['postbook']; ?></a>
                            </div>
                            <a href="ppuser.php?lang=<?php echo $lang; ?>&UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
                                <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                            </a>
                        </div>
                    </div>
                    <div class="md:hidden flex flex-col items-start space-y-2 mt-4 hidden" id="mobile-menu">
                        <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-xl">
                            Home</a>
                        <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                            Books</a>
                        <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                            My Books</a>
                        <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                            Post Book</a>
                    </div>
                </nav>
            </div>

            <div class="lg:text-xl text-BrownLight grid grid-cols-2 w-full md:mt-28 mt-20">
                <div class="md:col-span-1 col-span-2">
                    <p class="font-TitleFont bg-BrownDark w-fit lg:p-6 p-3" style="padding: 20px;"><b><?php echo $translations[$lang]['title']; ?>: </b><?= $rss['Title'] ?></p>
                </div>
                <div class="self-end flex justify-end md:col-span-1 col-span-2 md:mt-0 mt-2">
                    <a href="bookdetail.php?id=<?= $book_id; ?>&lang=<?php echo $_GET['lang']; ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-4 py-2 px-4 shadow-xl hover:shadow-2xl">
                        <?php echo $translations[$lang]['back']; ?></a>
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
                                <p class="md:text-xl text-lg"><i><?php echo $translations[$lang]['username']; ?>: </i><a href="profileNu.php?UserName=<?php echo $result['User_ID']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['User_ID'] ?></a></p>
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
                    <input type="submit" value="<?php echo $translations[$lang]['post']; ?>" name="post" class="rounded-lg bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                </form>
            </div>

            <script>
                document.getElementById('menu-icon').addEventListener('click', function() {
                    document.getElementById('mobile-menu').classList.remove('hidden');
                    document.getElementById('menu-icon').classList.add('hidden');
                    document.getElementById('close-icon').classList.remove('hidden');
                });

                document.getElementById('close-icon').addEventListener('click', function() {
                    document.getElementById('mobile-menu').classList.add('hidden');
                    document.getElementById('menu-icon').classList.remove('hidden');
                    document.getElementById('close-icon').classList.add('hidden');
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