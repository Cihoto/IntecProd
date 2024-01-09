$(document).ready(async function(){
    // SET EVENTS QUANTITY COMPARISON BTEWEEN ACTUAL  MONTH AND LAST MONTH
    const resumeDataDashboard = await getDashResume(EMPRESA_ID);
    const resumeDataQtty = resumeDataDashboard.event_quanity_cur_last_month;
    const resumeDataIncome = resumeDataDashboard.incomeResume; 

    const quantityResumePercentajes = getDifferencePercentajeBetweenData_CurMonth_LastMonth(resumeDataQtty.total_last_month, resumeDataQtty.total_current_month);
    setQuantityResumePercentaje(quantityResumePercentajes);

    // SET DIFFERENCE BTEWEEN INCOME FROM ACTUAL MONTH AND LAST MONTH EVENTS

    const incomeResumePercentajes = getDifferencePercentajeBetweenData_CurMonth_LastMonth(resumeDataIncome.last_month_income,resumeDataIncome.actual_income_month)
    setIncomeResumePercentaje(incomeResumePercentajes);
    let request = {
        "status": "all",
        "date":'',
        "type":''
    }
    const initialEvents = await getEventsForDashboard(request ,EMPRESA_ID);


    _dashEvents = initialEvents.events;
    printEventOnDashTable()


})




function getDifferencePercentajeBetweenData_CurMonth_LastMonth(lastMonthValue, curMonth){
    const PERCENTAJE = Math.round(((curMonth - lastMonthValue) / lastMonthValue) * 100);

    let simbol = "+";
    let perClass = "poss";

    if(PERCENTAJE < 0){
        simbol = "-"
        perClass = "neg"
    }else if(PERCENTAJE === 0){
        simbol = ""
        perClass = ""
    }
    return {
        "class": perClass,
        "percentaje": Math.abs(PERCENTAJE),
        "simbol": simbol,
        "curMonthValue":curMonth
    }
}
function setQuantityResumePercentaje(data){
    $('#eventAmountCurrentMonth').text(`${data.curMonthValue}`)
    $('#currentMonthEventamountPercentaje').text(`${data.simbol}${data.percentaje}%`)
    $('#currentMonthEventamountPercentaje').addClass(data.class)
}
function setIncomeResumePercentaje(data){

    $('#dash-amountIncome').text(`${data.curMonthValue}`)
    $('#dash-amountIncomePercentaje').text(`${data.simbol}${data.percentaje}%`)
    $('#dash-amountIncomePercentaje').addClass(data.class)
}


$('.eventStatusSortDash').on('click',async function(){

    $('.eventStatusSortDash').prop('checked',false);
    $(this).prop('checked',true);
    const STATUS = $(this).val()
    let request = 
    {
        "status": STATUS,
        "date":$('#fechaInicio').val(),
        "type":$('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request,EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
})


$('#fechaInicio').on('change',async function(){
 const STATUS = $('.eventStatusSortDash:checked').val();
    let request = 
    {
        "status": STATUS,
        "date":$('#fechaInicio').val(),
        "type":$('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request,EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
})
$('#eventTypeSelect').on('change',async function(){
 const STATUS = $('.eventStatusSortDash:checked').val();
    let request = 
    {
        "status": STATUS,
        "date":$('#fechaInicio').val(),
        "type":$('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request,EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
})

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


    },
    error: function (response) {
    }
    })
}



