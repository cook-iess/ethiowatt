<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcements</title>
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

    .dd {
      background-image: url('img/imgann2.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      width: 100%;
      height: 400px;
    }
  </style>
</head>

<body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">
  <div class="flex w-full justify-center">
  <nav class="fixed top-0 bg-BrownLight z-[9999] duration-300" style=" width: 93%; padding-top: 10px; padding-bottom: 6px;padding-left: 16px; padding-right:8px;">
  <div class="flex justify-between ">
        <div class="flex">
      <img src="img/logo.png" alt="logo" class="w-10 h-8 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont text-2xl my-auto cursor-default">
        Ethio Wattpad
      </h1>
    </div>

    <div class="my-auto flex">
      <div class="my-auto">
        <a href="#" style="border-bottom-width: 2px;" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 hover:font-extrabold font-bold text-2xl">
          Announcements</a>
      </div>
      <div class="my-auto">
        <a href="viewbooks.php" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          View Books</a>
      </div>
      <div class="my-auto">
        <a href="viewmybooks.php" class="navel mr-4 font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          View My Book</a>
      </div>
      <div class="my-auto">
        <a href="postbooks.php" class="navel font-TitleFont text-BrownDark ease-in duration-300 font-bold text-2xl">
          Post Book</a>
      </div>
      <a class="pp w-10 flex items-center ml-3 duration-300 mr-3">
        <img src="img/mindwatering.jpg" alt="pp" class="rounded-full my-auto cursor-pointer object-cover object-center" style="width: 90%; height: 60%; cursor: pointer;">
      </a>
    </div>
  </div>

  </nav>
  </div>

  <div class="w-full grid bg-BrownDark3" style="grid-template-columns: repeat(5, 1fr); margin-top: 75px;">
    <div class="w-full" style="grid-column: span 2;">
      <img src="img/imgann1.jpg" alt="" class="w-full">
    </div>

    <div class="w-full my-auto" style="grid-column: span 3;">
      <h1 class="hero text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-1 mb-4">Announcements</h1>
      <p class="text-center text-xl">Book Giveaways, Literary Festivals, Book Club Meetups and so on</p>
      <div class="text-center">
        <p class="inline">Want to post anything? Contact </p>
        <a class="inline font-extrabold underline" href="https://t.me/Ikam43">Admin</a>
      </div>
    </div>

  </div>

  <div class="pt-10">
    <?php
    $select = "select * from Announcements ORDER BY ID DESC";
    $rs = mysqli_query($con, $select);
    $count = mysqli_num_rows($rs);
    if ($count > 0) {
      while ($result = mysqli_fetch_assoc($rs)) {
    ?>
        <div class="md:flex justify-around pb-10">
          <div class="mr-4 p-4 justify-center items-center grid grid-cols-2" style="width: 85%">
            <div class="col-span-2 justify-center items-center">

              <div class="">
                <h2 class="md:text-5xl text-3xl font-bold font-Title border-b-2 pb-1" style="grid-column: span 3;">
                  <?php echo $result['Title'] ?></h2>


                <div class="grid grid-cols-2 mt-4">
                  <div>
                    <p class="text-gray-600 mb-2 mt-2">Posted by: <a href="profileNu.php?UserName=<?php echo $result['UserName']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['UserName'] ?></a></p>

                    <h3 class="pt-3 text-xl"><?php echo $result['Description'] ?></h3>
                  </div>

                  <div>
                    <img style="width: 350px; height: 400px; border: 2px solid #000; margin: 20px; margin-left: auto; margin-right: auto; margin-bottom:6px;" src="<?= $result['AnnPhoto'] ?>" alt="whats new" class="mx-auto">
                    <p class="text-base text-center w-full">Uploaded on: <?php echo $result['Reg_date'] ?></p>
                  </div>

                </div>

              </div>

            </div>
          </div>
        </div>
    <?php
      }
    } else {
      echo "<h2 class='text-center text-3xl font-bold mb-5'>No records found</h2>";
    }
    ?>
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