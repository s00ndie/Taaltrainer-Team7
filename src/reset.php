<?php
session_start();
$_SESSION['score1'] = 0;
$_SESSION['Levens'] = 3;
$_SESSION['score'] = 0;
$_SESSION['Levens1'] = 3;
header("Location: index.php");
exit();
?>