<?php

session_start();

if (isset($_SESSION['UserName']) && $_SESSION['UserName']== 'Admin321') {

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
      padding: 25px;
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
  <nav class="fixed top-0 bg-BrownLight z-[9999] duration-300 mt-2" style=" width: 93%; padding-top: 20px; padding-bottom: 20px; padding-left: 16px; padding-right:8px;">
  <div class="flex justify-between ">
        <div class="flex">
      <img src="img/logo.png" alt="logo" class="w-10 h-8 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont text-2xl my-auto cursor-default">
        Ethio Wattpad
      </h1>
    </div>

    <div class="my-auto flex">
      <div class="my-auto">
        <a href="postann.php" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
        Post Announcements</a>
      </div>
      <div class="my-auto">
        <a href="adminHome.php" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          Home</a>
      </div>
      <a href="ppadmin.php?UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
      <img style="margin: 2px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 40px; height: 40px; object-fit: cover; object-position: center;" src="<?php echo $pp; ?>" alt="pp" class="mx-auto rounded-full">  
      </a>
    </div>
  </div>

  </nav>
  </div>

  <script>
  window.addEventListener('scroll', function() {
    const header = document.querySelector('nav');
    if (window.pageYOffset > 0) {
      header.classList.add('shadow-2xl');
    } else {
      header.classList.remove('shadow-2xl');
    }
  });
</script>

</body>
</html>

<?php
}
?>