<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

ob_start(); // Start output buffering

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
    $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];
    
    $loguser = $_SESSION['UserName'];
    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);
    $pp = $result['Photo'];

    if (isset($_POST["start"])) {

        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $langg = $_POST['langg'];
        $genre = $_POST['genre'];
        $photo = $_FILES['Photo']['name'];

        if (!empty($title) && !empty($desc) && !empty($langg) && !empty($genre) && !empty($photo)) {

            if (isset($_POST["Agree"])) {

                $pg = $_POST['PG'];

                $imagename = $_FILES['Photo']['name'];
                $tmpname = $_FILES['Photo']['tmp_name'];
                $error = $_FILES['Photo']['error'];

                if ($error === 0) {
                    $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                    $imageexlc = strtolower($imageex);

                    $allowedex = array('jpg', 'jpeg', 'png');

                    if (in_array($imageexlc, $allowedex)) {
                        $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                        $imguploadpath = 'uploads/book/' . $newimgname;
                        move_uploaded_file($tmpname, $imguploadpath);
                        $newimgname = 'uploads/book/' . $newimgname;
                    } else {
                        header("Location: postBook.php?error=notsupported&lang=<?phpecho$lang;?>&title=" . $title . "&desc=" . $desc . "&langg=" . $langg . "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
                        exit();
                    }
                }

                $newimgname = mysqli_real_escape_string($con, $newimgname);
                $title = mysqli_real_escape_string($con, $title);
                $desc = mysqli_real_escape_string($con, $desc);
                $langg = mysqli_real_escape_string($con, $langg);
                $genre = mysqli_real_escape_string($con, $genre);
                $pg = mysqli_real_escape_string($con, $pg);

                $insert = "INSERT INTO `BOOK` (`Photo`, `Title`, `Book_Desc`, `Genre`, `PG`, `Language`, `UserName`) 
                    VALUES (\"$newimgname\", \"$title\", \"$desc\", \"$genre\", \"$pg\", \"$langg\", \"$UserName\")";
                $yes = mysqli_query($con, $insert);
                if ($yes) {
                    header("Location: startWriting.php?post=success&lang=". $lang ."&title=" . $title);
                    exit();
                } else {
                    header("Location: startWriting.php?error=failed&lang=". $lang ."&title=" . $title . "&desc=" . $desc . "&langg=" . $langg . "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
                exit();
            }
        } else {
            header("Location: postBook.php?error=emptyfields&lang=". $lang ."&title=" . $title . "&desc=" . $desc . "&langg=" . $langg . "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
            exit();
        }
    }}

    ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations[$lang]['postbook']; ?></title>
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
</head>

<body class="bg-BrownLight w-full h-screen text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
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
                    <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $lang; ?>" class="pp flex items-center ml-3 duration-300 mr-3">
                        <img class="rounded-full md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                    </a>
                </div>
                <div class="my-auto flex">
                    <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                        <img src="img/usa.png" alt="ethio"></a>
                    <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
                        <img src="img/ethio.png" alt="usa"></a>
                </div>
                <div class="hidden md:flex my-auto">
                    <div class="my-auto">
                        <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-xl">
                            <?php echo $translations[$lang]['home']; ?></a>
                    </div>
                    <div class="my-auto">
                        <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                            <?php echo $translations[$lang]['books']; ?></a>
                    </div>
                    <div class="my-auto">
                        <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                            <?php echo $translations[$lang]['mybooks']; ?></a>
                    </div>
                    <div class="my-auto">
                        <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
                            <?php echo $translations[$lang]['postbook']; ?></a>
                    </div>
                    <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $lang; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
                        <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
                    </a>
                </div>
            </div>
            <div class="md:hidden flex flex-col items-start space-y-2 mt-4 hidden" id="mobile-menu">
                <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-xl">
                    Home</a>
                <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                    Books</a>
                <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                    My Books</a>
                <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
                    Post Book</a>
            </div>
        </nav>
    </div>

        <div class="flex justify-center items-center h-screen md:mt-3 mt-48">

            <div class="md:grid md:grid-cols-4 md:mt-0">
                <div class="bg-BrownDark text-BrownLight align-middle my-auto shadow-2xl md:py-10 py-2">
                    <div class="">
                        <p class="md:text-4xl text-xl font-bold text-center mt-4">
                            <?php echo $translations[$lang]['postbook']; ?>
                        </p>
                        <p class="md:text-2xl font-bold text-center mb-4">
                            <?php echo $translations[$lang]['share']; ?>
                        </p>
                    </div>
                    <div class="">
                        <img src="img/signimg.png" class="mx-auto md:px-8 px-4 pb-4 md:w-96 w-60" />
                    </div>
                </div>

                <div class="text-BrownDark col-span-3 flex justify-center ">
                    <form action="postBook.php?lang=<?php echo $lang; ?>" class="md:mx-12 grid md:grid-cols-4 gap-x-6 gap-y-3 mx-6 md:mt-0 mt-4" method="post" enctype="multipart/form-data">
                        <div class="col-span-4">
                            <label htmlFor="title" class="">
                                <?php echo $translations[$lang]['title']; ?>*
                            </label>
                            <input name="title" type="text" placeholder="<?php echo $translations[$lang]['btitle']; ?>" value="<?php if (isset($_GET['title'])) {
                                                                                                        echo $_GET['title'];
                                                                                                    } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>
                        <div class="col-span-4 row-span-2">
                            <label htmlFor="desc" class=""><?php echo $translations[$lang]['desc']; ?>*
                            </label>
                            <textarea name="desc" id="" cols="30" rows="6" placeholder=" <?php echo $translations[$lang]['bdesc']; ?>" class="block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2"><?php if (isset($_GET['desc'])) {
                                                                                                                                                                                                                                                                                                                echo $_GET['desc'];
                                                                                                                                                                                                                                                                                                            } ?></textarea>
                        </div>

                        <div class="md:col-span-1 col-span-4">
                            <label htmlFor="lang" class="">
                                <?php echo $translations[$lang]['lang']; ?>*
                            </label>
                            <input name="langg" type="text" placeholder=" <?php echo $translations[$lang]['langu']; ?>" value="<?php if (isset($_GET['langg'])) {
                                                                                                                                    echo $_GET['langg'];
                                                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>

                        <div class="md:col-span-3 col-span-4">
                            <label htmlFor="genre" class="">
                                <?php echo $translations[$lang]['genre']; ?>*
                            </label>
                            <input name="genre" type="text" placeholder="Fiction, action, true story..." value="<?php if (isset($_GET['genre'])) {
                                                                                                                    echo $_GET['genre'];
                                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>

                        <div class="md:col-span-2 col-span-4">
                            <label htmlFor="Photo" class="">
                                <?php echo $translations[$lang]['cover']; ?>*
                            </label>
                            <input type="file" name="Photo" value="<?php if (isset($_GET['Photo'])) {
                                                                        echo $_GET['Photo'];
                                                                    } ?>" class="block w-full bg-BrownLight border border-BrownDark rounded-md px-3 py-1 text-BrownDark" />
                        </div>

                        <div class="w-full md:col-span-2 col-span-4">
                            <label htmlFor="PG" class="">
                                <?php echo $translations[$lang]['pg']; ?>
                            </label>
                            <input name="PG" type="number" placeholder=" <?php echo $translations[$lang]['ageres']; ?>" value="<?php if (isset($_GET['PG'])) {
                                                                                                                                    echo $_GET['PG'];
                                                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>



                        <div class="col-span-4">
                            <input type="checkbox" name="Agree" class="md:mt-0 mt-2 bg-BrownDark border-BrownDark border text-BrownDark focus:ring-BrownDark checked:bg-BrownDark" />

                            <p class="inline md:text-base text-sm"> <?php echo $translations[$lang]['con']; ?> </p>
                        </div>
                        <div class="col-span-4">
                            <?php

                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == "emptyfields") {
                            ?>
                                    <div class="error text-red"><?php echo $translations[$lang]['1']; ?></div>
                                <?php
                                } elseif ($_GET['error'] == "notaggreed") {
                                ?>
                                    <div class="error text-red"><?php echo $translations[$lang]['11']; ?></div>
                                <?php
                                } elseif ($_GET['error'] == "notsupported") {
                                ?>
                                    <div class="error text-red"><?php echo $translations[$lang]['5']; ?></div>
                                <?php
                                } elseif ($_GET['error'] == "failed") {
                                ?>
                                    <div class="error text-red"><?php echo $translations[$lang]['6']; ?></div>
                                <?php
                                } elseif ($_GET['post'] == "success") {
                                ?>
                                    <div class="error text-red"><?php echo $translations[$lang]['7']; ?></div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="my-auto col-span-4 mx-auto md:pb-0 pb-10">
                            <input type="submit" value="<?php echo $translations[$lang]['swriting']; ?>" name="start" class="px-24 rounded-lg bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                        </div>

                    </form>
                </div>
            </div>

        </div>



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
            const header = document.querySelector('nav');
            header.classList.add('shadow-xl');

            var pobo = document.getElementById("pobo");
            pobo.setAttribute("style", "border-bottom-width: 2px;");

        </script>

    </body>

    </html>

<?php
} else {
    header("Location: index.php");
}
?>