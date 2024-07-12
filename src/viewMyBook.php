<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

  $UserName = $_SESSION['UserName'];


?>

  <head>
    <title>View My Books</title>
  </head>

  <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

    <div class="w-full grid bg-BrownDark3" style="grid-template-columns: repeat(5, 1fr); margin-top: 75px;">
      <div class="w-full" style="grid-column: span 2;">
        <img src="img/imgimg.jpg" alt="" class="w-full">
      </div>

      <div class="w-full my-auto" style="grid-column: span 3;">
        <h1 class="hero text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-1 mb-4">View My Books</h1>
        <p class="text-center text-xl">Explore Your Literary Works, Edit them, Delete and so on</p>
        <div class="text-center">
          <p class="inline">Having a problem posting? </p>
          <a class="inline font-extrabold underline" href="https://t.me/Ikam43">Help Center</a>
        </div>
      </div>

    </div>

    <div class="pt-10">
      <?php


      function truncateText($text, $maxLength)
      {
        if (strlen($text) > $maxLength) {
          $text = substr($text, 0, $maxLength) . '...';
        }
        return $text;
      }


      $select = "SELECT * FROM BOOK WHERE UserName = '$UserName' ORDER BY Title ASC";
      $rs = mysqli_query($con, $select);
      $count = mysqli_num_rows($rs);
      if ($count > 0) {
      ?>
        <div class="flex justify-center">
          <div style="width: 85%">

            <div class="grid grid-cols-5 gap-4" style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr));">
              <?php
              while ($result = mysqli_fetch_assoc($rs)) {
                $truncatedDesc = truncateText($result['Book_Desc'], 49);
                $truncatedTitle = truncateText($result['Title'], 39);
              ?>
                <div class="mb-14">
                  <div class="mt-4">
                    <div>
                      <img style="margin: 20px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 150px; height: 200px; object-fit: cover; object-position: center;" src="<?= $result['Photo'] ?>" alt="whats new" class="mx-auto">
                      <h2 class="font-bold font-TitleFont text-center text-xs pb-1">
                        <?php echo $truncatedTitle ?></h2>
                      <h3 class="pt-1 text-xs text-center"><?php echo $truncatedDesc ?></h3>
                      <p class="text-xs text-center"><?php echo $result['Add_Date'] ?></p>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>

          </div>
        </div>
      <?php
      } else {
        echo "<h2 class='text-center text-BrownDark2 text-2xl font-bold mt-5'>You have not Written Anything Yet. Want to <a href='postBook.php' class='text-blue-500 underline'>Post?</a></h2>";
      }
      ?>
    </div>

    <script>
      var vibmo = document.getElementById("vimbo");
      vibmo.setAttribute("style", "border-bottom-width: 2px;");

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
} else {
  header("Location: index.php");
}
?>