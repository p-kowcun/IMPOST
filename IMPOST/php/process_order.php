<?php
session_start();
if (@crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") != @$_COOKIE['session_token']) {
    session_destroy();
    header("location: ./order.php");
}

else{

    if($_POST['from'] == '' || $_POST['to'] == '')
    {
        die('Brak wymaganych danych!');
    }

try{
	$connect = new PDO('mysql:host=localhost;dbname=impost','root','');
}catch(PDOException $e)
{
	die($e->getMessage());
}

//function navigate($s,$f){
// return array($s,'Warszawa',$f);
//}

require('./navigation.php');

$code = time();

    for($i = strlen($code); $i<24; $i++)
        $code .= rand(0, 9);

    $connect->exec("set names utf8");
    $query_get = $connect -> prepare('SELECT stops, id FROM routes WHERE city_start LIKE :from AND city_end LIKE :to');
    $query_get -> bindValue(':from',$_POST['from']);
    $query_get -> bindValue(':to',$_POST['to']);
    $query_get -> execute();





    $data = $query_get -> fetch(PDO::FETCH_ASSOC);
    @$stops = $data['stops'];

$stop_id = null;

    if($stops < 2)
    {

$stop_id = time();

        $route = navigate($_POST['from'],$_POST['to']);

        $query = $connect -> prepare('INSERT INTO routes VALUES (:id, :stops, :start, :end, NULL)');
        $query -> bindValue(':id',$stop_id);
        $query -> bindValue(':stops',sizeof($route));
        $query -> bindValue(':start',$_POST['from']);
        $query -> bindValue(':end',$_POST['to']);
        $query -> execute();

        $query = $connect -> prepare('INSERT INTO route_stops (id) VALUES (:id)');
        $query -> bindValue(':id',$stop_id);
        $query -> execute();


        foreach($route as $k => $s) {
    $columnName = "stop_" . ($k+1);
    $query = $connect->prepare("UPDATE route_stops SET $columnName = :name WHERE id = :id");
    $query->bindValue(':id', $stop_id);
    $query->bindValue(':name', $s);
    $query->execute();
}
    }
    else
    {
        $stop_id = $data['id'];
    }

        $query_add = $connect -> prepare('INSERT INTO parcels VALUES (NULL, :code, CURRENT_TIMESTAMP(), NULL, 1, :stop, :login) ');
		$query_add -> bindValue(':code',$code);
        $query_add -> bindValue(':stop',$stop_id);
        $query_add -> bindValue(':login',$_SESSION['username']);
		$query_add -> execute();

        $query_add = $connect -> prepare('INSERT INTO parcel_history VALUES (NULL, :code, CURRENT_TIMESTAMP(), :city) ');
		$query_add -> bindValue(':code',$code);
        $query_add -> bindValue(':city',$_POST['from']);
		$query_add -> execute();

        echo 'Zamówienie przebiegło pomyślnie. Twój numer przesyłki: <strong>'.$code.'</strong><br>Możesz zamknąć okno przeglądarki.<br><a href="./main.php">Wróć na stronę główną</a> <a href="./find.php?order_id='.$code.'">Kliknij tutaj aby śledzić paczkę</a>';
}

?>
