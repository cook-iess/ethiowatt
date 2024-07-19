<?php
ob_start(); 
session_start();

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

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
      padding: 25px;
      background-color: rgb(102 66 41 / var(--tw-bg-opacity));
    }

    .pp:hover {
      transform: scale(1.1);
    }

    .menu-icon, .close-icon {
      cursor: pointer;
    }
    </style>
</head>
<body>
<div class="flex w-full justify-center">
  <nav class="shadow-2xl fixed md:mt-2 top-0 bg-BrownLight z-[9999] duration-300 lg:w-[93%] w-full md:py-5 py-4 pl-4 pr-2">
    <div class="flex justify-between items-center">
      <div class="flex">
        <img src="img/logo.png" alt="logo" class="md:w-10 md:h-8 w-8 h-6 my-auto" />
        <h1 class="ml-1 font-extrabold font-TitleFont md:text-xl my-auto cursor-default">
        <?php echo $translations[$lang]['logo']; ?>
        </h1>
      </div>
      <div class="flex md:hidden items-center">
        <img src="img/menu-icon.png" alt="menu" id="menu-icon" class="menu-icon w-8 h-8" />
        <img src="img/close-icon.png" alt="close" id="close-icon" class="close-icon w-8 h-8 hidden" />
        <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>" class="pp flex items-center ml-3 duration-300 mr-3">
          <img class="rounded-full md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">                
        </a>
      </div>
      <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>
      <div class="hidden md:flex my-auto">
        <div class="my-auto">
          <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-xl">
          <?php echo $translations[$lang]['home']; ?></a>
        </div>
        <div class="my-auto">
          <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['books']; ?></a>
        </div>
        <div class="my-auto">
          <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['mybooks']; ?></a>
        </div>
        <div class="my-auto">
          <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-xl">
          <?php echo $translations[$lang]['postbook']; ?></a>
        </div>
        <a href="ppuser.php?lang=<?php echo $lang; ?>&UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
          <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">                
        </a>
      </div>
    </div>
    <div class="md:hidden flex flex-col items-start space-y-2 mt-4 hidden" id="mobile-menu">
      <a href="announcements.php?lang=<?php echo $lang; ?>" id="ann" class="navel font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-xl">
        Home</a>
      <a href="viewBooks.php?lang=<?php echo $lang; ?>" id="vibo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        Books</a>
      <a href="viewMyBook.php?lang=<?php echo $lang; ?>" id="vimbo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        My Books</a>
      <a href="postBook.php?lang=<?php echo $lang; ?>" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-xl">
        Post Book</a>
    </div>
  </nav>
</div>

<script>
  document.getElementById('menu-icon').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.remove('hidden');
    document.getElementById('menu-icon').classList.add('hidden');
    document.getElementById('close-icon').classList.remove('hidden');
  });

  document.getElementById('close-icon').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.add('hidden');
    document.getElementById('menu-icon').classList.remove('hidden');
    document.getElementById('close-icon').classList.add('hidden');
  });
</script>
</body>
</html>
<?php
}
ob_end_flush(); // End output buffering
?>
