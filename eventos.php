<?php
$active = "eventos";
$title = "Mis Eventos";
header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('./includes/head.php');
?>

<body>
    <?php require_once('./includes/Constantes/empresaId.php') ?>
    <?php require_once('./includes/Constantes/rol.php') ?>
    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>

        <div id="main">
            <header class="page-header">
                <?php require_once('./includes/headerBreadCrumb.php') ?>

                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        
                    </ol>
                </nav>
                <p class="headerTitle">Listado de eventos</p> -->
            </header>

            <div class="pageContent" id="evListContent">

                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-left: 8px;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="listview-tab" data-bs-toggle="tab" href="#listview" role="tab" aria-controls="listview" aria-selected="true">Lista</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="calendarView-tab" data-bs-toggle="tab" href="#calendarView" role="tab" aria-controls="calendarView" aria-selected="false">Calendario</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="deletedEv-tab" data-bs-toggle="tab" href="#deletedEv" role="tab" aria-controls="deletedEv" aria-selected="false">Eliminados</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active tab-data" id="listview" role="tabpanel" aria-labelledby="listview-tab">
                        <div class="formHeader d-flex justify-content-start" style="margin-top: 8px; margin-left: 16px;" id="eventListHeaderTitle">
                            <svg style="margin-top: 4px;" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="6" fill="#069B99" />
                            </svg>
                            <p class="header-P">Aquí puedes ver y editar tus eventos</p>
                        </div>

                        <div style="display: flex; justify-content: space-between;margin-left: 0px;margin-bottom: -16px;gap: 10px;width: 100%;">

                            <div class="--eventList-searchBar">
                                <!-- <div class="--eventList-searchBar"> -->
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label for="event_status" class="inputLabel">Estado</label>
                                    <select id="eventListSelector" name="" type="text" class="form-select">
                                        <option value="exe">Futuros</option>
                                        <option value="all">Todos</option>
                                        <option value="draft">Borradores</option>
                                        <option value="sells">Ventas</option>
                                        <option value="op">Operaciones</option>
                                        <option value="adm">Administración</option>
                                    </select>
                                </div>

                                <!-- </div> -->
                                <input readonly type="text" id="calendarInput" placeholder="Filtrar por fecha">

                            </div>

                            <!-- <button class="s-Button-w">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                    <path d="M17 2.75H2L8 9.845V14.75L11 16.25V9.845L17 2.75Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="s-P-g">Filtros</p>
                            </button> -->
                            <!-- <div class="row" style="margin-left: 0px;margin-bottom: -16px;gap: 10px;width: 100%;margin-left: 16px;">

                                <button class="s-Button-w" id="sortAllMyEvents">
                                    <p class="s-P-g">Todos</p>
                                </button>
                                <button class="s-Button-w" id="sortDrafEvents">
                                    <p class="s-P-g">Borradores</p>
                                </button>
                                <button class="s-Button-w" id="sortSells">
                                    <p class="s-P-g">Ventas</p>
                                </button>
                                <button class="s-Button-w" id="sortOperationalEvents">
                                    <p class="s-P-g">Operaciones</p>
                                </button>
                                <button class="s-Button-w" style="width: 125px;" id="sortAdmEvents">
                                    <p class="s-P-g">Administración</p>
                                </button>

                            </div> -->

                            <div class="--evl-actionbtn-ctn">
                                <!-- <button class="s-Button-w" style="width: 175px;position: absolute;right: 158px;" id="exportToExcel">
                                    <p class="s-P-g">Exportar Excel</p>
                                </button> -->

                                <button class="--secondary-action-btn" id="exportToExcel" style="width: 160px;">
                                    <img src="./assets/svg/downloadLogoSecondary.svg" alt="">
                                    <p>Exportar Excel</p>
                                </button>
                                <button class="s-Button" id="openModalNewFree" style="width: 160px;">
                                    <p class="s-P"><a href="./miEvento.php" style="color: white;text-decoration: none;">Crear evento</a></p>
                                </button>
                            </div>
                        </div>

                        <div style="overflow-x: scroll;">
                            <table class="" id="allProjectTable-list">
                                <thead>
                                    <tr>

                                        <th>
                                            <p>Evento</p>
                                        </th>
                                        <th>
                                            <p>Fecha</p>
                                            <!-- <img src="./assets//svg/calendar.svg" alt="" style="margin-right: 10px;"> -->
                                        </th>
                                        <th>
                                            <p>Estado</p>
                                        </th>
                                        <th>
                                            <p>Owner</p>
                                        </th>
                                        <th>
                                            <p>Asignación</p>
                                        </th>
                                        <th>
                                            <p>Venta</p>
                                        </th>
                                        <th>
                                            <p>Cliente</p>
                                        </th>
                                        <th>
                                            <p>Tipo de evento</p>
                                        </th>
                                        <!-- <th>
                                            <p>Facturación</p>
                                        </th> -->
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade tab-data" id="calendarView" role="tabpanel" aria-labelledby="calendarView-tab" style="margin: 15px; height: 100%;">
                        <div class="row">
                            <div class="form-group col-6 col-lg-3">
                                <label for="event_status" class="inputLabel">Estado</label>
                                <select style="width: 100%;" id="event_status" name="event_status" type="text" class="form-select input-lg s-Select">
                                    <option value=""></option>
                                    <option value="1">Borrador</option>
                                    <option value="2">Confirmado</option>
                                    <option value="4">Cotizado</option>
                                    <option value="3">Finalizado</option>
                                    <option value="5">Cerrado</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="calendar-container"> -->
                        <div id='calendar'></div>
                        <!-- </div> -->
                    </div>
                    <div class="tab-pane fade tab-data" id="deletedEv" role="tabpanel" aria-labelledby="deletedEv-tab" style="margin: 15px; height: 100%;">
                        <div style="display: block;overflow-x: auto;">

                            <table class="" id="deletedEventsTable-list">
                                <thead>
                                    <tr>
                                        <th>

                                        </th>

                                        <th>
                                            <p>Evento</p>
                                        </th>
                                        <th>
                                            <p>Fecha</p>
                                        </th>
                                        <th>
                                            <p>Estado</p>
                                        </th>
                                        <th>
                                            <p>Owner</p>
                                        </th>
                                        <th>
                                            <p>Asignación</p>
                                        </th>
                                        <th>
                                            <p>Venta</p>
                                        </th>
                                        <th>
                                            <p>Cliente</p>
                                        </th>
                                        <th>
                                            <p>Tipo de evento</p>
                                        </th>

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

            </div>
        </div>
    </div>
    <?php require_once('./includes/footer.php') ?>
    <?php require_once('./includes/footerScriptsJs.php') ?>

    </div>
    </div>


    <div id="statusMenuList-evl" class="optionLimiter">
        <section id="statusMenuHeader">
            <div id="headerOptionsContent">
                <img src="./assets/svg/bookMark.svg" alt="">
                <div class="listItemHeaderText">
                    <p class="header">Etiquetas de estado</p>
                    <p class="bottom">Puedes cambiar el estado de tu evento en todo momento</p>
                </div>
            </div>
        </section>
        <div class="d-flex" style="width: 100%;margin:-13px 0px;padding: 0px;">
            <div class="divider">1</div>
        </div>
        <section class="statusMenuOptions">
            <button status_id="1" class="event-status-btn borrador">
                <p>Borrador</p>
            </button>
            <button status_id="4" class="event-status-btn cotizado">
                <p>Cotizado</p>
            </button>
            <button status_id="2" class="event-status-btn confirmado">
                <p>Confirmado</p>
            </button>
            <button status_id="3" class="event-status-btn finalizado">
                <p>Finalizado</p>
            </button>
            <button status_id="5" class="event-status-btn cerrado">
                <p>Cerrado</p>
            </button>
            <button status_id="6" class="event-status-btn No_va" style="border-radius: 0px 0px 5px 5px;">
                <p>No va</p>
            </button>
        </section>
    </div>

