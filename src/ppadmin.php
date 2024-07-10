<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == 'Admin321' && isset($_COOKIE['UserName'])) {

    if (isset($_GET['UserName'])) {
        $UserName = $_GET['UserName'];
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Profile Admin View</title>
            <link rel="stylesheet" href="output.css">
        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">
            <div>

                <div class="w-full flex justify-end mt-4">
                    <div class="flex">
                        <img src="img/logo.png" alt="" class="w-12 h-10 my-auto" />
                        <h1 class="ml-1 font-extrabold font-TitleFont text-3xl my-auto cursor-default">
                            Ethio Wattpad
                        </h1>
                    </div>
                    <div class="ml-4 flex">
                        <a href="annman.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                            Back</a>
                    </div>
                </div>

                <p class="text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-4 mb-2">User Profile</p>
                <p class="text-center text-2xl font-bold">You'r an Admin.</p>

            </div>
            <div class="md:pt-10 pt-4">
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
                                <img src="<?= $result['Photo'] ?>" alt="profile Photo" class=" h-auto rounded-full" style="width: 80%">
                            </div>
                            <div class="my-auto col-span-2">
                                <h1 class="text-4xl font-extrabold">Username: <?php echo $result['UserName'] ?></h1>
                                <div class="flex mt-4" >
                                    <a href="logout.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                                        Logout</a>
                                </div>
                            </div>

                        </div>
            <?php
                    }
                } else {
                    echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'>No records found</h2>";
                }
            } else {
                echo "There was some error. Please try again later!";
            }
            ?>
            </div>
        </body>

        </html>

    <?php

} else {
    header("Location: index.php");
}
    ?>