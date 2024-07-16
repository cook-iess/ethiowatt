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

        <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
            <div>

                <div class="w-full flex justify-end mt-4">
                    <div class="flex">
                        <img src="img/logo.png" alt="" class="w-12 h-10 my-auto" />
                        <h1 class="ml-1 font-extrabold font-TitleFont text-xl md:text-3xl my-auto cursor-default">
                            Ethio Wattpad
                        </h1>
                    </div>
                    <div class="ml-4 flex">
                        <a href="adminHome.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                            Home</a>
                    </div>
                </div>

                <p class="md:text-6xl text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-4 mb-2">User Profile</p>

            </div>
            <div class="md:pt-10 pt-4">
                <?php
                $select = "SELECT * FROM USER WHERE UserName = '$UserName'";
                $rs = mysqli_query($con, $select);
                $count = mysqli_num_rows($rs);
                if ($count > 0) {
                    while ($result = mysqli_fetch_assoc($rs)) {
                ?>
                        <div class="grid lg:grid-cols-4 grid-cols-2 justify-around pb-10">
                            <div class="col-span-1 lg:block hidden">

                            </div>
                            <div class="col-span-1">
                                <img class="mx-auto rounded-full m-1 mb-2 md:w-72 md:h-72 w-36 h-36 object-cover object-center" src="<?= $result['Photo'] ?>" alt="profile picture">
                            </div>
                            <div class="my-auto lg:col-span-2">
                                <h1 class="md:text-4xl text-sm  font-extrabold">Username: <?php echo $result['UserName'] ?></h1>
                                <p class="md:text-2xl text-sm font-bold pt-4 inline-block">Full Name: </p>
                                <p class="md:text-xl text-sm inline-block"><?php echo $result['Full_Name'] ?></p>
                                <div>
                                    <p class="md:text-2xl text-sm font-bold inline">Bio: </p>
                                    <p class="md:text-xl text-sm inline-block"><?php echo $result['Bio'] ?></p>
                                </div>
                                <p class="md:text-2xl text-sm font-bold inline">Gender:</p>
                                <p class="md:text-xl text-sm inline-block"><?php echo $result['Gender'] ?></p>
                                <div>
                                    <p class="md:text-2xl text-sm font-bold inline">Email: </p>
                                    <p class="md:text-xl text-sm inline-block"><?php echo $result['Email'] ?></p>
                                </div>
                                <p class="md:text-base text-xs text-gray-600 md:text-center md:pt-3 pt-1"><b>Joined: </b><?php echo $result['Reg_Date'] ?></p>
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
                <p class="md:text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark md:px-6 md:py-6 px-4 py-4 md:mt-8 mb-2 w-fit">Books written By this User:</p>
            </div>

            <?php

            function truncateText($text, $maxLength)
            {
                if (strlen($text) > $maxLength) {
                    $text = substr($text, 0, $maxLength) . '...';
                }
                return $text;
            }


            $select = "SELECT * FROM BOOK WHERE UserName = '$UserName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
            ?>



                <div class="grid md:grid-cols-3 grid-cols-2  gap-4">
                    <?php
                    while ($result = mysqli_fetch_assoc($rs)) {
                        $truncatedDesc = truncateText($result['Book_Desc'], 49);
                        $truncatedTitle = truncateText($result['Title'], 39);
                    ?>
                        <div class="mb-14">
                            <div class="mt-4">
                                <div>
                                    <a href="bookdetailadmin.php?id=<?= $result['Book_ID'] ?>">
                                        <img style="margin: 20px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 150px; height: 200px; object-fit: cover; object-position: center;" src="<?= $result['Photo'] ?>" alt="whats new" class="mx-auto">
                                        <h2 class="font-bold font-TitleFont text-center text-xs pb-1">
                                            <?php echo $truncatedTitle ?>
                                        </h2>
                                    </a>

                                    <h3 class="pt-1 text-xs text-center"><?php echo $truncatedDesc ?></h3>
                                    <p class="text-xs text-center"><?php echo $result['Add_Date'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>


            <?php
            } else {
                echo "<h2 class='text-center text-3xl font-bold mt-12 mb-14 text-blue-800'>No Books written by this author yet</h2>";
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
    header("Location: index.php");
}
    ?>