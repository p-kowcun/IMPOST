<?php include('./session_check.php'); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include('./head.php'); ?>
    <link rel="stylesheet" href="../css/wwu.css">
    <title>Impost</title>
</head>

<body>

    <?php include('./nav.php'); ?>
    <div class="findjob">
    <span class="header">Znajdź pracę dla siebie</span> 
		<form method="POST" class="wwuform">
			<select name="praca" required>
			<option disabled selected hidden>Stanowisko</option>
			<option value="kurier">Kurier</option>
			<option value="magazynier">Magazynier</option>
			<option value="programista">Programista</option>
			<option value="moderator">Zarządca rejonu</option>
			</select>
			<select name="city" required>
						<option value="" disabled selected hidden>Rejon</option>
						<option value="Szczecin">Szczecin</option>
						<option value="Koszalin">Koszalin</option>
						<option value="Słupsk">Słupsk</option>
						<option value="Gdańsk">Gdańsk</option>
						<option value="Elbląg">Elbląg</option>
						<option value="Olsztyn">Olsztyn</option>
						<option value="Suwałki">Suwałki</option>
						<option value="Gorzów Wielkopolski">Gorzów Wielkopolski</option>
						<option value="Piła">Piła</option>
						<option value="Bydgoszcz">Bydgoszcz</option>
						<option value="Toruń">Toruń</option>
						<option value="Ostrołęka">Ostrołęka</option>
						<option value="Łomża">Łomża</option>
						<option value="Białystok">Białystok</option>
						<option value="Włocławek">Włowacławek</option>
						<option value="Ciechanów">Ciechanów</option>
						<option value="Zielona Góra">Zielona Góra</option>
						<option value="Poznań">Poznań</option>
						<option value="Konin">Konin</option>
						<option value="Skierniewice">Skierniewice</option>
						<option value="Płock">Płock</option>
						<option value="Warszawa">Warszawa</option>
						<option value="Siedlce">Siedlce</option>
						<option value="Biała Podlaska">Biała Podlaska</option>
						<option value="Leszno">Leszno</option>
						<option value="Kalisz">Kalisz</option>
						<option value="Sieradz">Sieradz</option>
						<option value="Łódź">Łódź</option>
						<option value="Radom">Radom</option>
						<option value="Lublin">Lublin</option>
						<option value="Chełm">Chełm</option>
						<option value="Jelenia Góra">Jelenia Góra</option>
						<option value="Legnica">Legnica</option>
						<option value="Wrocław">Wrocław</option>
						<option value="Wałbrzych">Wałbrzych</option>
						<option value="Opole">Opole</option>
						<option value="Częstochowa">Częstochowa</option>
						<option value="Piotrków Trybunalski">Piotrków Trybunalski</option>
						<option value="Kielce">Kielce</option>
						<option value="Zamość">Zamość</option>
						<option value="Katowice">Katowice</option>
						<option value="Tarnobrzeg">Tarnobrzeg</option>
						<option value="Rzeszów">Rzeszów</option>
						<option value="Tarnów">Tarnów</option>
						<option value="Bielsko-Biała">Bielsko-Biała</option>
						<option value="Nowy Sącz">Nowy Sącz</option>
						<option value="Krosno">Krosno</option>
						<option value="Przemyśl">Przemyśl</option>
					</select>
			<input type="submit" value="Dowiedz się więcej" name="submit"/>
		</form>
		</div>
    <main>
		<?php include('wwu.php');?>
    </main>

    <?php include('./footer.php'); ?>

    <script src="../js/app.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>