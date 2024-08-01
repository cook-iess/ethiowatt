<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_POST["signup"])) {

    $fname = $_POST['Full_Name'];
    $email = $_POST['Email'];
    $Bio = $_POST['Bio'];
    $username = $_POST['UserName'];
    $password = $_POST['Password'];
    $cPassword = $_POST['CPassword'];

    if (!empty($fname) && !empty($email) && !empty($_POST['Gender']) && !empty($username) && !empty($password) && !empty($cPassword)) {

        if (isset($_POST["Agree"])) {

            $check_username = "SELECT COUNT(*) FROM `USER` WHERE `UserName` = '$username'";
            $result = mysqli_query($con, $check_username);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(*)'] > 0) {
                header("Location: signup.php?error=userexists&Full_Name=" . $fname . "&Email=" . $email . "&Bio=" . $Bio . "&Photo=" . $_FILES['Photo']['name'] . "&lang=" . $lang);
                exit();
            } else {

                $gender = $_POST['Gender'];

                if ($password == $cPassword) {

                    $password = password_hash($password, PASSWORD_DEFAULT);

                    if (!empty($_FILES['Photo']['name'])) {

                        $imagename = $_FILES['Photo']['name'];
                        $tmpname = $_FILES['Photo']['tmp_name'];
                        $error = $_FILES['Photo']['error'];

                        if ($error === 0) {
                            $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                            $imageexlc = strtolower($imageex);

                            $allowedex = array('jpg', 'jpeg', 'png');

                            if (in_array($imageexlc, $allowedex)) {
                                $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                                $imguploadpath = 'uploads/user/' . $newimgname;
                                move_uploaded_file($tmpname, $imguploadpath);
                                $newimgname = 'uploads/user/' . $newimgname;
                            } else {
                                exit();
                            }
                        }
                    } else {
                        $newimgname = "uploads/user/default.jpg";
                    }

                    $newimgname = mysqli_real_escape_string($con, $newimgname);
                    $fname = mysqli_real_escape_string($con, $fname);
                    $gender = mysqli_real_escape_string($con, $gender);
                    $Bio = mysqli_real_escape_string($con, $Bio);
                    $email = mysqli_real_escape_string($con, $email);
                    $username = mysqli_real_escape_string($con, $username);
                    $password = mysqli_real_escape_string($con, $password);


                    $insert = "INSERT INTO `USER` (`Photo`, `Full_Name`, `Gender`, `Bio`, `Email`, `UserName`, `Password`) 
          VALUES (\"$newimgname\", \"$fname\", \"$gender\", \"$Bio\", \"$email\", \"$username\", \"$password\")";
                    $yes = mysqli_query($con, $insert);
                    if ($yes) {
                        header("Location: login.php?signup=success&lang=". $lang);
                        exit();
                    } else {
                        header("Location: signup.php?error=failed&Full_Name=" . $fname . "&Email=" . $email . "&lang=" . $lang . "&Bio=" . $Bio . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
                        exit();
                    }
                } else {
                    header("Location: signup.php?error=nomatch&Full_Name=" . $fname . "&Email=" . $email . "&lang=" . $lang . "&Bio=" . $Bio . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
                    exit();
                }
            }
        } else {
            header("Location: signup.php?error=notaggreed&Full_Name=" . $fname . "&Email=" . $email . "&lang=" . $lang . "&Bio=" . $Bio . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
            exit();
        }
    } else {
        header("Location: signup.php?error=emptyfields&Full_Name=" . $fname . "&Email=" . $email . "&Bio=" . $Bio . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name'] . "&lang=" . $lang);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations[$lang]['sign']; ?></title>
    <link rel="stylesheet" href="output.css">
</head>

<body class="w-full h-full md:flex bg-BrownLight font-TextFont overflow-y-scroll custom-scrollbar">
    <div class="flex md:p-5 p-4 md:fixed top-0 md:mt-5 mt-2">
        <img src="img/logo.png" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 font-extrabold font-TitleFont text-3xl my-auto text-BrownDark">
        <?php echo $translations[$lang]['logo']; ?>
        </h1>
        <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>
    </div>

    <div class="flex justify-center items-center h-screen w-full">
            <div class="md:grid grid-cols-2 h-full">
        <div class="bg-BrownDark text-BrownLight align-middle my-auto md:rounded-r-3xl md:pt-10 pt-4 md:mb-auto mb-7">
            <div class="">
                <p class="md:text-3xl text-xl font-bold text-center mt-4">
                <?php echo $translations[$lang]['unlock']; ?>
                </p>
                <p class="md:text-3xl text-xl font-bold text-center mb-4">
                <?php echo $translations[$lang]['bookworld']; ?>
                </p>
            </div>
            <div class="">
                <img src="img/book3.png" class="mx-auto md:px-14 px-10 mb:pb-14 pb-8 md:w-96 w-72" />
            </div>
        </div>

        <div class="text-BrownDark my-auto">
            <h1 class="md:text-6xl text-3xl ml-12 font-extrabold font-TitleFont">
            <?php echo $translations[$lang]['create']; ?>
            </h1>
            <p class="ml-12 mb-6"> <?php echo $translations[$lang]['let']; ?></p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $_GET['lang']; ?>" class="ml-12 md:grid grid-cols-4 gap-x-6 gap-y-3 mr-12" method="post" enctype="multipart/form-data">
                <div class="col-span-4">
                    <label htmlFor="full_name" class="">
                    <?php echo $translations[$lang]['full']; ?>*
                    </label>
                    <input id="Full_Name" name="Full_Name" type="text" placeholder="<?php echo $translations[$lang]['enter']; ?>" value="<?php if (isset($_GET['Full_Name'])) {
                                                                                                                        echo $_GET['Full_Name'];
                                                                                                                    } ?>" class="md:mb-0 mb-2 shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-4">
                    <label htmlFor="email" class="">
                    <?php echo $translations[$lang]['email']; ?>*
                    </label>
                    <input id="Email" name="Email" type="email" placeholder="name@example.com" value="<?php if (isset($_GET['Email'])) {
                                                                                                            echo $_GET['Email'];
                                                                                                        } ?>" class="md:mb-0 mb-2 block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-2">
                    <label htmlFor="age" class="">
                    <?php echo $translations[$lang]['bio']; ?>
                    </label>
                    <input id="Bio" name="Bio" type="text" placeholder=" <?php echo $translations[$lang]['enter']; ?>" value="<?php if (isset($_GET['Bio'])) {
                                                                                                                echo $_GET['Bio'];
                                                                                                            } ?>" class="md:mb-0 mb-2 shadow-lg md:mt-2 w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="w-full col-span-2 md:mb-0 mb-2">
                    <label htmlFor="gender" class="">
                    <?php echo $translations[$lang]['gender']; ?>*
                    </label>
                    <div class="border rounded-lg border-BrownDark flex py-2 px-4 mt-1">
                        <input type="radio" name="Gender" value="Male" />
                        <?php echo $translations[$lang]['male']; ?>
                        <input type="radio" name="Gender" value="Female" class="ml-2" />
                        <?php echo $translations[$lang]['female']; ?>
                    </div>
                </div>
                <div class="col-span-2">
                    <label htmlFor="userName"> <?php echo $translations[$lang]['username']; ?>*</label>
                    <input id="UserName" name="UserName" type="text" placeholder="<?php echo $translations[$lang]['unique']; ?>" value="<?php
                                                                                                            if (isset($_GET['UserName'])) {
                                                                                                                echo $_GET['UserName'];
                                                                                                            } ?>" class="md:mb-0 mb-3 shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-2">
                    <label htmlFor="pp" class="">
                    <?php echo $translations[$lang]['upload']; ?>
                    </label>
                    <input type="file" name="Photo" value="<?php if (isset($_GET['Photo'])) {
                                                                echo $_GET['Photo'];
                                                            } ?>" class="md:mb-0 mb-2 block w-full bg-BrownLight border border-BrownDark rounded-md px-2 py-1 text-BrownDark" />
                </div>
                <div class="col-span-2">
                    <label htmlFor="password"> <?php echo $translations[$lang]['pass']; ?>*</label>
                    <input id="Password" name="Password" minLength={8} type="password" placeholder="<?php echo $translations[$lang]['min']; ?>" class="md:mb-0 mb-2 w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-2">
                    <label htmlFor="cPassword"> <?php echo $translations[$lang]['cpass']; ?>*</label>
                    <input id="CPassword" name="CPassword" minLength={8} type="password" placeholder="<?php echo $translations[$lang]['cpass']; ?>" class="w-full mb-4 block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-4 md:text-lg text-sm md:mb-0 mb-2">
                    <input type="checkbox" name="Agree" class="bg-BrownDark border-BrownDark border text-BrownDark focus:ring-BrownDark checked:bg-BrownDark" />

                    <p class="inline">  <?php echo $translations[$lang]['iagree']; ?> </p>
                    <a href="https://docs.google.com/document/d/1KdnkTXs1JC_GNXShBbkxyYt1Q9N8b7Vabjy0cCqEpc8/edit?usp=sharing" class="font-extrabold font-sans font-italic inline underline">
                    <?php echo $translations[$lang]['tns']; ?>
                    </a>
                </div>
                <div class="col-span-4">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['1']; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "notaggreed") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['2']; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "nomatch") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['3']; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "userexists") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['4']; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "notsupported") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['5']; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "failed") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['6']; ?></div>
                        <?php
                        } elseif ($_GET['signup'] == "success") {
                        ?>
                            <div class="error text-red"> <?php echo $translations[$lang]['7']; ?></div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="my-auto col-span-4 md:mb-0 mb-1">
                    <input type="submit" value="<?php echo $translations[$lang]['sign']; ?>" name="signup" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                </div>
                <div class="col-span-4 md:pb-0 pb-8">
                    <p class="inline"><?php echo $translations[$lang]['already']; ?></p>
                    <a href="login.php?lang=<?php echo $_GET['lang']; ?>" class="font-extrabold font-sans font-italic inline underline">
                    <?php echo $translations[$lang]['log']; ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
    </div>


</body>

</html>