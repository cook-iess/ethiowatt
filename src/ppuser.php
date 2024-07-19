<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");

require "header.php";

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    // if (isset($_POST['delete'])) {

    //     $sql = "DELETE FROM Announcements WHERE UserName = '$UserName'";
    //     $sql2 = "DELETE FROM Comments WHERE User_ID = '$UserName'";
    //     $sql3 = "DELETE FROM Favorite WHERE User_ID = '$UserName'";
    //     $sql4 = "DELETE FROM LIKES WHERE User_ID = '$UserName'";
    //     $sql2 = "DELETE FROM BOOK WHERE UserName = '$UserName'";
    //     $sql6 = "DELETE FROM USER WHERE UseName = '$UserName'";

    //     $rs = mysqli_query($con, $sql);

    //     $rs2 = mysqli_query($con, $sql2);

    //     $rs3 = mysqli_query($con, $sql3);

    //     $rs4 = mysqli_query($con, $sql4);

    //     $rs5 = mysqli_query($con, $sql5);

    //     $rs6 = mysqli_query($con, $sql6);

    //     if ($rs && $rs2 && $rs3 && $rs4 && $rs5 && $rs6) {
    //         header("Location: index.php");
    //       } else {
    //         echo "Error deleting record: " . $conn->error;
    //       }

    // }

