<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include("conn.php");

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    if (isset($_POST['change'])) {

        $newpass = $_POST['newpassword'];
        $cnewpass = $_POST['cnewpassword'];
        $oldpass = $_POST['oldpassword'];

        if (!empty($newpass) && !empty($cnewpass) && !empty($oldpass)) {
            $sql = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            if (password_verify($oldpass, $result['Password'])) {

                if ($newpass == $cnewpass) {
                    $hashpass = password_hash($newpass, PASSWORD_DEFAULT);
                    $sql = "UPDATE USER SET password = '$hashpass' WHERE username = '$UserName'";
                    if ($con->query($sql) === TRUE) {
                        session_start();
                        session_unset();
                        session_destroy();
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: chanpass.php?update=notsuccess");
                        exit();
                    }
                } else {
                    header("Location: chanpass.php?error=nomatch");
                    exit();
                }
            } else {
                header("Location: chanpass.php?error=incorrect");
                exit();
            }
        } else {
            header("Location: chanpass.php?error=emptyfields");
            exit();
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change Pasword</title>
        <link rel="stylesheet" href="output.css">
    </head>

    <body class="bg-BrownLight w-full h-screen text-BrownDark font-TextFont">
        <div class="flex w-full h-full justify-center items-center">
            <div class="">
                <h3 class="text-center font-bold text-xl">Change Your Password</h3>
                <p>After successful update you will have to login again</p>
                <form action="chanpass.php" method="post">
                    <div class="flex justify-center mx-auto">
                        <div>
                            <input type="password" name="newpassword" minlength="8" placeholder="new password" style="margin: 12px; padding: 8px;"><br>
                            <input type="password" name="cnewpassword" minlength="8" placeholder="confirm new password" style="margin: 12px; padding: 8px;"><br>
                            <input type="password" name="oldpassword" minlength="8" placeholder="old password" style="margin: 12px; padding: 8px;"><br>
                        </div>

                    </div>
                    <div class="text-center">
                        <?php

                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "emptyfields") {
                        ?>
                                <div class="error text-red">Fill in all the required Fields</div>
                            <?php
                            } elseif ($_GET['error'] == "incorrect") {
                            ?>
                                <div class="error text-red">Incorrect old password</div>
                            <?php
                            } elseif ($_GET['error'] == "nomatch") {
                            ?>
                                <div class="error text-red">Password and confirm password dont match</div>
                            <?php
                            } elseif ($_GET['update'] == "success") {
                            ?>
                                <div class="error text-red">Update successful</div>
                            <?php
                            } elseif ($_GET['update'] == "notsuccess") {
                            ?>
                                <div class="error text-red">Update was not successful</div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="flex justify-center w-full mt-4" style="margin-left: 8px;">
                        <form action="chanpass.php" method="post">
                            <button type="submit" name="change" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                                Change
                            </button>
                        </form>
                        <a href="ppuser.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>