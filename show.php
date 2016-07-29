<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/skeleton.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <title>Kamatos</title>
</head>
<body>


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
