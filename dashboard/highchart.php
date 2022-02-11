<?php
require 'script.php';
// Crée une page avec l'ensemble des données qui seront récupérées par le json

while($row3 = mysqli_fetch_array($result3)) {
    $value = $row3['wallet'];
    $timestamp = strtotime($row3['date']) * 1000;
    $data[] = [$timestamp, (int)$value];
}
echo json_encode($data);
?>
