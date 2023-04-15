<?php
session_start();
if (@crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") != @$_COOKIE['session_token']) {
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../img/auto.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles_r.css">
    <link rel="stylesheet" href="../css/opinions.css">

    <title>Impost - Wystaw opinię</title>

</head>

<body>
    <?php include('./nav.php'); ?>
    <main>
        <?php
            if(!empty($_SESSION['token']))
            {
                echo "<span class='header'>Wystaw Opinię</span>
                <p>Twoja opinia jest dla nas bardzo ważna i na pewno jej nie wrzucimy do spamu</p>
                <form method='post' autocomplete='off'>
                <textarea name='opinion' cols='65' rows='9' required></textarea><br>
                <button type='submit' class='login__btn' name='submitopinion'>Wyslij</button>
                </form>";
                script();
            }
            else
            {
                echo "<h2>Aby wystawic opinię należy się zalogować</h2>";
                echo "<a href='login.php?redirect=opinions' class='login__btn'>Zaloguj się</a>";
            }
        
        ?>
        
        
    </main>

    <?php include('./footer.php'); ?>
    <script src="../js/app.js"></script>

</body>
<?php
function script()
{
    if(!empty($_SESSION['token'])&&isset($_POST['submitopinion'])&&isset($_POST['opinion'])&&$_POST['opinion']!="")
    {
        $file="../opinie.txt";
        if(file_exists($file))
        {
            $myfile = fopen($file, "a");
            $txt = "Użytkownik ".$_SESSION['username']." z dnia ".date("Y-m-d")." o godzinie ".date('H:i:s')." przesłał opinie o treści:"."\n".$_POST['opinion']."\n";
            fwrite($myfile, $txt);
            fclose($myfile);
            echo ("<span class='header'>Dziękujemy za wystawienie opini</span>");
        }
        else
        {
            echo ("<span class='header'>Nie udało się wystawić opini :(</span>");
        }
            
    }
}

?>


</html>
