<?php
session_start();
$isDetails = true;
//Variables que manipulan condiciones if en Form proyecto
$detalle = true;
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once('./includes/head.php');
$active = 'dashboard';

?>

<body>

  <script src="./assets/js/initTheme.js"></script>
  <?php require_once('./includes/Constantes/empresaId.php') ?>

  <?php require_once('./includes/Constantes/rol.php') ?>
  <div id="app">

    <?php require_once('./includes/sidebar.php') ?>

    <div id="main">

      <div class="page-right-content">

        <header class="page-header">


          <?php require_once('./includes/headerBreadCrumb.php') ?>



          <div class="personalInformation-user">

            <div class="welcome-container">

              <p class="user-welcome">Hola, <strong class="user-name"><?php echo $_SESSION['user_name'] ?></strong></p>
            </div>
            <p class="user-tip">Consulta el estado de tus eventos</p>

          </div>
        </header>

        <div class="page-content page-r-content">
          <div class="left-side-container">

            <div id="dash-monthResumeContainer">
              <div id="monthEventsAmount" class="resume-event-container">
                <div class="detail-month">
                  <p class="month-name">Eventos del mes</p>
                  <div class="d-flex justify-content-start" style="gap: 4px;">
                    <p class="month-amount" id="eventAmountCurrentMonth"></p>
                    <p class="month-perc" id="currentMonthEventamountPercentaje"></p>
                  </div>
                </div>
                <div class="img-event-month">
                  <img src="./assets/svg/dsCalendar.svg" alt="">
                </div>
              </div>
              <div id="monthEventsAmount" class="resume-event-container">
                <div class="detail-month">
                  <p class="month-name">Venta del mes</p>
                  <div class="d-flex justify-content-start" style="gap: 4px;">
                    <p id="dash-amountIncome" class="month-amount"></p>
                    <!-- <p id="dash-amountIncomePercentaje" class="month-perc neg">-14%</p> -->
                  </div>
                </div>
                <div class="img-event-month">
                  <img src="./assets/svg/moneySymbol.svg" alt="">
                </div>
              </div>
              <div id="monthEventsAmount" class="resume-event-container">
                <div class="detail-month">
                  <p class="month-name">Eventos por completar</p>
                  <div class="d-flex justify-content-start" style="gap: 4px;">
                    <p class="month-amount" id="currentMonthLeftEvents"></p>
                    <!-- <p class="month-perc">+14%</p> -->
                  </div>
                </div>
                <div class="img-event-month">
                  <img src="./assets/svg/medal.svg" alt="">
                </div>
              </div>
            </div>

            <div class="actionMobileContainer">

              <div class="--mo-action-button" id="eventListdashMobile">
                <p>Lista de eventos</p>

                <div class="img-event-month">
                  <img src="./assets/svg/medal.svg" alt="">
                </div>
              </div>

              <div class="--mo-action-button" id="dashCreateNewEventMobile">
                <p>Crear Evento</p>
                <div class="img-event-month" style="margin-left: 32px;">
                  <img src="./assets/svg/medal.svg" alt="">
                </div>
              </div>

            </div>
            <div id="dash-event-housing">
              <p class="dstheader">Próximos eventos</p>
              <form id="dash-event-menu">
                <!-- <div id="dash-event-status">
                    <label for="" id="dash-searchBy">Buscar por:</label>
                    <div class="select-status-container">
                      <input type="radio" class="eventStatusSortDash" value="all" checked>
                      <label for="">Todos</label>
                    </div>
                    <div class="select-status-container">
                      <input type="radio" class="eventStatusSortDash" value="1">
                      <label for="">Creados</label>
                    </div>
                    <div class="select-status-container">
                      <input type="radio" class="eventStatusSortDash" value="2">
                      <label for="">Confirmados</label>
                    </div>
                    <div class="select-status-container">
                      <input type="radio" class="eventStatusSortDash" value="3">
                      <label for="">Finalizados</label>
                    </div>
                  </div> -->
                <div class="row justify-content-between">
                  <!-- <div class="dash-filter-event">
                    <div class="select-area-dashEvent">
                      <div class="form-group" style="width: 180px;">
                        <label for="fechaInicio" class="inputLabel dateLabel">Fecha</label>
                        <input id="fechaInicio" name="dpInicio" type="date" class="form-control s-Input-g">
                      </div>
                    </div>
                    <div class="form-group" style="width:180px">
                      <label for="eventTypeSelect" class="inputLabel">Tipo de evento</label>
                      <select id="eventTypeSelect" name="eventTypeSelect" type="text" class="form-select s-Select-g">
                        <option value=""></option>
                        <option value="1">Evento corporativo </option>
                        <option value="2">Recital o festival </option>
                        <option value="3">Fiestas</option>
                        <option value="4">Matrimonio</option>
                        <option value="5">Seminario, charlas o conferencias</option>
                        <option value="6">Rental</option>
                        <option value="7">Otro</option>
                      </select>
                    </div>
                  </div> -->
                  <!-- <button class="s-Button-w" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                      <path d="M17 2.75H2L8 9.845V14.75L11 16.25V9.845L17 2.75Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="s-P-g">Filtros</p>
                  </button> -->
                </div>
              </form>

              <table class="" id="dash-event-table">
                <thead>
                  <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Venta</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                </tfoot>
              </table>

            </div>
          </div>
          <div class="right-side-dash">
            <div id="calendar-container">
              <div id="calendar">

              </div>
            </div>

            <div id="today-resume">

              <p class="today-p"></p>

              <div class="card-days">
                <div class="day-card" day_sum="-2" id="day-minus-2">
                  <p class="day-number"></p>
                  <p class="day-name"></p>
                </div>
                <div class="day-card" day_sum="-1" id="day-minus-1">
                  <p class="day-number"></p>
                  <p class="day-name"></p>
                </div>
                <div class="day-card today" day_sum="0" id="day-today">
                  <p class="day-number"></p>
                  <p class="day-name"></p>
                </div>
                <div class="day-card" day_sum="1" id="day-plus-1">
                  <p class="day-number"></p>
                  <p class="day-name"></p>
                </div>
                <div class="day-card" day_sum="2" id="day-plus-2">
                  <p class="day-number"></p>
                  <p class="day-name"></p>
                </div>
              </div>
              <div class="blur-line">
              </div>
              <div class="daily-events-background">
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <div class="dl-line"></div>
                <section id="daily-event-list">
                  <!-- <div class="event-data-container">
                    <div class="--dly-ev-data-body">
                      <div class="--dly-logo"></div>
                      <div class="--dly-info">
                          <p class="--dly-info-event-name">Event name</p>
                          <p class="--dly-info-event-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero esse veniam enim nulla ut. Aut saepe provident culpa nulla, nihil esse voluptatem, magni odio aperiam eos cum omnis cumque accusantium!</p>
                      </div>
                    </div>
                  </div> -->
                </section>
              </div>
            </div>

            <!-- <div id="finance-resume">

            </div> -->
          </div>
        </div>
      </div>
    </div>
    <?php include_once('./includes/Modal/detallesProyecto.php') ?>
  </div>
  </div>
  <?php require_once('./includes/footerScriptsJs.php') ?>

  <script src="./js/dashboard/dashboard.js"></script>
  <script src="./js/sortTable/eventSort.js"></script>
  <script src="./js/valuesValidator/validator.js"></script>

  <!-- GLOBAL FUNCTIONS -->
  <script src="./js/Funciones/openEventFromTables.js"></script>
  <script src="./js/pageHeader/breadCrumb.js"></script>
  <script src="./js/pageHeader/searchBar.js"></script>

