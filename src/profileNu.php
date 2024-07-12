<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header.php";

if (isset($_SESSION['UserName'])) {

    if (isset($_GET['UserName'])) {
        $UserName = $_GET['UserName'];
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Profile View</title>
            <link rel="stylesheet" href="output.css">
        </head>

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

            <p class="text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mb-2" style="margin-top: 82px;">User Profile</p>

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
                                <img style="margin: 2px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 280px; height: 280px; object-fit: cover; object-position: center;" src="<?= $result['Photo'] ?>" alt="pp" class="mx-auto rounded-full">
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
            } else {
                echo "There was some error. Please try again later!";
            }
            ?>
            </div>

            <div>
                <p class="text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark py-4 mt-8 mb-2 w-1/2 pl-10">Books written By this User:</p>
            </div>

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
    header("Location: login.php");
}

    ?>