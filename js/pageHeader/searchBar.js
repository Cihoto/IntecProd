const SEARCHBAR = document.getElementById('dashIndexInput');
const SEARCHBAR_RESULTS = document.getElementById('eventSearbarResults');
let searchbarIsOpen = false;

SEARCHBAR.addEventListener('keyup', async function (e) {

    console.log('this.value',this.value)
    if(this.value === ''){
        closeSearchBar();
        return
    }

    moveSearchBar(this);

    let eventSearchRequest = {
        eventName: this.value,
        empresa_id: EMPRESA_ID
    }

    const FOUND_EVENTS = await liveSearchEvent(eventSearchRequest);
    showSearchBar();
    printLiveEvents(FOUND_EVENTS.events);
});

function moveSearchBar(element){
    let rect = SEARCHBAR.getBoundingClientRect();
    // bottom: 177,
    // height: 54.7,
    // left: 278.5,​
    // right: 909.5,
    // top: 122.3,
    // width: 631,
    // x: 278.5,
    // y: 122.3,
    SEARCHBAR_RESULTS.style.width = `${rect.width}px`;
    SEARCHBAR_RESULTS.style.top = `${rect.top + 35}px`;
    SEARCHBAR_RESULTS.style.left = `${rect.left}px`;
    SEARCHBAR_RESULTS.style.right = `${rect.right}px`;
}


function closeSearchBar(){
    SEARCHBAR_RESULTS.style.display = 'none';
    document.querySelectorAll('.--result-data').forEach(e => e.remove());
    searchbarIsOpen = false;
}
function showSearchBar(){
    SEARCHBAR_RESULTS.style.display = 'block';
    searchbarIsOpen = true;
}

function printLiveEvents(events){
     
    document.querySelectorAll('.--result-data').forEach(e => e.remove());

    events.forEach((event)=>{

        $('#rContainer').append(`<div class="--result-data" ev_id=${event.id}>
            <div class="--ev-data">
                <p>${event.event_name}</p>
                <p class="--ev-date">
                    ${event.s_date}
                </p>
            </div>
            <div class="--ev-share">
                <img src="../assets/svg/shareIcon.svg" alt="">
            </div>
        </div>`);

    })

}

$(document).on('click','.--ev-share',function(){
    const EVENT_ID = $(this).closest('.--result-data').attr('ev_id');
    location.href = `./miEvento.php?event_id=${EVENT_ID}`;
})

$(document).on('click',function(e){

    if(searchbarIsOpen){
        let clickedInsideResutlts = $(e.target).closest('#eventSearbarResults').length;
        console.log(clickedInsideResutlts);

        if(clickedInsideResutlts === 0){
            closeSearchBar();
        }
    }    
    
})

window.addEventListener("resize", function(event) {
    moveSearchBar(SEARCHBAR)
})

function liveSearchEvent(request) {
    return $.ajax({
        type: "POST",
        url: 'ws/pageHeader/liveSearchEvents.php',
        data: JSON.stringify({"request": request}),
        dataType: 'json',
        success: function (response) {
        }, error: function (response) {
            // console.log(response)
        }
    })
}

