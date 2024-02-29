let _projectsToList = [];
let _projectListBackup = [];
let _filteredProjects = [];

async function getEvents(empresa_id) {
    $.ajax({
        type: "POST",
        url: "ws/proyecto/proyecto.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getAllMyProjects_list_toExecute",
            "empresa_id": empresa_id,
            "status": 1
        }),
        success: function (response) {
            console.log(response)
            _projectsToList = response;
            _projectListBackup = response;
            // console.log(_projectsToList)
            printAllProjects(_projectsToList);
        }
    })
}

let tableEventList;
async function printAllProjects(_projectList) {

    // const table = $('#allProjectTable-list').DataTable();

    if ($.fn.DataTable.isDataTable('#allProjectTable-list')) {
        // $('#allProjectTable-list').DataTable()
        //     .clear()
        //     .draw();
        $('#allProjectTable-list').DataTable()
        .clear()
        .draw();
        $('#allProjectTable-list').DataTable().destroy();
    }


    _projectList.forEach((evento) => {
        let color = "";
        let phf = "";
        let php = "";
        let phv = "";

        if (evento.phf == null) {
            phf = `<img src="./assets/svg/ArchiveNoActive.svg" alt="">`;
        } else {
            phf = `<img src="./assets/svg/ArchiveActive.svg" alt="">`
        }
        if (evento.php == null) {
            php = `<img src="./assets/svg/PersonalNoActive.svg" alt="">`;
        } else {
            php = `<img src="./assets/svg/PersonalActive.svg" alt="">`
        }
        if (evento.phv == null) {
            phv = `<img src="./assets/svg/VehicleNoActive.svg" alt="">`;
        } else {
            phv = `<img src="./assets/svg/VehicleActive.svg" alt="">`
        }

        if (evento.estado == null) {
            evento.estado = "borrador"
        }
        if (evento.estado_id === 1) {

        }
        if (evento.estado_id === 2) {
            color = "#27AE60"
        }
        if (evento.estado_id === 3) {
            color = "#7F45E3"
        }

        if (evento.nombreCliente === null) {
            evento.nombreCliente = ""
        }

        // let estadoStyle = '<p style =""></p>'
        //     let trs = `<tr project_id=${evento.id}>
        //     <td><p> ${evento.nombre_proyecto}</p></td>
        //     <td><p class="p-estado" style="border-radius:10px; background-color:${color};">${evento.estado}</p></td>
        //     <td><p>${evento.fecha_inicio}</p></td>
        //     <td><p >${evento.nombreCliente}</p></td>
        //     <td>Tipo de evento</td>
        //     <td>Precio venta</td>
        //     <td>Owner</td>
        //   </tr>`

        let nombreCliente = '';
        if (evento.nombre_fantasia !== null) {
            nombreCliente = evento.nombre_fantasia
        } else {
            nombreCliente = evento.nombreCliente
        }
        let dateToFormatt = new Date(evento.fecha_inicio);
        let timeStamp = dateToFormatt.getTime()/1000 
        // console.log(dateToFormatt.getTime()/1000)
        // console.log(dateToFormatt.getTime()/1000)

        let tr = `<tr evento_id="${evento.id}" class="eventListRow">
            <td class="deleteEv-container">
                <img src="./assets/svg/trashCan.svg" alt="">
            </td>
            <td>
                <div class="-eve-list-inf-ctn">
                    <p class="event-name"> ${evento.nombre_proyecto} </p>
                    <button class="commentContainer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M15.75 8.62502C15.7526 9.61492 15.5213 10.5914 15.075 11.475C14.5458 12.5338 13.7323 13.4244 12.7256 14.047C11.7189 14.6696 10.5587 14.9996 9.375 15C8.3851 15.0026 7.40859 14.7713 6.525 14.325L2.25 15.75L3.675 11.475C3.2287 10.5914 2.99742 9.61492 3 8.62502C3.00046 7.44134 3.33046 6.28116 3.95304 5.27443C4.57562 4.26771 5.46619 3.4542 6.525 2.92502C7.40859 2.47872 8.3851 2.24744 9.375 2.25002H9.75C11.3133 2.33627 12.7898 2.99609 13.8969 4.10317C15.0039 5.21024 15.6638 6.68676 15.75 8.25002V8.62502Z" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </td>
            <td> <p class="event-status ${evento.estado}">${evento.estado[0].toUpperCase()}${evento.estado.slice(1)}</p> </td>
            <td data-order="${timeStamp}"> <p>${getEventListDate(evento.fecha_inicio,evento.fecha_termino)}</p> </td>
            <td> <p class="event-client-name">${nombreCliente}</p> </td>
            <td> <p class="event-name">${evento.event_type === null ? "" : evento.event_type}</p> </td>
            <td> <p>${CLPFormatter(evento.income)}</p> </td>
            <td> <p class="event-name" >${evento.owner === null ? "" : evento.owner}</p> </td>
            <td>

                <div class="-eve-list-inf-ctn">
                    <button class="buttonEventList">
                        ${phf}
                    </button>
                    <button class="buttonEventList">
                        ${php}
                    </button>
                    <button class="buttonEventList">
                        ${phv}
                    </button>
                </div>
            </td>
            <td style="display:flex;justify-content:space-between;">            
                <button class="buttonEventList">
                    <img src="./assets/svg/dollar-sign-inactive.svg" alt="">
                </button>
                <button class="buttonEventList">
                    <img src="./assets/svg/paperclip.svg" alt="">
                </button>
            </td> 
        </tr>`

        $('#allProjectTable-list tbody').append(tr);
        // tableEventList.row.add($(tr)).draw();
    });


    
    tableEventList = $('#allProjectTable-list').DataTable({
        responsive: true,
        sort:true,
        columnDefs: [
        {width: '2%', targets: [0]},
        {width: '10%', targets: [1] },
        {width: '15%', targets: [3]},
        {width: '10%', targets: [4]},
        { width: '15%', targets: [7] },
        {width: '1%', targets: [9]},
    ]
    });
    // if (!$.n.DataTable.isDataTable('#allProjectTable-list')){

    // }

        // $('#allProjectTable-list').DataTable({
        //     responsive: true,
        //     columnDefs: [{ width: '10%', targets: 0 }]
        // })
        // $('#allProjectTable-list').DataTable({
        //     order: [[2, 'asc']],
        //     language: {
        //         "decimal": "",
        //         "emptyTable": "No hay información",
        //         "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        //         "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        //         "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        //         "infoPostFix": "",
        //         "thousands": ",",
        //         "lengthMenu": "Mostrar _MENU_ Eventos",
        //         "loadingRecords": "Cargando...",
        //         "processing": "Procesando...",
        //         "search": "Buscar:",
        //         "zeroRecords": "Sin resultados encontrados",
        //         "paginate": {
        //           "first": "Primero",
        //           "last": "Ultimo",
        //           "next": "Siguiente",
        //           "previous": "Anterior"
        //         }
        //     }
        // })
    // }

    // $("#allProjectTable-list_length select").change();
    // $("#allProjectTable-list_length select option[value=25]").attr('selected','selected');

}



