let _projectsToList = [];
let _projectListBackup = [];
let _filteredProjects = [];
let _allProjectsToSearch = [];

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
async function printAllProjects(_projectList,isAdmSort) {

    let sort = [1,'asc']
    console.log('_isAdmSort',isAdmSort);
    console.log('_isAdmSort',isAdmSort);
    if(isAdmSort !== undefined){
        sort = [1,'desc']
    }

    if ($.fn.DataTable.isDataTable('#allProjectTable-list')) {

        $('#allProjectTable-list tbody tr').remove();
        $('#allProjectTable-list').DataTable()
            .clear()
            .draw();

        $('#allProjectTable-list')
            .DataTable()
            .destroy();
    }

    _projectList.forEach((evento) => {
        let color = "";
        
        let phf = "";
        let php = "";
        let phv = "";
        let ehc = "";
        let ehf = "";

        let eventOwner = "";
        if(evento.owner !== null){

            let eventOwnerArray = evento.owner.split(' ');

            if(eventOwnerArray.length > 1){
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}${eventOwnerArray[1][0].toUpperCase()}`
            }else{
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}`
            }
        }

        if(evento.event_has_comment == null){
            ehc = `<img src="./assets/svg/commentNoActive.svg" alt="">`
        }else{
            ehc = `<img src="./assets/svg/commentActive.svg" alt="">`
        }

        if(evento.phf == null){
            ehf = `<img src="./assets/svg/paperclip.svg" alt="">`
        }else{
            ehf = `<img src="./assets/svg/paperclip-active.svg" alt="">`
        }

        if (evento.event_has_inventory == null) {
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


        let eventStatus = evento.estado;

        if (evento.estado == null) {
            evento.estado = "borrador"
        }
        if (evento.estado == 'No va') {
            evento.estado = "No_va"
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
        let timeStamp = dateToFormatt.getTime() / 1000
        // console.log(dateToFormatt.getTime()/1000)
        // console.log(dateToFormatt.getTime()/1000)

        let tr = `<tr evento_id="${evento.id}" class="eventListRow">
            <td>
                <div class="-eve-list-inf-ctn">
                    <p class="--h-text-flex-20"> ${evento.nombre_proyecto}</p>
                    <div class="--ev-assigments-container">

                        <button class="commentContainer">
                            ${ehc}
                        </button>
                        <button class="buttonEventList">
                            ${ehf}
                        </button>
                    </div>
                </div>
            </td>
            <td data-order="${timeStamp}"><p class="--eventDates-evl">${getEventListDate(evento.fecha_inicio, evento.fecha_termino)}</p> </td>
            <td class="--ev-status-ch"> <p class="event-status ${evento.estado}">${eventStatus[0].toUpperCase()}${eventStatus.slice(1)}</p> </td>
            <td class="ownerCircleContainer"> <div class="ownerCircle"> <p>${eventOwner}</p> </div> </td>
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
           
            <td><p class="">${CLPFormatter(evento.income)}</p> </td>
            <td> <p class="event-client-name">${nombreCliente}</p> </td>
            <td> <p class="--h-text">${evento.event_type === null ? "" : evento.event_type}</p> </td>
         
            <td class="deleteEv-container">
                <img src="./assets/svg/trashCan-red.svg" alt="">
            </td>
        </tr>`

        $('#allProjectTable-list tbody').append(tr);
        // tableEventList.row.add($(tr)).draw();
    });
    if (!$.fn.DataTable.isDataTable('#allProjectTable-list')) {


        tableEventList = $('#allProjectTable-list').DataTable({
            sort: true,
            responsive: true,
            order: sort,
            pageLength: 100,
            columns:[
                { width: '20%' },
                { width: '10%' },
                { width: '10%' },
                { width: '6%' },
                { width: '10%' },
                { width: '5%' },
                { width: '4%' },
                { width: '8%' },
                { width: '1%' }
            ],
                // columnDefs: [
                //     // {width: '20%', targets: [0]},
                //     // {width: '10%', targets: [1]},
                //     // {width: '10%', targets: [2]},
                //     // {width: '6%', targets: [3]},
                //     // {width: '10%', targets: [4]},
                //     // {width: '5%', targets: [5]},
                //     // {width: '4%', targets: [6]},
                //     // {width: '8%', targets: [7]},
                //     // // {width: '8%', targets: [8]},
                //     // {width: '1%', targets: [8]}
                //     {width: '30%', targets: [0]},
                //     // {width: '%', targets: [1]},
                //     // {width: '%', targets: [2]},
                //     // {width: '%', targets: [3]},
                //     // {width: '%', targets: [4]},
                //     // {width: '%', targets: [5]},
                //     // {width: '%', targets: [6]},
                //     // {width: '%', targets: [7]},
                //     // {width: '8%', targets: [8]},
                //     {width: '1%', targets: [8]}
                // ],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Eventos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
                }
            }
        });

        // from pageheader/searchbar set input target
        searchInputTarget = tableEventList;

    }
}


