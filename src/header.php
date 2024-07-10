<?php

session_start();

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

  $loguser = $_SESSION['UserName'];

  $sql = "SELECT * FROM `USER` WHERE `UserName` = '$loguser'";
  $rs = mysqli_query($con, $sql);
  $result = mysqli_fetch_assoc($rs);
  $pp = $result['Photo'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <style>
    .navel:hover {
      --tw-bg-opacity: 1;
      color: rgb(229 211 179 / var(--tw-text-opacity));
      padding: 20px;
      background-color: rgb(102 66 41 / var(--tw-bg-opacity))
        /* #664229 */
      ;
    }

    .pp:hover {
      transform: scale(1.1);
      /* Slightly enlarge the element */
    }
  </style>
</head>
<body>
<div class="flex w-full justify-center">
  <nav class="fixed mt-2 top-0 bg-BrownLight z-[9999] duration-300" style=" width: 93%; padding-top: 20px; padding-bottom: 20px;padding-left: 16px; padding-right:8px;">
  <div class="flex justify-between ">
        <div class="flex">
      <img src="img/logo.png" alt="logo" class="w-10 h-8 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont text-2xl my-auto cursor-default">
        Ethio Wattpad
      </h1>
    </div>

    <div class="my-auto flex">
      <div class="my-auto">
        <a href="announcements.php" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-2xl">
          Announcements</a>
      </div>
      <div class="my-auto">
        <a href="viewbooks.php" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          View Books</a>
      </div>
      <div class="my-auto">
        <a href="viewmybooks.php" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          View My Book</a>
      </div>
      <div class="my-auto">
        <a href="postBook.php" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          Post Book</a>
      </div>
      <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
        <img src=<?php echo $pp; ?> alt="pp" class="rounded-full my-auto cursor-pointer object-cover object-center" style="width: 90%; height: 75%; cursor: pointer;">
      </a>
    </div>
  </div>

  </nav>
  </div>

</body>
</html>

<?php
}
?>