function subDayToDate(date,daysToSub){

    let tempday = new Date(date);
    tempday.setDate(tempday.getDate() - daysToSub);
    return tempday;

};

function getEventListDate(initDate,finishDate){



    if(initDate === '' || initDate === null){
        return '';
    }
    const EVENT_DATE_INIT = new Date(initDate);
    const EVENT_DATE_FINISH = new Date(finishDate);

    const DATE_OPTIONS_DAYNAME_LONG = {
        weekday: "long"
    }
    const DATE_OPTIONS_DAY = {
        day: "numeric"
    }
    const MONTH_OPTIONS = { 
        month: 'short'
    };

    let fullDay = EVENT_DATE_INIT.toLocaleDateString("es-Cl", DATE_OPTIONS_DAYNAME_LONG);
    let dateNumber_init = EVENT_DATE_INIT.toLocaleDateString("es-Cl", DATE_OPTIONS_DAY);
    let month_init = EVENT_DATE_INIT.toLocaleDateString("es-Cl", MONTH_OPTIONS);
    dateNumber_init = parseInt(dateNumber_init) + 1;

    if(finishDate === '' || finishDate === null){
        return `${dateNumber_init} ${month_init}`;
    }

    let dateNumber_finish = EVENT_DATE_FINISH.toLocaleDateString("es-Cl", DATE_OPTIONS_DAY);
    let month_finish = EVENT_DATE_FINISH.toLocaleDateString("es-Cl", MONTH_OPTIONS);

    dateNumber_finish = parseInt(dateNumber_finish) + 1;

    if(initDate === finishDate){
        return `${dateNumber_init} ${month_init}`;
    }
    if(month_init === month_finish){
        return `${dateNumber_init}, ${dateNumber_finish} ${month_init}`;
    }
    if(initDate !== finishDate){
        return `${dateNumber_init} ${month_init}, ${dateNumber_finish} ${month_finish}`;
    }
}

