<?php
session_start();
if (@crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") == @$_COOKIE['session_token']) {
    header("location: panel.php");
} else {
    session_destroy();

}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
<?php include('./head.php'); ?>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/register.css">

    <title>Impost - rejestracja</title>

</head>

<body><?php include('./nav.php'); ?>
    <main>
    <div class="video-container">
            <video src="../img/login_video.mp4" muted loop autoplay></video>
        </div>
    <form method="post" autocomplete="off">
            <h2>Rejestracja</h2>
            <br>
            <p>Podaj login</p>
            <input type="text" name="login" id="login" required >
            <?php

            if(!isset($_SESSION['token'])&&(!empty($_POST['login'])))
			{

				echo "<p style='color:var(--secondary__color); font-weight: 600;'>Podany login już jest zajęty</p>";
			}
            ?>
            <p>Podaj hasło</p>
            <input type="password" name="password" id="password" required>
                                            <div class="strength-meter">
                                                <div class="bar"></div>
                                            </div>

            <p>Powtórz hasło</p>
			
            <input type="password" name="password2" id="password2" required>
            <p class="warn">Klawisz CapsLock jest wciśnięty</p>
			
			
			<p>Wykonaj obliczenie:</p>
			
			<div id="wysw"></div>
			<input type="number" id="num" required onchange="check_captcha();" placeholder="Wpisz wynik działania">

            <input type="submit" name="submit" value="Zarejestruj" class="login">
            <a href="login.php">Zaloguj się</a>
        </form>

    </main>

    <?php include('./footer.php'); ?>



    <script src="../js/app.js"></script>
    <script src="../js/password_strength.js"></script>
	<script src="../js/captcha.js"></script>



</body>
<?php
try{
	$connect = new PDO('mysql:host=localhost;dbname=impost','root','');
}catch(PDOException $e)
{
	die($e->getMessage());
}

if(!empty($_POST['login'])&&!empty($_POST['password']))
{
	$_POST['login'] = strtolower($_POST['login']);
		
		$check = $connect -> prepare('SELECT login FROM login');
		
		$check -> execute();
		
		$check_rows = $check -> fetchAll(PDO::FETCH_ASSOC);
		
		
		
		$jest = false;
		
		foreach ($check_rows as $row)
		{
			if ($row['login'] == $_POST['login'])
			{
				$jest = true;
			}
		}
		if (!$jest)
		{
			
			$query = $connect -> prepare('INSERT INTO login VALUES (:login, :password, :at, :seen, 0)');
			
			$query -> bindValue(':login', $_POST['login']);
			$query -> bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
			$query -> bindValue(':at', date('Y-m-d H:i:s'));
			$query -> bindValue(':seen', date('Y-m-d H:i:s'));
			$query -> execute();

            if(!empty($_GET['redirect']))
                header("location: login.php?redirect=".$_GET['redirect']);
            else
                header("location: login.php");
		}
		else{

        }
		
 
}

?>

</html>
