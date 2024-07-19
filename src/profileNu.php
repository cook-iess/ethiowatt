<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

ob_start(); 
session_start();

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {
  $loguser = $_SESSION['UserName'];
  $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
  $rs = mysqli_query($con, $sql);
  $result = mysqli_fetch_assoc($rs);
  $pp = $result['Photo'];

    if (isset($_GET['UserName'])) {
        $UserName = $_GET['UserName'];
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $translations[$lang]['oupv']; ?></title>
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

    .menu-icon, .close-icon {
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
        <a href="?lang=en&UserName=<?php echo $UserName; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am&UserName=<?php echo $UserName; ?>" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>
      <div class="hidden md:flex my-auto">
        <div class="my-auto">
          <a href="announcements.php" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-xl">
          <?php echo $translations[$lang]['home']; ?></a>
        </div>
        <div class="my-auto">
          <a href="viewBooks.php" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['books']; ?></a>
        </div>
        <div class="my-auto">
          <a href="viewMyBook.php" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['mybooks']; ?></a>
        </div>
        <div class="my-auto">
          <a href="postBook.php" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['postbook']; ?></a>
        </div>
        <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
          <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">                
        </a>
      </div>
    </div>
    <div class="md:hidden flex flex-col items-start space-y-2 mt-4 hidden" id="mobile-menu">
      <a href="announcements.php" id="ann" class="navel font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-xl">
        Home</a>
      <a href="viewBooks.php" id="vibo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        Books</a>
      <a href="viewMyBook.php" id="vimbo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        My Books</a>
      <a href="postBook.php" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        Post Book</a>
    </div>
  </nav>
</div>
            <div class="md:mt-24 mt-16">

                <p class="md:text-6xl text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-4 mb-2"><?php echo $translations[$lang]['uprofile']; ?></p>

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
                                <h1 class="md:text-4xl text-sm  font-extrabold"><?php echo $translations[$lang]['username']; ?>: <?php echo $result['UserName'] ?></h1>
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
                                    <p class="md:text-xl text-sm inline-block"><?php echo $result['Email'] ?></p>
                                </div>
                                <p class="md:text-base text-xs text-gray-600 md:text-center md:pt-3 pt-1"><b><?php echo $translations[$lang]['join']; ?>: </b><?php echo $result['Reg_Date'] ?></p>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<h2 class='text-center text-3xl font-bold mb-5 text-blue-800'><?php echo $translations[$lang]['tuv']; ?></h2>";
                }
            } else {
                echo "There was no username provided";
            }
            ?>
            </div>

            <div>
                <p class="md:text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark md:px-6 md:py-6 px-4 py-4 md:mt-8 mb-2 w-fit"><?php echo $translations[$lang]['bwb']; ?>:</p>
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
                                    <a href="bookdetail.php?id=<?= $result['Book_ID'] ?>">
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
                echo "<h2 class='text-center md:text-3xl font-bold mt-12 mb-14 text-blue-800'>No Books written by this author yet</h2>";
            }
            ?>


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