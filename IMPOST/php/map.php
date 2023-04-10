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
    <link rel="stylesheet" href="../css/map.css">

    <title>Impost - mapa przesyłek</title>

</head>

<body>
    <?php include('./nav.php'); ?>
    <main>
        <span class="header">Kliknij na mape i sprawdź na mapie miejsca doręczeń twojej przesyłki</span>

        <div class="allcontent">
            <div class="content">
                <img src="../img/wojewodzstwa.png" usemap="#wojewodzstwa">
                <map name="wojewodzstwa" id="map">
                    <area alt="Szczecin" title="Szczecin" coords="13,63 67,50 86,92 43,138 16,158 0,144 16,111 "
                        shape="polygon">
                    <area alt="Koszalin" title="Koszalin" coords="120,26 138,92 95,110 92,122 73,112 86,90 68,50 99,43 "
                        shape="polygon">
                    <area alt="Słupsk" title="Słupsk" coords="180,3 175,59 161,102 135,93 134,63 121,22 143,18 158,7 "
                        shape="polygon">
                    <area alt="Gdańsk" title="Gdańsk"
                        coords="228,21 224,11 181,2 179,65 201,83 226,90 233,49 233,38 215,18 " shape="polygon">
                    <area alt="Elbląg" title="Elbląg" coords="300,34 234,37 226,94 256,103 263,70 297,60 "
                        shape="polygon">
                    <area alt="Olsztyn" title="Olsztyn"
                        coords="356,38 352,99 316,123 299,121 293,111 273,109 255,94 265,89 263,69 298,59 300,33 "
                        shape="polygon">
                    <area alt="Suwałki" title="Suwałki"
                        coords="456,85 448,63 451,49 418,32 357,39 352,100 376,104 412,81 426,94 440,84 "
                        shape="polygon">
                    <area alt="Gorzów Wielkopolski" title="Gorzów Wielkopolski"
                        coords="25,191 16,182 22,168 15,157 75,110 94,125 94,188 72,193 47,182 " shape="polygon">
                    <area alt="Piła" title="Piła" coords="164,149 159,94 133,85 95,99 89,148 109,159 122,150 144,158 "
                        shape="polygon">
                    <area alt="Bydgoszcz" title="Bydgoszcz"
                        coords="173,62 227,89 221,111 198,134 219,160 201,183 176,178 157,137 164,82 " shape="polygon">
                    <area alt="Toruń" title="Toruń" coords="267,137 277,110 227,94 195,134 228,150 249,136 "
                        shape="polygon">
                    <area alt="Ciechanów" title="Ciechanów" coords="305,183 339,175 337,153 313,124 276,109 267,138 "
                        shape="polygon">
                    <area alt="Ostrołęka" title="Ostrołęka"
                        coords="350,190 382,167 375,133 360,104 350,97 316,119 326,142 341,161 337,178 "
                        shape="polygon">
                    <area alt="Łomża" title="Łomża" coords="411,177 424,94 411,79 361,105 385,162 " shape="polygon">
                    <area alt="Białystok" title="Białystok" coords="442,192 476,158 471,120 457,86 425,92 411,181 "
                        shape="polygon">
                    <area alt="Biała Podlaska" title="Biała Podlaska" coords="433,252 463,240 467,206 420,187 405,231 "
                        shape="polygon">
                    <area alt="Siedlce" title="Siedlce"
                        coords="369,248 406,234 419,187 391,160 359,175 351,195 351,226 " shape="polygon">
                    <area alt="Warszawa" title="Warszawa" coords="320,221 350,226 359,205 337,175 316,178 294,189 "
                        shape="polygon">
                    <area alt="Płock" title="Płock" coords="238,215 266,217 305,184 282,150 260,146 255,178 239,193 "
                        shape="polygon">
                    <area alt="Konin" title="Konin" coords="210,232 239,215 238,192 208,177 178,178 173,209 195,218 "
                        shape="polygon">
                    <area alt="Włocławek" title="Włocławek"
                        coords="207,180 228,192 247,193 262,163 258,145 268,145 267,136 247,136 232,150 218,150 "
                        shape="polygon">
                    <area alt="Poznań" title="Poznań"
                        coords="106,212 123,204 148,219 173,207 175,168 163,160 143,165 116,158 109,169 89,159 94,201 "
                        shape="polygon">
                    <area alt="Zielona Góra" title="Zielona Góra"
                        coords="32,260 68,256 99,232 104,212 92,187 74,193 62,183 26,190 18,231 " shape="polygon">
                    <area alt="Jelenia Góra" title="Jelenia Góra"
                        coords="23,302 36,302 37,292 52,295 54,313 86,328 95,298 73,289 69,259 32,260 " shape="polygon">
                    <area alt="Legnica" title="Legnica" coords="114,295 113,255 94,233 69,256 73,292 " shape="polygon">
                    <area alt="Leszno" title="Leszno" coords="104,210 123,205 147,218 157,240 140,253 114,256 94,226 "
                        shape="polygon">
                    <area alt="Kalisz" title="Kalisz" coords="169,207 213,231 206,285 166,282 164,251 150,243 152,217 "
                        shape="polygon">
                    <area alt="Sieradź" title="Sieradź" coords="234,294 255,250 242,218 209,234 206,286 "
                        shape="polygon">
                    <area alt="Łódź" title="Łódź" coords="272,249 280,222 263,214 242,217 251,249 " shape="polygon">
                    <area alt="Skierniewice" title="Skierniewice"
                        coords="304,247 319,246 322,216 296,189 261,211 279,223 272,238 " shape="polygon">
                    <area alt="Radom" title="Radom"
                        coords="378,291 378,256 350,224 320,222 317,244 306,243 306,277 342,290 " shape="polygon">
                    <area alt="Lublin" title="Lublin"
                        coords="407,306 439,293 440,259 407,232 400,243 389,236 368,244 381,258 377,294 "
                        shape="polygon">
                    <area alt="Chełm" title="Chełm" coords="436,254 463,243 486,290 467,305 436,294 442,267 "
                        shape="polygon">
                    <area alt="Zamość" title="Zamość"
                        coords="471,348 492,336 495,316 490,309 499,304 486,289 466,305 436,294 410,301 423,311 424,325 410,340 434,348 460,338 "
                        shape="polygon">
                    <area alt="Tarnobrzeg" title="Tarnobrzeg"
                        coords="345,349 359,341 411,348 420,324 424,308 408,302 391,302 377,290 345,312 341,332 "
                        shape="polygon">
                    <area alt="Kielce" title="Kielce"
                        coords="314,364 343,350 345,311 369,293 309,276 293,277 288,305 277,305 293,322 277,330 285,348 "
                        shape="polygon">
                    <area alt="Piotrków Trybunalski" title="Piotrków Trybunalski"
                        coords="238,285 253,251 273,251 277,237 305,247 307,276 292,281 285,304 258,295 "
                        shape="polygon">
                    <area alt="Częstochowa" title="Częstochowa"
                        coords="203,320 240,337 277,332 293,322 275,302 249,294 251,287 237,284 234,294 204,287 "
                        shape="polygon">
                    <area alt="Opole" title="Opole"
                        coords="179,377 190,371 191,361 207,356 206,338 218,332 203,320 204,283 164,281 154,311 131,339 162,355 173,349 172,360 165,366 "
                        shape="polygon">
                    <area alt="Wrocław" title="Wrocław"
                        coords="113,255 128,257 156,244 166,255 164,293 148,319 120,315 111,284 " shape="polygon">
                    <area alt="Wałbrzych" title="Wałbrzych"
                        coords="93,319 95,296 117,293 125,317 147,320 146,328 130,343 136,356 120,365 94,343 106,330 "
                        shape="polygon">
                    <area alt="Katowice" title="Katowice"
                        coords="187,373 189,360 207,357 206,339 219,327 242,336 277,330 288,337 260,374 250,366 242,385 216,384 "
                        shape="polygon">
                    <area alt="Kraków" title="Kraków"
                        coords="280,396 302,389 315,365 299,351 289,351 278,345 259,370 276,382 " shape="polygon">
                    <area alt="Tarnów" title="Tarnów"
                        coords="344,393 362,385 367,361 343,347 314,365 303,389 325,390 335,394 " shape="polygon">
                    <area alt="Rzeszów" title="Rzeszów"
                        coords="425,345 401,384 383,389 362,383 367,362 345,347 359,339 384,348 " shape="polygon">
                    <area alt="Przemyśl" title="Przemyśl"
                        coords="429,402 471,349 458,337 421,346 398,386 415,401 420,394 " shape="polygon">
                    <area alt="Krosno" title="Krosno"
                        coords="443,444 429,401 395,385 364,385 343,392 361,418 387,420 393,432 " shape="polygon">
                    <area alt="Nowy Sącz" title="Nowy Sącz"
                        coords="274,436 292,439 298,424 324,420 339,428 359,416 344,393 301,390 276,398 262,406 268,421 276,421 "
                        shape="polygon">
                    <area alt="Bielsko-Biała" title="Bielsko-Biała"
                        coords="236,422 246,419 260,405 266,407 281,395 276,379 250,366 239,384 229,380 213,391 "
                        shape="polygon">
                </map>
                <div class="mapinfo whiteborder">
                    <span class="towndesc"></span>
                    <span class="time"></span>
                </div>
            </div>
        </div>

    </main>

    <?php include('./footer.php'); ?>
    <script src="../js/app.js"></script>
    <script src="../js/map.js"></script>

</body>

</html>
