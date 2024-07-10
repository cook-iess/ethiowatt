<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");
session_start();
// require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);

    if (isset($_POST['update'])) {

        $fname = $_POST['Full_Name'];
        $email = $_POST['Email'];
        $Bio = $_POST['Bio'];
        $password = $_POST['Password'];

        if (!empty($fname) && !empty($email) && !empty($_POST['Gender']) && !empty($password)) {
            $gender = $_POST['Gender'];

            $sql = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            if (password_verify($password, $result['Password'])) {
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
                            header("Location: editprofile.php?error=notsupported");
                            exit();
                        }
                    }
                } else {
                    $newimgname = "uploads/user/default.jpg";
                }


                $sql = "UPDATE USER SET Full_Name = '$fname', Email = '$email', Bio = '$Bio', Gender = '$gender', Photo = '$newimgname' WHERE UserName = '$UserName'";
                if ($con->query($sql) === TRUE) {
                    header("Location: ppuser.php?update=success");
                    exit();
                } else {
                    header("Location: editprofile.php?update=notsuccess");
                    exit();
                }
            } else {
                header("Location: editprofile.php?error=incorrect");
                exit();
            }
        } else {
            header("Location: editprofile.php?error=emptyfields");
            exit();
        }

    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="output.css">
    </head>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">
        <div class="mt-14">
            <h3 class="text-center font-bold text-xl">Edit Your Profile</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="ml-12 mr-12" style="width: 45%; margin-left:auto; margin-right:auto; margin-top:auto; margin-down:auto;" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label htmlFor="full_name" class="">
                        Full name*
                    </label>
                    <input id="Full_Name" name="Full_Name" type="text" placeholder="enter full name Here" value="<?php echo $result['Full_Name'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="email" class="">
                        Email*
                    </label>
                    <input id="Email" name="Email" type="email" placeholder="name@example.com" value="<?php echo $result['Email'] ?>" class="block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="mb-2">
                    <label htmlFor="age" class="">
                        Bio
                    </label>
                    <input id="Bio" name="Bio" type="text" placeholder="Something about yourself" value="<?php echo $result['Bio'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="gender" class="">
                        Gender*
                    </label>
                    <div class="border rounded-lg border-BrownDark flex py-2 px-4 mt-1">
                        <input type="radio" name="Gender" value="Male" />
                        Male
                        <input type="radio" name="Gender" value="Female" class="ml-2" />
                        Female
                    </div>
                </div>
                <div class="mb-2">
                    <label htmlFor="userName">Username*</label>
                    <input readonly id="UserName" name="UserName" type="text" placeholder="unique username" value="<?php echo $result['UserName'] ?>(not editable)" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="pp" class="">
                        Upload Profile Photo
                    </label>
                    <input type="file" name="Photo" value="<?php echo $result['Photo'] ?>" class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                </div>
                <div class="mb-2">
                    <label htmlFor="password">Current Password*</label>
                    <input id="Password" name="Password" minLength={8} type="password" placeholder="min 8 chars" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="mb-4">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error text-red">Fill in all the required Fields</div>
                        <?php
                        } elseif ($_GET['error'] == "incorrect") {
                        ?>
                            <div class="error text-red">Current password not correct</div>
                        <?php
                        } elseif ($_GET['error'] == "notsupported") {
                        ?>
                            <div class="error text-red">Image not supported</div>
                        <?php
                        } elseif ($_GET['update'] == "notsuccess") {
                        ?>
                            <div class="error text-red">Updating not successful</div>
                    <?php
                        } elseif ($_GET['update'] == "success") {
                            ?>
                                <div class="error text-red">Updated successfully</div>
                        <?php
                            }
                    }
                    ?>
                </div>
                <input type="submit" value="Update" name="update" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                <a href="ppuser.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">Cancel</a>
            </form>
        </div>


    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>