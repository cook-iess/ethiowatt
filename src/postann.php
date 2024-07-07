<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

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
                    $error = "Image this Type not supported!";
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
                header("Location: annman.php");
            } else {
                $error = "Announcement Not posted Successfully!!";
            }
        } else {
            $error = "Username doesn't exists.";
        }
    } else {
        $error = "Fill in all the required credentials!";
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

<body class="bg-BrownLight w-full text-BrownDark font-TextFont">
    <div class="flex items-center ml-4 absolute right-0 my-auto">
        <div class="flex mt-3">
            <img src="img/logo.png" class="w-14 h-10 my-auto" />
            <h1 class="font-extrabold font-TitleFont text-2xl my-auto text-BrownDark">
                Ethio Wattpad
            </h1>
        </div>

        <div class="mt-4 ml-4">
            <a href="annman.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                Back</a>
        </div>
    </div>
    <div class="flex justify-center items-center h-full shadow-2xl shadow-BrownDark">
        <div class="mx-auto p-5 w-5/12 shadow-2xl shadow-BrownDark2 px-10 py-10">
            <h1 class="text-5xl font-extrabold font-TitleFont text-center">
                Post Announcements
            </h1>
            <p class="text-center">
                About book events, book showcase, and so on
            </p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="py-6 px-12" enctype="multipart/form-data">
                <div class="col-span-2 mb-4">
                    <label htmlFor="title">Title</label>
                    <input id="title" type="text" name="title" placeholder="About the title..." class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-2 mb-4">
                    <label htmlFor="description">Description</label>
                    <textarea placeholder="About the title..." name="description" id="" cols="30" rows="6" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2"></textarea>
                </div>
                <div class="col-span-2 mb-4">
                    <label htmlFor="username">Username</label>
                    <input id="username" type="text" name="username" placeholder="Who requested this post?" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-2 mb-4">
                    <label htmlFor="pp" class="">
                        Upload Profile Photo
                    </label>
                    <input type="file" name="Photo" class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                </div>
                <div class="col-span-2">
                    <?php
                    // Check if the error message is set
                    if (isset($error)) {
                    ?>
                        <div class="error text-red"><?php echo $error; ?></div>
                    <?php
                    }
                    ?>
                </div>
                <div class="my-auto col-span-4 mt-2 mb-1">
                    <input type="submit" name="post" value="Post" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                </div>
            </form>
        </div>
    </div>
    <div class="top-0 absolute">
        <img src="img/annman.png" class="w-1/2" style="width: 30%; margin-left: 200px; margin-top: -40px;" />
    </div>

</body>

</html>