// $(document).on('mouseover','.evDate',function(){

//     const EVENT_ID = $(this).closest('tr').attr('evento_id');

//     const EVENT_DATA = _projectsToList.find((event)=>{
//         return event.id === EVENT_ID
//     });

//     if(!EVENT_DATA){
//         return false;
//     };

//     // console.log('EVENT_DATA',EVENT_DATA);
//     console.log(new Date(EVENT_DATA.fecha_inicio));
//     const EVENT_DATE_INIT = new Date(EVENT_DATA.fecha_inicio);

//     const DATE_OPTIONS_DAYNAME_LONG = {
//         weekday: "long"
//     }
//     const DATE_OPTIONS_DAY = {
//         day: "numeric"
//     }
//     const MONTH_OPTIONS = { 
//         month: 'short'
//     };

//     let fullDay = EVENT_DATE_INIT.toLocaleDateString("es-Cl", DATE_OPTIONS_DAYNAME_LONG);
//     let dateNumber = EVENT_DATE_INIT.toLocaleDateString("es-Cl", DATE_OPTIONS_DAY);
//     let month = EVENT_DATE_INIT.toLocaleDateString("es-Cl", MONTH_OPTIONS);

//     console.log( parseInt(dateNumber)+ 1);
//     console.log(fullDay);
//     console.log(month);

// });


async function getDeletedEvents(empresa_id) {
    $.ajax({
        type: "POST",
        url: "ws/proyecto/proyecto.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getDeletedEvents",
            "empresa_id": empresa_id
        }),
        success: function (response) {
            console.log(response)

            // console.log(_projectsToList)
            printDeletedEvents(response);
        }
    })
}

