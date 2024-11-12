<?php

ob_start();
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['empresa_id'])){
    header("Location: login.php");
    die();
}else{
  $empresaId = $_SESSION["empresa_id"];
}

ob_end_flush();
// remove header
header_remove('ETag');
header_remove('Pragma');
header_remove('Cache-Control');
header_remove('Last-Modified');
header_remove('Expires');

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$active = "eventos";
$title = "Mis Eventos";
$clientDash  = false;
$copEvent = true;
require_once('./includes/Constantes/personalIds.php')
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once('./includes/head.php');
?>

<body>
    <div id='file-frame-top-menu' class="">


    </div>
    <?php require_once('./includes/Constantes/empresaId.php') ?>
    <?php require_once('./includes/Constantes/rol.php') ?>

    <div id="app">


        <?php require_once('./includes/sidebar.php') ?>

        <div id="main">

            <header class="page-header">

            <?php require_once('./includes/headerBreadCrumb.php')?>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        
                    </ol>
                </nav>
                <p class="headerTitle createOrEditBreadcrumTitle" style="margin:-13px 0px 16px 0px!important;">Crear un nuevo evento</p> -->
            </header>

            <div class="pageContent">
                <div class="status-container">
                    <p style="color: var(--Text-secondary, #53545C);
                        font-family: Roboto;
                        font-size: 12px;
                        font-style: normal;
                        font-weight: 400;
                        line-height: normal;
                        letter-spacing: 0.12px;">
                        Estado actual:
                    </p>


                    <div class="status-options-container">
                        <button status_id="1" class="event-status-btn borrador" id="status-button">
                            <p>Borrador</p>
                        </button>
                        <!-- <button class="event-status-btn cotizado">
                            <p>Cotizado</p>
                        </button>
                        <button class="event-status-btn confirmado">
                            <p>Confirmado</p>
                        </button>
                        <button class="event-status-btn finalizado">
                            <p>Finalizado</p>
                        </button>
                        <button class="event-status-btn cerrado">
                            <p>Cerrado</p>
                        </button> -->
                    </div>
                </div>
                <?php require_once('./includes/eventAssigments.php') ?>
            </div>
            <div id="statusMenuList" class="optionLimiter">
                <section id="statusMenuHeader">
                    <div id="headerOptionsContent">
                        <img src="./assets/svg/bookMark.svg" alt="">
                        <div class="listItemHeaderText">
                            <p class="header">Etiquetas de estado</p>
                            <p class="bottom">Puedes cambiar el estado de tu evento en todo momento</p>
                        </div>
                    </div>
                </section>
                <div class="d-flex" style="width: 100%;margin:-13px 0px;padding: 0px;">
                    <div class="divider">1</div>
                </div>
                <section class="statusMenuOptions">
                    <button status_id="1" class="event-status-btn borrador">
                        <p>Borrador</p>
                    </button>
                    <button status_id="4" class="event-status-btn cotizado">
                        <p>Cotizado</p>
                    </button>
                    <button status_id="2" class="event-status-btn confirmado">
                        <p>Confirmado</p>
                    </button>
                    <button status_id="3" class="event-status-btn finalizado">
                        <p>Finalizado</p>
                    </button>
                    <button status_id="5" class="event-status-btn cerrado">
                        <p>Cerrado</p>
                    </button>
                    <button status_id="6" class="event-status-btn No_va" style="border-radius: 0px 0px 5px 5px;">
                        <p>No va</p>
                    </button>
                </section>
            </div>
        </div>
    </div>

    <?php require_once('./includes/sidemenu/clientSideMenu.php') ?>




    <!-- DONT DELETE THIS DIV IS USED FOR DOCUMENT DOWNLOAD -->
    <div style="display: none;" id="downloadPdf">
    </div>
    <!-- END  -->

    <?php require_once('./includes/footer.php');?>
    <?php require_once('./includes/footerScriptsJs.php');?>
    <?php require_once('./includes/bottomBar.php'); ?>

    <!-- require Modal -->
    <?php require_once('./includes/Modal/direccion.php');?>
    <?php require_once('./includes/Modal/cliente.php');?>
    <!-- FIN require Modal -->
    <?php require_once('./includes/footerScriptsJs.php');?>

    <!-- SIDEMENUS -->
    <?php require_once('./includes/sidemenu/viewUploadedFiles.php'); ?>
    <?php require_once('./includes/sidemenu/newFreelanceSideMenu.php'); ?>
    <?php require_once('./includes/sidemenu/eventComments.php'); ?>
    <?php require_once('./includes/sidemenu/vehicleSideMenu.php'); ?>
    <?php require_once('./includes/sidemenu/resumeCreditedBalance.php'); ?>

    


    <!-- REQUIRE FORM ARRIENDOS -->
    <?php require_once('./includes/forms/arriendosForm.php');?>

    </div>
    </div>
    <!-- REQUIRE DE FUNCIONES JS -->

    <!-- <script src="/js/evento/getEventData.js"></script>
    <script src="/js/evento/createEvent.js"></script>
    <script src="/js/evento/eventoController.js"></script>
    <script src="/js/map.js"></script> -->
    <script src="./js/evento/eventoController.js"></script>

    <script src="./js/const/projectToSearch.js"></script>
    <script src="./js/Funciones/NewProject.js"></script>
    <script src="./js/packages.js"></script>
    <script src="./js/clientes.js"></script>
    <script src="./js/direccion.js"></script>
    <script src="./js/personal.js"></script>
    <script src="./js/vehiculos.js"></script>
    <script src="./js/valuesValidator/validator.js"></script>
    <script src="./js/ClearData/clearFunctions.js"></script>
    <script src="./js/localeStorage.js"></script>
    <script src="./js/ProjectResume/projectResume.js"></script>
    <script src="./js/ProjectResume/viatico.js"></script>
    <script src="./js/ProjectResume/subArriendo.js"></script>
    <script src="./js/ProjectResume/creditedPercentage.js"></script>
    <script src="./js/Funciones/assigments.js"></script>
    <script src="./js/cotizacion.js"></script>
    <script src="./js/provider.js"></script>
    <script src="./js/map.js"></script>
    <script src="./js/evento/createEvent.js?version=1.0"> </script>
    <script src="./js/eventSchedule.js"></script>
    <script src="./js/filesUpload.js"></script>
    <script src="./js/evento/getEventData.js"></script>
    <script src="./js/productos.js"></script>
    <script src="./js/rendiciones.js"></script>
    <script src="./js/otherCosts.js"></script>
    <script src="./js/bottomBar.js"></script>
    <script src="./js/bottomBar/assignedElementsSelector.js"></script>
    <script src="./js/factSheet.js"></script>
    <script src="./js/evento/viewUploadedFiles.js"></script>
    <script src="./js/evento/eventComments.js"></script>
    
    
    <!-- HEADER CONTROLLER -->
    <script src="/js/pageHeader/breadCrumb.js"></script>
    <script src="/js/pageHeader/searchBar.js"></script>
    
    <!-- DEMO ACCOUNT ACTIVATOR CONTROLLER -->
    <script src="./js/pageHeader/demoAccountButton.js"></script>
    <script src="./js/demoAccount/activateDemoFromEvents.js"></script>
    

    <!-- VALIDATE FORM -->
    <script src="./js/validateForm/addNewFreeLance.js"></script>
    <script src="./js/validateForm/addNewProvider.js"></script>
    <script src="./js/validateForm/clientForm.js"></script>
    <script src="./js/validateForm/createVehicle.js"></script>
