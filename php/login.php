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
    <title>Impost - logowanie</title>
</head>

<body><?php include('./nav.php'); ?>

    <main>
    <div class="video-container">
            <video src="../img/login_video.mp4" muted loop autoplay></video>
        </div>
        <form method="post" autocomplete="off">
            <span class="header">Panel Logowania</span>
            <br>
            <label for="login">Login</label>
            <input type="text" name="login" id="login" required>
            <label for="password">Hasło</label>
            <input type="password" name="password" id="password" required><br><br>
			<?php
			if(!isset($_SESSION['token'])&&(!empty($_POST['login'])))
			{

				echo "<p style='color:var(--secondary__color); font-weight: 600;'>Błędny login lub hasło</p>";
			}
			?>
            <input type="submit"  class="login" name="submit" value="Zaloguj się">
            <div class="log"><a href="register.php<?php if (!empty($_GET['redirect'])) echo "?redirect=".$_GET['redirect']; ?>">Nie masz konta? Zarejestruj się</a></div>
        </form>

    </main>

    <?php include('./footer.php'); ?>

    <script src="../js/app.js"></script>
    <script>
    document.querySelector("#login").focus();
    </script>

</body>
<?php

try{
	$connect = new PDO('mysql:host=localhost;dbname=impost','root','');
}catch(PDOException $e)
{
	die("Błąd aplikacji");
}

if(!empty($_POST['login'])&&!empty($_POST['password']))
{
	$_POST['login'] = strtolower($_POST['login']);

		$query = $connect -> prepare('SELECT password, privileges_level FROM login WHERE login LIKE :login ');

		$query -> bindValue(':login',$_POST['login']);

		$query -> execute();

		$record = $query -> fetch(PDO::FETCH_ASSOC);

		if(password_verify($_POST['password'],$record['password']))
		{
			session_start();
			$_SESSION['username']=$_POST['login'];
            $token = bin2hex(random_bytes(32));
            $_SESSION['token']=$token;
            $_SESSION['time']=time();
            $_SESSION['privileges_level'] = $record['privileges_level'];
            setcookie("session_token", crypt($token, "$5$".$_SESSION['time']."$") , time() + 300, "/");

            $query = $connect -> prepare('UPDATE login SET last_seen = CURRENT_TIMESTAMP() WHERE login LIKE :login');
            $query -> bindValue(':login',$_POST['login']);
            $query -> execute();

            if(!empty($_GET['redirect']))
                header("location: ".$_GET['redirect'].".php");
            else
                header("location: panel.php");
		}
}

?>

</html>
