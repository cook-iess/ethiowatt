<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header2.php";

if(isset($_SESSION['UserName']) && $_SESSION['UserName']== 'Admin321' && isset($_COOKIE['UserName'])){

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
  $ID = $_POST["ID"];

  // SQL to delete record
  $sql = "DELETE FROM announcements WHERE id = $ID";
  $rss = mysqli_query($con, $sql);

  $select = "select * from Announcements WHERE id = $ID";
  $rs = mysqli_query($con, $select);
  $count = mysqli_num_rows($rs);
  $result = mysqli_fetch_assoc($rs);

  // if ($rs) {
  //   $oldPhoto = $result['AnnPhoto'];
  //   if (file_exists($oldPhoto)) {
  //     if (unlink($oldPhoto)) {
          
  //     } else {
  //         echo "Error: Could not delete the file '$oldPhoto'.";
  //     }
  // } else {
  //     echo "Error: File '$oldPhoto' does not exist.";
  // }
    
  // } else {
  //   echo "Error deleting record: " . $conn->error;
  // }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Announcements</title>
  <link rel="stylesheet" href="output.css">
</head>

<body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">

  <h1 class="md:text-6xl text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 md:mt-20 mt-14 md:mb-6">Announcements</h1>
  <div class="md:pt-10 pt-4">
    <?php
    $select = "select * from Announcements ORDER BY ID DESC";
    $rs = mysqli_query($con, $select);
    $count = mysqli_num_rows($rs);
    if ($count > 0) {
      while ($result = mysqli_fetch_assoc($rs)) {
    ?>
        <div class="md:flex justify-around md:pb-20 pb-14">
          <div class="p-4 justify-center items-center grid grid-cols-2 mx-auto md:w-[80%] w-[95%]">
            <div class="col-span-2 justify-center items-center">

              <div class="">
                <div class="grid grid-cols-4">
                  <h2 class="md:text-5xl text-xl font-bold font-Title border-b-2 pb-1 md:mr-0 mr-6" style="grid-column: span 3;">
                    <?php echo $result['Title'] ?></h2>
                  <div class="w-full flex justify-center col-span-1" style="width: 100%; margin-top: 8px;">
                    <form action="annman.php" method="post">
                      <input type="hidden" name="ID" value="<?php echo $result['ID']; ?>">
                      <button type="submit" class="mx-auto px-5 py-2 my-auto bg-red text-white rounded-lg cursor-pointer text-base uppercase" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8); transition: background-color 0.3s ease;">
                        Delete
                      </button>
                    </form>
                  </div>
                </div>

                <p class="text-gray-600 mb-2 mt-2">Posted by: <a href="profileAd.php?UserName=<?php echo $result['UserName']; ?>"
                  class="underline font-bold" style="display:inline-block;"><?php echo $result['UserName'] ?></a></p>
               
                <h3 class="pt-3 md:text-xl text-base"><?php echo $result['Description'] ?></h3>
              </div>

              <div class="">
                <img class="md:w-4/6 md:h-4/6 w-2/3 h-2/3 m-5 mt-5 mx-auto" src="<?= $result['AnnPhoto'] ?>" alt="announcement image">
                <p class="text-base text-center w-full">Uploaded on: <?php echo $result['Reg_date'] ?></p>
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

</body>

</html>

<?php

}else{
    header("Location: index.php");
}
?>