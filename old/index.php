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

        <form action="show.php" method="post">
            <div class="row">
                <div id="form" class="four columns offset-by-four">

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