?>

    <head>
        <title><?php echo $translations[$lang]['uprofile']; ?></title>
    </head>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">

        <p class="md:text-6xl text-xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark md:py-6 py-4 mb-2 md:mt-24 mt-16"><?php echo $translations[$lang]['uprofile']; ?></p>
        <div class="flex justify-end md:mt-6 mt-2">
            <div class="grid grid-cols-2">
                <div class="my-auto">
                    <a href="chanpass.php?lang=<?php echo $lang; ?>" class="text-xs rounded-lg md:mr-1 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 px-2 shadow-xl md:text-sm hover:shadow-2xl"><?php echo $translations[$lang]['chpass']; ?></a>
                </div>
                <div class="my-auto flex justify-end">
                    <a href="editprofile.php?lang=<?php echo $lang; ?>" class="text-xs rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl"><?php echo $translations[$lang]['eprofile']; ?></a>
                </div>
            </div>
        </div>

        <div class="mt-11 pb-10">
            <?php
            $select = "SELECT * FROM USER WHERE UserName = '$UserName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
                while ($result = mysqli_fetch_assoc($rs)) {
            ?>
                    <div class="grid md:grid-cols-4 grid-cols-2 gap-4 justify-around">
                        <div class="col-span-1 md:block hidden">

                        </div>
                        <div class="col-span-1">
                            <img class="mx-auto rounded-full m-1 mb-2 md:w-72 md:h-72 w-36 h-36 object-cover object-center" src="<?= $result['Photo'] ?>" alt="profile picture">
                        </div>
                        <div class="my-auto md:col-span-2">
                            <h1 class="md:text-4xl text-sm font-extrabold"><?php echo $translations[$lang]['username']; ?>: <?php echo $result['UserName'] ?></h1>
                            <p class="md:text-2xl text-sm font-bold pt-4 inline-block"><?php echo $translations[$lang]['full']; ?>: </p>
                            <p class="md:text-xl text-sm inline-block"><?php echo $result['Full_Name'] ?></p>
                            <div>
                                <p class="md:text-2xl text-sm font-bold inline"><?php echo $translations[$lang]['bio']; ?>: </p>
                                <p class="md:text-xl text-sm inline-block"><?php echo $result['Bio'] ?></p>
                            </div>
                            <p class="md:text-2xl text-sm font-bold inline"><?php echo $translations[$lang]['gender']; ?>:</p>
                            <p class="md:text-xl text-sm inline-block"><?php echo $result['Gender'] ?></p>
                            <div>
                                <p class="md:text-2xl text-sm font-bold inline"><?php echo $translations[$lang]['email']; ?>: </p>
                                <p class="md:text-xl text-xs inline-block"><?php echo $result['Email'] ?></p>
                            </div>
                            <p class="md:text-base text-xs text-gray-600 md:text-center pt-3"><b><?php echo $translations[$lang]['join']; ?>: </b><?php echo $result['Reg_Date'] ?></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h2 class='text-center md:text-3xl font-bold mb-5 text-blue-800'>No records found</h2>";
            }
            ?>

            <div class="flex justify-end md:mt-0 mt-10">
                <div class="grid grid-cols-2">
                    <div class="my-auto self-end flex justify-end">
                        <a href="logout.php?lang=<?php echo $_GET['lang']; ?>" class="text-xs rounded-lg mr-3 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl"><?php echo $translations[$lang]['logout']; ?></a>
                    </div>
                    <div class="my-auto">
                        <!-- <form action="ppuser.php" method="post"> -->
                        <button onclick="confirmDelete(event)" data-delete-url="delprofile.php" type="submit" name="delete" class="text-xs rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl">
                            <?php echo $translations[$lang]['del']; ?>
                        </button>
                        <!-- </form> -->
                    </div>
                </div>
            </div>

        </div>

        <div>
            <p class="md:text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark py-4 md:mt-8 mb-2 px-10 w-fit"><?php echo $translations[$lang]['yourfav']; ?>:</p>
        </div>

        <div class="md:pt-5 pt-0">

            <?php

            function truncateText($text, $maxLength)
            {
                if (strlen($text) > $maxLength) {
                    $text = substr($text, 0, $maxLength) . '...';
                }
                return $text;
            }

            $select = "SELECT * FROM Favorite WHERE User_ID = '$UserName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
                while ($result = mysqli_fetch_assoc($rs)) {
                    $bookid = $result['Book_ID'];
                    $select2 = "SELECT * FROM BOOK WHERE Book_ID = '$bookid'";
                    $rss = mysqli_query($con, $select2);
                    $countt = mysqli_num_rows($rss);
                    if ($countt > 0) { ?>
                        <div class="flex justify-center">
                            <div class="md:w-[75%] w-[95%]">
                                <div class="grid">
                                    <?php
                                    while ($resultt = mysqli_fetch_assoc($rss)) {

                                        $truncatedDesc = truncateText($resultt['Book_Desc'], 49);
                                        $truncatedTitle = truncateText($resultt['Title'], 22);

                                    ?>
                                        <div class="md:mb-14 mb-4">
                                            <div class="md:mt-12 mt-6">
                                                <div class="grid grid-cols-2 gap-4 md:gap-0">
                                                    <div>
                                                        <a href="bookdetail.php?id=<?= $result['Book_ID'] ?>&lang=<?php echo $lang; ?>">
                                                            <img class="mx-auto w-56 h-72 object-cover object-center" src="<?= $resultt['Photo'] ?>" alt="cover photo">
                                                        </a>
                                                    </div>
                                                    <div class="mt-6 my-auto">
                                                        <a href="bookdetail.php?id=<?= $result['Book_ID'] ?>&lang=<?php echo $lang; ?>">
                                                            <h2 class="font-bold font-TitleFont text-xl pb-1 underline"> <?php echo $truncatedTitle ?></h2>
                                                        </a>
                                                        <p class="text-xs mb-2"><?php echo $translations[$lang]['uon']; ?>: <?php echo $resultt['Add_Date'] ?></p>
                                                        <h3 class="pt-1 text-xs mb-4"><?php echo $truncatedDesc ?></h3>
                                                        <?php
                                                        $select3 = "SELECT COUNT(*) as count FROM LIKES WHERE Book_ID = '$bookid' AND User_ID = '$UserName'";
                                                        $rs3 = mysqli_query($con, $select3);
                                                        if ($rs3) {
                                                            $row = mysqli_fetch_assoc($rs3);
                                                            $liked = $row['count'] > 0;
                                                        }

                                                        $likeImage = $liked ? 'img/filled_like.png' : 'img/unfilled_like.png';
                                                        ?>
                                                        <div class="flex mb-5">
                                                            <img id="likeImage_<?php echo $resultt['Book_ID']; ?>" src="<?php echo $likeImage; ?>" alt="Like" style="width: 35px; height: 35px;">
                                                            <p class="my-auto text-lg ml-1 mt-2"><?php echo $resultt['Likes'] ?></p>
                                                        </div>
                                                        <div>
                                                            <a href="comments.php?book_id=<?= $resultt['Book_ID'] ?>&lang=<?php echo $lang; ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl"><?php echo $translations[$lang]['comment']; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
        <?php }
                                }
                            }
                        } else {
                            echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'>No Saved Items</h2>";
                        }
        ?>

        </div>

        <script>
            function confirmDelete(event) {
                event.preventDefault();
                let userConfirmed = confirm("Are you sure you want to delete you profile? All books and announcements by you will be deleted too.");
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