function subDayToDate(date, daysToSub) {

    let tempday = new Date(date);
    tempday.setDate(tempday.getDate() - daysToSub);
    return tempday;

};

function getEventListDate(initDate, finishDate) {

    moment.lang('es', {
        months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
        monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
        weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
        weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
        weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
      }
    );

    console.log(initDate);
    console.log(finishDate);
    console.log(moment(initDate).isValid());
    console.log('moment(finishDate).isValid()',moment('0000-00-00').isValid());


    let initIsValid = moment(initDate).isValid(); 
    let finishIsValid = moment(finishDate).isValid();

    if(!initIsValid && !finishIsValid){
        return '';
    }

    const INIT_DATE = moment(initDate);
    const FINISH_DATE = moment(finishDate);

    console.log('lolg',INIT_DATE)
    console.log('lolg',FINISH_DATE)
    
    let initMonth= INIT_DATE.format('MMM');
    let initDay= INIT_DATE.format('DD');
    console.log('lolg',initMonth)
    console.log('lolg',initDay)

    let finishMonth= FINISH_DATE.format('MMM');
    let finishDay= FINISH_DATE.format('DD');

    if(moment(INIT_DATE).format('YYYY-MM-DD')  === moment(FINISH_DATE).format('YYYY-MM-DD')){
        return `${initMonth}-${initDay}`
    }

    if(moment(INIT_DATE).format('YYYY-MM-DD')  !== moment(FINISH_DATE).format('YYYY-MM-DD')){
        return `${initMonth}-${initDay}, ${finishMonth}-${finishDay}`
    }
    if (initMonth === finishMonth) {
        return `${initDay}, ${finishDay} ${initMonth}`;
    }

    if (finishDate === '' || finishDate === null) {
        return `${dateNumber_init} ${month_init}`;
    }



    // let date = moment(INIT_DATE); 
    // let year = moment(INIT_DATE,'YY'); 
    // let day = moment(INIT_DATE,'DD'); 
    // let month = moment(INIT_DATE,'MMM'); 
    // console.log(INIT_DATE)
    // console.log(INIT_DATE,'YY')
    // console.log(INIT_DATE,'DD')
    // console.log(INIT_DATE,'MMM')


    // return '1-1-1'
    
    
    
    return 




    if (initDate === '' || initDate === null) {
        return '';
    }
    if (initDate === '0000-00-00' || initDate === '0000-00-00') {
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

    if (finishDate === '' || finishDate === null) {
        return `${dateNumber_init} ${month_init}`;
    }

    let dateNumber_finish = EVENT_DATE_FINISH.toLocaleDateString("es-Cl", DATE_OPTIONS_DAY);
    let month_finish = EVENT_DATE_FINISH.toLocaleDateString("es-Cl", MONTH_OPTIONS);

    dateNumber_finish = parseInt(dateNumber_finish) + 1;

    if (initDate === finishDate) {
        return `${dateNumber_init} ${month_init}`;
    }
    if (month_init === month_finish) {
        return `${dateNumber_init}, ${dateNumber_finish} ${month_init}`;
    }
    if (initDate !== finishDate) {
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

let deletedEvents = [];
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
            deletedEvents = response;
            // console.log(_projectsToList)
            printDeletedEvents(response);
        }
    })
}

