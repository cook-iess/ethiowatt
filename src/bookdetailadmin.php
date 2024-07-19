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

    // if (isset($_POST["delete"]) && isset($_GET["id"])) {

    //     $ID = $_GET["id"];

    //     $sql = "DELETE FROM Favorite WHERE Book_ID = $ID";
    //     $rs = mysqli_query($con, $sql);

    //     $sql2 = "DELETE FROM Comments WHERE Book_ID = $ID";
    //     $rs2 = mysqli_query($con, $sql2);

    //     $sql3 = "DELETE FROM Likes WHERE Book_ID = $ID";
    //     $rs3 = mysqli_query($con, $sql3);

    //     $sql4 = "DELETE FROM BOOK WHERE Book_ID = $ID";
    //     $rs4 = mysqli_query($con, $sql4);

    //     if ($rs && $rs2 && $rs3 && $rs4) {
    //         echo "Record deleted successfully";
    //         header("Location: bookman.php?delete=success&lang=" .$lang);
    //     } else {
    //         echo "Error deleting record: " . $conn->error;
    //     }
    // }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $translations[$lang]['bdadmin']; ?></title>
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

        <script>
            function toggleSave(bookId, username) {
                fetch(`toggle_save.php?book_id=${bookId}&username=${username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const saveImage = document.getElementById(`save-image-${bookId}`);

                            // Toggle the image source
                            if (saveImage.src.includes('unfilled_save.png')) {
                                saveImage.src = 'img/filled_save.png';
                            } else {
                                saveImage.src = 'img/unfilled_save.png';
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
                    saveImage.src = 'img/unfilled_save.png';
                } else {
                    saveImage.src = 'img/filled_save.png';
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

    <body>

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
                            <a href="?lang=en&id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                <img src="img/usa.png" alt="ethio"></a>
                            <a href="?lang=am&id=<?php echo $book_id; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                                <img src="img/ethio.png" alt="usa"></a>
                        </div>

                        <div class="my-auto flex">
                            <div class="my-auto">
                                <a id="vb" href="bookman.php?lang=<?php echo $_GET['lang']; ?>" class="navel md:mr-4 mr-2 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                    <?php echo $translations[$lang]['vbookss']; ?></a>
                            </div>
                            <div class="my-auto">
                                <a href="adminHome.php?lang=<?php echo $_GET['lang']; ?>" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                                    <?php echo $translations[$lang]['home']; ?></a>
                            </div>
                            <a href="ppadmin.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="pp w-10 flex items-center md:ml-3 ml-2 duration-300 md:mr-3">
                                <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                            </a>
                        </div>
                    </div>

                </nav>
            </div>
            <h1 class="md:text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 md:mt-24 mt-14 mb-2">Book Detail Admin</h1>

            <div class="flex justify-end mr-4 mt-4">
                <div class="flex justify-end">
                    <!-- <form action="bookdetailadmin.php?id=<?= $book_id ?>" method="post"> -->
                        <input type="submit" onclick="confirmDelete(event)" data-delete-url="delbookadmin.php?id=<?= $book_id ?>" name="delete" value="<?php echo $translations[$lang]['del']; ?>" class="rounded-lg md:mr-4 mr-2 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-6 shadow-xl hover:shadow-2xl">
                    <!-- </form> -->
                </div>
            </div>

            <?php
            $select = "SELECT * FROM BOOK WHERE book_id = '$book_id'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
                while ($result = mysqli_fetch_assoc($rs)) {
            ?>

                    <div class="lg:grid lg:grid-cols-6 mt-4 lg:w-full mx-10 lg:mx-0 flex-col justify-center">
                        <div class="col-span-1 lg:block hidden"></div>
                        <div class="md:mx-auto w-full mx-auto md:w-[80%] col-span-2">
                            <img class="mb-2 w-72 h-96 object-cover lg:mx-0 mx-auto" src="<?= $result['Photo'] ?>" alt="">
                            <p class="text-center font-bold text-xl lg:mb-0 mb-4"><?= $result['Title'] ?></p>
                        </div>
                        <div class="my-auto col-span-3 text-xl ">
                            <div class="lg:grid grid-cols-4 lg:mb-6 mb-4">
                                <div class="col-span-1">
                                    <p class=""><b><?php echo $translations[$lang]['auth']; ?>: </b><a href="profileAd.php?UserName=<?= $result['UserName']; ?>" class="underline"><?= $result['UserName'] ?></a></p>
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
                                    <p class="mb-2 inline text-base"><b><?php echo $translations[$lang]['pg']; ?>:</b> <?= $result['PG'] ?></p>
                                </div>

                                <div class="flex lg:justify-center justify-end items-center lg:mr-10 mr-6">
                                    <button id="like-button-<?= $book_id ?>" onclick="toggleLike(<?= $book_id ?>, '<?= $username ?>')" style="width: 38px; height: 38px;" class="flex">
                                        <img id="like-image-<?= $book_id ?>" src="<?= $is_liked ? 'img/filled_like.png' : 'img/unfilled_like.png' ?>" alt="Like" class="" style="width: 32px; height: 32px;">
                                        <span class="my-auto ml-2" id="like-count-<?= $book_id ?>"><?= $result['Likes'] ?></span>
                                    </button>
                                </div>
                            </div>

                            <a href="mycommentsadmin.php?book_id=<?= $book_id ?>&lang=<?php echo $_GET['lang']; ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl"><?php echo $translations[$lang]['comment']; ?></a>
                        </div>
                    </div>

                    <div class="flex justify-end mr-4 mb-6 md:mt-0 mt-7">
                        <div class="flex justify-end">
                            <a href="startreadingadmin.php?book_id=<?= $book_id ?>&lang=<?php echo $_GET['lang']; ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-6 shadow-xl hover:shadow-2xl">
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


            <script>

        function confirmDelete(event) {
            event.preventDefault();
            let userConfirmed = confirm("Are you sure you want to delete this item?");
            if (userConfirmed) {
                window.location.href = event.target.getAttribute('data-delete-url');
            }
        }

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
    header("Location: index.php");
}
?>