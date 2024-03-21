let _allCalendarEvents = [];

async function getCalendarEvents(){
  const EVENTS = await getAllCalendarEvents(EMPRESA_ID);

  let purple = false
  _allCalendarEvents = EVENTS.events.map(event => {
    let eventColor = '#36ABA9'
    if(!purple){
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
}

function fixEndDateOnEvent(endDate){
 

    let startDate = new Date(endDate);
    let fixedDate = startDate.setDate(startDate.getDate() + 1)
    return fixedDate
}


function renderCalendar(_calendarEvents){
  let calendarEl = document.getElementById('calendar');

  let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: _calendarEvents,
      locale: 'es',
      displayEventTime:false,
      headerToolbar: {
          start: 'dayGridMonth,timeGridWeek,timeGridDay',
          center: 'title',
          end: 'today prevYear,prev,next,nextYear'
      },
      aspectRatio: 1.8,
  });
  calendar.setOption('locale', 'es');
  calendar.render();
}





// async function FormatEventsForCalendar(status){
//     const events = await (GetCalendarProjects(EMPRESA_ID,status));
//     let calendarEventObj = [];

//     events.forEach(element => {
      
//       // console.log(element.id);
//       let color = "white";
//       let textColor = "black";
//       if (element.estado === 'creado') {
//         color = "yellow";
//         let textColor = "black";

//       }
//       if (element.estado === 'confirmado') {
//         color = "green";
//         let textColor = "white";

//       }
//       if (element.estado === 'finalizado') {
//         color = "blue";
//         let textColor = "white";

//       }

//       calendarEventObj.push({
//         id: element.id,
//         title: element.nombre_proyecto,
//         start: element.fecha_inicio,
//         end: element.fecha_termino,
//         color: color,
//         textColor: textColor
//       })

//     });
//     return calendarEventObj;
//   }
  
//   async function RenderCalendar(status){
//     const events = await FormatEventsForCalendar(status);
//       calendar = new FullCalendar.Calendar(calendarEl, {
//       height: 590,
//       eventClick: function(info) {
//         // ViewResume(projectId)
//         console.log(`ID ${info.event.id}`);
//         ViewResume(info.event.id);
//         // alert('Event: ' + info.event.title);
//         // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
//         // alert('View: ' + info.view.type);
//         // change the border color just for fun
//         // info.el.style.borderColor = 'red';
//       },
//       events: events
//       })
      
//       calendar.render();
//   }

//   async function FillCalendar(status){
//     if(!calendarEl.children.length > 0){
//       RenderCalendar(status);
//     }else{
//       calendar.destroy();
//       RenderCalendar(status);
//     }
//   }