async function printDeletedEvents(_DeletedprojectList) {

    // const table = $('#allProjectTable-list').DataTable();

    if ($.fn.DataTable.isDataTable('#deletedEventsTable-list')) {
        $('#deletedEventsTable-list').DataTable()
            .clear()
            .draw();
        // $('#allProjectTable-list').DataTable()
        // .clear()
        // .draw();
        // $('#allProjectTable-list').DataTable().destroy();
    } else {

    }


    _DeletedprojectList.forEach((evento) => {
        let color = "";
        let phf = "";
        let php = "";
        let phv = "";

        if (evento.phf == null) {
            phf = `<img src="./assets/svg/ArchiveNoActive.svg" alt="">`;
        } else {
            phf = `<img src="./assets/svg/ArchiveActive.svg" alt="">`
        }
        if (evento.php == null) {
            php = `<img src="./assets/svg/PersonalNoActive.svg" alt="">`;
        } else {
            php = `<img src="./assets/svg/PersonalActive.svg" alt="">`
        }
        if (evento.phv == null) {
            phv = `<img src="./assets/svg/VehicleNoActive.svg" alt="">`;
        } else {
            phv = `<img src="./assets/svg/VehicleActive.svg" alt="">`
        }

        if (evento.estado == null) {
            evento.estado = "borrador"
        }
        if (evento.estado_id === 1) {

        }
        if (evento.estado_id === 2) {
            color = "#27AE60"
        }
        if (evento.estado_id === 3) {
            color = "#7F45E3"
        }

        if (evento.nombreCliente === null) {
            evento.nombreCliente = ""
        }

        // let estadoStyle = '<p style =""></p>'
        //     let trs = `<tr project_id=${evento.id}>
        //     <td><p> ${evento.nombre_proyecto}</p></td>
        //     <td><p class="p-estado" style="border-radius:10px; background-color:${color};">${evento.estado}</p></td>
        //     <td><p>${evento.fecha_inicio}</p></td>
        //     <td><p >${evento.nombreCliente}</p></td>
        //     <td>Tipo de evento</td>
        //     <td>Precio venta</td>
        //     <td>Owner</td>
        //   </tr>`

        let nombreCliente = '';
        if (evento.nombre_fantasia !== null) {
            nombreCliente = evento.nombre_fantasia
        } else {
            nombreCliente = evento.nombreCliente
        }
        let dateToFormatt = new Date(evento.fecha_inicio);
        let timeStamp = dateToFormatt.getTime()/1000 
        // console.log(dateToFormatt.getTime()/1000)
        // console.log(dateToFormatt.getTime()/1000)

        let tr = `<tr evento_id="${evento.id}" class="deletedEvent">
            <td class="deleteEv-container">
                <i style="color:#069B99;" class="fa-solid fa-rotate-left"></i>
            </td>
            <td>
                <div class="-eve-list-inf-ctn">
                    <p class="event-name"> ${evento.nombre_proyecto} </p>
                    <button class="commentContainer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M15.75 8.62502C15.7526 9.61492 15.5213 10.5914 15.075 11.475C14.5458 12.5338 13.7323 13.4244 12.7256 14.047C11.7189 14.6696 10.5587 14.9996 9.375 15C8.3851 15.0026 7.40859 14.7713 6.525 14.325L2.25 15.75L3.675 11.475C3.2287 10.5914 2.99742 9.61492 3 8.62502C3.00046 7.44134 3.33046 6.28116 3.95304 5.27443C4.57562 4.26771 5.46619 3.4542 6.525 2.92502C7.40859 2.47872 8.3851 2.24744 9.375 2.25002H9.75C11.3133 2.33627 12.7898 2.99609 13.8969 4.10317C15.0039 5.21024 15.6638 6.68676 15.75 8.25002V8.62502Z" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </td>
            <td> <p class="event-status ${evento.estado}">${evento.estado[0].toUpperCase()}${evento.estado.slice(1)}</p> </td>
            <td data-order="${timeStamp}"> <p>${getEventListDate(evento.fecha_inicio,evento.fecha_termino)}</p> </td>
            <td> <p class="event-client-name">${nombreCliente}</p> </td>
            <td> <p class="event-name">${evento.event_type === null ? "" : evento.event_type}</p> </td>
            <td> <p>${CLPFormatter(evento.income)}</p> </td>
            <td> <p class="event-name" >${evento.owner === null ? "" : evento.owner}</p> </td>
            <td>

                <div class="-eve-list-inf-ctn">
                    <button class="buttonEventList">
                        ${phf}
                    </button>
                    <button class="buttonEventList">
                        ${php}
                    </button>
                    <button class="buttonEventList">
                        ${phv}
                    </button>
                </div>
            </td>
            <td style="display:flex;justify-content:space-between;">            
                <button class="buttonEventList">
                    <img src="./assets/svg/dollar-sign-inactive.svg" alt="">
                </button>
                <button class="buttonEventList">
                    <img src="./assets/svg/paperclip.svg" alt="">
                </button>
            </td> 
        </tr>`

        $('#deletedEventsTable-list tbody').append(tr);
        // tableEventList.row.add($(tr)).draw();
    });


    
    tableEventList = $('#deletedEventsTable-list').DataTable({
        responsive: true,
        sort:true,
        columnDefs: [
        {width: '2%', targets: [0]},
        {width: '10%', targets: [1] },
        {width: '15%', targets: [3]},
        {width: '10%', targets: [4]},
        { width: '15%', targets: [7] },
        {width: '1%', targets: [9]},
    ]
    });
    // if (!$.fn.DataTable.isDataTable('#allProjectTable-list')) {
    // }

        // $('#allProjectTable-list').DataTable({
        //     responsive: true,
        //     columnDefs: [{ width: '10%', targets: 0 }]
        // })
        // $('#allProjectTable-list').DataTable({
        //     order: [[2, 'asc']],
        //     language: {
        //         "decimal": "",
        //         "emptyTable": "No hay información",
        //         "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        //         "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        //         "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        //         "infoPostFix": "",
        //         "thousands": ",",
        //         "lengthMenu": "Mostrar _MENU_ Eventos",
        //         "loadingRecords": "Cargando...",
        //         "processing": "Procesando...",
        //         "search": "Buscar:",
        //         "zeroRecords": "Sin resultados encontrados",
        //         "paginate": {
        //           "first": "Primero",
        //           "last": "Ultimo",
        //           "next": "Siguiente",
        //           "previous": "Anterior"
        //         }
        //     }
        // })
    // }

    // $("#allProjectTable-list_length select").change();
    // $("#allProjectTable-list_length select option[value=25]").attr('selected','selected');

}



