<?php include('./session_check.php'); ?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('./head.php'); ?>
    <link rel="stylesheet" href="../css/main.css">
    <title>Impost</title>
</head>

<body>

    <?php include('./nav.php'); ?>

    <div class="find">
        <img src="../img/susbus.png" alt="" class="susbus">
        <div class="findbox">
            <span class="header">Śledź swoją przesyłkę</span>
            <form action="find.php" method="GET" autocomplete="off">
                <input type="text" name="order_id" placeholder="Wpisz numer przesyłki">
                <button type="submit">📦</button>
            </form>
        </div>


    </div>

    <main>

        <div class="oferty">
            <div class="item">
                <b>Punkty doręczeń paczek</b><br><br>
                <p>Sprawdź punkty na mapie <br>do których możesz wysłać <br> swoją przesyłkę</p>
                <br>
                <a href="map.php"><button>Sprawdź</button></a>
            </div>
            <div class="item">
                <b>Bezpieczeństwo</b><br><br>
                <p>Bezpieczeństwo <br> na pierwszym miejscu, <br> chroń swoje dane</p>
                <br>
                <a href="safety.php"><button>Sprawdź</button></a>
            </div>
            <div class="item">
                <b>Pracuj z nami</b><br><br>
                <p>Dołącz do naszego zespołu<br>i pracuj z najlepszymi<br> #IMPOSTTEAM</p>
                <br>
                <a href="work_with_us.php"><button>Sprawdź</button></a>
            </div>
        </div>
        <div class="content">
            <div class="box">
                <div class="boxborder"><img src="../img/impost.png" alt="asd" class="boximpostor"></div>
            </div>
            <div class="slider">
                <div class="title">
                    <span class="boxspace"></span>
                    <span class="boxpercentage"></span>
                </div>
                <span class="header">Przesuń suwak i zobacz,
                        jakie znaczenie ma to,
                        jak pakujesz!</span>
            </div>
            
        </div>
        <input type="range" min="140" max="240" value="140" class="sliderange">


    </main>

    <?php include('./footer.php'); ?>

    <script src="../js/app.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>
