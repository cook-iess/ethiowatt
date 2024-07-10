<?php

session_start();

if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == 'Admin321' && isset($_COOKIE['UserName'])) {

?>


    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin home page</title>
        <link href="output.css" rel="stylesheet">
    </head>

    <body class="bg-BrownLight w-full h-screen text-BrownDark font-TextFont flex justify-center items-center">
        <div class="flex justify-center items-center">
            <a href="bookman.php">
                <div class="border border-BrownDark rounded-3xl mx-10 py-4">
                    <img src="img/bookman.png" alt="book man" class="mx-auto" style="width: 90%">
                    <p class="text-center font-bold text-3xl font-TextFont">Manage Books</p>
                </div>
            </a>
            <a href="annman.php">
                <div class="border border-BrownDark rounded-3xl mx-10 pb-14 mb-3 py-4">
                    <img src="img/annman.png" alt="ann icon" class="">
                    <p class="text-center font-bold text-3xl font-TextFont">Manage Announcemets</p>
                </div>
            </a>
            <a href="logout.php">
                <div class="border border-BrownDark rounded-3xl mx-10 py-4">
                    <img src="img/logout.png" alt="logout icon" class="mx-auto py-10" style="width: 70%;">
                    <p class="text-center font-bold text-3xl font-TextFont">Logout</p>
                </div>
            </a>
        </div>
        <div class="absolute top-0 flex justify-start mt-4">
            <img src="img/logo.png" class="w-14 h-10 my-auto" />
            <h1 class="font-extrabold font-TitleFont text-2xl my-auto text-BrownDark">
                Ethio Wattpad
            </h1>
        </div>
    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>