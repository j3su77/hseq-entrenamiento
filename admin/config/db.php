
<?php
$host = "localhost";
$db = "hseq_entrenamiento";
$user = "root";
$password = "";

try {
  $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $password);

} catch (Exception $ex) {
  echo $ex->getMessage();
}
?>