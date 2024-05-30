<?php
ob_start();
if (session_id() == '') {
  session_start();
}

if (!isset($_SESSION['empresa_id'])) {
  header("Location: login.php");
  die();
} else {
  $empresaId = $_SESSION["empresa_id"];
}

ob_end_flush();
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


      <div class="pageContent">
        <div class="formHeader d-flex justify-content-start" style="margin-top: 8px; margin-left: 16px;" id="eventListHeaderTitle">
          <svg style="margin-top: 4px;" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99"></circle>
          </svg>
          <p class="header-P">Estado de pago de los eventos</p>
        </div>

        <div class='--table-top-header'>

          <p>
            Eventos
          </p>


          <div class="--table-top-header-actions">
            <div class="form-group" style="margin-bottom: 0px;margin-top: -16px;">
              <label for="event_type" class="inputLabel">Tipo de evento</label>
              <select onchange="filterFinanceEventList(this.value)" style="width: 220px;" id="event_type" name="event_type" type="text" class="form-select input-lg s-Select">
                <option value="">Todos</option>
                <option value="1">Evento corporativo </option>
                <option value="2">Recital o festival </option>
                <option value="3">Fiestas</option>
                <option value="4">Matrimonio</option>
                <option value="5">Seminario, charlas o conferencias</option>
                <option value="6">Rental</option>
                <option value="7">Otro</option>
              </select>
            </div>
          </div>
        </div>

        <table class="--finances-event-resume" id="financeEventDetail">
          <thead>
            <tr>
              <th>
                <p>Nombre del evento</p>
              </th>
              <th>
                <p>Fecha</p>
              </th>
              <th>
                <p>Costo</p>
              </th>
              <th>
                <p>Utilidad</p>
              </th>
              <th>
                <p>Venta</p>
              </th>
              <th>
                <p>Progreso</p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr event_id="319">

              <td>
                <button class="--data-details-fnc">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" class="--show-data">
                    <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M14.75 3H4.25C3.42157 3 2.75 3.67157 2.75 4.5V15C2.75 15.8284 3.42157 16.5 4.25 16.5H14.75C15.5784 16.5 16.25 15.8284 16.25 15V4.5C16.25 3.67157 15.5784 3 14.75 3Z" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M2.75 7.5H16.25" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12.5 1.5V4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M6.5 1.5V4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
                <p>TEST_GAGGERO_1</p>
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M11 1.5H5C4.60218 1.5 4.22064 1.65804 3.93934 1.93934C3.65804 2.22064 3.5 2.60218 3.5 3V15C3.5 15.3978 3.65804 15.7794 3.93934 16.0607C4.22064 16.342 4.60218 16.5 5 16.5H14C14.3978 16.5 14.7794 16.342 15.0607 16.0607C15.342 15.7794 15.5 15.3978 15.5 15V6L11 1.5Z" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12.5 12.75H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12.5 9.75H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M8 6.75H7.25H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M11 1.5V6H15.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
                <button class="redirectToEvent">
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M14 9.75V14.25C14 14.6478 13.842 15.0294 13.5607 15.3107C13.2794 15.592 12.8978 15.75 12.5 15.75H4.25C3.85218 15.75 3.47064 15.592 3.18934 15.3107C2.90804 15.0294 2.75 14.6478 2.75 14.25V6C2.75 5.60218 2.90804 5.22064 3.18934 4.93934C3.47064 4.65804 3.85218 4.5 4.25 4.5H8.75" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M11.75 2.25H16.25V6.75" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M8 10.5L16.25 2.25" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
              </td>
              <td>31/12/2024</td>
              <td>$150.000</td>
              <td>$100.000</td>
              <td>$250.000</td>
              <td>
                <div class="--finance-perc-container" style="background-color:#b3ffb3;">
                  <div style="background-color:#00cc00;width:100%; " class="--finance-perc-view">
                  </div>
                </div>
              </td>
            </tr>
            <tr class="-event-data-info">
              <td colspan="6">
                <div class="--ev-detailsOnTable">
                  <div class="--ev-det-icon-ctn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                      <path d="M11.25 7.5L15 11.25L11.25 15" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M3 3V8.25C3 9.04565 3.31607 9.80871 3.87868 10.3713C4.44129 10.9339 5.20435 11.25 6 11.25H15" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <div class="--ev-det-info-ctn">

                    <div class="ev-det-info-general">
                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Cliente</p>
                        <p class="--ev-det-desc">jose loyola</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">DTE</p>
                        <p class="--ev-det-desc">Sí</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Ingresado/Facturado</p>
                        <p class="--ev-det-desc">Sí</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Estado de pago</p>
                        <p class="--ev-det-desc">Abonado</p>
                      </div>

                    </div>


                    <div class="ev-det-info-general ">
                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Total Costos:</p>
                        <p class="--ev-det-desc">$2.500.000</p>
                      </div>
                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Vehículos</p>
                        <p class="--ev-det-desc">$2.500.000</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Sub Arriendos</p>
                        <p class="--ev-det-desc">$2.500.000</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Otros</p>
                        <p class="--ev-det-desc">$2.500.000</p>
                      </div>

                      <div class="--ev-det-group">
                        <p class="--ev-det-title">Personas</p>
                        <p class="--ev-det-desc">$2.500.000</p>
                      </div>

                    </div>
      

                  </div>
                </div>
              </td>
            </tr>
            <!-- <tr class="">
              <td>
                <button class="--data-details-fnc">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M6.75 13.5L11.25 9L6.75 4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M14.75 3H4.25C3.42157 3 2.75 3.67157 2.75 4.5V15C2.75 15.8284 3.42157 16.5 4.25 16.5H14.75C15.5784 16.5 16.25 15.8284 16.25 15V4.5C16.25 3.67157 15.5784 3 14.75 3Z" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2.75 7.5H16.25" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.5 1.5V4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6.5 1.5V4.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
                <p>1</p>
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M11 1.5H5C4.60218 1.5 4.22064 1.65804 3.93934 1.93934C3.65804 2.22064 3.5 2.60218 3.5 3V15C3.5 15.3978 3.65804 15.7794 3.93934 16.0607C4.22064 16.342 4.60218 16.5 5 16.5H14C14.3978 16.5 14.7794 16.342 15.0607 16.0607C15.342 15.7794 15.5 15.3978 15.5 15V6L11 1.5Z" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.5 12.75H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.5 9.75H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 6.75H7.25H6.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11 1.5V6H15.5" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M14 9.75V14.25C14 14.6478 13.842 15.0294 13.5607 15.3107C13.2794 15.592 12.8978 15.75 12.5 15.75H4.25C3.85218 15.75 3.47064 15.592 3.18934 15.3107C2.90804 15.0294 2.75 14.6478 2.75 14.25V6C2.75 5.60218 2.90804 5.22064 3.18934 4.93934C3.47064 4.65804 3.85218 4.5 4.25 4.5H8.75" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.75 2.25H16.25V6.75" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5L16.25 2.25" stroke="#8B8D97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
              </td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td>5</td>
              <td>5</td>
            </tr>
            <tr>
              <td>
                <button></button>
                <p>1</p>
                <button></button>
                <button></button>
              </td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td>5</td>
              <td>5</td>
            </tr> -->
          </tbody>
        </table>
      </div>




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

  <!-- FINANCES FUNCTIONS -->
  <script src="./js/finances/financeAPI.js"></script>
  <script src="./js/finances/event_details/financeDetailTable.js"></script>
  <script src="./js/finances/financeHandlers.js"></script>




</body>

<script>
  const EMPRESA_ID = <?php echo $empresaId; ?>;

  // ON DOCUMENT READY CALL API TO FETCH EVENT DATA
  window.addEventListener("load", (event) => {
    //CALL AND RENDER TABLE FINANCIAL EVENT DATA FUNCTIONS
    getFinanceEventDetail(EMPRESA_ID);
  });
</script>



</html>