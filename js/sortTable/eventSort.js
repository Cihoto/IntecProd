$(document).ready(function () {

    const event_status_order = [2, 3, 5, 4, 1,6];
    let future_search = false;
    $('#sortAllMyEvents').on('click', async function () {

        if (future_search === true) {
            await getEvents(EMPRESA_ID);
            $(this).find('p').text("Todos")
            future_search = false
            return
        }

        const allMyEvents = await getAllMyEvents(EMPRESA_ID);
        if (allMyEvents) {

            console.log(allMyEvents);

            let mergedArray = [];
            const ordered_events = event_status_order.map((order) => {
                const ordStatus = allMyEvents.wd.filter((event) => {
                    return parseInt(event.estado_id) === order
                });
                return ordStatus
            })
            // console.log(ordered_events)

            ordered_events.forEach(ordered => {
                ordered.forEach(element => {
                    mergedArray.push(element);
                });
            });

            allMyEvents.woutd.forEach((woutd_event) => {
                mergedArray.push(woutd_event);
            })

            // console.log(mergedArray);

            _projectsToList = mergedArray;
            _projectListBackup = mergedArray;
            future_search = true
            $(this).find('p').text("Futuros")
            printAllProjects(_projectsToList);
        }
    });


    $('#sortDrafEvents').on('click', async function () {
        const ALL_DRAFT_EVENTS = await getEventByStatus_id(EMPRESA_ID, 1);
        if (!ALL_DRAFT_EVENTS) {
            return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortSells').on('click', async function () {
        const ALL_DRAFT_EVENTS = await getSellsEvents(EMPRESA_ID);
        if (!ALL_DRAFT_EVENTS) {
            return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortOperationalEvents').on('click', async function () {
        const ALL_DRAFT_EVENTS = await getOperEvents(EMPRESA_ID);
        if (!ALL_DRAFT_EVENTS) {
            return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortAdmEvents').on('click', async function () {
        const ALL_DRAFT_EVENTS = await getAdmEvents(EMPRESA_ID);
        if (!ALL_DRAFT_EVENTS) {
            return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS,true);
    })
})


function setEventsAndPrintOnTable(allEventsOnRange,isAdmSort) {
    _projectsToList = [];
    _projectListBackup = [];

    allEventsOnRange.wd.forEach((evento) => {
        _projectsToList.push(evento);
        _projectListBackup.push(evento);
    });
    
    allEventsOnRange.woutd.forEach((evento) => {
        _projectsToList.push(evento);
        _projectListBackup.push(evento);
    });

    if(isAdmSort !== undefined){
        printAllProjects(_projectsToList,true);
    }else{
        printAllProjects(_projectsToList);
    }
}


async function getAllMyEvents(empresa_id) {
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getAllMyEvents",
                'empresa_id': empresa_id,
            }),
            dataType: 'json',
            success: function (response) {
                // console.log("RESPONSE  getAllMyEvents", response);
            },
            error: function (response) {
                // console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}
async function getAllMyEvents_notDeleted(empresa_id) {

    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            'action': "getAllMyEvents_notDeleted",
            'empresa_id': empresa_id,
        }),
        dataType: 'json',
        success: function (response) {
            console.log("RESPONSE  getAllMyEvents", response);
        },
        error: function (response) {
            console.log(response.responseText);
        }
    })
}

async function getAllCalendarEvents(empresa_id,status_id) {

    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            'action': "getAllCalendarEvents",
            'empresa_id': empresa_id,
            'status_id': status_id,
        }),
        dataType: 'json',
        success: function (response) {
            console.log("RESPONSE  getAllCalendarEvents", response);
        },
        error: function (response) {
            console.log(response.responseText);
        }
    })
}


async function getEventByStatus_id(empresa_id, status_id) {
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getEventByStatus_id",
                'empresa_id': empresa_id,
                'status_id': status_id
            }),
            dataType: 'json',
            success: function (response) {
                // console.log("RESPONSE  getEventByStatus_id", response);
            },
            error: function (response) {
                // console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }

}

async function getSellsEvents(empresa_id) {
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getSellsEvents",
                'empresa_id': empresa_id
            }),
            dataType: 'json',
            success: function (response) {
                // console.log("RESPONSE  getSellsEvents", response);
            },
            error: function (response) {
                // console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}
async function getOperEvents(empresa_id) {
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getOperEvents",
                'empresa_id': empresa_id
            }),
            dataType: 'json',
            success: function (response) {
                // console.log("RESPONSE  getOperEvents", response);
            },
            error: function (response) {
                // console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}
async function getAdmEvents(empresa_id) {
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getAdmEvents",
                'empresa_id': empresa_id
            }),
            dataType: 'json',
            success: function (response) {
                console.log("RESPONSE  getAdmEvents", response);
            },
            error: function (response) {
                console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}


// DASHBOARD SECTION
async function getEventsDashboard(empresa_id) {
    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            'action': "getAllMyProjects_list_toExecute",
            'empresa_id': empresa_id
        }),
        dataType: 'json',
        success: function (response) {
            // console.log(response)
            _dashEvents = response;
        },
        error: function (response) {
            // console.log(response.responseText);
        }
    })
}

function getEventsForDashboard(request,empresa_id){
    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            'action': "getEventsForDashboard",
            'request': request,
            "empresa_id":empresa_id
        }),
        dataType: 'json',
        success: function (response) {
        },
        error: function (response) {
        }
    })
}


let _dashEvents = [];

function printNoEventsAvailableDash() {
    const table = $('#dash-event-table')

    let tr = `<tr style="justify-content:center;">
        <td style="padding:16px;border:none;">Sin eventos disponibles</td> 
    </tr>`

    table.append(tr);
}


let table = "";
function printEventOnDashTable() {

    // const table =  $('#dash-event-table');
    // $('#dash-event-table tbody tr').remove();

    if (!$.fn.DataTable.isDataTable('#dash-event-table')) {

        table = new DataTable('#dash-event-table', {
            "paging": true,
            "autoWidth":false,
            scrollY: '230px',
            lengthMenu: [5, 8, 10, 20,50,100],
            columnDefs: [ 
                { "defaultContent": "", "targets": "_all" }
                // { "width" : "147px", "targets": "_all"}
            ],
            // "columns":[
            //     { "width": "147px" },
            //     { "width": "147px" },
            //     { "width": "147px" },
            //     { "width": "147px" }
            // ]

        })

    }else{
        table
        .rows()
        .remove()
        .draw();
        // table.clear();
    }

    // if ( $.fn.DataTable.isDataTable( '#dash-event-table' ) ) {
    //     $('#dash-event-table').Datatable().destroy();
    // }
    
    _dashEvents.forEach((evento) => {
        // console.log(evento)

        if(evento.estado == null){
            evento.estado = "borrador"
        }
        if(evento.estado_id === 1){
            
        }
        if(evento.estado_id === 2){
            color = "#27AE60"
        }
        if(evento.estado_id === 3){
            color = "#7F45E3"
        }
        
        if(evento.address === null){ 
            evento.address = ""
        }

        if(evento.direccion == null){evento.direccion =""}

        table.row
            .add([
                evento.nombre_proyecto,
                evento.fecha_inicio,
                `<p><img src="./assets/svg/location.svg" alt=""> ${evento.address}</p>`,
                `<p class="event-status ${evento.estado}">${ evento.estado[0].toUpperCase()}${evento.estado.slice(1)}</p>`
            ])
            .draw(false)
    });


    
}



