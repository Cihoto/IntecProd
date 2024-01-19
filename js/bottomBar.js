const SPINNER = `<div class="loadingio-spinner-rolling-a4dt90r28kv" id="spinnerBottomContainer">
<div class="ldio-r2lhg8dn3dg">
    <div></div>
</div>
</div>`

const SUCCESS = `<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
'<lottie-player src="https://lottie.host/760e4548-a943-49d5-83f8-05ca3851379f/XirQ8ufIES.json" background="transpa rent" speed="1" style="width: 60px; height: 60px" direction="1" mode="normal" autoplay></lottie-player>`;

const ERROR = `<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<dotlottie-player src="https://lottie.host/e6bda4df-48fa-4463-aa5b-6ce9a90b01c0/VPkyvxRcXB.json" background="transparent" speed="1" style="width: 60px; height: 60px" direction="1" mode="normal" autoplay></dotlottie-player>`;

const DOWNLOAD = `<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<dotlottie-player src="https://lottie.host/1e467063-21db-4fa2-be5a-f3abc0ad6ef8/FmnbCRlyGr.json" background="transparent" speed="1" style="width: 60px; height: 60px" direction="1" mode="normal" loop autoplay></dotlottie-player>`

function clearBottomBar(){
    $('#footerInformation p').text('');
    $('#spinnerBottomContainer').remove();
    $('#footerInformation script').remove();
    $('#footerInformation lottie-player').remove();
    $('#footerInformation dotlottie-player ').remove();
}

function completeEventDataToContinue(){

    clearBottomBar();
    $('#footerInformation p').text('Complete la información para continuar');
    $('#footerInformation').append(ERROR);
}

function preparingDocumentBottomBar(text){
    clearBottomBar();
    $('#footerInformation p').text(text);
    $('#footerInformation').append(SPINNER);
}

function closeBottomBar(){
    clearBottomBar();
    $('#footerInformation').removeClass('active');
}

function eventWasCreatedBottomBar(wasCreated){
    clearBottomBar();
    let confirmText = "";
    
    if(wasCreated === false){
        confirmText = "Evento Creado"
    }else{
        confirmText = "Eventos Actualizado"
    }
    $('#footerInformation p').text(confirmText);
    $('#footerInformation').append(SUCCESS);
}

function changesCompleted(){
    clearBottomBar();
    let confirmText = "Cambios confirmados";

    $('#footerInformation p').text(confirmText);
    $('#footerInformation').append(SUCCESS);
}

function initBottomBar(){
    let confirmText = "";
    
    if(event_data.event_id === ""){
        confirmText = "Creando Evento"
    }else{
        confirmText = "Actualizando Evento"
    }
    $('#footerInformation p').text(confirmText);
    $('#footerInformation').append(SPINNER);
}

function preparingDocumentDownload(downloadText){
    clearBottomBar();
    $('#footerInformation p').text(downloadText);
    $('#footerInformation').append(DOWNLOAD);
}
