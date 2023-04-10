<?php if(empty($_POST)) header("location: main.php"); ?>
<?php
include('./navigation.php');
echo sizeof(navigate($_POST['from'], $_POST['to']));
?>
