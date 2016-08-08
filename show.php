<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rakkas&subset=latin-ext" rel="stylesheet">
    <title>Kamat Számláló</title>
</head>
<body>

    <header>
        <a class="two columns" href="/kamatos">Vissza</a>
        <div class="container">
            <div class="row">
                <h3 class="four columns offset-by-four">Kamat számláló</h3>
            </div>
        </div>
    </header>

        <?php
            include "Credit.php";

            $loan = $_POST["loan"];

            $duration = $_POST["duration"];

            $interest = $_POST["interest"];

            $credit = new Credit($loan, $duration, $interest);
        ?>

</body>
</html>
