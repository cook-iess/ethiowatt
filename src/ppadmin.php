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

if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == 'Admin321' && isset($_COOKIE['UserName'])) {

    if (isset($_GET['UserName'])) {
        $UserName = $_GET['UserName'];
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $translations[$lang]['adminpp']; ?></title>
            <link rel="stylesheet" href="output.css">
        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
            <div>

                <div class="w-full flex md:justify-end justify-between mt-4">
                    <div class="my-auto flex">
                        <a href="?lang=en&UserName=<?php echo $UserName; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                            <img src="img/usa.png" alt="ethio"></a>
                        <a href="?lang=am&UserName=<?php echo $UserName; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                            <img src="img/ethio.png" alt="usa"></a>
                    </div>
                    <div class="flex md:ml-0 ml-4">
                        <img src="img/logo.png" alt="" class="w-12 h-10 my-auto" />
                        <h1 class="ml-1 font-extrabold font-TitleFont text-xl md:text-2xl my-auto cursor-default">
                        <?php echo $translations[$lang]['logo']; ?>
                        </h1>
                    </div>
                    <div class="ml-4 flex">
                        <a href="adminHome.php?lang=<?php echo $_GET['lang']; ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 text-base md:px-5 px-4 shadow-xl hover:shadow-2xl">
                        <?php echo $translations[$lang]['home']; ?></a>
                    </div>
                </div>

                <p class="md:text-5xl text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark md:py-6 py-4 mt-4 mb-2"><?php echo $translations[$lang]['uprofile']; ?></p>
                <p class="text-center md:text-2xl font-bold"><?php echo $translations[$lang]['youad']; ?></p>

            </div>
            <div class="md:pt-10 pt-4">
                <?php
                $select = "SELECT * FROM USER WHERE UserName = '$UserName'";
                $rs = mysqli_query($con, $select);
                $count = mysqli_num_rows($rs);
                if ($count > 0) {
                    while ($result = mysqli_fetch_assoc($rs)) {
                ?>
                        <div class="grid lg:grid-cols-4 grid-cols-2 md:gap-5 justify-around pb-10">
                            <div class="col-span-1 lg:block hidden">

                            </div>
                            <div class="col-span-1">
                                <img class="mx-auto rounded-full m-1 mb-2 md:w-72 md:h-72 w-36 h-36 object-cover object-center" src="<?= $result['Photo'] ?>" alt="profile picture">
                            </div>
                            <div class="my-auto lg:col-span-2">
                                <h1 class="lg:text-3xl md:text-2xl font-extrabold"><?php echo $translations[$lang]['username']; ?>: <?php echo $result['UserName'] ?></h1>
                                <div class="flex md:mt-4 mt-1">
                                    <a href="logout.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                                    <?php echo $translations[$lang]['logout']; ?></a>
                                </div>
                            </div>

                        </div>
            <?php
                    }
                } else {
                    echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'>No records found</h2>";
                }
            } else {
                echo "There was no username!";
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