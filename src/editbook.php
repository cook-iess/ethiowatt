<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");
session_start();
// require "header.php";

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    $bookid = $_GET['book_id'];

    $sql = "SELECT * FROM `BOOK` WHERE `Book_ID` = '$bookid'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);

    if (isset($_POST['update'])) {

        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $langg = $_POST['langg'];
        $genre = $_POST['genre'];
        $PG = $_POST['PG'];
        $password = $_POST['Password'];

        if (!empty($title) && !empty($desc) && !empty($langg) && !empty($genre) && !empty($PG) && !empty($password)) {

            $sql2 = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
            $rss = mysqli_query($con, $sql2);
            $resultt = mysqli_fetch_assoc($rss);
            if (password_verify($password, $resultt['Password'])) {

                if (!empty($_FILES['Photo']['name'])) {


                    $oldPhoto = $result['Photo'];

                    if (file_exists($oldPhoto)) {
                        if (unlink($oldPhoto)) {
                            echo "File '$oldPhoto' has been deleted successfully.";
                        } else {
                            echo "Error: Could not delete the file '$oldPhoto'.";
                        }
                    } else {
                        echo "Error: File '$oldPhoto' does not exist.";
                    }

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
                            $error = "notsupported";
                        }
                    }
                } else {
                    $newimgname = $result['Photo'];
                }


                $newimgname = mysqli_real_escape_string($con, $newimgname);
                $title = mysqli_real_escape_string($con, $title);
                $desc = mysqli_real_escape_string($con, $desc);
                $langg = mysqli_real_escape_string($con, $langg);
                $genre = mysqli_real_escape_string($con, $genre);
                $PG = mysqli_real_escape_string($con, $PG);


                $sql = "UPDATE BOOK SET Title = '$title', Book_Desc = '$desc', Genre = '$genre', PG = '$PG', Language = '$langg', Photo = '$newimgname' WHERE Book_ID = '$bookid'";
                if ($con->query($sql) === TRUE) {
                    header("Location: viewMyBook.php?update=success&lang=<?php echo $lang; ?>");
                    exit();
                } else {
                    $error = "notsuccess";
                }
            } else {
                $error = "incorrect";
            }
        } else {
            $error = "emptyfields";
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $translations[$lang]['ebook']; ?></title>
        <link rel="stylesheet" href="output.css">
    </head>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
        <div class="flex p-4 lg:fixed top-0 mt-1">
            <img src="img/logo.png" class="md:w-14 md:h-10 w-10 h-8 my-auto" />
            <h1 class="ml-1 font-extrabold font-TitleFont md:text-3xl my-auto text-BrownDark">
            <?php echo $translations[$lang]['logo']; ?>
            </h1>
        </div>
        <div class="md:mt-8 pb-6 md:pb-0">
            <h3 class="text-center font-bold md:text-2xl text-xl"><?php echo $translations[$lang]['ebook']; ?></h3>
            <form action="editbook.php?book_id=<?= $result['Book_ID'] ?>&lang=<?php echo $_GET['lang']; ?>" class="md:w-[45%] w-[85%] mx-auto my-auto" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label htmlFor="title" class="">
                    <?php echo $translations[$lang]['title']; ?>*
                    </label>
                    <input id="title" name="title" type="text" placeholder="Enter title Here" value="<?php echo $result['Title'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="desc" class="">
                    <?php echo $translations[$lang]['desc']; ?>*
                    </label>
                    <textarea name="desc" id="desc" class="bg-transparent border p-1 w-full focus:outline-none focus:shadow-outline" style="height: 80px; padding: 6px;"><?php echo $result['Book_Desc'] ?></textarea>
                </div>

                <div class="mb-2">
                    <label htmlFor="langg" class="">
                    <?php echo $translations[$lang]['lang']; ?>*
                    </label>
                    <input id="langg" name="langg" type="text" placeholder="<?php echo $translations[$lang]['whlang']; ?>" value="<?php echo $result['Language'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="genre" class="">
                    <?php echo $translations[$lang]['genre']; ?>*
                    </label>
                    <input id="genre" name="genre" type="text" placeholder="<?php echo $translations[$lang]['whbook']; ?>" value="<?php echo $result['Genre'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="PG" class="">
                    <?php echo $translations[$lang]['pg']; ?>
                    </label>
                    <input id="PG" name="PG" type="number" placeholder="<?php echo $translations[$lang]['ageres']; ?>" value="<?php echo $result['PG'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2 md:mt-0 mt-4">
                    <label htmlFor="pp" class="text-sm md:text-base ">
                    <?php echo $translations[$lang]['ucp']; ?>
                    </label>
                    <input type="file" name="Photo" value="<?php echo $result['Photo'] ?>" class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                </div>
                <div class="mb-2">
                    <label htmlFor="password"><?php echo $translations[$lang]['cupass']; ?>*</label>
                    <input id="Password" name="Password" minLength={8} type="password" placeholder="<?php echo $translations[$lang]['min']; ?>" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="mb-4">
                    <?php

                    if (isset($error)) {
                        if ($error == "emptyfields") {
                    ?>
                            <div class="error text-red">Fill in all the required Fields</div>
                        <?php
                        } elseif ($error == "incorrect") {
                        ?>
                            <div class="error text-red">Current password not correct</div>
                        <?php
                        } elseif ($error == "notsupported") {
                        ?>
                            <div class="error text-red">Image not supported</div>
                        <?php
                        } elseif ($error == "notsuccess") {
                        ?>
                            <div class="error text-red">Updating not successful</div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <input type="submit" value="<?php echo $translations[$lang]['update']; ?>" name="update" class="lg:text-base text-xs rounded-lg lg:mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                <a href="editcontent.php?book_id=<?= $result['Book_ID'] ?>&lang=<?php echo $_GET['lang']; ?>" class="lg:text-base text-xs rounded-lg lg:mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"><?php echo $translations[$lang]['editcont']; ?></a>
                <a href="mybookdetail.php?id=<?= $result['Book_ID'] ?>&lang=<?php echo $_GET['lang']; ?>" class="lg:text-base text-xs rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"><?php echo $translations[$lang]['cancel']; ?></a>
            </form>
        </div>


    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>