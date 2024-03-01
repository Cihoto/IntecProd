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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="txtDec-no" href="./proximosEventos.php"><img src="./assets/svg/Eventos.svg" alt=""> Eventos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a class="txtDec-no" href="#">Listado de eventos</a></li>
                    </ol>
                </nav>
                <p class="headerTitle">Listado de eventos</p>
            </header>

            <div class="pageContent">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="listview-tab" data-bs-toggle="tab" href="#listview" role="tab" aria-controls="listview" aria-selected="true">Lista</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="calendar-tab" data-bs-toggle="tab" href="#calendar" role="tab" aria-controls="calendar" aria-selected="false">Calendario</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="deletedEv-tab" data-bs-toggle="tab" href="#deletedEv" role="tab" aria-controls="deletedEv" aria-selected="false">Eliminados</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active tab-data" id="listview" role="tabpanel" aria-labelledby="listview-tab">
                        <div class="formHeader d-flex justify-content-start" style="margin-top: 8px;">
                            <svg style="margin-top: 4px;" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="6" fill="#069B99" />
                            </svg>
                            <p class="header-P">Aquí puedes ver y editar tus eventos</p>
                        </div>

                        <div style="display: flex; justify-content: space-between;margin-left: 0px;margin-bottom: -16px;gap: 10px;width: 100%;">

                            <div class="row" style="margin-left: 0px;margin-bottom: -16px;gap: 10px;width: 100%;">

                                <!-- <button class="s-Button-w">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                        <path d="M17 2.75H2L8 9.845V14.75L11 16.25V9.845L17 2.75Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="s-P-g">Filtros</p>
                                </button> -->
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
                                <input readonly type="text" id="calendar-input" style="width: 250px;height: 40px;border-radius: 4px;" placeholder="filtrar por fecha">
                            </div>

                            <div style="display: flex;gap: 16px;flex-direction: column;margin-top: -55px;">
                                <!-- <button class="s-Button-w" style="width: 175px;position: absolute;right: 158px;" id="exportToExcel">
                                    <p class="s-P-g">Exportar Excel</p>
                                </button> -->

                                <button class="s-Button-w" id="exportToExcel" style="width: 140px;">
                                    <p class="s-P-g">Exportar Excel</p>
                                </button>
                                <button class="s-Button" id="openModalNewFree" style="width: 140px;">
                                    <p class="s-P"><a href="./miEvento.php" style="color: white;text-decoration: none;">Crear evento</a></p>
                                </button>
                            </div>
                        </div>

                        <div style="display: block;overflow-x: auto;">
                            <table class="" id="allProjectTable-list">
                                <thead>
                                    <tr>

                                        <th>
                                            <p>Evento</p>
                                        </th>
                                        <th>
                                            <p>Estado</p>
                                        </th>
                                        <th>
                                            <p>Fecha</p>
                                            <!-- <img src="./assets//svg/calendar.svg" alt="" style="margin-right: 10px;"> -->
                                        </th>
                                        <th>
                                            <p>Cliente</p>
                                        </th>
                                        <th>
                                            <p>Tipo de evento</p>
                                        </th>
                                        <th>
                                            <p>Precio venta</p>
                                        </th>
                                        <th>
                                            <p>Owner</p>
                                        </th>
                                        <th>
                                            <p>Asignación</p>
                                        </th>
                                        <th>
                                            <p>Facturación</p>
                                        </th>
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
                    <div class="tab-pane fade tab-data" id="calendar" role="tabpanel" aria-labelledby="calendar-tab" style="margin: 15px; height: 100%;">
                        <div class="calendar-container">
                            <div id='calendar'></div>
                        </div>
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
                                            <p>Estado</p>
                                        </th>
                                        <th>
                                            <p>Fecha</p>
                                            <!-- <img src="./assets//svg/calendar.svg" alt="" style="margin-right: 10px;"> -->
                                        </th>
                                        <th>
                                            <p>Cliente</p>
                                        </th>
                                        <th>
                                            <p>Tipo de evento</p>
                                        </th>
                                        <th>
                                            <p>Precio venta</p>
                                        </th>
                                        <th>
                                            <p>Owner</p>
                                        </th>
                                        <th>
                                            <p>Asignación</p>
                                        </th>
                                        <th>
                                            <p>Facturación</p>
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
</body>

<script src="/js/eventList.js"></script>
<script src="/js/calendar.js"></script>
<script src="./js/const/projectToSearch.js"></script>
<script src="./js/sortTable/eventSort.js"></script>
<script src="./js/valuesValidator/validator.js"></script>

<script>
    caches.keys().then((keyList) => Promise.all(keyList.map((key) => caches.delete(key))));
    const EMPRESA_ID = <?php echo $empresaId; ?>;
    const ROL_ID = <?php echo json_encode($rol_id); ?>;



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

        createCalendar();
    });




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
    $('#calendar-tab').on('click', function() {
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
    })

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

        project_id_to_search = EVENT_ID;
        window.location = `/miEvento.php?event_id=${EVENT_ID}`;
    });

    $(document).on('click', '.deletedEvent td', function() {

        let closestTd = $(this).closest('td');

        const EVENT_ID = $(this).closest('tr').attr('evento_id');

        console.log(closestTd);

        if (closestTd.hasClass('deleteEv-container')) {

            const EV_DATA = _allProjectsToSearch.find((event) => {
                return event.id === EVENT_ID
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
                changeToInput(e, calendar, self) {
                    if (!self.HTMLInputElement) return
                    if (self.selectedDates[1]) {
                        self.selectedDates.sort((a, b) => +new Date(a) - +new Date(b))
                        self.HTMLInputElement.value = `${self.selectedDates[0]} — ${self.selectedDates[self.selectedDates.length - 1]}`
                        let filtered_dates = filtrarPorRangoDeFechas(_projectsToList, init_date(self.selectedDates[0]), end_date(self.selectedDates[self.selectedDates.length - 1]));
                        _filteredProjects = filtered_dates;
                        printAllProjects(filtered_dates);
                    } else if (self.selectedDates[0]) {
                        self.HTMLInputElement.value = self.selectedDates[0];
                        let filtered_dates = filtrarPorRangoDeFechas(_projectsToList, init_date(self.selectedDates[0]), init_date(self.selectedDates[0]));
                        _filteredProjects = filtered_dates;
                        printAllProjects(filtered_dates);
                    } else {
                        self.HTMLInputElement.value = ""
                        _filteredProjects = [];
                        printAllProjects(_projectsToList);

                    }
                }
            }
        }

        const calendarInput = new VanillaCalendar("#calendar-input", options)
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
</style>

</html>