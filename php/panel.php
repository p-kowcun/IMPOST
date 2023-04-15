<?php
session_start();
if (crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") == $_COOKIE['session_token']) {

} else {
    session_destroy();
    header("location: login.php");
}
if(isset($_POST['submit']))
{
    session_destroy();
    header("location: main.php");
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
<?php include('./head.php'); ?>
    <link rel="stylesheet" href="../css/panel.css">
    <title>Impost - panel</title>


</head>

<body><?php include('./nav.php'); ?>

    <main>
            
		<?php

		try{
	$connect = new PDO('mysql:host=localhost;dbname=impost','root','');
}catch(PDOException $e)
{
	die("Błąd aplikacji");
}
$connect->exec("set names utf8");

            if($_SESSION['privileges_level']>1)
                require("./panel_manage_users.php");

			if($_SESSION['privileges_level']==1)
				require("panel_employee.php");

			require("./panel_manage_parcels.php");

		?>
    </main>

    <?php include('./footer.php'); ?>
    <script src="../js/app.js"></script>

</body>

</html>