</body>

<script>
    caches.keys().then((keyList) => Promise.all(keyList.map((key) => caches.delete(key))));

    // VARIABLE FOR CREATE NEW VEHICLE SIDE MENU FORM
    // RECOGNIZE IF REQUEST COME FROM VEHICLE DASH OR EVENT
    const REQUEST_FROM_EVENTS = true;
    //END VEHICLE VARIBLE SECTION

    let isProdQuantitySelected = false;
    let prodQuantityElementSelected = "";
    let is_open = false;
    let ROL_ID = <?php echo json_encode($rol_id); ?>;
    let EMPRESA_ID = <?php echo $empresaId; ?>;
    const PERSONAL_IDS = <?php echo $personal_ids; ?>;

    console.log('PERSONAL_IDS',PERSONAL_IDS);

    let eventIsCreated = false;

    $('#closeThis').on("click", function() {
        $("#clientSideMenu").removeClass("active");
        resetClientForm();
    })

    // Obtener el elemento de input file y el elemento de visualización del nombre del archivo
    const fileInput = document.getElementById('excel_input');
    const fileNameDisplay = document.getElementById('fileName');
    const fileLabel = document.getElementById('fileLabel');

    window.addEventListener('DOMContentLoaded', function() {
        fileInput.addEventListener('change', function(event) {
            const fileName = fileInput.files[0].name;
            const path = fileInput.files[0];
            let tmppath = this.value
            saveTempFileOnServer();
        });
    });

    function handleDragOver(event) {
        event.preventDefault();
        fileLabel.classList.add('dragover');
    }
    // Manejar el evento de soltar archivos en el label
    function handleDrop(event) {
        event.preventDefault();
        fileLabel.classList.remove('dragover');

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const fileName = files[0].name;
            fileNameDisplay.textContent = `Archivo seleccionado: ${fileName}`;
        }
    }

    $(document).ready(async function() {

        // CHANGE TOP MOBILE BAR PAGE NAME 

        $('.--pageHeadName').text('Eventos')

        projectDates.start_date = "";
        projectDates.finish_date = "";
        projectDates.total_days = "";
        projectDates.selectDates = false;
        projectDates.project_id = "";
        printNewRow_subRent();
        // from apgeheaderbreadCrumb
        createBreadCrumb('eventCreateOrEdit');
        // SET EVENT_ID
        <?php if (isset($_GET['event_id'])) : ?>
            const EVENT_ID = <?= $_GET['event_id']; ?>;
            event_data.event_id = EVENT_ID;
            projectDates.project_id = EVENT_ID;
            eventIsCreated = true;

            $('.createOrEditBreadcrumTitle').text('Ver evento');
            $('#createOrEditBreadcrumTitle').text('Ver evento');

        <?php endif; ?>

        // OBJECT CONTAINS INFO ABOUT START AND FINISH DATE ON EVENT 
        // TO SHOW PERSONAL, VEHICLES AND PERSONAL ON LIVE AVAILABILITY 
        // ON TABLES

        $('#openViewUploadedFiles').on('click', function() {
            openViewUploadedFileDieMenu();
        });

        $('#closeViewUploadedFiles').on('click', function() {
            closeViewUploadedFileDieMenu();
        });

        $('#inputProjectName').on('change', function() {
            $('#projectNameResume').text($(this).val());
        });
        $('#inputProjectName').on('blur', function() {
            if ($(this).val() !== "") {
                $('#eventNameMessage').css('visibility', 'hidden');
            } else {
                $('#eventNameMessage').css('visibility', 'visible');
            }
        });

        <?php if (isset($_GET['event_id'])) : ?>
            await getAllProjectData(EVENT_ID, EMPRESA_ID);
        <?php endif; ?>

        $('#status-button').on('click', function() {
            $('#statusMenuList').addClass('active')
            is_open = true;
        })
        $('#addFilestest').on('click', function() {
            console.log("_allmyUploadedFiles", _allmyUploadedFiles);
            assignFilesToEvent(_allmyUploadedFiles, event_data.event_id, EMPRESA_ID, PERSONAL_IDS);
        })

        $(document).on('click', function(e) {
            const IS_LIMIT = $(e.target).closest('#statusMenuList').hasClass('optionLimiter')
            if ($(e.target).hasClass('event-status-btn')) {} else {
                if (is_open === true) {
                    $('#statusMenuList').removeClass('active');
                }
            }
        })



        $('.saveDraft').on('click', function() {
            // $('#hiddenAddProject').trigger('click');
            SaveOrUpdateEvent();
        })
        $('.createOrContinue').on('click', function() {
            // $('#hiddenAddProject').trigger('click');
            SaveOrUpdateEvent();
        });


        console.log('_uploadedFiles', _uploadedFiles)

        printUploadedFiles();
    })

    $('.event-status-btn').on('click', function() {
        const BUTTON_CLASS = $(this).attr('class').split(" ")[1];
        const ACTUAL_CLASS = $('#status-button').attr('class').split(" ")[1];
        const STATUS_ID = $(this).attr('status_id');
        $('#status-button').removeClass(ACTUAL_CLASS);
        $('#status-button').addClass(BUTTON_CLASS);
        $('#status-button').find('p').text(BUTTON_CLASS.replaceAll('_',' '));
        $('#status-button').attr('status_id', STATUS_ID);
        console.log($('#status-button').attr('status_id'));
    });

    $('#postComment').on('click', async function() {

        // a;; variables are declared in evnets/comments
        const COMMENT_TEXT = $('#postCommentArea').val();


        if (COMMENT_TEXT === '') {
            return
        }

        _tempCommentIdCounter++;

        let commentData = {
            temp_comment_id: _tempCommentIdCounter,
            post_user_id: PERSONAL_IDS[0].usuario_id,
            user_name: PERSONAL_IDS[0].user_name,
            comment_text: COMMENT_TEXT,
            files: [],
            replies: []
        }
        $('.--comments-container').append(createComment(commentData));

        if (eventIsCreated) {
            addAndAssignCommentsToCreatedEvent([commentData], EMPRESA_ID, event_data.event_id);
            return
        }
        _tempCommentList.push(commentData);
    })

    $(document).keydown(function(event) {
        if (event.which === 13) {
            // console.log("isProdQuantitySelected",isProdQuantitySelected);
            // console.log("prodQuantityElementSelected",prodQuantityElementSelected);
            if (isProdQuantitySelected === true) {
                $(prodQuantityElementSelected).closest('td').find('.addItem').trigger('click');
                // $(prodQuantityElementSelected).trigger('click');
            }
        }
    });
</script>

</html>