<?php
// DEBUT DE LA ZONE DE CONFIG


$servername = ""; // IP DE VOTRE BASE DE DONNÉE (peut être localhost, si vous hébergé sur votre serveur)
$username = ""; // Par défaut, root sur wamp
$password = ""; // Par défaut, vide sur wamp
$dbname = ""; //Nom de la base de donnée
$nb_bot = 2; // Nombre de bot dont vous voulez suivre l'évolution. Evidemment, il faut qu'ils aient chacun leur DB et le morceaux de code python qui permet d'ajouter les infos dans la DB
$bot_name = array("", "Bot 1", "Bot 2"); // IMPORTANT DE LAISSER LE PREMIER ESPACE LIBRE !!!  REMPLIR AVEC LES NOMS QUE VOUS VOULEZ


// FIN DE LA ZONE DE CONFIG
// Ne pas toucher en dessous sauf si vous savez ce que vous faites


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


//Fonction pour afficher l'order book
function affiche_orderBook($x, $conn) {
  $db = 'orderBook'.$x;
  $sql = "SELECT * FROM $db ORDER BY id DESC LIMIT 10";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
        while($row = $result->fetch_assoc()) {
          if($row["type"] == 1) {$order='<span class="HighlightRed">Vente</span>';} else {$order='<span class="HighlightGreen">Achat</span>';}
          echo "<tr><td>" . $order. "</td><td>" . $row["amount"] . "</td><td>" . $row["symbol"] . "</td><td>" . $row["price"] . "</td></tr>";
        }
      } else {
        echo "</table>Aucun historique pour le moment";
      }
}


// Fonction qui affiche l'évolution du wallet
function affiche_historical_wallet($x, $conn) {

  $db = 'bot'.$x;
  $sql2 = "(SELECT * FROM $db
    ORDER BY id DESC LIMIT 2)
  UNION (SELECT  *  FROM $db
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

  if (isset($weekPrice)) {$evoWeek = (($todayPrice - $weekPrice) * 100) / $weekPrice;$evoWeek = number_format($evoWeek,2);}
    else {$evoWeek = 'Manque de données';}

  if (isset($monthPrice)) {$evoMonth = (($todayPrice - $monthPrice) * 100) / $monthPrice;$evoMonth = number_format($evoMonth,2);}
    else {$evoMonth = 'Manque de données';}

  echo'
   <h2>Valeur du wallet : <span style="color:#42a37a;">'.$todayPrice.' $</span></h2>
    <div style="display:flex;justify-content:space-evenly;margin-top:50px;" >
      <div class="section"><b>Daily :</b> ';
      if($evoDay > 0) {echo '<span class="HighlightGreen"> '. $evoDay.' %</span></div>';} else {echo '<span class="HighlightRed"> '. $evoDay.' %</span></div>';}
      if($evoWeek > 0) {echo '<div class="section"><b>Weekly :</b><span class="HighlightGreen"> '.$evoWeek.'</span></div>';} else {echo '<div class="section"><b>Weekly :</b><span class="HighlightRed"> '.$evoWeek.'</span></div>';}
      if ($evoMonth > 0) {echo '<div class="section"><b>Monthly :</b><span class="HighlightGreen"> '.$evoMonth.'</span>/div>/div>';} else {echo '<div class="section"><b>Monthly :</b><span class="HighlightRed"> '.$evoMonth.'</span></div></div>';}
}


// Fonction qui affiche le menu des onglets en haut de la page
function affiche_menu_onglet($nb_bot, $bot_name)
  {
    $x=1;
    while($nb_bot >= $x) {
          echo '<span class="onglet_0 onglet" id="onglet_bot'. $x .'" onclick="javascript:change_onglet(\'bot'. $x .'\');">';
          if (isset($bot_name[$x])) { echo $bot_name[$x].'</span>';} else { echo 'Bot '. $x .'</span>';}
          $x++;
        }
  }

// Fonction qui affiche la partie supérieur du dashboard
function affiche_contenu_onglet_top($nb_bot, $conn, $bot_name)
  {
    $x=1;
    while($nb_bot >= $x) {
      echo '<div class="contenu_onglet" id="contenu_onglet_top_bot'.$x.'">';
      affiche_historical_wallet($x, $conn);
      echo '</div>';
      $x++;
    }
  }

// Fonction pour afficher la div contenant l'order book
function affiche_contenu_onglet_bot($nb_bot, $conn)
  {
    $x=1;
    while($nb_bot >= $x) {
      
      echo '<div class="orderBook contenu_onglet" id="contenu_onglet_bottom_bot'.$x.'">
        <h2>Carnet d\'ordres</h2>
        <table>
          <tr><td>TYPE</td><td>QUANTITÉ</td><td>SYMBOL</td><td>PRIX</td></tr>';
          affiche_orderBook($x, $conn);
        echo '</table>
      </div>';
      $x++;
    }
  }

// Fonction qui récupère les data utile au graph
function data_graph($nb_bot, $conn)
  {
    $x=1;
    while($nb_bot >= $x) {
      $db = 'bot'.$x;
      $sql3 = "SELECT * FROM $db ORDER BY id";
      $result3 = $conn->query($sql3);

      while($row3 = mysqli_fetch_array($result3)) {
          $value = $row3['wallet'];
          $timestamp = strtotime($row3['date']) * 1000;
          $data[] = [$timestamp, (int)$value];
      }
      if ($x >1) {echo ',{';} else {echo '{';}
      echo 'name :\'Bot'.$x.'\',data:';
      echo json_encode($data);
      echo '}';
      unset($data);
      $x++;

    }
  }

?>