async function printDeletedEvents(_DeletedprojectList) {



    if ($.fn.DataTable.isDataTable('#deletedEventsTable-list')) {
        $('#deletedEventsTable-list').DataTable()
            .clear()
            .draw();
        $('#deletedEventsTable-list').DataTable().destroy();
    }



    _DeletedprojectList.forEach((evento) => {

        let color = "";


        let phf = "";
        let php = "";
        let phv = "";
        let ehc = "";
        let ehf = "";


        let eventOwner = "";
        if(evento.owner !== null){

            let eventOwnerArray = evento.owner.split(' ');

            if(eventOwnerArray.length > 1){
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}${eventOwnerArray[1][0].toUpperCase()}`
            }else{
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}`
            }
        }


        if(evento.event_has_comment == null){
            ehc = `<img src="./assets/svg/commentNoActive.svg" alt="">`
        }else{
            ehc = `<img src="./assets/svg/commentActive.svg" alt="">`
        }

        if(evento.phf == null){
            ehf = `<img src="./assets/svg/paperclip.svg" alt="">`
        }else{
            ehf = `<img src="./assets/svg/paperclip-active.svg" alt="">`
        }
        
        if (evento.event_has_inventory == null) {
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

  

        let eventStatus = evento.estado;

        if (evento.estado == null) {
            evento.estado = "borrador"
        }
        if (evento.estado == 'No va') {
            evento.estado = "No_va"
        }
        if (evento.estado_id === 1) {

        }
        if (evento.estado_id === 2) {
            color = "#27AE60"
        }
        if (evento.estado_id === 3) {
            color = "#7F45E3"
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
        let timeStamp = dateToFormatt.getTime() / 1000


        let tr = `<tr evento_id="${evento.id}" class="deletedEvent">
            <td class="deleteEv-container">
                <i style="color:#069B99;" class="fa-solid fa-rotate-left"></i>
            </td>
            <td>
                <div class="-eve-list-inf-ctn">
                    <p class="event-cell-hide-text"> ${evento.nombre_proyecto} </p>
                    <div class="--ev-assigments-container">

                    <button class="commentContainer">
                        ${ehc}
                    </button>
                    <button class="buttonEventList">
                        ${ehf}
                    </button>
                    </div>
                </div>
            </td>
            <td data-order="${timeStamp}"> <p>${getEventListDate(evento.fecha_inicio, evento.fecha_termino)}</p> </td>
            <td> <p class="event-status ${evento.estado}">${eventStatus[0].toUpperCase()}${eventStatus.slice(1)}</p> </td>
            <td class="ownerCircleContainer"> <div class="ownerCircle"> <p>${eventOwner}</p> </div> </td>
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
            <td> <p>${CLPFormatter(evento.income)}</p> </td>
            <td> <p class="event-client-name">${nombreCliente}</p> </td>
            <td> <p class="--h-text">${evento.event_type === null ? "" : evento.event_type}</p> </td>
            
            </tr>`
            // <td style="display:flex;justify-content:space-between;">            
            //     <button class="buttonEventList">
            //         <img src="./assets/svg/dollar-sign-inactive.svg" alt="">
            //     </button>
            // </td> 
            // <td> <p class="event-name" >${evento.owner === null ? "" : evento.owner}</p> </td>

        $('#deletedEventsTable-list tbody').append(tr);
        // tableEventList.row.add($(tr)).draw();
    });



    if (!$.fn.DataTable.isDataTable('#deletedEventsTable-list')) {

        tableEventList = $('#deletedEventsTable-list').DataTable({
            responsive: true,
            sort: true,
            pageLength: 100,
            columnDefs: [
                {width: '20%', targets: [1]},
                {width: '10%', targets: [2]},
                {width: '10%', targets: [3]},
                {width: '6%', targets: [4]},
                {width: '10%', targets: [5]},
                {width: '5%', targets: [6]},
                {width: '4%', targets: [7]},
                {width: '8%', targets: [8]},
                {width: '1%', targets: [0]}
            ],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Eventos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        // from pageheader/searchbar set input target
        searchInputTarget = tableEventList;

    }

}



