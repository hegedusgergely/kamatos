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

    <header>
        <div class="row">
            <h1 class="six columns offset-by-three">Kamat számláló</h1>
            <h3 class="six columns offset-by-three">Hegedűs Tamás</h3>
        </div>
    </header>

    <section class="container">

        <form action="show.php" method="post">
            <div class="row">
                <div class="four columns offset-by-four">

                    <label for="loan">Tőke</label>
                    <input class="u-full-width" type="number" name="loan" value="" placeholder="1 000 000 Ft">

                    <label for="duration">Kamat</label>
                    <input class="u-full-width" type="number" name="interest" value="" step="any" placeholder="10 %">

                    <label for="month">Futamidő</label>
                    <input class="u-full-width" type="number" name="duration" value="" placeholder="24 hónap">

                    <input class="u-full-width" type="submit" name="submit" value="Számítás!">

                </div>
            </div>
        </form>

    </section>

</body>
</html>
