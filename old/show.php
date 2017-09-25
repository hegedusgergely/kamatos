<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <!-- <script src="js/script.js" charset="utf-8"></script> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700|Noto+Serif:400,700&subset=latin-ext">
    <title>Kamat Számláló</title>
</head>
<body>

    <nav>
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="/old">Kezdőlap</a></li>
                    <li><a href="#">Nyomtatás</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="conteiner">
            <div class="row">
                <div id='headertext' class="four columns offset-by-four">
                    <h1 id="h1no1">Kamat számláló</h1>
                    <h1 id="h1no2">Kamat számítás</h1>
                    <p>Hegedűs Tamás számításai alapján</p>
                </div>
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