</body>

<script src="/js/eventList.js"></script>
<script src="/js/calendar.js"></script>
<script src="./js/const/projectToSearch.js"></script>
<script src="./js/sortTable/eventSort.js"></script>
<script src="./js/valuesValidator/validator.js"></script>


<!-- HEADER CONTROLLER -->
<script src="./js/pageHeader/breadCrumb.js"></script>
<script src="./js/pageHeader/searchBar.js"></script>

<script>
    caches.keys().then((keyList) => Promise.all(keyList.map((key) => caches.delete(key))));
    const EMPRESA_ID = <?php echo $empresaId; ?>;
    const ROL_ID = <?php echo json_encode($rol_id); ?>;
    const EVENT_STATUS_CHANGER = document.getElementById('statusMenuList-evl');

    function alertSomthings() {
        alert('SomeThing');
    }

    let init_date = (iDate) => {

        let date = new Date(iDate);
        date.setDate(date.getDate() + 1);
        return date;
    };
    let end_date = (eDate) => {
        let date = new Date(eDate);
        date.setDate(date.getDate() + 1);
        return date;
    };
    $(document).ready(async function() {

        createCalendar();


        // from apgeheaderbreadCrumb
        createBreadCrumb('eventList');
        // from pageheader/searchbar set input target
        searchInputTarget = $('#dash-event-table_filter')
        // .find('input[type="search"]');

        await getEvents(EMPRESA_ID);
        await getCalendarEvents();

        const ALL_MY_EVENTS = await getAllMyEvents(EMPRESA_ID);

        if (ALL_MY_EVENTS) {


            ALL_MY_EVENTS.wd.map((ev) => {
                _allProjectsToSearch.push(ev)
            })
            ALL_MY_EVENTS.woutd.map((ev) => {
                _allProjectsToSearch.push(ev)
            })
        }


    });

    $('#event_status').on('change', async function() {
        calendar.removeAllEvents();
        const STATUS_ID = $(this).val()
        if (STATUS_ID == null || STATUS_ID === "") {

            return
        }
        const CALENDAR_EVENTS = await getAllCalendarEvents(EMPRESA_ID, STATUS_ID);


        let purple = false
        _allCalendarEvents = CALENDAR_EVENTS.events.map(event => {
            let eventColor = '#36ABA9'
            if (!purple) {
                eventColor = '#8b5fd6'
            }
            purple = !purple
            return {
                title: event.nombre_proyecto,
                start: event.fecha_inicio,
                end: fixEndDateOnEvent(event.fecha_termino),
                url: `https://intecsoftware.tech/miEvento.php?event_id=${event.id}`,
                color: eventColor,
            }
        });

        renderCalendar(_allCalendarEvents);
    });

    let statusWasOpen = false;
    $(document).on('click',function(e){

        if($('#statusMenuList-evl').hasClass('active') && statusWasOpen){

            let target = $(this).closest('.optionLimiter');

            if(target.length === 0){
                EVENT_STATUS_CHANGER.classList.remove('active')
                statusWasOpen = false;
            }
            return 
        }

        statusWasOpen = true 
    })




    function generateExcelArray(projectArray) {
        let excelRowData = projectArray.map((evento) => {

            let phf = "No";
            let php = "No";
            let phv = "No";

            if (evento.phf == null) {
                phf = "No"
            } else {
                phf = "Sí"
            }
            if (evento.php == null) {
                php = "No"
            } else {
                php = "Sí"
            }
            if (evento.phv == null) {
                phv = "No"
            } else {
                phv = "Sí"
            }

            return [evento.nombre_proyecto,
                evento.estado,
                evento.fecha_inicio,
                evento.fecha_termino,
                evento.nombreCliente,
                evento.event_type,
                evento.income,
                evento.owner,
                phf,
                php,
                phv
            ]

        });

        let ws_data = ['Nombre Evento', 'Estado', 'Fecha Inicio', 'Fecha Termino', 'Cliente', 'Tipo Evento', 'Precio Venta', 'Owner', 'Inventario', 'Personal', 'Vehículos'];
        excelRowData.unshift(ws_data);

        return excelRowData;
    }

    $('#listview-tab').on('click', function() {
        getEvents(EMPRESA_ID);
    });
    $('#deletedEv-tab').on('click', function() {
        getDeletedEvents(EMPRESA_ID);
    });
    $('#calendarView-tab').on('click', function() {
        renderCalendar(_allCalendarEvents);
    });

    $('#exportToExcel').on('click', function() {

        var ws_name = "SheetJS";
        let excelArray = [];

        if (_filteredProjects.length > 0) {
            excelArray = generateExcelArray(_filteredProjects);
        } else {
            excelArray = generateExcelArray(_projectsToList);
        }

        let ws = XLSX.utils.aoa_to_sheet(excelArray);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        XLSX.writeFile(wb, "SheetJS.xlsx");
    });



    let selectedStatusId = 0;
    let selectedStatus = '';
    let selectedEventId = 0;
    let selectedEventStatusContainer ;
    let previousStatus = '' ;

    $(document).on('click', '.eventListRow td', function() {

        let closestTd = $(this).closest('td');

        const EVENT_ID = $(this).closest('tr').attr('evento_id');

        if (closestTd.hasClass('deleteEv-container')) {
            const EV_DATA = _allProjectsToSearch.find((event) => {
                return event.id === EVENT_ID
            })

            if (!EV_DATA) {
                return;
            }
            Swal.fire({
                icon: 'question',
                title: `¿Deseas eliminar el evento ${EV_DATA.nombre_proyecto}?`,
                text: 'Podrás ver, modificar y restaurar este evento por los proximos 30 días antes de que se elimine permanentemente',
                showCancelButton: false,
                showDenyButton: true,
                confirmButtonText: "Eliminar",
                denyButtonText: 'Conservar'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    deleteEvent(EMPRESA_ID, EVENT_ID);
                    $(this).closest('tr').remove();
                } else if (result.isDenied) {}
            })
            return
        }


        if(closestTd.hasClass('--ev-status-ch')){
            // return

            let eventId = closestTd.closest('tr').attr('event_id');
            selectedStatusId = 0;
            selectedStatus = '';
            selectedEventId = 0;
            previousStatus = '';
            selectedEventStatusContainer = $(this).find('p');
            previousStatus = $(this).find('p').attr('class').split(' ')[1];
            selectedEventId = EVENT_ID;

            let position = this.getBoundingClientRect();

            EVENT_STATUS_CHANGER.classList.add('active');
            
            EVENT_STATUS_CHANGER.style.top = `${position.top}px`;
            EVENT_STATUS_CHANGER.style.left = `${position.left}px`;
            EVENT_STATUS_CHANGER.style.right = `${position.right}px`;
            EVENT_STATUS_CHANGER.style.bottom = `${position.bottom}px`;

            // alert(`you are changing ther status of ${eventId}  this event`);
            return;
        };

        
        if(statusWasOpen){
            return;
        }

        project_id_to_search = EVENT_ID;
        window.location = `/miEvento.php?event_id=${EVENT_ID}`;
    });

    $(document).on('click','.event-status-btn',function(){
        selectedStatusId =  $(this).attr('status_id');
        let classList = $(this).attr('class').split(' ');

        selectedStatus = classList[1];


        // change front class on status container in selected event row
        console.log('previousStatus',previousStatus);
        $(selectedEventStatusContainer)
        .removeClass(previousStatus)
        .addClass(selectedStatus)
        .text(`${capitalizeFirstLetter(selectedStatus)}`);

        const EVENT_STATUS_RESPONSE = $.ajax({
            type: "POST",
            url: "ws/proyecto/proyecto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "updateEventStatusFromEventList",
                "status_id": selectedStatusId,
                "empresa_id": EMPRESA_ID,
                "event_id": selectedEventId
            }),
            success: function(response) {
                console.log(response)
            }
        })

       
    })

    $(document).on('click', '.deletedEvent td', function() {

        let closestTd = $(this).closest('td');

        const EVENT_ID = $(this).closest('tr').attr('evento_id');

        if (closestTd.hasClass('deleteEv-container')) {
            const EV_DATA = deletedEvents.find((event) => {
                return event.id == EVENT_ID
            });

            if (!EV_DATA) {
                return;
            }
            Swal.fire({
                icon: 'question',
                title: `¿Deseas conservar el evento ${EV_DATA.nombre_proyecto}?`,
                text: 'Este evento dejará de estar en tú lista de eliminados',
                showCancelButton: false,
                showDenyButton: true,
                confirmButtonText: "Devolver",
                denyButtonText: 'Cancelar'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    returnEventToList(EMPRESA_ID, EVENT_ID);
                    $(this).closest('tr').remove();
                } else if (result.isDenied) {}
            })
            return
        }

        // project_id_to_search = EVENT_ID;
        // window.location = `/miEvento.php?event_id=${EVENT_ID}`;
    });

    async function deleteEvent(empresa_id, event_id) {
        $.ajax({
            type: "POST",
            url: "ws/proyecto/proyecto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "deleteEvent",
                "empresa_id": empresa_id,
                "event_id": event_id
            }),
            success: function(response) {
                console.log(response)
            }
        })
    }
    async function returnEventToList(empresa_id, event_id) {
        $.ajax({
            type: "POST",
            url: "ws/proyecto/proyecto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "returnEventToList",
                "empresa_id": empresa_id,
                "event_id": event_id
            }),
            success: function(response) {
                console.log(response)
            }
        })
    }

    function filtrarPorRangoDeFechas(array, fechaInicio, fechaTermino) {
        return array.filter(function(item) {
            let fechaInicioItem = new Date(item.fecha_inicio);
            let fechaTerminoItem = new Date(item.fecha_termino);

            // Comparar si la fecha de inicio del item está dentro del rango
            let dentroDelRangoInicio = fechaInicioItem >= fechaInicio && fechaInicioItem <= fechaTermino;

            // Comparar si la fecha de término del item está dentro del rango
            let dentroDelRangoTermino = fechaTerminoItem >= fechaInicio && fechaTerminoItem <= fechaTermino;

            // Retornar verdadero si alguna de las fechas está dentro del rango
            return dentroDelRangoInicio || dentroDelRangoTermino;
        });
    }

    function createCalendar() {

        const options = {
            input: true,
            type: "multiple",
            settings: {
                range: {
                    disablePast: false
                },
                selection: {
                    day: "multiple-ranged"
                },
                visibility: {
                    daysOutside: false,
                    theme: 'light'
                }
            },
            actions: {
                clickDay(event, self) {
                    if (self.selectedDates[1]) {
                        self.selectedDates.sort((a, b) => +new Date(a) - +new Date(b))
                        self.HTMLInputElement.value = `${self.selectedDates[0]} — ${self.selectedDates[self.selectedDates.length - 1]}`
                        let filtered_dates = filtrarPorRangoDeFechas(_projectsToList, init_date(self.selectedDates[0]), end_date(self.selectedDates[self.selectedDates.length - 1]));
                        _filteredProjects = filtered_dates;
                        console.log('FILTRO DE EVENTOS PARA LAS FECHAS', _filteredProjects)
                        printAllProjects(filtered_dates);
                    } else if (self.selectedDates[0]) {
                        self.HTMLInputElement.value = self.selectedDates[0];
                        let filtered_dates = filtrarPorRangoDeFechas(_projectsToList, init_date(self.selectedDates[0]), init_date(self.selectedDates[0]));
                        _filteredProjects = filtered_dates;
                        console.log('FILTRO DE EVENTOS PARA LAS FECHAS', _filteredProjects)
                        printAllProjects(filtered_dates);
                    } else {
                        self.HTMLInputElement.value = ""
                        _filteredProjects = [];
                        console.log('FILTRO DE EVENTOS PARA LAS FECHAS', _filteredProjects)
                        printAllProjects(_projectsToList);

                    }

                },
                // changeToInput(e, calendar, self) {
                //     console.log(self)
                //     if (!self.HTMLInputElement) return;
                //     // console.log(self.selectedDates);
                // }
            }
        }

        const calendarInput = new VanillaCalendar("#calendarInput", options);

        calendarInput.init();
    }
</script>

<style>
    .calendar-container {
        height: 800px;
        width: 100%;
        background-color: white;
        border-radius: 10px;
        padding: 45px;
    }

    #allProjectTable-list_length {
        margin-bottom: 16px;
    }

    #allProjectTable-list_filter {
        margin-bottom: 16px;
        margin-right: 0px;

    }
</style>

</html>