<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

// session_start();
require "header.php";

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

    if (isset($_POST["delete"]) && isset($_GET["id"])) {
        $ID = $_GET["id"];
      
        $sql = "DELETE FROM Favorite WHERE Book_ID = $ID";
        $rs = mysqli_query($con, $sql);

        $sql2 = "DELETE FROM Comments WHERE Book_ID = $ID";
        $rs2 = mysqli_query($con, $sql2);

        $sql3 = "DELETE FROM Likes WHERE Book_ID = $ID";
        $rs3 = mysqli_query($con, $sql3);

        $sql4 = "DELETE FROM BOOK WHERE Book_ID = $ID";
        $rs4 = mysqli_query($con, $sql4);
      
        if ($rs && $rs2 && $rs3 && $rs4) {
          header("Location: viewMyBook.php");
        } else {
          echo "Error deleting record: " . $conn->error;
        }
      }


?>

    <head>
        <title>Book Detail</title>
        <script>
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
        <h1 class="md:text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 md:mt-24 mt-16 mb-2">Book Detail</h1>

        <div class="flex justify-end mr-4 mt-4">
        <div class="flex justify-end">
                <a href="editbook.php?book_id=<?= $book_id ?>" class="text-sm md:text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-6 shadow-xl hover:shadow-2xl">
                    Edit</a>
            </div>
            <div class="flex justify-end">
                <form action="mybookdetail.php?id=<?= $book_id ?>" method="post">
                <input type="submit" name="delete" value="Delete" class="text-sm md:text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-6 shadow-xl hover:shadow-2xl">
                </form>
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
                        <p class="text-center font-bold text-xl lg:mb-0 mb-4 mt-2"><?= $result['Title'] ?></p>
                    </div>
                    <div class="my-auto col-span-3 text-xl ">
                        <div class="lg:grid grid-cols-4 lg:mb-6 mb-4">
                            <div class="col-span-1">
                                <p class=""><b>Author: </b><a href="profileNu.php?UserName=<?= $result['UserName']; ?>" class="underline"><?= $result['UserName'] ?></a></p>
                            </div>
                            <div class="col-span-1"></div>
                            <div class="col-span-2 self-end flex lg:justify-normal justify-end md:mt-0 mt-2">
                                <p class="text-base font-bold">
                                    Save to Favorites
                                </p>
                                <button id="save-button-<?= $book_id ?>" onclick="toggleSave(<?= $book_id ?>, '<?= $username ?>')" style="width: 38px; height: 38px;">
                                    <img id="save-image-<?= $book_id ?>" src="<?= $is_saved ? 'img/filled_save.png' : 'img/unfilled_save.png' ?>" alt="Save" class="" style="width: 32px; height: 32px;">
                                </button>
                            </div>
                        </div>

                        <p class="mb-2 text-base"><b>Language Used:</b> <?= $result['Language'] ?></p>
                        <p class="mb-2 text-base"><b>Uploaded on:</b> <?= $result['Add_Date'] ?></p>
                        <p class="mb-2 text-base lg:mr-14"><b>Book Description</b>: <?= $result['Book_Desc'] ?></p>
                        <p class="mb-2 text-base"><b>Genre: </b><?= $result['Genre'] ?></p>

                        <div class="grid grid-cols-2 mb-5">
                            <div class="col-span-1 my-auto">
                                <p class="mb-2 inline"><b>PG:</b> <?= $result['PG'] ?></p>
                            </div>

                            <div class="flex lg:justify-center justify-end items-center lg:mr-10 mr-6">
                                <button id="like-button-<?= $book_id ?>" onclick="toggleLike(<?= $book_id ?>, '<?= $username ?>')" style="width: 38px; height: 38px;" class="flex">
                                    <img id="like-image-<?= $book_id ?>" src="<?= $is_liked ? 'img/filled_like.png' : 'img/unfilled_like.png' ?>" alt="Like" class="" style="width: 32px; height: 32px;">
                                    <span class="my-auto ml-2" id="like-count-<?= $book_id ?>"><?= $result['Likes'] ?></span>
                                </button>
                            </div>
                        </div>

                        <a href="mycomments.php?book_id=<?= $book_id ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl">Comments</a>
                    </div>
                </div>

                <div class="flex justify-end mr-4 mb-6 md:mt-0 mt-8">
                    <div class="flex justify-end">
                        <a href="startreadwriter.php?book_id=<?= $book_id ?>" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-6 shadow-xl hover:shadow-2xl">
                            Start Reading</a>
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