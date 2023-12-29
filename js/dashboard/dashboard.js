$(document).ready(async function(){
    const resumeData = await getDashResume(EMPRESA_ID);


    setCurrentEventAmount(resumeData.event_quanity_cur_last_month);

   

    // getEvents(EMPRESA_ID)
    console.log("resumeData",resumeData);

    const initialEvents = await getEventsDashboard(EMPRESA_ID);

    if(initialEvents.length > 0){
        printEventOnDashTable();
    }else{
        printNoEventsAvailableDash();
    }

    // sort events function 

})

function setCurrentEventAmount(amounts){
    
    const LAST_MONTH_QTY = parseInt(amounts.total_last_month);
    const CURRENT_MONTH_QTY = parseInt(amounts.total_current_month);

    const PERCENTAJE = Math.round(((CURRENT_MONTH_QTY - LAST_MONTH_QTY) / LAST_MONTH_QTY) * 100);

    console.log(PERCENTAJE);

    let simbol = "+";
    let perClass = "poss";

    if(PERCENTAJE < 0){
        simbol = "-"
        perClass = "neg"
    }else if(PERCENTAJE === 0){
        simbol = ""
        perClass = ""
    }

    $('#eventAmountCurrentMonth').text(`${CURRENT_MONTH_QTY }`)
    $('#currentMonthEventamountPercentaje').text(`${simbol}${PERCENTAJE}%`)
    $('#currentMonthEventamountPercentaje').addClass(perClass)


}

async function getDashResume(empresa_id){

return $.ajax({
    type: "POST",
    url: 'ws/proyecto/proyecto.php',
    data: JSON.stringify({
        'empresa_id': empresa_id,
        'action': "getDashResume"
    }),
    dataType: 'json',
    success: function (response) {

        console.log("RESPONSE DASHBORAD RESUME DATA", response);

    },
    error: function (response) {
        console.log(response.responseText);
    }
    })
}



