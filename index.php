<?php
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
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="txtDec-no" href="./proximosEventos.php"><img src="./assets/svg/Dashboard.svg" alt="" style="margin-top: -5px;"> Eventos</a></li>
            </ol>
          </nav>
          <p class="headerTitle" style="margin:-13px 0px 16px 0px!important;">Dashboard</p>


          <div class="personalInformation-user">

            <div class="welcome-container">

              <p class="user-welcome">Hola, <strong class="user-name"> Cote</strong></p>
            </div>
            <p class="user-tip">Consulta el estado de tus eventos</p>

          </div>
        </header>

        <div class="page-content page-r-content">

          <div id="dash-monthResumeContainer">
            <div id="monthEventsAmount" class="resume-event-container" >
              <div class="detail-month">
                <p class="month-name">Eventos del mes</p>
                <div class="d-flex justify-content-start" style="gap: 4px;">
                  <p class="month-amount">90</p>
                  <p class="month-perc">+14%</p>
                </div>
              </div>
              <div class="img-event-month">
                <img src="./assets/svg/dsCalendar.svg" alt="">
              </div>
            </div>
            <div id="monthEventsAmount" class="resume-event-container">
              <div class="detail-month">
                <p class="month-name">Utilidad mensual</p>
                <div class="d-flex justify-content-start" style="gap: 4px;">
                  <p class="month-amount">$12.537.900</p>
                  <p class="month-perc">-14%</p>
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
                  <p class="month-amount">+5,4</p>
                  <p class="month-perc">+14%</p>
                </div>
              </div>
              <div class="img-event-month">
                <img src="./assets/svg/medal.svg" alt="">
              </div>
            </div>
            
          </div>

          <div id="dash-event-housing">
            <p class="dstheader">Historial de eventos</p>
            <form id="dash-event-menu">
              <fieldset>
                <input type="radio" value="Creados">Creados
                <input type="radio" value="Confirmados">
                <input type="radio" value="Finalizados">
                <input type="radio" value="Todos">
              </fieldset>
              <div class="row justify-content-between">
                <div class="dash-filter-event">
                  <div class="select-area-dashEvent">
                    <div class="form-group" style="width: 180px;">
                      <label for="fechaInicio" class="inputLabel dateLabel">Fecha</label>
                      <input id="fechaInicio" name="dpInicio" type="date" class="form-control s-Input-g">
                    </div>
                    <div class="form-group" style="width: 180px;">
                      <label for="especialidadSelect" class="inputLabel">Periodo</label>
                      <select id="especialidadSelect" name="especialidadSelect" type="text" class="form-select s-Select-g">
                        <option value="uno">Uno</option>
                      </select>
                    </div>
                    <div class="form-group" style="width:180px">
                      <label for="nombreInput" class="inputLabel">Tipo de evento</label>
                      <input id="nombreInput" name="nombreInput" type="text" class="form-control s-Input-g" />
                    </div>
                  </div>
                  <button class="s-Button-w" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                      <path d="M17 2.75H2L8 9.845V14.75L11 16.25V9.845L17 2.75Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="s-P-g">Filtros</p>
                  </button>
                </div>
              </div>
            </form>

            <table class="s-table" id="dash-event-table">
              <thead>
                <tr>
                  <th style="width: 176px;">Evento</th>
                  <th style="width: 156px;">Fecha</th>
                  <th style="width: 224px;">Ubicación</th>
                  <th style="width: 176px;">Estado</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <?php include_once('./includes/Modal/detallesProyecto.php') ?>
    </div>
  </div>

  <?php require_once('./includes/footerScriptsJs.php') ?>
  <?php require_once('./includes/Modal/detallesProyecto.php'); ?>
  <?php require_once('./includes/Modal/cliente.php'); ?>
  <?php require_once('./includes/Modal/direccion.php'); ?>

</body>

<script src="/js/Funciones/UpdateProject.js"></script>
<script src="/js/clientes.js"></script>
<script src="/js/direccion.js"></script>
<script src="/js/personal.js"></script>
<script src="/js/vehiculos.js"></script>
<script src="/js/productos.js"></script>
<script src="/js/project.js"></script>
<script src="/js/Funciones/NewProject.js"></script>
<script src="/js/localeStorage.js"></script>
<script src="/js/valuesValidator/validator.js"></script>
<script src="/js/ClearData/clearFunctions.js"></script>
<script src="/js/ProjectResume/viatico.js"></script>
<script src="/js/ProjectResume/subArriendo.js"></script>
<script src="/js/ProjectResume/projectResume.js"></script>
<script src="/js/Funciones/assigments.js"></script>
<script src="/js/Cargo_Especialidad/Testing/calendarviewResume.js"></script>
<script src="/js/calendar.js"></script>

<script>
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
</script>

</html>