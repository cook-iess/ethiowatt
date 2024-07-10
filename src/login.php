<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_POST["login"])) {
  $username = $_POST['UserName'];
  $password = $_POST['Password'];

  $usernameAdmin = "Admin321";

  if (!empty($username) && !empty($password)) {

    if ($username == $usernameAdmin) {
      $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username'";
      $rs = mysqli_query($con, $sql);
      $result = mysqli_fetch_assoc($rs);
      if ($test = password_verify($password, $result['Password'])) {

        session_start();
        $_SESSION['UserName'] = $result['UserName'];
        setcookie('UserName',$username, time()+3600);

        header("Location: adminHome.php?&login=success");
        exit();
      } else {
        header("Location: login.php?error=incorrect&username=" . $username);
        exit();
      }
    } else {
      $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username'";
      $rs = mysqli_query($con, $sql);
      $result = mysqli_fetch_assoc($rs);
      $count = mysqli_num_rows($rs);

      if ($count > 0) {

        if ($test = password_verify($password, $result['Password'])) {

          session_start();
          $_SESSION['UserName'] = $result['UserName'];
          setcookie('UserName',$username, time()+3600);

          header("Location: announcements.php?&login=success");
          exit();
        } else {
          header("Location: login.php?error=incorrect&username=" . $username);
          exit();
        }
      } else {
        header("Location: login.php?error=signedup");
        exit();
      }
    }
  } else {
    header("Location: login.php?error=emptyfields&username=" . $username);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="output.css">
</head>

<body class="w-full h-screen bg-BrownLight text-BrownDark font-TextFont">
  <div class="flex justify-center items-center h-full shadow-2xl shadow-BrownDark">
    <div class="mx-auto p-5 w-5/12 shadow-2xl shadow-BrownDark2 px-10 py-10">
      <div class="flex justify-center">
        <img src="img/logo.png" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 text-center font-extrabold font-TitleFont text-3xl my-auto text-BrownDark">
          Ethio Wattpad
        </h1>
      </div>
      <h1 class="text-6xl font-extrabold font-TitleFont text-center">
        Welcome Back
      </h1>
      <p class="text-center">
        Please Login in to your Account
      </p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="py-6 h-1/3 px-12">
        <div class="col-span-2 mb-4">
          <label htmlFor="username">Username</label>
          <input id="username" type="text" name="UserName" placeholder="Enter Username" value="<?php
                                                                                                if (isset($_GET['username'])) {
                                                                                                  echo $_GET['username'];
                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
        </div>
        <div class="col-span-2 mb-4">
          <label htmlFor="password">Password</label>
          <input id="password" type="password" name="Password" minlength="8" placeholder="min 8 chars" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
        </div>
        <div class="col-span-2">
          <?php

          if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
          ?>
              <div class="error text-red">Fill in all the required Fields</div>
            <?php
            } elseif ($_GET['error'] == "incorrect") {
            ?>
              <div class="error text-red">Incorrect password</div>
            <?php
            } elseif ($_GET['error'] == "signedup") {
            ?>
              <div class="error text-red">You need to get signed up first</div>
            <?php
            } elseif ($_GET['login'] == "success") {
            ?>
              <div class="error text-red">Login successful</div>
          <?php
            }
          }
          ?>
        </div>
        <div class="my-auto col-span-4 mt-2 mb-1">
          <input type="submit" name="login" value="Login" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
        </div>
        <div class="col-span-4">
          <p class="inline">Don't have an account? </p>
          <a href="signup.php" class="font-extrabold font-sans font-italic inline underline">
            Sign up
          </a>
        </div>
      </form>
    </div>
  </div>
  <div class="bottom-0 absolute ml-5">
    <img src="img/BookOffer.png" class="" />
  </div>
</body>

</html>