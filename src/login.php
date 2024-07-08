<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['UserName'];
  $password = $_POST['Password'];

  $usernameAdmin = "Admin321";
  $passwordAdmin = "Admin@124";

  if (!empty($username) && !empty($password)) {

    if ($username == $usernameAdmin && $password == $passwordAdmin) {
      header("Location: adminHome.php");
    } else {
      $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username'";
      $rs = mysqli_query($con, $sql);
      $result = mysqli_fetch_assoc($rs);
      if ($test = password_verify($password, $result['Password'])) {
        $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username' AND `Password` = '$password'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
          header("Location: announcements.php");
        } else {
          $error = "Please sign up first.";
        }
      }else{
        $error = "Incorrect Password!";
      }
    }
  } else {
    $error = "Fill in the Credentials!";
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
          <input id="username" type="text" name="UserName" placeholder="unique username" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
        </div>
        <div class="col-span-2 mb-4">
          <label htmlFor="password">Password</label>
          <input id="password" type="password" name="Password" minlength="8" placeholder="min 8 chars" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
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