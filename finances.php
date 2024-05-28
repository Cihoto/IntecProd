<?php
session_start();
$isDetails = true;
//Variables que manipulan condiciones if en Form proyecto
$detalle = true;
$title = "Intec - Finanzas"
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once('./includes/head.php');
$active = 'finance';

?>

<body>

  <script src="./assets/js/initTheme.js"></script>
  <?php require_once('./includes/Constantes/empresaId.php') ?>

  <?php require_once('./includes/Constantes/rol.php') ?>
  <div id="app">

    <?php require_once('./includes/sidebar.php') ?>

    <div id="main">

      <header class="page-header">

        <?php require_once('./includes/headerBreadCrumb.php') ?>

      </header>

      <!-- <div class="ct-chart ct-major-third"></div> -->

      <div id="myChart"></div>


      <button class="--f-button" onclick="openFinancesEventsDetails()">
        <div class="--f-btn-icon">
          <img src="./assets/svg/financeLogo.svg" alt="">
        </div>
        <p>
          Detalle eventos
        </p>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

    </div>
  </div>
  <?php require_once('./includes/footerScriptsJs.php') ?>

  <script src="./js/valuesValidator/validator.js"></script>



  <!-- GLOBAL FUNCTIONS -->
  <script src="./js/pageHeader/breadCrumb.js"></script>
  <script src="./js/pageHeader/searchBar.js"></script>
  <script src="./js/demoAccount/demoAccountCreation.js"></script>
  <script src="./js/demoAccount/demoAccountDelete.js"></script>
  <script src="./js/pageHeader/demoAccountButton.js"></script>


  <!-- LOCAL FUNCTIONS -->
  <script src="./js/finances/financeHandlers.js"></script>




</body>

<script>
  const EMPRESA_ID = <?php echo $empresaId; ?>;
  createBreadCrumb('finances');


  document.addEventListener("DOMContentLoaded", function(event) {
    getAnualIncome(EMPRESA_ID);

  });



  function getAnualIncome(empresa_id) {
    fetch('ws/finance/getAnualIncomeResume.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          request: {
            empresa_id: empresa_id
          }
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error en la solicitud 1');
        }
        return response.json();
      })
      .then(data => {
        // Manejar la respuesta exitosa aquí
        console.log(data);


        const CHART_DATA = data.anualIncome.map((row) => {
          return {
            'month': row.month,
            'totalMonthIncome': parseInt(row.total_month_income),
            'totalEventCount': row.total_event_count
          }
        });

        console.log('CHART_DATA', CHART_DATA)
        renderChartAnualIncome(CHART_DATA);
      })
      .catch(error => {
        // Manejar errores aquí
        console.error('Error en la solicitud:', error);
      });
  }



  function formatNumber(value) {
    value /= 1000_000;
    return `${Math.floor(value)}M`;
  }


  function renderChartAnualIncome(chartData) {
    // Chart Options
    const options = {
      // Container: HTML Element to hold the chart
      container: document.getElementById('myChart'),
      data: chartData,
      series: [
        // Existing 'Bar' Series, using 'iceCreamSales' data-points
        {
          type: 'bar',
          xKey: 'month',
          yKey: 'totalMonthIncome',
          yName: 'Venta',
          stacked: true,
          fill: '#FFF',
          label: {
            formatter: ({
              value
            }) => formatNumber(value),
          },
        },
        {
          type: 'line',
          xKey: 'month',
          yKey: 'totalEventCount'
        }
      ],
      axes: [{
          type: 'category',
          position: 'bottom'
        },
        {
          type: 'number',
          position: 'left',
          keys: ['totalMonthIncome'],
          label: {
            formatter: ({
              value
            }) => formatNumber(value),
          },
          tick: {
            minSpacing: 1,
          },
        },
        {
          type: 'number',
          position: 'right',
          keys: ['totalEventCount']
        },
      ],
      background: {
        fill: 'linear-gradient(358deg, #069B99 1.07%, #0BBEBB 61.75%, #10E5E1 108.47%)',
      },
    };

    // Create Chart
    const chart = agCharts.AgCharts.create(options);

  }
</script>



</html>