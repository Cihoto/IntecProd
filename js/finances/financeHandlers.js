function openFinancesEventsDetails(){
    window.location = './financeEventDetails.php';
}


function filterFinanceEventList(element){

    console.log(element);
    console.log(EVENT_TABLE_DATA);

    const FILTERED_EVENTS = EVENT_TABLE_DATA.filter((ev)=>{
        return ev.event_type == element;
    });


    if(!FILTERED_EVENTS){
        return;
    }


    console.log('FILTERED_EVENTS',FILTERED_EVENTS);
}






