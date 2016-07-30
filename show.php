<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/skeleton.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="js/script.js" charset="utf-8"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rakkas&subset=latin-ext" rel="stylesheet">
    <title>Kamat Számláló</title>
</head>
<body>

    <header>
        <a class="two columns" href="/">Vissza</a>
        <div class="container">
            <div class="row">
                <h3 class="four columns offset-by-four">Kamat számláló</h3>
            </div>
        </div>
    </header>

    <section class="container">
        <?php
            include_once "Credit.php";

                $credit = new Credit;

                $credit->setLoan($_POST["loan"]);

                $credit->setDurationInMonth($_POST["duration"]);

                $credit->setInterestRate($_POST["interest"]);

                $credit->setInterestRateForAMonth(1);

                $credit->setReedemForAMonth(1);

                $credit->setLoanCounter(1);

                $credit->setInterestRateCounter(1);

                $credit->setSumInterestRate(1);

                $credit->__toString();
            ?>
    </section>

</body>
</html>
