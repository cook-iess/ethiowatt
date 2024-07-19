<?php

session_start();

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

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
  <nav class="fixed top-0 bg-BrownLight z-[9999] duration-300 md:mt-2 md:w-[93%] w-full md:py-4 py-2 md:pl-4 pl-2 pr-2">
  <div class="flex justify-between items-center">
        <div class="flex">
      <img src="img/logo.png" alt="logo" class="md:w-10 md:h-8 w-8 h-7 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont md:text-2xl my-auto cursor-default">
      <?php echo $translations[$lang]['logo']; ?>
      </h1>
    </div>

    <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>

    <div class="my-auto flex">
      <div class="my-auto">
        <a href="postann.php?lang=<?php echo $_GET['lang']; ?>" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-2xl">
        <?php echo $translations[$lang]['pann']; ?></a>
      </div>
      <div class="my-auto">
        <a href="adminHome.php?lang=<?php echo $_GET['lang']; ?>" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-2xl">
        <?php echo $translations[$lang]['home']; ?></a>
      </div>
      <a href="ppadmin.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
      <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp" class="mx-auto rounded-full">  
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