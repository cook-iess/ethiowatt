<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header.php";

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {


?>

<head>
  <title><?php echo $translations[$lang]['uhome']; ?></title>
</head>
  <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">

    <div class="w-full grid md:grid-cols-5 grid-cols-3 md:mt-20 mt-16 bg-BrownDark3">
      <div class="w-full md:col-span-2">
        <img src="img/imgann1.jpg" alt="" class="w-full">
      </div>

      <div class="w-full my-auto md:col-span-3 col-span-2">
        <h1 class="hero lg:text-6xl md:text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark md:py-6 py-3 mt-1 md:mb-4"><?php echo $translations[$lang]['ann']; ?></h1>
        <p class="text-center lg:text-xl md:text-sm text-xs"><?php echo $translations[$lang]['can']; ?></p>
        <div class="text-center md:text-base text-xs">
          <p class="inline"><?php echo $translations[$lang]['wanapost']; ?></p>
          <a class="inline font-extrabold underline" href="https://t.me/Ikam43"><?php echo $translations[$lang]['admin']; ?></a>
        </div>
      </div>

    </div>

    <div class="md:pt-10 pt-4">
      <?php
      $select = "select * from Announcements ORDER BY ID DESC";
      $rs = mysqli_query($con, $select);
      $count = mysqli_num_rows($rs);
      if ($count > 0) {
        while ($result = mysqli_fetch_assoc($rs)) {
      ?>
          <div class="flex justify-center">
          <div class="mr-4" style="width: 85%">

                <div class="mb-14">
                  <h2 class="md:text-5xl text-xl font-bold font-Title border-b-2 pb-1">
                    <?php echo $result['Title'] ?></h2>


                  <div class="grid md:grid-cols-2 mt-4">
                    <div>
                      <p class="md:mb-2 mt-2 md:text-base text-sm"><?php echo $translations[$lang]['pby']; ?>: <a href="profileNu.php?UserName=<?php echo $result['UserName']; ?>&lang=<?php echo $_GET['lang']; ?>" class="underline font-bold" style="display:inline-block;"><?php echo $result['UserName'] ?></a></p>

                      <h3 class="md:pt-3 pt-1 md:text-xl"><?php echo $result['Description'] ?></h3>
                    </div>

                    <div>
                      <img class="mx-auto md:w-80 md:h-96 w-72 h-80 md:shadow-2xl shadow-lg m-5 mb-2" src="<?= $result['AnnPhoto'] ?>" alt="whats new">
                      <p class="md:text-base text-sm text-center w-full"><?php echo $translations[$lang]['uon']; ?>: <?php echo $result['Reg_date'] ?></p>
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

      var ann = document.getElementById("ann");
      ann.setAttribute("style", "border-bottom-width: 2px;");
      
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: index.php");
}
?>