<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {


?>

<head>
  <title>Announcements</title>
</head>
  <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">

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
          <div class="flex justify-center">
          <div class="mr-4" style="width: 85%">

                <div class="mb-14">
                  <h2 class="md:text-5xl text-3xl font-bold font-Title border-b-2 pb-1">
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