</body>


<script>
  const EMPRESA_ID = <?php echo $empresaId; ?>;
</script>

<style>
  table.dataTable thead>tr>th.sorting,
  table.dataTable thead>tr>th.sorting_asc,
  table.dataTable thead>tr>th.sorting_desc,
  table.dataTable thead>tr>th.sorting_asc_disabled,
  table.dataTable thead>tr>th.sorting_desc_disabled,
  table.dataTable thead>tr>td.sorting,
  table.dataTable thead>tr>td.sorting_asc,
  table.dataTable thead>tr>td.sorting_desc,
  table.dataTable thead>tr>td.sorting_asc_disabled,
  table.dataTable thead>tr>td.sorting_desc_disabled {
    padding-right: 0px !important;
  }
</style>



<script>
  // window.addEventListener("beforeunload", function (e) {
  //   var confirmationMessage = "\o/";

  //   (e || window.event).returnValue = confirmationMessage; //Gecko + IE
  //   return confirmationMessage;                            //Webkit, Safari, Chrome
  // });
</script>

<!-- <script src="/js/Cargo_Especialidad/Testing/calendarviewResume.js"></script> -->
<!-- <script src="/js/calendar.js"></script> -->

<!-- <script>
  const EMPRESA_ID = $('#empresaId').text();
  let calendar;
  var calendarEl = document.getElementById('calendar');

  async function GetCalendarProjects(empresaId) {
    return $.ajax({
      type: "POST",
      url: "ws/proyecto/proyecto.php",
      dataType: 'json',
      data: JSON.stringify({
        "action": "GetAllMyProjects",
        empresaId: empresaId
      }),
      success: function(response) {
        // console.log("PROYECTOS A AAGREGAR A CALENDAR",response);

      }
    })
  }

  $('#changedateevent').on('click', function() {
    // console.log(calendar.getEvent());

    let calendarData = calendar.getEvents();
    console.log(calendarData);
    let specificEvent = calendar.getEventById(75);
  })

  async function fillListProjects() {
    let eventos = await GetCalendarProjects(EMPRESA_ID);
    let ul = $('#project-resume');

    console.log("eventos", eventos);

    eventos.forEach((element) => {
      let li = `<li class="headerLi">
                  <div class="projectData">
                    <p class="projectName lipad">${element.nombre_proyecto}</p>
                    <p class="projectDate lipad">${element.fecha_inicio} / ${element.fecha_termino}</p>
                  </div>
                </li>`
      ul.append(li);
    })
  }

  document.addEventListener('DOMContentLoaded', async function() {

    fillListProjects();


    FillCalendar(0);

    // const events = await (GetCalendarProjects(EMPRESA_ID));
    // let calendarEventObj = [];

    // console.log(events);

    // events.forEach(element => {

    //   console.log(element.id);
    //   let color = "white";
    //   let textColor = "black";
    //   if (element.estado === 'creado') {
    //     color = "yellow";
    //     let textColor = "black";

    //   }
    //   if (element.estado === 'confirmado') {
    //     color = "green";
    //     let textColor = "white";

    //   }
    //   if (element.estado === 'finalizado') {
    //     color = "blue";
    //     let textColor = "white";

    //   }

    //   calendarEventObj.push({
    //     id: element.id,
    //     title: element.nombre_proyecto,
    //     start: element.fecha_inicio,
    //     end: element.fecha_termino,
    //     color: color,
    //     textColor: textColor
    //   })

    // });


    // calendar = new FullCalendar.Calendar(calendarEl, {
    //   eventClick: function(info) {

    //     // ViewResume(projectId)

    //     console.log(`ID ${info.event.id}`);
    //     ViewResume(info.event.id);
    //     // alert('Event: ' + info.event.title);
    //     // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    //     // alert('View: ' + info.view.type);
    //     // change the border color just for fun
    //     // info.el.style.borderColor = 'red';
    //   },
    //   events: calendarEventObj
    // })
    // calendar.render();

  });


  function ViewResume(projectId) {

    // $('#resumen').show();
    ResetClienteForm();
    localStorage.clear();

    // LIMPIAR TODOS LOS li PERSONAL ASSIGNED
    DropDragPersonal();

    // CLOSE ALL NAV-LINKS IN PORJECT ASSIGMENTS
    CloseAllTabsOnProjectsAssigments();

    // CLEAR PRODUCTS ASSIGMENTS
    DropAllSelectedProducts();

    // console.log("LOCAL STORAGE POST CLEAN FUNCTION",GetPersonalStorage());

    $('#idProjectModalResume').text("");
    $('#idClienteModalResume').text("");
    $('#idLugarModalResume').text("");

    // let projectId = element.closest('tr').find('.idProject').text();

    $('#idProjectModalResume').text(projectId);

    $('#proyectosModal').modal('show');

    let projectRequest = {
      idProject: projectId,
      asignados: true
    }

    $.ajax({
      type: "POST",
      url: 'ws/proyecto/proyecto.php',
      data: JSON.stringify({
        request: {
          projectRequest
        },
        action: "getProjectResume"
      }),
      dataType: 'json',
      success: function(response) {
        // console.table(response.asignados.vehiculos);
        // console.table(response.asignados.personal);
        // console.table(response.asignados.cliente);
        // console.table(response.asignados.productos);
        // console.table(response.asignados.viaticos);
        // console.table(response.asignados.arriendos);
        // console.table(response.asignados.totalIngresos);
        console.table(response.dataProject);

        response.dataProject.forEach(data => {

          let nombre_cliente;

          // console.table("response.asignados.cliente",response.asignados.cliente);
          if (response.asignados.cliente.length > 0) {

            response.asignados.cliente.forEach(cliente => {
              $('#inputTelefono').val(cliente.telefono);
              $('#inputNombreCliente').val(`${cliente.nombre} ${cliente.apellido} | ${cliente.razon_social} | ${cliente.rut_df}`);
              nombre_cliente = `${cliente.nombre} ${cliente.apellido} | ${cliente.razon_social} | ${cliente.rut_df}`;
            });
          }
          if (data.nombre_proyecto === "" || data.nombre_proyecto === undefined || data.nombre_proyecto === null) {
            data.nombre_proyecto = "";
          }
          if (data.fecha_inicio === "" || data.fecha_inicio === undefined || data.fecha_inicio === null) {
            data.fecha_inicio = "";
          }
          if (data.fecha_termino === "" || data.fecha_termino === undefined || data.fecha_termino === null) {
            data.fecha_termino = "";
          }
          // console.log("NOMBRE CLIENTE",nombre_cliente);
          if (nombre_cliente === "" || nombre_cliente === undefined || nombre_cliente === null) {
            nombre_cliente = "";
          }
          if (data.comentarios === "" || data.comentarios === undefined || data.comentarios === null) {
            comentarios = "";
          }

          console.log("NOMBRE PROYECTO", data.nombre_proyecto);
          $('#inputProjectName').val(data.nombre_proyecto);
          $('#fechaInicio').val(data.fecha_inicio)
          $('#fechaTermino').val(data.fecha_termino)
          $('#direccionInput').val('')

          if (data.lugarId === null) {

            $('#direccionInput').val("")

          } else {

            $('#direccionInput').val(data.direccion + ' ' + data.numero + ' ' + data.dpto + ', ' + data.comuna + ', ' + data.region)
          }

          $('#inputNombreCliente').val(data.nombre_cliente)
          $('#commentProjectArea').val(data.comentarios);
          $('#estadoProyecto').text(data.estado);
          if (data.estado === "1") {
            $('#changeStatusButton').text("Confirmar Evento")
          }
          if (data.estado === "2") {
            $('#changeStatusButton').text("Finalizar Evento")
          }
          if (data.estado === "3") {
            $('#changeStatusButton').css('display', 'none');
          }
          SetProjectData(data.nombre_proyecto, data.fecha_inicio, data.fecha_termino, nombre_cliente, data.comentarios);
        });

        if (response.asignados.vehiculos.length > 0) {
          // console.log('ARRAY DE VEHICLOS',response.asignados.vehiculos)
          response.asignados.vehiculos.forEach(asignado => {
            $('#sortable2').append(`<li style="display:flex; justify-content:space-between;" class="${asignado.id}">
                                            ${asignado.patente}
                                            <div class="personalPricing" style="display:flex;align-content: center;">
                                                <input type="number" name="price" value="" class="vehiclePrice" placeholder="Costo"/>
                                                <i onclick="AddVehiculo(this)"class="fa-solid fa-plus addPersonal"></i>
                                            </div>
                                        </li>`)
            VehicleStorage(asignado.id, asignado.patente, asignado.costo);
            // console.log("SI SE ASIGNA EL LOCALSTORAGE DE VEHICULOS");
          });

        } else {
          // VehicleStorage("","","");
          document.getElementById('car').style.display = "block"
        }

        if (response.asignados.productos.length > 0) {
          response.asignados.productos.forEach(asignado => {
            AddDivProduct(asignado.nombre, asignado.precio_arriendo, asignado.id, asignado.cantidad);
            let totalPrice = parseInt(asignado.precio_arriendo) * parseInt(asignado.cantidad)
            ProductsStorage(asignado.id, asignado.nombre, asignado.precio_arriendo, asignado.cantidad, totalPrice);
          });

        } else {
          // ProductsStorage({id:"", nombre:"", precio_arriendo:"", cantidad:"",totalPrice:""});
        }

        if (response.asignados.cliente.length > 0) {
          response.asignados.cliente.forEach(cliente => {
            $('#clienteSelect').val(cliente.id);
            $('#idClienteModalResume').text(cliente.id);
            $('#inputNombreClienteForm').val(cliente.nombre);
            $('#inputApellidos').val(cliente.apellido);
            $('#inputRutCliente').val(cliente.rut);
            $('#inputCorreo').val(cliente.correo);
            $('#inputTelefono').val(cliente.telefono);
            $('#inputRut').val(cliente.rut_df);
            $('#inputRazonSocial').val(cliente.razon_social);
            $('#inputNombreFantasia').val(cliente.nombre_fantasia);
            $('#inputDireccionDatosFacturacion').val(cliente.direccion);
            $('#inputCorreoDatosFacturacion').val(cliente.correo);
            $('#inputNombreCliente').val(`${cliente.nombre} ${cliente.apellido} | ${cliente.razon_social} | ${cliente.rut_df}`);
          });
        } else {
          document.getElementById('person').style.display = "none";
        }

        if (response.asignados.personal.length > 0) {
          response.asignados.personal.forEach(asignado => {
            $('#sortablePersonal2').append(`<li style="display:flex; justify-content:space-between;" class="${asignado.id}">
                                          ${asignado.nombre} | ${asignado.cargo} ${asignado.especialidad} 
                                          <div class="personalPricing" style="display:flex;align-content: center;">
                                              <input type="number" name="price" value="${asignado.costo}" class="personalPrice" placeholder="Costo"/>
                                              <i onclick="AddPersonal(this)" style="display:none" class="fa-solid fa-plus addPersonal"></i>
                                              <i onclick="removePersonal(this)" class="fa-solid fa-minus" style="color: #b92413;"></i>
                                          </div>
                                      </li>`);

            PersonalLocalStorage(asignado.id, `${asignado.nombre} | ${asignado.cargo} ${asignado.especialidad}`, asignado.costo, asignado.contrato);
          });

        } else {}


        if (response.asignados.arriendos.length > 0) {
          response.asignados.arriendos.forEach(asignado => {

            SetArriendosProject(asignado.id_proyecto, parseInt(asignado.valor), asignado.detalle_arriendo)
          });

        } else {

        }
        if (response.asignados.viaticos.length > 0) {
          response.asignados.viaticos.forEach(asignado => {
            SetViatico(asignado.proyecto_id, asignado.valor, asignado.detalle);
          });
        } else {

        }

        if (response.asignados.totalIngresos.length > 0) {
          response.asignados.totalIngresos.forEach(asignado => {
            console.log("TOTAL INGRESOS", asignado);

            SetTotalProject(asignado.id_proyecto, asignado.total, "");

          });
        } else {
          SetTotalProject("", 0, "");
        }
        // GetResumeProjectList();
      },
      error: function(err) {}
    })
  }


  $('#clienteSelect').on('change', function() {

    $('#clientDataBtn').text("Guardar");
    const SelectValue = $(this).val();

    if (SelectValue === "" || SelectValue === "new") {

      ResetClienteForm();

      $('#idClienteModalResume').text("");
    }
  })


  function DropAllSelectedProducts() {
    $('.detailsProduct-box').each((key, element) => {
      $(element).remove();
    })
  }

  function DropVehiculos() {
    $('#sortable1 li').each((key, element) => {
      $(element).remove()
    })
  }

  function DropDragPersonal() {
    $('#sortablePersonal2 li').each((key, element) => {
      $(element).remove()
    })
  }
</script> -->

</html>