
let datesForCalendar = [];
let dateLimits = {
    "init": "",
    "finish": ""
}
$(document).ready(async function () {
    // SET EVENTS QUANTITY COMPARISON BTEWEEN ACTUAL  MONTH AND LAST MONTH


    const resumeDataDashboard = await getDashResume(EMPRESA_ID);

    console.log('resumeDataDashboard',resumeDataDashboard)
    console.log('resumeDataDashboard',resumeDataDashboard)
    console.log('resumeDataDashboard',resumeDataDashboard)
    const resumeDataQtty = resumeDataDashboard.event_quanity_cur_last_month;
    const resumeDataIncome = resumeDataDashboard.incomeResume;
    const currentMonthIncome = resumeDataDashboard.currentMonthIncome;

    // const quantityResumePercentajes = getDifferencePercentajeBetweenData_CurMonth_LastMonth(resumeDataQtty.total_last_month, resumeDataQtty.total_current_month);
    // setQuantityResumePercentaje(quantityResumePercentajes);
    
    setQuantityResumePercentaje(resumeDataQtty.total_current_month,currentMonthIncome.currentMonthIncome == undefined ? 0 :currentMonthIncome.currentMonthIncome,resumeDataQtty.currentLeftEvents);
    
    // SET DIFFERENCE BTEWEEN INCOME FROM ACTUAL MONTH AND LAST MONTH EVENTS

    const incomeResumePercentajes = getDifferencePercentajeBetweenData_CurMonth_LastMonth(resumeDataIncome.last_month_income, resumeDataIncome.actual_income_month)
    setIncomeResumePercentaje(incomeResumePercentajes);
    let request = {
        "status": "2",
        "date": '',
        "type": ''
    }

    const initialEvents = await getEventsForDashboard(request, EMPRESA_ID);

    _dashEvents = initialEvents.events;
    printEventOnDashTable();

    console.log(getToday())

    printDailyEvents(getToday());

    const ALL_MY_EVENTS = await getAllMyEvents(EMPRESA_ID)

    if (!ALL_MY_EVENTS) {
        return
    }
    console.log(ALL_MY_EVENTS);
    datesForCalendar = ALL_MY_EVENTS.wd.map((event) => {
        return {
            'fecha_inicio': event.fecha_inicio,
            'fecha_termino': event.fecha_termino
        }
    });


    console.log(datesForCalendar);

    // SET CALENDAR TO DASHBOARD
    setcalendar()


});


function getToday(){
    let today = new Date();
    console.log("today",today);
    let year = today.getFullYear(); 
    let day =  today.getDate();
    let month = today.getMonth() + 1;
    console.log("today",day);
    console.log("today",year);
    console.log("today",month);
    if (month < 10) {
        month = `0${month}`;
    }
    if (day < 10) {
        day = `0${day}`;
    }   

    return `${year}-${month}-${day}`

}

function checkIfDateIsInRange(currentDate) {
    const FIND_DATE = datesForCalendar.find((evDate) => {
        return evDate.fecha_inicio === currentDate
    });
    if (FIND_DATE) {
        return true;
    }
    return false;
}


