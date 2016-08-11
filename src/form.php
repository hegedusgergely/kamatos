<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rakkas&subset=latin-ext" rel="stylesheet">
    <title>Kamat Számláló</title>
</head>
<body>

    <header>
        <div class="conteiner">
            <div class="row">
                <h1 class="eight columns offset-by-two">Kamat számláló</h1>
                <p class="six columns offset-by-three">Hegedűs Tamás számításai alapján.</p>
            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <form class="four columns offset-by-four" action="src/show.php" method="post" onsubmit="return validateForm()">

                <label for="loan">Tőke</label>
                <input class="u-full-width" type="number" id="loan" name="loan" value="" placeholder="1 000 000 Ft">

                <label for="interest">Kamat</label>
                <input class="u-full-width" type="number" id="interest" name="interest" value="" step="any" placeholder="10 %">

                <label for="duration">Futamidő</label>
                <input class="u-full-width" type="number" id="duration" name="duration" value="" placeholder="24 hónap">

                <input class="u-full-width button-primary" type="submit" name="submit" value="Számítás">

            </form>
        </div>
    </section>

</body>
</html>
