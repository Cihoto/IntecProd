<?php   
$demo_activator_button_text = 'Cargar datos demo';

// if(!isset($_SESSION['buss_data'])){
//     session_destroy();
// }

// if(!isset($_SESSION['buss_data']->diff)){
//     session_destroy();
// }
echo '<script>console.log("1123123123123123",'. json_encode($_SESSION['buss_data']) .')</script>';
$demo_active = $_SESSION['buss_data']->demo_active;
$diff = $_SESSION['buss_data']->diff;

$demo_available = true;
$demo_availableJS = 1;

// if(intval($diff) >= 2){
if(intval($diff) >= 100){
    $demo_availableJS = 0;
    $demo_available = false;
}

if( $demo_active == 1){
    $demo_activator_button_text = 'Eliminar datos demo'; 
}
?>

<div class="-head-breadCrumb-container">
    <div class="--topMobileHeader">
        <a href="#" class="burger-btn d-block d-xl-none">

        <img src="../assets/svg/burguerMenuButton.svg" alt="" style="margin-left: 10px;">
        </a>
        <p class="--pageHeadName">Eventos</p>
        <div class="-usr-name" style="margin-right: 11px;" id="moTopMenu"> 
            <p>JM</p>
        </div>
    </div>
    <div class="-bcr-ctn">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="bcrumb-Container">
                <!-- <li class="breadcrumb-item"><a class="txtDec-no"><img src="./assets/svg/Dashboard.svg" alt="" style="margin-top: -5px;"> Dashboard</a></li> -->
            </ol>
        </nav>
        <!-- <p class="headerTitle" id="createOrEditBreadcrumTitle" style="margin:-13px 0px 16px 0px!important;"> -->
    </div>
    <?php if($demo_available):?>
        <button id="activeDemoDataInAccount"  class="--secondary-action-btn --d-acc"><p><?php echo $demo_activator_button_text;?></p></button>
    <?php endif;?>
    <!-- <button id="activeDemoDataInAccount"  class="--secondary-action-btn --d-acc"><p>Cargar datos demo</p></button> -->

    <div class="-user-info-ctn">
        <div class="-search-tab">
            <div class="form-group --mb-0 --top" style="width: 350px;z-index: 3;">
                <label for="dashIndexInput" class="inputLabel">Buscar</label>
                <input id="dashIndexInput" name="dashIndexInput" type="text" class="form-control input-lg s-Input" value="">
            </div>
            <img src="./assets/svg/searchLent.svg" alt="" style="margin-top: 15px;">
        </div>
        <div class="-usr-inf" id="topUserMenuButton">
            <img src="./assets/svg/notificationBell.svg" alt="" style="margin-right: 4px;">
            <div class="-usr-name" id="">
                <p>JM</p>
            </div>
            
        </div>
    </div>

    

</div>

<div id="topUserMenu">
    <button class="--u-config-el" onclick="openbussinessConfiguration()">
            <img src="../assets/svg/settings.svg" alt="" >
            <p>Configuración</p>
    </button>
    <button class="--u-config-el" onclick="closeSession()">
            <img src="../assets/svg/closeSession.svg" alt="">
            <p>Cerrar sesión</p>
    </button>
</div>

<div id="eventSearbarResults" style="display: none;">
    <div class="--result-container" id='rContainer'>
        <!-- <div class="--result-data">
            <div class="--ev-data">
                <p>Evento mis muerto 112345678912334 5678912345 678911234567891233456789123456789s</p>
                <p class="--ev-date">
                    2024-01-02
                </p>
            </div>
            <div class="--ev-share">
                <img src="../assets/svg/shareIcon.svg" alt="">
            </div>
        </div>
        <div class="--result-data">
            <div class="--ev-data">
                <p>Evento mis muerto 112345678912334 5678912345 678911234567891233456789123456789s</p>
                <p class="--ev-date">
                    2024-01-02
                </p>
            </div>
            <div class="--ev-share">
                <img src="../assets/svg/shareIcon.svg" alt="">
            </div>

        </div>
        <div class="--result-data">
            <div class="--ev-data">
                <p>Evento mis muerto 112345678912334 5678912345 678911234567891233456789123456789s</p>
                <p class="--ev-date">
                    2024-01-02
                </p>
            </div>
            <div class="--ev-share">
                <img src="../assets/svg/shareIcon.svg" alt="">
            </div>
        </div> -->
    </div>
</div>


<script src="./js/pageHeader/configMenu/updateBussinessLogo.js"></script>
<script src="./js/pageHeader/configMenu/openConfigMenu.js"></script>
<script src="../js/demoAccount/demoAccountCreation.js"></script>
<script src="../js/demoAccount/addProductsToDemo/productsMasive.js"></script>
<script src="../js/demoAccount/addPersonalToDemo/personalMasive.js"></script>
<script src="../js/demoAccount/addVehiclesDemo/vehiclesMasive.js"></script>
<script src="../js/demoAccount/addClientesToDemo/clientsMasive.js"></script>
<script src="../js/demoAccount/addEventsToDemo/EventsMasiva.js"></script>

<script src="./js/demoAccount/demoAccountDelete.js"></script>
<script src="./js/pageHeader/demoAccountButton.js"></script>


<script>

let demo_buss =  <?php echo $demo_active;?>;
let demo_AvailablePHP =  <?php echo $demo_availableJS;?>;
let bussinessIsDemo = false;
let isDemoAvailable = true;



if(demo_buss == 1){

    bussinessIsDemo = true;

}


if(demo_AvailablePHP != 1){
    isDemoAvailable = false;
}
// else{
//     bussinessIsDemo = false;
// }




</script>
<style>
    .swal2-actions button + button{
        margin-left: 10px;
    }
</style>