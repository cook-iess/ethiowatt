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

    <div class="w-full grid md:grid-cols-5 grid-cols-3 bg-BrownDark3 md:mt-20 mt-16">
      <div class="w-full md:col-span-2">
        <img src="img/imgimg.jpg" alt="" class="w-full">
      </div>

      <div class="w-full my-auto md:col-span-3 col-span-2">
        <h1 class="hero lg:text-6xl md:text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark md:py-6 py-3 md:mb-4">View My Books</h1>
        <p class="text-center lg:text-xl md:text-sm text-xs px-3">Explore Your Literary Works, Edit them, Delete and so on</p>
        <div class="text-center md:text-base text-xs px-2">
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

            <div class="grid md:grid-cols-2 gap-4">
              <?php
              while ($result = mysqli_fetch_assoc($rs)) {
                $truncatedTitle = truncateText($result['Title'], 32);
                $truncatedDesc = truncateText($result['Book_Desc'], 110);
              ?>
                <div class="mb-14">
                  <div class="grid grid-cols-2 mt-4 gap-4">
                    <div>
                      <a href="mybookdetail.php?id=<?= $result['Book_ID'] ?>">
                        <img style="margin: 10px auto 6px auto; width: 230px; height: 280px; object-fit: cover; object-position: center;" src="<?= $result['Photo'] ?>" alt="cover photo" class="mx-auto">
                      </a>
                    </div>
                    <div class="mt-6">
                      <a href="mybookdetail.php?id=<?= $result['Book_ID'] ?>">
                        <h2 class="font-bold font-TitleFont text-xl pb-1 underline"> <?php echo $truncatedTitle ?></h2>
                      </a>
                      <p class="text-xs mb-2">Uploaded on: <?php echo $result['Add_Date'] ?></p>
                      <h3 class="pt-1 text-xs mb-4"><?php echo $truncatedDesc ?></h3>
                      <?php
                      $bookid = $result['Book_ID'];
                      $select3 = "SELECT COUNT(*) as count FROM LIKES WHERE Book_ID = '$bookid' AND User_ID = '$UserName'";
                      $rs3 = mysqli_query($con, $select3);
                      if ($rs3) {
                        $row = mysqli_fetch_assoc($rs3);
                        $liked = $row['count'] > 0;
                      }

                      $likeImage = $liked ? 'img/filled_like.png' : 'img/unfilled_like.png';
                      ?>
                      <div class="flex mb-5">
                        <img id="likeImage_<?php echo $result['Book_ID']; ?>" src="<?php echo $likeImage; ?>" alt="Like" style="width: 35px; height: 35px;">
                        <p class="my-auto text-lg ml-1 mt-2"><?php echo $result['Likes'] ?></p>
                      </div>
                      <div>
                        <a href="mycomments.php?book_id=<?= $result['Book_ID'] ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-4 px-5 shadow-xl hover:shadow-2xl">Comments</a>
                      </div>
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