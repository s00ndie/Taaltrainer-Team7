<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'taaltrainer';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die('Conection Failed : ' . mysqli_connect_error());
} else{
    'Succes';
}
?>