function subtractYears(date, years) {
    date.setFullYear(date.getFullYear() - years);

    return date;
}
function addYears(date, years) {
    date.setFullYear(date.getFullYear() + years);

    return date;
}
async function setcalendar() {
    const START_DATE = subtractYears(new Date(), 1);
    const FINISH_DATE = addYears(new Date(), 1);

    let start_year = START_DATE.getFullYear();
    let start_month = START_DATE.getMonth() + 1;
    let start_day = START_DATE.getDate();
    let finish_year = FINISH_DATE.getFullYear();
    let finish_month = FINISH_DATE.getMonth() + 1;
    let finish_day = FINISH_DATE.getDate();


    if (start_month < 10) {
        start_month = `0${start_month}`;
    }
    if (start_day < 10) {
        start_day = `0${start_day}`;
    }
    if (finish_month < 10) {
        finish_month = `0${finish_month}`;
    }
    if (finish_day < 10) {
        finish_day = `0${finish_day}`;
    }

    console.log(`${start_year}-${start_month}-${start_day}`);
    console.log(`${finish_year}-${finish_month}-${finish_day}`);


    const CALENDAR_OPTIONS = {
        'date': {
            min: `${start_year}-${start_month}-${start_day}`,
            max: `${finish_year}-${finish_month}-${finish_day}`,
        },
        'settings': {
            'range': {
                min: `${start_year}-${start_month}-${start_day}`,
                max: `${finish_year}-${finish_month}-${finish_day}`,
            },
            'lang': 'es',
            'visibility': {
                'theme': 'light',
                'disabled': true,
            }
        },
        'actions': {
            getDays(day, date, HTMLElement, HTMLButtonElement, self) {

                const START_DATE = subtractYears(new Date(), 1);
                const FINISH_DATE = addYears(new Date(), 1);

                const CURDATE = new Date(date)

                if (CURDATE >= START_DATE && CURDATE < FINISH_DATE) {
                    const PRINT_DATE = checkIfDateIsInRange(date);
                    if (PRINT_DATE) {
                        HTMLButtonElement.style.background = 'linear-gradient(90deg, #36ABA9 0%, #10E5E1 82.29%)'
                        HTMLButtonElement.style.color = 'white'
                    }
                } else {
                   
                }

            },
            clickDay(event, self,) {
                console.log(self.selectedDates);

                if(self.selectedDates.length === 0){
                    return
                }
                printDailyEvents(self.selectedDates[0])
            },
        },
    }
    const calendar = new VanillaCalendar('#calendar', CALENDAR_OPTIONS);
    calendar.init();
}

function addDayToDate(date,daysToAdd){

    let tempday = new Date(date);
    tempday.setDate(tempday.getDate() + daysToAdd);
    return tempday;

};

function subDayToDate(date,daysToSub){

    let tempday = new Date(date);
    tempday.setDate(tempday.getDate() - daysToSub);
    return tempday;

};

