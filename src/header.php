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
      padding: 25px;
      background-color: rgb(102 66 41 / var(--tw-bg-opacity));
      transform: scale(1.1); /* Slightly enlarge the link */
    }

    .pp:hover {
      transform: scale(1.1);
    }

    .menu-items {
      display: flex;
    }

    .mobile-menu {
      display: none;
    }

    @media (max-width: 768px) {
      .menu-items {
        display: none;
      }

      .mobile-menu {
        display: block;
      }

      .menu-items.open {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 60px; /* Adjust based on your needs */
        left: 0;
        background-color: #664229; /* Adjust background color */
        width: 100%;
        padding: 10px;
      }

      .menu-items.open a {
        padding: 10px 0; /* Add padding for links */
      }
    }
  </style>
</head>
<body>
<div class="flex w-full justify-center">
  <nav class="shadow-2xl fixed md:mt-2 top-0 bg-BrownLight z-[9999] duration-300 lg:w-[93%] w-full md:py-5 py-4 pl-4 pr-2">
  <div class="flex justify-between items-center">
    <div class="flex">
      <img src="img/logo.png" alt="logo" class="md:w-10 md:h-8 w-8 h-6 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont md:text-2xl my-auto cursor-default">
        Ethio Wattpad
      </h1>
    </div>

    <div class="my-auto flex items-center relative">
      <div class="menu-items my-auto bg-BrownLight">
        <a href="announcements.php" id="ann" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold md:text-2xl">
          Home</a>
        <a href="viewBooks.php" id="vibo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-2xl">
          Books</a>
        <a href="viewMyBook.php" id="vimbo" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-2xl">
          My Books</a>
        <a href="postBook.php" id="pobo" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold md:text-2xl">
          Post Book</a>
      </div>
      <a href="ppuser.php?UserName=<?php echo $result['UserName']; ?>" class="pp w-10 flex items-center ml-3 duration-300 mr-3">
        <img class="mx-auto rounded-full m-2 md:w-10 md:h-10 w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">                
      </a>
      <img src="img/menu-icon.png" alt="menu" class="mobile-menu w-8 h-8 cursor-pointer">
    </div>
  </div>
  </nav>
</div>

<script>
  const menuIcon = document.querySelector('.mobile-menu');
  const menuItems = document.querySelector('.menu-items');

  menuIcon.addEventListener('click', () => {
    menuItems.classList.toggle('open');
  });
</script>

</body>
</html>

<?php
}
?>
