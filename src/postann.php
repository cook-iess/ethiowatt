<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conn.php");

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

session_start();

if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == 'Admin321' && isset($_COOKIE['UserName'])) {

    if (isset($_POST['post'])) {

        $title = $_POST['title'];
        $Description = $_POST['description'];
        $UserName = $_POST['username'];

        if (!empty($title) && !empty($Description) && !empty($UserName) && !empty($_FILES['Photo']['name'])) {

            $check_username = "SELECT COUNT(*) FROM `USER` WHERE `UserName` = '$UserName'";
            $result = mysqli_query($con, $check_username);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(*)'] > 0) {

                $imagename = $_FILES['Photo']['name'];
                $tmpname = $_FILES['Photo']['tmp_name'];
                $error = $_FILES['Photo']['error'];

                if ($error === 0) {
                    $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                    $imageexlc = strtolower($imageex);

                    $allowedex = array('jpg', 'jpeg', 'png');

                    if (in_array($imageexlc, $allowedex)) {
                        $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                        $imguploadpath = 'uploads/announcements/' . $newimgname;
                        move_uploaded_file($tmpname, $imguploadpath);
                        $newimgname = 'uploads/announcements/' . $newimgname;
                    } else {
                        header("Location: postann.php?error=notsupported&title=" . $title . "&description=" . $Description . "&Bio=" . $Bio . "&username=" . $UserName );
                        exit();
                    }
                }

                $title = mysqli_real_escape_string($con, $title);
                $Description = mysqli_real_escape_string($con, $Description);
                $UserName = mysqli_real_escape_string($con, $UserName);
                $newimgname = mysqli_real_escape_string($con, $newimgname);

                $insert = "INSERT INTO `Announcements` (`Title`, `Description`, `UserName`, `AnnPhoto`) 
          VALUES (\"$title\", \"$Description\", \"$UserName\",\"$newimgname\")";
                $yes = mysqli_query($con, $insert);
                if ($yes) {
                    header("Location: annman.php?post=success");
                } else {
                    header("Location: postann.php?error=failed&title=" . $title . "&description=" . $Description . "&Bio=" . $Bio . "&username=" . $UserName . "&Photo=" . $_FILES['Photo']['name']);
                    exit();
                }
            } else {
                header("Location: postann.php?error=nouser&title=" . $title . "&description=" . $Description . "&Bio=" . $Bio . "&Photo=" . $_FILES['Photo']['name']);
                exit();
            }
        } else {
            header("Location: postann.php?error=emptyfields&title=" . $title . "&description=" . $Description . "&Bio=" . $Bio . "&lang=" . $lang . "&username=" . $UserName . "&Photo=" . $_FILES['Photo']['name']);
            exit();
        }
    }

?>


    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post Announcemets</title>
        <link href="output.css" rel="stylesheet">
    </head>

    <body class="bg-BrownLight w-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
        <div class="flex items-center ml-4 absolute right-0 my-auto">
        <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>
            <div class="flex mt-3">
                <img src="img/logo.png" class="lg:w-14 lg:h-10 w-12 h-8 my-auto" />
                <h1 class="font-extrabold font-TitleFont lg:text-2xl my-auto text-BrownDark cursor-default">
                <?php echo $translations[$lang]['logo']; ?>
                </h1>
            </div>

            <div class="mt-4 ml-4">
                <a href="annman.php" class="text-base rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 py-2 px-4 md:px-5 shadow-xl hover:shadow-2xl">
                <?php echo $translations[$lang]['back']; ?></a>
            </div>
        </div>
        <div class="flex justify-center items-center w-full h-full shadow-2xl shadow-BrownDark lg:pt-0 pt-16">
            <div class="mx-auto lg:p-5 lg:h-auto h-full lg:w-5/12 shadow-2xl shadow-BrownDark2 md:px-10 md:pt-10 md:pb-10">
                <h1 class="lg:text-5xl text-xl font-extrabold font-TitleFont text-center">
                <?php echo $translations[$lang]['pannn']; ?>
                </h1>
                <p class="text-center text-sm md:text-base">
                <?php echo $translations[$lang]['postann']; ?>
                </p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="py-6 px-12" enctype="multipart/form-data">
                    <div class="col-span-2 mb-4">
                        <label htmlFor="title"><?php echo $translations[$lang]['title']; ?></label>
                        <input id="title" type="text" name="title" placeholder="<?php echo $translations[$lang]['abtitle']; ?>..." 
                        value="<?php if (isset($_GET['title'])) {
                                                                echo $_GET['title'];
                                                            } ?>"
                        class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                    </div>
                    <div class="col-span-2 mb-4">
                        <label htmlFor="description"><?php echo $translations[$lang]['desc']; ?></label>
                        <textarea placeholder="<?php echo $translations[$lang]['bdesc']; ?>..." name="description" id="" cols="30" rows="6"
                        class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2"><?php if (isset($_GET['description'])) {
                                                                echo $_GET['description'];
                                                            } ?></textarea>
                    </div>
                    <div class="col-span-2 mb-4">
                        <label htmlFor="username"><?php echo $translations[$lang]['username']; ?></label>
                        <input id="username" type="text" name="username" placeholder="<?php echo $translations[$lang]['who']; ?>" 
                        value="<?php if (isset($_GET['username'])) {
                                                                echo $_GET['username'];
                                                            } ?>"
                        class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                    </div>
                    <div class="col-span-2 mb-4">
                        <label htmlFor="pp" class="">
                        <?php echo $translations[$lang]['upload']; ?>
                        </label>
                        <input type="file" name="Photo" 
                        value="<?php if (isset($_GET['Photo'])) {
                                                                echo $_GET['Photo'];
                                                            } ?>"
                        class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                    </div>
                    <div class="col-span-2">
                        <?php

                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "emptyfields") {
                        ?>
                                <div class="error text-red"><?php echo $translations[$lang]['1']; ?></div>
                            <?php
                            } elseif ($_GET['error'] == "nouser") {
                            ?>
                                <div class="error text-red">Username doesn't exist</div>
                            <?php
                            } elseif ($_GET['error'] == "notsupported") {
                            ?>
                                <div class="error text-red">Image not supported</div>
                            <?php
                            } elseif ($_GET['error'] == "failed") {
                            ?>
                                <div class="error text-red">Posting not successful</div>
                            <?php
                            } elseif ($_GET['post'] == "success") {
                            ?>
                                <div class="error text-red">Posting successful</div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="my-auto col-span-4 mt-2 mb-1">
                        <input type="submit" name="post" value="<?php echo $translations[$lang]['post']; ?>" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                    </div>
                </form>
            </div>
        </div>
        <div class="top-0 absolute lg:block hidden">
            <img src="img/annman.png" class="w-1/2" style="width: 30%; margin-left: 200px; margin-top: -40px;" />
        </div>

    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>