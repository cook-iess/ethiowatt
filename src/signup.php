<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (($_SERVER["REQUEST_METHOD"] == "POST")) {

    $fname = $_POST['Full_Name'];
    $email = $_POST['Email'];
    $age = $_POST['Age'];
    $username = $_POST['UserName'];
    $password = $_POST['Password'];
    $cPassword = $_POST['CPassword'];

    if (!empty($fname) && !empty($email) && !empty($age) && !empty($_POST['Gender']) && !empty($username) && !empty($password) && !empty($cPassword)) {

        if (isset($_POST["Agree"])) {

            $check_username = "SELECT COUNT(*) FROM `USER` WHERE `UserName` = '$username'";
            $result = mysqli_query($con, $check_username);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(*)'] > 0) {
                $error = "Username already exists.";
            } else {

                $gender = $_POST['Gender'];

                if ($password == $cPassword) {

                    if(!empty($_FILES['Photo']['name'])){

                        $imagename = $_FILES['Photo']['name'];
                        $tmpname = $_FILES['Photo']['tmp_name'];
                        $error = $_FILES['Photo']['error'];

                        if ($error === 0) {
                            $imageex = pathinfo($imagename, PATHINFO_EXTENSION);
                    
                            $imageexlc = strtolower($imageex);
                    
                            $allowedex = array('jpg', 'jpeg', 'png');
                    
                            if (in_array($imageexlc, $allowedex)) {
                                $newimgname=uniqid("IMG-",true).'.'.$imageexlc;
                                $imguploadpath='uploads/user/'.$newimgname;
                                move_uploaded_file($tmpname, $imguploadpath);
                                $newimgname='uploads/user/'.$newimgname;
                            } else {
                                $error = "Image this Type not supported!";
                                echo "<h4>Image this Type not supported!</h4>";
                            }
                        }
                    }else{
                        $newimgname = "uploads/user/default.jpg";
                }
                


                    $insert = "INSERT INTO `USER` (`Photo`, `Full_Name`, `Gender`, `Age`, `Email`, `UserName`, `Password`) 
          VALUES (\"$newimgname\", \"$fname\", \"$gender\", \"$age\", \"$email\", \"$username\", \"$password\")";
                    $yes = mysqli_query($con, $insert);
                    if ($yes) {
                        echo '<script type="text/javascript">alert("Logging Successfully!!!")</script>';
                        header("Location: login.php");
                        echo '<script type="text/javascript">alert("Logging Successfully!!!")</script>';
                    } else {
                        $error = "User Not Registered Successfully!!";
                    }
                } else {
                    $error = "Password and Confirm password don't match!";
                }
            }
        } else {
            $error = "You must agree to the terms and conditions!";
        }
    } else {
        $error = "Fill in all the required credentials!";
    }
}
else{
    echo "image not uploaded";
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="output.css">
</head>

<body class="w-full h-full flex bg-BrownLight font-TextFont">
    <div class="flex p-5 fixed top-0 mt-5">
        <img src="img/logo.png" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 font-extrabold font-TitleFont text-3xl my-auto text-BrownDark">
            Ethio Wattpad
        </h1>
    </div>
    <div class="grid grid-cols-2 h-full">
        <div class="bg-BrownDark text-BrownLight align-middle my-auto rounded-r-3xl pt-10">
            <div class="">
                <p class="text-3xl font-bold text-center mt-4">
                    Unlock the Wonders of the
                </p>
                <p class="text-3xl font-bold text-center mb-4">
                    Book World - Join Today!
                </p>
            </div>
            <div class="">
                <img src="img/book3.png" class="mx-auto px-14 pb-14 w-96" />
            </div>
        </div>

        <div class="bg-BrownLight text-BrownDark my-auto">
            <h1 class="text-6xl ml-12 font-extrabold font-TitleFont">
                Create Your Account
            </h1>
            <p class="ml-12 mb-6">Lets get Started</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="ml-12 grid grid-cols-4 gap-x-6 gap-y-3 mr-12" method="post" enctype="multipart/form-data">
                <div class="col-span-4">
                    <label htmlFor="full_name" class="">
                        Full name*
                    </label>
                    <input id="Full_Name" name="Full_Name" type="text" placeholder="enter full name Here" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-4">
                    <label htmlFor="email" class="">
                        Email*
                    </label>
                    <input id="Email" name="Email" type="email" placeholder="name@example.com" class="block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-1">
                    <label htmlFor="age" class="">
                        Age*
                    </label>
                    <input id="Age" name="Age" type="number" placeholder="0" class="shadow-lg mt-2 w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="w-full col-span-3">
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
                <div class="col-span-2">
                    <label htmlFor="userName">Username*</label>
                    <input id="UserName" name="UserName" type="text" placeholder="unique username" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="col-span-2">
                    <label htmlFor="pp" class="">
                        Upload Profile Photo
                    </label>
                    <input type="file" name="Photo" class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                </div>
                <div class="col-span-2">
                    <label htmlFor="password">Password*</label>
                    <input id="Password" name="Password" minLength={8} type="password" placeholder="min 8 chars" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-2">
                    <label htmlFor="cPassword">Confirm Password*</label>
                    <input id="CPassword" name="CPassword" minLength={8} type="password" placeholder="enter password again" class="w-full mb-4 block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="col-span-4">
                    <input type="checkbox" name="Agree" class="bg-BrownDark border-BrownDark border text-BrownDark focus:ring-BrownDark checked:bg-BrownDark" />

                    <p class="inline"> I agree to the </p>
                    <a href="" class="font-extrabold font-sans font-italic inline underline">
                        Terms & Condotions
                    </a>
                </div>
                <div class="col-span-4">
                    <?php
                    // Check if the error message is set
                    if (isset($error)) {
                    ?>
                        <div class="error text-red"><?php echo $error; ?></div>
                    <?php
                    }
                    ?>
                </div>
                <div class="my-auto col-span-4">
                    <input type="submit" value="Sign Up" name="signup" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                </div>
                <div class="col-span-4">
                    <p class="inline">Already have an account? </p>
                    <a href="login.php" class="font-extrabold font-sans font-italic inline underline">
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>