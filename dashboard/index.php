<?php require 'script.php'; ?>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>

<link rel="stylesheet" href="style.css">

<script type="text/javascript">
function change_onglet(name) {
  document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
  document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
  document.getElementById('contenu_onglet_top_'+anc_onglet).style.display = 'none';
  document.getElementById('contenu_onglet_bottom_'+anc_onglet).style.display = 'none';
  document.getElementById('contenu_onglet_top_'+name).style.display = 'block';
  document.getElementById('contenu_onglet_bottom_'+name).style.display = 'block';
  anc_onglet = name;
}
</script>

<div class="main"> 
<div style = 'display:flex;justify-content: space-between;'>
<div style ='margin-left:3%;'><h1>Dashboard : </h1>
</div>
<!-- Affichage du menu des onglets -->
  <div class="onglets">
    <?php affiche_menu_onglet($nb_bot, $bot_name); ?>
  </div>
</div>

<!-- Affichage du contenu des onglets supérieur -->
  <?php affiche_contenu_onglet_top($nb_bot, $conn, $bot_name); ?>
 
<!-- Affichage du graph -->
  <div class="graph">
    <h2>Graphique</h2>
    <div id="container"></div>
  </div>

<!-- Affichage du contenu des onglets inférieur -->
  <?php affiche_contenu_onglet_bot($nb_bot, $conn); ?>
    <div class='credit'>Auteur : Askoou<br><span style='font-size: 15px;'>Merci de me citer en cas de réutilisation.</span></div>
</div>


<script type="text/javascript">
  var anc_onglet = 'bot1';
  change_onglet(anc_onglet);
</script>

<!-- Script affichage du graph  -->
<script>
Highcharts.chart('container', {

    title: {
        text: 'Evolution des différents wallets'
    },

    yAxis: {
        title: {
            text: 'Valeur du wallet (en $)'
        }
    },

    xAxis: {
        type: 'datetime'
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 2010
        }
    },

    series: [<?php data_graph($nb_bot, $conn); ?>],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});

</script>
<?php $conn->close(); ?>
