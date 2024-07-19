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

    $book_id = $_GET['id'];
    $username = $_SESSION['UserName'];

    // Check if the book is already saved by the user
    $check_saved_query = "SELECT COUNT(*) as count FROM Favorite WHERE Book_ID = '$book_id' AND User_ID = '$username'";
    $check_saved_result = mysqli_query($con, $check_saved_query);
    $saved_row = mysqli_fetch_assoc($check_saved_result);
    $is_saved = $saved_row['count'] > 0;

    // Check if the book is liked by the user
    $check_liked_query = "SELECT COUNT(*) as count FROM LIKES WHERE Book_ID = '$book_id' AND User_ID = '$username'";
    $check_liked_result = mysqli_query($con, $check_liked_query);
    $liked_row = mysqli_fetch_assoc($check_liked_result);
    $is_liked = $liked_row['count'] > 0;

    $loguser = $_SESSION['UserName'];
    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);
    $pp = $result['Photo'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $translations[$lang]['bdetail']; ?></title>
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

            function toggleSave(bookId, username) {
                fetch(`toggle_save.php?book_id=${bookId}&username=${username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const saveImage = document.getElementById(`save-image-${bookId}`);

                            // Toggle the image source
                            if (saveImage.src.includes('unfilled_save.png')) {
                                saveImage.src = 'img/filled_save.png'; // Path to your filled star image
                            } else {
                                saveImage.src = 'img/unfilled_save.png'; // Path to your unfilled star image
                            }
                        } else {
                            alert('An error occurred while saving.');
                        }
                    });
            }

            function toggleLike(bookId, username) {
                fetch(`toggle_like.php?book_id=${bookId}&username=${username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const likeImage = document.getElementById(`like-image-${bookId}`);
                            const likeCount = document.getElementById(`like-count-${bookId}`);
                            if (likeImage.src.includes('unfilled_like.png')) {
                                likeImage.src = 'img/filled_like.png';
                                likeCount.textContent = parseInt(likeCount.textContent) + 1;
                            } else {
                                likeImage.src = 'img/unfilled_like.png';
                                likeCount.textContent = parseInt(likeCount.textContent) - 1;
                            }
                        } else {
                            alert('An error occurred while liking.');
                        }
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const saveImage = document.getElementById(`save-image-<?= $book_id ?>`);
                if (saveImage.src.includes('unfilled_save.png')) {
                    saveImage.src = 'img/unfilled_save.png'; // Path to your unfilled star image
                } else {
                    saveImage.src = 'img/filled_save.png'; // Path to your filled star image
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const bookId = <?= $book_id ?>;
                const username = '<?= $username ?>';
                const likeImage = document.getElementById(`like-image-${bookId}`);
                const likeCount = document.getElementById(`like-count-${bookId}`);

                fetch(`get_like_status.php?book_id=${bookId}&username=${username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.liked) {
                            likeImage.src = 'img/filled_like.png';
                        } else {
                            likeImage.src = 'img/unfilled_like.png';
                        }
                        likeCount.textContent = data.likeCount;
                    });
            });
        </script>
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
                        <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="pp flex items-center ml-3 duration-300 mr-3">
                            <img class="rounded-full md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                        </a>
                    </div>
                    <div class="my-auto flex">
                        <a href="?lang=en&id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                            <img src="img/usa.png" alt="ethio"></a>
                        <a href="?lang=am&id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                            <img src="img/ethio.png" alt="usa"></a>
                    </div>
                    <div class="hidden md:flex my-auto">
                        <div class="my-auto">
                            <a href="announcements.php?lang=<?php echo $_GET['lang']; ?>" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-xl">
                                <?php echo $translations[$lang]['home']; ?></a>
                        </div>
                        <div class="my-auto">
                            <a href="viewBooks.php?lang=<?php echo $_GET['lang']; ?>" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                <?php echo $translations[$lang]['books']; ?></a>
                        </div>
                        <div class="my-auto">
                            <a href="viewMyBook.php?lang=<?php echo $_GET['lang']; ?>" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                <?php echo $translations[$lang]['mybooks']; ?></a>
                        </div>
                        <div class="my-auto">
                            <a href="postBook.php?lang=<?php echo $_GET['lang']; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                <?php echo $translations[$lang]['postbook']; ?></a>
                        </div>
                        <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
                            <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                        </a>
                    </div>
                </div>
                <div class="md:hidden flex flex-col items-start space-y-2 mt-4 hidden" id="mobile-menu">
                    <a href="announcements.php?lang=<?php echo $_GET['lang']; ?>" id="ann" class="navel font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-xl">
                        Home</a>
                    <a href="viewBooks.php?lang=<?php echo $_GET['lang']; ?>" id="vibo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                        Books</a>
                    <a href="viewMyBook.php?lang=<?php echo $_GET['lang']; ?>" id="vimbo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                        My Books</a>
                    <a href="postBook.php?lang=<?php echo $_GET['lang']; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                        Post Book</a>
                </div>
            </nav>
        </div>

        <h1 class="md:text-5xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 md:mt-24 mt-16 mb-2"><?php echo $translations[$lang]['bbdes']; ?></h1>

        <?php
        $select = "SELECT * FROM BOOK WHERE book_id = '$book_id'";
        $rs = mysqli_query($con, $select);
        $count = mysqli_num_rows($rs);
        if ($count > 0) {
            while ($result = mysqli_fetch_assoc($rs)) {
        ?>

                <div class="lg:grid lg:grid-cols-6 mt-10 lg:w-full mx-10 lg:mx-0 flex-col justify-center">
                    <div class="col-span-1 lg:block hidden"></div>
                    <div class="md:mx-auto w-full mx-auto md:w-[80%] col-span-2">
                        <img class="mb-2 md:w-72 h-96 object-cover lg:mx-0 mx-auto" src="<?= $result['Photo'] ?>" alt="">
                        <p class="text-center font-bold text-xl lg:mb-0 mb-4 mt-2"><?= $result['Title'] ?></p>
                    </div>
                    <div class="my-auto col-span-3 text-xl ">
                        <div class="lg:grid grid-cols-4 lg:mb-6 mb-4">
                            <div class="col-span-1">
                                <p class=""><b><?php echo $translations[$lang]['auth']; ?>: </b><a href="profileNu.php?UserName=<?= $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="underline"><?= $result['UserName'] ?></a></p>
                            </div>
                            <div class="col-span-1"></div>
                            <div class="col-span-2 self-end flex lg:justify-normal justify-end md:mt-0 mt-2">
                                <p class="text-base font-bold">
                                    <?php echo $translations[$lang]['savefav']; ?>
                                </p>
                                <button id="save-button-<?= $book_id ?>" onclick="toggleSave(<?= $book_id ?>, '<?= $username ?>')" style="width: 38px; height: 38px;">
                                    <img id="save-image-<?= $book_id ?>" src="<?= $is_saved ? 'img/filled_save.png' : 'img/unfilled_save.png' ?>" alt="Save" class="" style="width: 32px; height: 32px;">
                                </button>
                            </div>
                        </div>

                        <p class="mb-2 text-base"><b><?php echo $translations[$lang]['langu']; ?>:</b> <?= $result['Language'] ?></p>
                        <p class="mb-2 text-base"><b><?php echo $translations[$lang]['uon']; ?>:</b> <?= $result['Add_Date'] ?></p>
                        <p class="mb-2 text-base lg:mr-14"><b><?php echo $translations[$lang]['bbdes']; ?></b>: <?= $result['Book_Desc'] ?></p>
                        <p class="mb-2 text-base"><b><?php echo $translations[$lang]['genre']; ?>: </b><?= $result['Genre'] ?></p>

                        <div class="grid grid-cols-2 mb-5">
                            <div class="col-span-1 my-auto">
                                <p class="mb-2 inline"><b><?php echo $translations[$lang]['pg']; ?>:</b> <?= $result['PG'] ?></p>
                            </div>

                            <div class="flex lg:justify-center justify-end items-center lg:mr-10 mr-6">
                                <button id="like-button-<?= $book_id ?>" onclick="toggleLike(<?= $book_id ?>, '<?= $username ?>')" style="width: 38px; height: 38px;" class="flex">
                                    <img id="like-image-<?= $book_id ?>" src="<?= $is_liked ? 'img/filled_like.png' : 'img/unfilled_like.png' ?>" alt="Like" class="" style="width: 32px; height: 32px;">
                                    <span class="my-auto ml-2" id="like-count-<?= $book_id ?>"><?= $result['Likes'] ?></span>
                                </button>
                            </div>
                        </div>

                        <a href="comments.php?book_id=<?= $book_id ?>&lang=<?php echo $_GET['lang']; ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl"> <?php echo $translations[$lang]['comment']; ?></a>
                    </div>
                </div>

                <div class="flex justify-end mr-4 mb-6 md:mt-0 mt-8">
                    <div class="flex justify-end">
                        <a href="startReading.php?book_id=<?= $book_id ?>&lang=<?php echo $_GET['lang']; ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-6 shadow-xl hover:shadow-2xl">
                            <?php echo $translations[$lang]['sread']; ?></a>
                    </div>
                </div>

        <?php
            }
        }
        ?>
        <div class="bottom-0 absolute lg:block hidden">
            <img src="img/smalliamge.png" alt="" class="h-80 w-56" />
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: index.php");
}
?>