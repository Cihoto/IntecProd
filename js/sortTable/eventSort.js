$(document).ready(function () {

    const  event_status_order = [2, 3, 5, 4, 1];
    let future_search = false;
    $('#sortAllMyEvents').on('click', async function () {
        
        if(future_search === true){
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
            console.log(ordered_events)
           
            ordered_events.forEach(ordered => {
                ordered.forEach(element => {
                    mergedArray.push(element);
                });
            });
            
            allMyEvents.woutd.forEach((woutd_event)=>{
                mergedArray.push(woutd_event);
            })
           
            console.log(mergedArray);

            _projectsToList = mergedArray;
            future_search = true
            $(this).find('p').text("Futuros")
            printAllProjects();
        }
    });


    $('#sortDrafEvents').on('click',async function(){
       const ALL_DRAFT_EVENTS =  await getEventByStatus_id(EMPRESA_ID,1);

       if(!ALL_DRAFT_EVENTS){
           return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortSells').on('click',async function(){
       const ALL_DRAFT_EVENTS =  await getSellsEvents(EMPRESA_ID);
       if(!ALL_DRAFT_EVENTS){
           return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortOperationalEvents').on('click',async function(){
       const ALL_DRAFT_EVENTS =  await getOperEvents(EMPRESA_ID);
       if(!ALL_DRAFT_EVENTS){
           return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
    $('#sortAdmEvents').on('click',async function(){
       const ALL_DRAFT_EVENTS =  await getAdmEvents(EMPRESA_ID);
       if(!ALL_DRAFT_EVENTS){
           return;
        }
        setEventsAndPrintOnTable(ALL_DRAFT_EVENTS);
    })
})


function setEventsAndPrintOnTable(allEventsOnRange){
    _projectsToList = [];

    allEventsOnRange.wd.forEach((evento)=>{
        _projectsToList.push(evento);
    });

    allEventsOnRange.woutd.forEach((evento)=>{
        _projectsToList.push(evento);
    });


    printAllProjects();
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
                console.log("RESPONSE  getAllMyEvents", response);
            },
            error: function (response) {
                console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}

async function getEventByStatus_id(empresa_id,status_id){
    try {
        return $.ajax({
            type: "POST",
            url: 'ws/proyecto/proyecto.php',
            data: JSON.stringify({
                'action': "getEventByStatus_id",
                'empresa_id': empresa_id,
                'status_id':status_id
            }),
            dataType: 'json',
            success: function (response) {
                console.log("RESPONSE  getEventByStatus_id", response);
            },
            error: function (response) {
                console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }

}

async function getSellsEvents(empresa_id){
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
                console.log("RESPONSE  getSellsEvents", response);
            },
            error: function (response) {
                console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}
async function getOperEvents(empresa_id){
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
                console.log("RESPONSE  getOperEvents", response);
            },
            error: function (response) {
                console.log(response.responseText);
            }
        })
    } catch (e) {
        console.log(e);
    }
}
async function getAdmEvents(empresa_id){
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