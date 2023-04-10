<?php
session_start();
if (@crypt($_SESSION['token'], "$5$".$_SESSION['time']."$") != @$_COOKIE['session_token']) {
    session_destroy();
}
?>
