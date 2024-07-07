<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
  $ID = $_POST["ID"];

  // SQL to delete record
  $sql = "DELETE FROM announcements WHERE id = $ID";

  if ($con->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Management Announcements</title>
  <link rel="stylesheet" href="output.css">
</head>

<body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont">
  <nav class="flex justify-between" style="margin-top: 20px; margin-left: 30px;  margin-right: 30px; ">
    <div class="flex">
      <img src="img/logo.png" alt="" class="w-12 h-10 my-auto" />
      <h1 class="ml-1 font-extrabold font-TitleFont text-3xl my-auto">
        Ethio Wattpad
      </h1>
    </div>

    <div class="my-auto">
        <a href="postann.php" 
        class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-110">Post Announcements</a>
      <a href="adminHome.php" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-110">
        Back</a>
    </div>
  </nav>

  <h1 class="text-6xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark py-6 mt-5 mb-6">Announcements</h1>
  <div class="md:pt-10 pt-4">
    <?php
    $select = "select * from Announcements";
    $rs = mysqli_query($con, $select);
    $count = mysqli_num_rows($rs);
    if ($count > 0) {
      while ($result = mysqli_fetch_assoc($rs)) {
    ?>
        <div class="md:flex justify-around md:pb-20 pb-14">
          <div class="mr-4 p-4 justify-center items-center grid grid-cols-2" style="width: 80%">
            <div class="col-span-2 justify-center items-center">

              <div class="">
                <div class="grid grid-cols-4">
                  <h2 class="md:text-5xl text-3xl font-bold font-Title border-b-2 pb-1" style="grid-column: span 3;">
                    <?php echo $result['Title'] ?></h2>
                  <div class="w-full flex justify-center col-span-1" style="width: 100%; margin-top: 8px;">
                    <form action="annman.php" method="post">
                      <input type="hidden" name="ID" value="<?php echo $result['ID']; ?>">
                      <button type="submit" style="margin-left: auto; margin-right: auto; padding: 10px 20px; margin-top:50px; margin-bottom:50px; background-color: #FF0000; color: white; border: none; border-radius: 10px; cursor: pointer; font-size: 15px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8); transition: background-color 0.3s ease;">
                        Delete
                      </button>
                    </form>
                  </div>
                </div>

                <p class="text-gray-600 mb-2 mt-2">Posted by: <a href="profileAd.php?UserName=<?php echo $result['UserName']; ?>"
                  class="underline font-bold" style="display:inline-block;"><?php echo $result['UserName'] ?></a></p>
               
                <h3 class="pt-3 text-xl"><?php echo $result['Description'] ?></h3>
              </div>

              <div>
                <img style="width: 500px; height: 700px; border: 2px solid #000; margin: 20px; margin-left: auto; margin-right: auto;" src="<?= $result['AnnPhoto'] ?>" alt="whats new" class="mx-auto">
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