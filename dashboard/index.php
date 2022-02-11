<?php require 'script.php'; ?>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="highcharts.js"> </script>
<link rel="stylesheet" href="style.css">

<div class="main"> 
  <h1>Tableau de bord</h1>
  <h2><?php echo $todayPrice. " $"; ?> </h2>
  <div style="display:flex;justify-content:space-evenly;margin-top:50px;" >
    <div class="section"><b>Daily :</b> <?php if($evoDay > 0) {echo '<span class="HighlightGreen"> '. $evoDay.' %</span>';} else {echo '<span class="HighlightRed"> '. $evoDay.' %</span>';} ?></div>
    <div class="section"><b>Weekly :</b> <?php if($evoWeek > 0) {echo '<span class="HighlightGreen"> '.$evoWeek.'</span>';} else {echo '<span class="HighlightRed"> '.$evoWeek.'</span>';} ?></div>
    <div class="section"><b>Monthly :</b> <?php if($evoMonth > 0) {echo '<span class="HighlightGreen"> '.$evoMonth.'</span>';} else {echo '<span class="HighlightRed"> '.$evoMonth.'</span>';} ?></div>
  </div>
  <div class="graph">
    <h2>Graphique</h2>
<div id="container"></div>


  </div>
  <div class="orderBook">
    <h2>Carnet d'ordres</h2>
    <table>
    <tr><td>TYPE</td><td>QUANTITÉ</td><td>SYMBOL</td><td>PRIX</td></tr>
    <?php
      if ($result->num_rows > 0) {
      // output data of each row
        while($row = $result->fetch_assoc()) {
          if($row["type"] == 1) {$order='<span class="HighlightRed">Vente</span>';} else {$order='<span class="HighlightGreen">Achat</span>';}
          echo "<tr><td>" . $order. "</td><td>" . $row["amount"] . "</td><td>" . $row["symbol"] . "</td><td>" . $row["price"] . "</td></tr>";
        }
      } else {
        echo "</table>Aucun historique pour le moment";
      }
    ?>
    </table>
  </div>
</div>

<?php
$conn->close();
?>
