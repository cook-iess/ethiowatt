<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");

require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    if (isset($_POST['delete'])) {

        $sql = "DELETE FROM Announcements WHERE UserName = '$UserName'";
        $sql2 = "DELETE FROM USER WHERE username = '$UserName'";

        if ($con->query($sql) === TRUE) {
            if ($con->query($sql2) === TRUE) {
                header("Location: index.php");
            } else {
                echo "Error deleting record: " . $con->error;
            }
        } else {
            echo "Error deleting record: " . $con->error;
        }
    }

?>

    <head>
        <title>User Profile</title>
    </head>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

        <p class="text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mb-2" style="margin-top: 82px;">User Profile</p>
        <div class="flex justify-end mt-4">
            <div class="flex">
                <a href="chanpass.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Change Password</a>
                <a href="editprofile.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Edit Profile</a>
                <a href="logout.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Logout</a>
                <form action="ppuser.php" method="post">
                    <button type="submit" name="delete" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="" style="margin-top: 45px;">
            <?php
            $select = "SELECT * FROM USER WHERE UserName = '$UserName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
                while ($result = mysqli_fetch_assoc($rs)) {
            ?>
                    <div class="grid grid-cols-4 justify-around pb-10">
                        <div class="col-span-1">

                        </div>
                        <div class="col-span-1">
                            <img style="margin: 2px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 280px; height: 280px; object-fit: cover; object-position: center;" src="<?php echo $pp; ?>" alt="pp" class="mx-auto rounded-full">
                        </div>
                        <div class="my-auto col-span-2">
                            <h1 class="text-4xl font-extrabold">Username: <?php echo $result['UserName'] ?></h1>
                            <p class="text-2xl font-bold pt-4 inline-block">Full Name: </p>
                            <p class="text-xl inline-block"><?php echo $result['Full_Name'] ?></p>
                            <div>
                                <p class="text-2xl font-bold inline">Bio: </p>
                                <p class="text-xl inline-block"><?php echo $result['Bio'] ?></p>
                            </div>
                            <p class="text-2xl font-bold inline">Gender:</p>
                            <p class="text-xl inline-block"><?php echo $result['Gender'] ?></p>
                            <div>
                                <p class="text-2xl font-bold inline">Email: </p>
                                <p class="text-xl inline-block"><?php echo $result['Email'] ?></p>
                            </div>
                            <p class="text-base text-gray-600 text-center pt-3"><b>Joined: </b><?php echo $result['Reg_Date'] ?></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'>No records found</h2>";
            }
            ?>
        </div>

        <div>
            <p class="text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark py-4 mt-8 mb-2 pl-10" style="width: 35%;">Your favourites:</p>
        </div>

        <?php
        $select = "SELECT * FROM Favorite WHERE User_ID = '$UserName'";
        $rs = mysqli_query($con, $select);
        $count = mysqli_num_rows($rs);

        if ($count > 0) {
            while ($result = mysqli_fetch_assoc($rs)) {
                $bookid = $result['Book_ID'];
                $select2 = "SELECT * FROM BOOK WHERE Book_ID = '$bookid'";
                $rss = mysqli_query($con, $select2);
                while ($resultt = mysqli_fetch_assoc($rss)) { ?>
                    <div class="flex justify-center">
                        <div style="width: 95%;">
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;" class="">
                                <div class="mb-14">
                                    <div class="mt-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <img style="margin: 20px auto 6px auto; width: 230px; height: 280px; object-fit: cover; object-position: center;" src="<?= $resultt['Photo'] ?>" alt="whats new" class="mx-auto">
                                            </div>
                                            <div class="mt-6 my-auto" style="margin-top: auto; margin-bottom: auto;">
                                                <h2 class="font-bold font-TitleFont text-xl pb-1"> <?php echo $resultt['Title'] ?></h2>
                                                <p class="text-xs mb-2">Uploaded on: <?php echo $resultt['Add_Date'] ?></p>
                                                <h3 class="pt-1 text-xs mb-4"><?php echo $resultt['Book_Desc'] ?></h3>
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
                                                    <img id="likeImage_<?php echo $resultt['Book_ID']; ?>" src="<?php echo $likeImage; ?>" alt="Like" style="cursor:pointer; width: 35px; height: 35px;">
                                                    <p class="my-auto text-lg ml-1 mt-2"><?php echo $resultt['Likes'] ?></p>
                                                </div>
                                                <div>
                                                    <a href="comments.php?book_id=<?= $resultt['Book_ID'] ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl">Comments</a>
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
        } else {
            echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'>No Saved Items</h2>";
        }
        ?>


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
    header("Location: index.php");
}
?>