let violetBackground = false;
async function printDailyEvents(dayToSearch) {

    console.log(dayToSearch)

    const DATE_OPTIONS_DAY = {
        day: "numeric"
    }
    const DATE_OPTIONS_DAYNAME = {
        weekday: "short"
    }
    const DATE_OPTIONS_DAYNAME_LONG = {
        weekday: "long"
    }
    let tempday = addDayToDate(dayToSearch, 1);
    const TITLE_DATE = new Date(tempday);

    console.log(TITLE_DATE)

    let fullDay = TITLE_DATE.toLocaleDateString("es-Cl", DATE_OPTIONS_DAYNAME_LONG);

    let dateNumber = TITLE_DATE.toLocaleDateString("es-Cl", DATE_OPTIONS_DAY);

    console.log("fullDay",fullDay)
    console.log("dateNumber",dateNumber)

    $('.today-p').text(`Hoy, ${fullDay.slice(0, 1).toUpperCase() + fullDay.slice(1, fullDay.length)} ${dateNumber} `);

    $('.day-card').each((key, element) => {

        let daysToSum = parseInt($(element).attr("day_sum"));
        const date = new Date(tempday);
        date.setDate(date.getDate() + daysToSum);
        let day = date.toLocaleDateString("es-CL", DATE_OPTIONS_DAYNAME);
        $(element).find(".day-number").text(date.toLocaleDateString("es-CL", DATE_OPTIONS_DAY));
        $(element).find(".day-name").text(day.slice(0, 1).toUpperCase() + day.slice(1, day.length));

    });



    const TODAY_EVENTS = await getEventDay(dayToSearch,EMPRESA_ID);

    console.log('TODAY_EVENTS',TODAY_EVENTS);
    console.log('TODAY_EVENTS',TODAY_EVENTS);
    console.log('TODAY_EVENTS',TODAY_EVENTS);

    const LIST_CONTAINER = $('#daily-event-list');
    let bgClass = "bg-cyan";

    $('.event-data-container').remove();
    TODAY_EVENTS.data.forEach((event) => {
        let color = '';

        if(event.status_id == 1){ color = '939395'}
        if(event.status_id == 4){ color = '2F80ED'}
        if(event.status_id == 2){ color = '27AE60'}
        if(event.status_id == 3){ color = '7445C4'}
        if(event.status_id == 5){ color = 'EB5757'}


        let eventOwner = "";
        if(event.owner !== null){

            let eventOwnerArray = event.owner.split(' ');

            if(eventOwnerArray.length > 1){
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}${eventOwnerArray[1][0].toUpperCase()}`
            }else{
                eventOwner = `${eventOwnerArray[0][0].toUpperCase()}`
            }
        }


        if(event.status_id == 6){ color = ''}
        if (violetBackground) {
            bgClass = "bg-violet"
        };

        
        let section = `<div class="event-data-container " style="background-color:#${color};">
          <div class="--dly-ev-data-body">
            <div class="--dly-logo">
                <p>${eventOwner}</p>
            </div>
            <div class="--dly-info">
                <p class="--dly-info-event-name">${event.nombre_proyecto}</p>
                <p class="--dly-info-event-desc">
                    EVENT DESCRIPTION
                </p>
            </div>
          </div>
        </div>`;
        violetBackground = true;
        LIST_CONTAINER.append(section);
    })
}

function todayEvents() {
    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            action: "getTodayEvent"
        }),
        dataType: 'json',
        success: function (response) {
        },
        error: function (error) {

        }
    })
}
function getEventDay(date,empresa_id) {
    return $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            action: "getEventDay",
            'date': date,
            'empresa_id' : empresa_id
        }),
        dataType: 'json',
        success: function (response) {
        },
        error: function (error) {

        }
    })
}

function getDifferencePercentajeBetweenData_CurMonth_LastMonth(lastMonthValue, curMonth) {
    const PERCENTAJE = Math.round(((curMonth - lastMonthValue) / lastMonthValue) * 100);
    let simbol = "+";
    let perClass = "poss";
    if (PERCENTAJE < 0) {
        simbol = "-"
        perClass = "neg"
    } else if (PERCENTAJE === 0) {
        simbol = ""
        perClass = ""
    }
    return {
        "class": perClass,
        "percentaje": Math.abs(PERCENTAJE),
        "simbol": simbol,
        "curMonthValue": curMonth
    }
}

function setQuantityResumePercentaje(eventAmountCurrentMonth,currentMonthIncome,currentLeftEvents) {
    $('#eventAmountCurrentMonth').text(`${eventAmountCurrentMonth}`)
    $('#dash-amountIncome').text(`${CLPFormatter(currentMonthIncome)}`);
    $('#currentMonthLeftEvents').text(`${currentLeftEvents}`)
    // $('#eventAmountCurrentMonth').text(`${data.curMonthValue}`)
    // $('#currentMonthEventamountPercentaje').text(`${data.simbol}${data.percentaje}%`)
    // $('#currentMonthEventamountPercentaje').addClass(data.class)
}

function setIncomeResumePercentaje(data) {

    // $('#dash-amountIncome').text(`${data.curMonthValue}`)
    // $('#dash-amountIncomePercentaje').text(`${data.simbol}${data.percentaje}%`)
    // $('#dash-amountIncomePercentaje').addClass(data.class)
}

$('.eventStatusSortDash').on('click', async function () {

    $('.eventStatusSortDash').prop('checked', false);
    $(this).prop('checked', true);
    const STATUS = $(this).val()
    let request =
    {
        "status": STATUS,
        "date": $('#fechaInicio').val(),
        "type": $('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request, EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
});

$('#fechaInicio').on('change', async function () {
    const STATUS = $('.eventStatusSortDash:checked').val();
    let request =
    {
        "status": STATUS,
        "date": $('#fechaInicio').val(),
        "type": $('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request, EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
});

$('#eventTypeSelect').on('change', async function () {
    const STATUS = $('.eventStatusSortDash:checked').val();
    let request =
    {
        "status": STATUS,
        "date": $('#fechaInicio').val(),
        "type": $('#eventTypeSelect').val()
    }
    const eventos = await getEventsForDashboard(request, EMPRESA_ID);
    _dashEvents = eventos.events;
    printEventOnDashTable()
});

async function getDashResume(empresa_id) {

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



