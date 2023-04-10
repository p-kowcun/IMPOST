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
    <link rel="stylesheet" href="../css/safety.css">

    <title>Impost - mapa przesyłek</title>

</head>

<body>
    <?php include('./nav.php'); ?>
    <main>
        <span class="header">Ogólne zasady bezpieczeństwa</span>
        <div class="safetycontent">
            <div class="item">
                <div class="heading">
                    <span class="item-icon">🔒</span>
                    <span class="itemheader">Co więcej haseł, to nie jedno</span>
                </div>
                <div class="content">
                    <p>Nie używaj tych samych haseł do poczty oraz innych serwisów. Używanie jednego hasła może
                        spowodować, że przestępcy, którzy przejmą je z pierwszej strony, będą próbowali go użyć do
                        zalogowania się na inne serwisy.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">📧</span>
                    <span class="itemheader">Wysyłaj z głową</span>
                </div>
                <div class="content">
                    <p>Wysyłając pliki w postaci załącznika staraj się (w zależności od stopnia ich prywatności)
                        zabezpieczyć je hasłem. Hasło wyślij w osobnej wiadomości lub SMS-em.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">🔓︎</span>
                    <span class="itemheader">Zawsze blokuj telefon i komputer</span>
                </div>
                <div class="content">
                    <p>Pamiętaj, że odblokowane urządzenie to łatwy kąsek dla cyberprzestępców. Jeśli możesz, to
                        zaszyfruj komputer i telefon specjalnym programem. To dodatkowe zabezpieczenie Twoich urządzeń.
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">⚠️</span>
                    <span class="itemheader">Zastanów się dwa razy przed otwarciem załącznika</span>
                </div>
                <div class="content">
                    <p>W załącznikach, które wysyłają cyberprzestępcy, znajdują się wirusy i inne programy, które mogą
                        zainfekować twój sprzęt.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">🔒</span>
                    <span class="itemheader">Prywatność na wysokim poziomie</span>
                </div>
                <div class="content">
                    <p>Z pewnością podniesiesz swój poziom bezpieczeństwa, jeśli zmienisz ustawienia prywatności swojej
                        przeglądarki internetowej na bardziej „agresywne”.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">❗</span>
                    <span class="itemheader">Instaluj aplikacje mobilne tylko z oficjalnych sklepów</span>
                </div>
                <div class="content">
                    <p>Cyberprzestępcy zachęcają do pobierania nieautoryzowanych aplikacji, żeby wykradać dane, zdjęcia
                        i pieniądze.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">🦠</span>
                    <span class="itemheader">Antywirus to konieczność</span>
                </div>
                <div class="content">
                    <p>Taki program zabezpieczy Twoje urządzenie przed wirusami.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">⚠️</span>
                    <span class="itemheader">Zawsze sprawdzaj, gdzie wpisujesz swoje hasło</span>
                </div>
                <div class="content">
                    <p>cyberprzestępcy tworzą fałszywe strony WWW, aby wykraść Twoje hasła.</p>
                </div>
            </div>
            <div class="item">
                <div class="heading">
                    <span class="item-icon">💾</span>
                    <span class="itemheader">Pamiętaj o backupach</span>
                </div>
                <div class="content">
                    <p>Kopie zapasowe przydają się najbardziej, kiedy niespodziewanie stracisz swoje dane. W tym celu,
                        skorzystaj z płatnych serwisów lub dokonaj zakupu np. dysku przenośnego. Przed wysyłką kopii
                        swoich danych do chmury, zabezpiecz je hasłem.</p>
                </div>
            </div>
        </div>
        <span class="header2">Cyberprzestępczość</span>
        <span class="cyberinfo">To ogół zagadnień, które dotyczą przestępstw popełnianych w Internecie.</span>
        <div class="cybercrime">
            <div class="phishing">
                <span class="header">Phishing</span>
                <div class="content">To jedna z najczęstszych i najbardziej popularnych metod oszustwa, którą
                    wykorzystują cyberprzestępcy. Popularny phishing polega na tym, że przestępca podszywa się pod
                    konkretną instytucję lub osobę w celu wyłudzenia cennych i poufnych informacji. Mogą to być np.
                    hasła, loginy, dane osobowe czy dane bankowe.

                    Jedną z form phishingu jest tzw. SMS phishing (smishing), który polega na wysyłaniu wiadomości SMS,
                    mających skłonić użytkownika urządzenia do podjęcia konkretnej akcji lub działania. Wiadomości
                    phishingowe zawsze zawierają link do fałszywej strony, na której nieświadomy niczego użytkownik
                    przekazuje przestępcom swój login i hasło. </div>
            </div>
            <div class="spoofing">
                <span class="header">Spoofing</span>
                <div class="content">Metoda internetowego oszustwa, której działanie opiera się na podszywaniu
                    pod konkretny podmiot (element oprogramowania czy innego użytkownika Internetu) w celu wyłudzenia
                    wrażliwych danych, takich jak np. dostępy do rachunków bankowych. Wyróżniamy kilka rodzajów
                    spoofingu: spoofing adresu IP, spoofing wiadomości email, spoofing SMS oraz spoofing informacji
                    dzwoniącego.

                    Spoofing to operacja relatywnie tania i do wykonania przez każdego z podstawową wiedzą
                    informatyczną. Własna bramka SMS, fałszywa domena czy wykorzystanie technologii, dają przestępcom
                    wręcz nieskończone możliwości działania i wyłudzania środków finansowych.</div>
            </div>
        </div>
        <div class="tips">
            <div class="item">
                <div class="itemH">Przydatne!</div>
                <div class="content">Ataki phishing bazują na emocjach. Wykorzystanie znanych socjotechnik sprawia, że
                    przed takimi przestępstwami bardzo trudno się bronić. Uważaj na maile, smsy lub połączenia
                    telefoniczne, które próbują wzbudzić w Tobie poczucie pilności tematu, strach bądź radość.</div>
                <div class="advices">
                    ⚠️Nigdy nie klikaj w podejrzane linki. Uważaj zwłaszcza na te skrócone (typu bit.ly) – najedź myszką
                    w
                    link, żeby sprawdzić rzeczywisty adres strony internetowej. <br>
                    ⚠️Nie otwieraj i nie odpowiadaj na podejrzane wiadomości SMS. Takie działania tylko prowokują
                    przestępców do wzmożonych ataków. Pamiętaj, że numer zawsze możesz sprawdzić w wyszukiwarce. <br>
                    ⚠️Pod żadnym pozorem nie ujawniaj swoich prywatnych danych. Stosuj zasadę ograniczonego zaufania w
                    sieci. Nie ufaj nawet poważnym instytucjom, jeśli proszą o aktualizację danych.
                </div>
            </div>
            <div class="item">
                <div class="itemH">Przydatne!</div>
                <div class="content">Na stronie <a href="haveibeenpwned.com">haveibeenpwned.com</a> możesz – podając
                    adres email sprawdzić, czy Twoje dane nie wyciekły z innych serwisów i nie są w posiadaniu hackerów.
                    Korzystanie ze strony jest bezpieczne gdy tylko robimy to z głową. Cyberprzestępcy zachęcają do pobierania nieautoryzowanych aplikacji, żeby wykradać dane, zdjęcia
                        i pieniądze.</div>
                <div class="advices">
                    ⚠️Zachowaj ostrożność podczas surfowania po Internecie. Używaj aktualnej przeglądarki, regularnie
                    czyść historię i sprawdzaj linki, w które klikasz. <br>
                    ⚠️Nie odpowiadaj na maile, w których nadawca prosi o podanie prywatnych danych, takich jak np.: adres
                    zamieszkania, numer PESEL czy numer rachunku bankowego. <br>
                    ⚠️Sprawdzaj adresy email i strony www. Jeśli masz wątpliwości, skontaktuj się bezpośrednio z
                    instytucją, od której dostałeś tę informację i poproś o zweryfikowanie wiadomości.
                </div>
            </div>


    </main>

    <?php include('./footer.php'); ?>
    <script src="../js/app.js"></script>
    <script src="../js/map.js"></script>

</body>

</html>