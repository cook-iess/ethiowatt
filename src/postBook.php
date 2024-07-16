<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

// session_start();

require "header.php";

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    if (isset($_POST["start"])) {

        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $lang = $_POST['lang'];
        $genre = $_POST['genre'];
        $photo = $_FILES['Photo']['name'];

        if (!empty($title) && !empty($desc) && !empty($lang) && !empty($genre) && !empty($photo)) {

            if (isset($_POST["Agree"])) {

                $pg = $_POST['PG'];

                $imagename = $_FILES['Photo']['name'];
                $tmpname = $_FILES['Photo']['tmp_name'];
                $error = $_FILES['Photo']['error'];

                if ($error === 0) {
                    $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                    $imageexlc = strtolower($imageex);

                    $allowedex = array('jpg', 'jpeg', 'png');

                    if (in_array($imageexlc, $allowedex)) {
                        $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                        $imguploadpath = 'uploads/book/' . $newimgname;
                        move_uploaded_file($tmpname, $imguploadpath);
                        $newimgname = 'uploads/book/' . $newimgname;
                    } else {
                        header("Location: postBook.php?error=notsupported&title=" . $title . "&desc=" . $desc . "&lang=" . $lang. "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
                        exit();
                    }
                }

                $newimgname = mysqli_real_escape_string($con, $newimgname);
                $title = mysqli_real_escape_string($con, $title);
                $desc = mysqli_real_escape_string($con, $desc);
                $lang = mysqli_real_escape_string($con, $lang);
                $genre = mysqli_real_escape_string($con, $genre);
                $pg = mysqli_real_escape_string($con, $pg);

                $insert = "INSERT INTO `BOOK` (`Photo`, `Title`, `Book_Desc`, `Genre`, `PG`, `Language`, `UserName`) 
                    VALUES (\"$newimgname\", \"$title\", \"$desc\", \"$genre\", \"$pg\", \"$lang\", \"$UserName\")";
                $yes = mysqli_query($con, $insert);
                if ($yes) {
                    header("Location: startWriting.php?post=success&title=". $title );
                    exit();
                } else {
                    header("Location: startWriting.php?error=failed&title=" . $title . "&desc=" . $desc . "&lang=" . $lang. "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
                    exit();
                }
            } else {
                header("Location: postBook.php?error=notaggreed&title=" . $title . "&desc=" . $desc . "&lang=" . $lang. "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
                exit();
            }
        } else {
            header("Location: postBook.php?error=emptyfields&title=" . $title . "&desc=" . $desc . "&lang=" . $lang. "&desc=" . $desc . "&genre=" . $genre . "&PG=" . $pg);
            exit();
        }
    }

?>

    <body class="bg-BrownLight w-full h-screen text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">

        <div class="flex justify-center items-center h-screen md:mt-3 mt-48">

            <div class="md:grid md:grid-cols-4 md:mt-0">
                <div class="bg-BrownDark text-BrownLight align-middle my-auto shadow-2xl md:py-10 py-2">
                    <div class="">
                        <p class="md:text-4xl text-xl font-bold text-center mt-4">
                            Post Book
                        </p>
                        <p class="md:text-2xl font-bold text-center mb-4">
                            Share Your Literary Experiences
                        </p>
                    </div>
                    <div class="">
                        <img src="img/signimg.png" class="mx-auto md:px-8 px-4 pb-4 md:w-96 w-60" />
                    </div>
                </div>

                <div class="text-BrownDark col-span-3 flex justify-center ">
                    <form action="postBook.php" class="md:mx-12 grid md:grid-cols-4 gap-x-6 gap-y-3 mx-6 md:mt-0 mt-4" method="post" enctype="multipart/form-data">
                        <div class="col-span-4">
                            <label htmlFor="title" class="">
                                Title*
                            </label>
                            <input name="title" type="text" placeholder="Title of the book" value="<?php if (isset($_GET['title'])) {
                                                                                                        echo $_GET['title'];
                                                                                                    } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>
                        <div class="col-span-4 row-span-2">
                            <label htmlFor="desc" class="">
                                Description*
                            </label>
                            <textarea name="desc" id="" cols="30" rows="6" placeholder="Brief description" class="block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2"><?php if (isset($_GET['lang'])) {
                                                                                                    echo $_GET['desc'];
                                                                                                } ?></textarea>
                        </div>

                        <div class="md:col-span-1 col-span-4">
                            <label htmlFor="lang" class="">
                                Language*
                            </label>
                            <input name="lang" type="text" placeholder="Language Used" value="<?php if (isset($_GET['lang'])) {
                                                                                                    echo $_GET['lang'];
                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>

                        <div class="md:col-span-3 col-span-4">
                            <label htmlFor="genre" class="">
                                Genre*
                            </label>
                            <input name="genre" type="text" placeholder="Fiction, action, true story..." value="<?php if (isset($_GET['genre'])) {
                                                                                                                    echo $_GET['genre'];
                                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>

                        <div class="md:col-span-2 col-span-4">
                            <label htmlFor="Photo" class="">
                                Upload Cover Photo*
                            </label>
                            <input type="file" name="Photo" value="<?php if (isset($_GET['Photo'])) {
                                                                        echo $_GET['Photo'];
                                                                    } ?>" class="block w-full bg-BrownLight border border-BrownDark rounded-md px-3 py-1 text-BrownDark" />
                        </div>

                        <div class="w-full md:col-span-2 col-span-4">
                            <label htmlFor="PG" class="">
                                PG
                            </label>
                            <input name="PG" type="number" placeholder="Age restrictions in number" value="<?php if (isset($_GET['PG'])) {
                                                                                                                echo $_GET['PG'];
                                                                                                            } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                        </div>



                        <div class="col-span-4">
                            <input type="checkbox" name="Agree" class="md:mt-0 mt-2 bg-BrownDark border-BrownDark border text-BrownDark focus:ring-BrownDark checked:bg-BrownDark" />

                            <p class="inline md:text-base text-sm"> This is my original work, and I take full responsibility for any plagiarism. </p>
                        </div>
                        <div class="col-span-4">
                            <?php

                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == "emptyfields") {
                            ?>
                                    <div class="error text-red">Fill in all the required Fields</div>
                                <?php
                                } elseif ($_GET['error'] == "notaggreed") {
                                ?>
                                    <div class="error text-red">You must check the checkbox to proceed</div>
                                <?php
                                } elseif ($_GET['error'] == "notsupported") {
                                ?>
                                    <div class="error text-red">Image not supported</div>
                                <?php
                                } elseif ($_GET['error'] == "failed") {
                                ?>
                                    <div class="error text-red">Posting failed</div>
                                <?php
                                } elseif ($_GET['post'] == "success") {
                                ?>
                                    <div class="error text-red">Posting successfully</div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="my-auto col-span-4 mx-auto md:pb-0 pb-10">
                            <input type="submit" value="Start Writing" name="start" class="px-24 rounded-lg bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                        </div>

                    </form>
                </div>
            </div>

        </div>



        <script>
            const header = document.querySelector('nav');
            header.classList.add('shadow-xl');

            var ann = document.getElementById("pobo");
            pobo.setAttribute("style", "border-bottom-width: 2px;");

            var newTitleElement = document.createElement("title");
            newTitleElement.textContent = "Post Book";
            var headElement = document.getElementsByTagName("head")[0];
            headElement.appendChild(newTitleElement);
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: index.php");
}
?>