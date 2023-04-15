<?php if(empty($_POST)) header("location: main.php"); ?>
<?php
if (isset($_POST['m_u_panel_select'])) {

    $db = new PDO('mysql:host=localhost;dbname=impost;charset=utf8', 'root', '');
    $select = $_POST['m_u_panel_select'];
    $q = $db->prepare("SELECT login, registered_at, last_seen FROM login WHERE privileges_level=:privileges_level");
    $q->bindValue(':privileges_level', $select);
    $q->execute();

    echo "<div>";
    while ($linia = $q->fetch(PDO::FETCH_ASSOC)) {
        echo "<table><tr><th>Nazwa użytkownika:</th><td> " . $linia['login'] . "</td></tr><tr><th> Zarejestrowany:</th><td> " . $linia['registered_at'] . "</td></tr><tr><th> Ostatnio zalogowany:</th><td> " . $linia['last_seen'] . "</td></tr></table>";
    }
    echo "</div>";
}


?>