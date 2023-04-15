<?php
session_start();
if (@crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") != @$_COOKIE['session_token']) {
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <?php include('./head.php'); ?>
    <link rel="stylesheet" href="../css/find.css">

    <title>Impost - Śledź paczkę</title>

</head>

<body>



    <?php include('./nav.php'); ?>
    <main>

        <span class="header">Śledź paczkę</span>
        <div class="findbox">
            <span class="header">Śledź swoją przesyłkę</span>
            <form action="find.php" method="GET" autocomplete="off">
                <input type="text" name="order_id" id="order_id" value="<?php echo $_GET['order_id']?>" placeholder="Wpisz numer przesyłki">
                <button type="submit">📦</button>
            </form>
        </div>
        </form>
        <script type="text/javascript">
            function move(current_stop = 0, max_stops = 1) {
                let truck = document.querySelector(".progress_bar .truck");
                let percentage = (current_stop / max_stops) * 100;
                let position = percentage * 2.8;
                setTimeout(() => {
                    truck.style.marginLeft = position + "px";
                }, 500);
            }
        </script>
        
        <?php
    $dsn = "mysql:host=localhost;dbname=impost;charset=utf8mb4";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    if(isset($_GET['order_id']) && !empty($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        $sql1 = "SELECT parcel_code, action_time, description FROM parcel_history WHERE parcel_code = ?";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$order_id]);
        $parcel_history = $stmt1->fetchAll();

        $sql2 = "SELECT current_stop, stops FROM parcels JOIN routes ON parcels.route = routes.id WHERE code = ?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$order_id]);
        $parcel_info = $stmt2->fetch();

        if(!empty($parcel_history)) {
?>

<div class="progress">
    <div class="progress_bar">
        <div class="truck" id="divtruck"><img class="truck" src="../img/truck.png" alt="truck"></div>
        <img class="road" src="../img/road.png" alt="road">
    </div>
</div>

<script>
    setInterval(move(<?php echo $parcel_info['current_stop']-1; ?>, <?php echo $parcel_info['stops']-1; ?>), 1000);
</script>
<div class="parcel">
<?php
            foreach($parcel_history as $x => $history) {
?>

    <div class="parcelstatus">
        <div class="timeinfo"><?php echo $history['action_time']; ?></div>
        <div class="parcelinfo"><?php


        if ($x == 0){
         echo "Twoja paczka została nadana! Rozpoczęła podróż w mieście: ";
        }
        else if ($x == $parcel_info['stops']-1){
        echo "Twoja paczka dotarła już do celu! Została odebrana w mieście: ";
        }
        else{
            echo "Twoja paczka aktualnie podróżuje między oddziałami firmy Impost.  Aktualnie znajduje się w mieście: ";
        }


        echo $history['description']; ?></div>

</div>
<?php
            }
        }
    }
?></div>
    </main>

    <?php include('./footer.php'); ?>
<script>
const x = document.querySelector("#order_id");
if(!x.value)
    x.focus();
    </script>

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

			$query = $connect -> prepare('INSERT INTO login VALUES (:login, :password, :at, :seen)');

			$query -> bindValue(':login', $_POST['login']);
			$query -> bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
			$query -> bindValue(':at', date('Y-m-d'));
			$query -> bindValue(':seen', date('Y-m-d H:i:s'));
			$query -> execute();

            session_start();
			$_SESSION['username']=$_POST['login'];
            $token = bin2hex(random_bytes(32));
            $_SESSION['token']=$token;
            $_SESSION['time']=time();
            setcookie("session_token", crypt($token, "$5$".$_SESSION['time']."$") , time() + 300, "/");

			header("location: panel.php");
		}


}
?>



</html>
