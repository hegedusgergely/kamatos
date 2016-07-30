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
        <div class="conteiner">
            <div class="row">
                <h1 class="eight columns offset-by-two">Kamat számláló</h1>
                <p class="six columns offset-by-three">Hegedűs Tamás számításai alapján.</p>
            </div>
        </div>
    </header>

    <section class="container">

        <form action="show.php" method="post">
            <div class="row">
                <div class="four columns offset-by-four" id="form">

                    <label for="loan">Tőke</label>
                    <input class="u-full-width" type="number" id="loan" name="loan" value="" placeholder="1 000 000 Ft" required>

                    <label for="duration">Kamat</label>
                    <input class="u-full-width" type="number" name="interest" value="" step="any" placeholder="10 %" required>

                    <label for="month">Futamidő</label>
                    <input class="u-full-width" type="number" name="duration" value="" placeholder="24 hónap" required>

                    <input class="u-full-width button-primary" type="submit" name="submit" value="Számítás">

                </div>
            </div>
        </form>

    </section>

</body>
</html>
