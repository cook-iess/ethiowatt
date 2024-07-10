<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");

require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    if (isset($_POST['delete'])) {

        $sql = "DELETE FROM Announcements WHERE UserName = '$UserName'";
        $sql2 = "DELETE FROM USER WHERE username = '$UserName'";

        if ($con->query($sql) === TRUE) {
            if ($con->query($sql2) === TRUE) {
                header("Location: index.php");
            } else {
                echo "Error deleting record: " . $con->error;
            }
        } else {
            echo "Error deleting record: " . $con->error;
        }
    }
?>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

        <p class="text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mb-2" style="margin-top: 75px;">User Profile</p>
        <div class="flex justify-end mt-4">
            <div class="flex">
                <a href="chanpass.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Change Password</a>
                <a href="editprofile.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Edit Profile</a>
                <a href="logout.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">Logout</a>
                <form action="ppuser.php" method="post">
                    <button type="submit" name="delete" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="" style="margin-top: 45px;">
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
                            <img src="<?= $result['Photo'] ?>" alt="profile Photo" class=" h-auto rounded-full" style="width: 80%">
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
            ?>
        </div>

        <div>
            <p class="text-4xl font-TitleText font-bold text-BrownLight bg-BrownDark py-4 mt-8 mb-2 pl-10" style="width: 35%;">Your favourites:</p>
        </div>
    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>