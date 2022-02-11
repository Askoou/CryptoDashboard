<?php
$servername = "";
$username = ""; 
$password = ""; 
$dbname = "cryptobot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//ORDER BOOK
$sql = "SELECT * FROM orderBook ORDER BY id LIMIT 10";
$result = $conn->query($sql);

// GRAPHIQUE
$sql3 = "SELECT * FROM afg20 ORDER BY id";
$result3 = $conn->query($sql3);


// HISTORICAL WALLET
$sql2 = "(SELECT * FROM afg20
  ORDER BY id DESC LIMIT 2)
UNION (SELECT  *  FROM afg20
    WHERE  DATE(date) = DATE(DATE_SUB(NOW(), INTERVAL 1 MONTH))
        OR DATE(date) = DATE(DATE_SUB(NOW(), INTERVAL 1 WEEK)))";
$result2 = $conn->query($sql2);
$i=0;
while($rowPrice = $result2->fetch_assoc()) {
          $i++;
          if ($i == 1) {$todayPrice = $rowPrice['wallet'];}
          else if ($i == 2) {$yestPrice = $rowPrice['wallet'];}
          else if ($i == 3) {$weekPrice = $rowPrice['wallet'];}
          else if ($i == 4) {$monthPrice = $rowPrice['wallet'];}
        }

// Calcul des % d'evo
if (isset($yestPrice)) { $evoDay = (($todayPrice - $yestPrice) * 100) / $yestPrice; $evoDay = number_format($evoDay,2);}
else {$evoDay = 'Manque de données';}

if (isset($monthPrice)) {$evoWeek = (($todayPrice - $weekPrice) * 100) / $weekPrice;$evoWeek = number_format($evoWeek,2);}
  else {$evoWeek = 'Manque de données';}

if (isset($monthPrice)) {$evoMonth = (($todayPrice - $monthPrice) * 100) / $monthPrice;$evoMonth = number_format($evoMonth,2);}
  else {$evoMonth = 'Manque de données';}


?>
