<?php

ob_start();
if (session_id() == '') {
  session_start();
}

if (!isset($_SESSION['empresa_id'])) {
  header("Location: login.php");
  die();
} else {
  $empresaId = $_SESSION["empresa_id"];
}
$active = 'administracion';
$title = 'Intec - Vehículos';

?>

<!DOCTYPE html>
<html lang="en">
<?php
require_once('./includes/head.php');
$active = 'vehiculos';
?>

<body>
    <?php include_once('./includes/Constantes/empresaId.php') ?>
    <?php include_once('./includes/Constantes/rol.php') ?>

    <p style="display: none;" class="empresaId"> <?= $empresaId ?></p>
    <script src="./assets/js/initTheme.js"></script>
    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>

        <div id="main">


        <div id="module-container">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar y crear los vehículos para tus eventos</p>
                </div>
                <div class="row justify-content-end" style="margin:0px; gap :8px;">
                    <button class="s-Button-w" id="openMasivaVehicle" style="width: 220px;">
                        <p class="s-P-g">Agregar vehículos masiva</p>
                    </button>
                    <button class="s-Button" id="openSideVehicleForm">
                        <p class="s-P">Agregar vehículo</p>
                    </button>
                </div>

                <table id="vehiclesDashTable">
                    <thead>
                        <tr>
                            <th>Tipo de vehículo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Patente</th>
                            <th>Propietario</th>
                            <th>Costo por viaje</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- <tr>
                            <td>Nombre</td>
                            <td>Rut</td>
                            <td>Especialidad</td>
                            <td>Teléfono</td>
                            <td>Correo eléctronico</td>
                            <td>Tipo contrato</td>
                            <td>Costo mensual </td>
                        </tr> -->
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        
        <?php require_once('./includes/footer.php') ?>
    </div>
    </div>
    <?php require_once('./includes/footerScriptsJs.php') ?>


    <!-- GLOBAL FUNCTIONS  -->
    <script src="./js/Funciones/openEventFromTables.js"></script>
    <!-- xlsx Reader -->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>
    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>
    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <!-- SIDEMENU VEHICLES -->
    <?php require_once('./includes/sidemenu/vehicleSideMenu.php')?>
    <?php require_once('./includes/sidemenu/vehicleMasivaSideMenu.php')?>
    <?php require_once('./includes/sidemenu/vehicleInfoSideMenu.php')?>
    <!-- jsfunctions -->
    <script src="./js/vehiculos.js"></script>
    <!-- VALIDATE FORMS -->
    <script src="./js/validateForm/createVehicle.js"></script>

    <script>
        const EMPRESA_ID = <?php echo $empresaId;?>;
        const fileInput = document.getElementById('excel_input');
        const fileNameDisplay = document.getElementById('fileName');
        const fileLabel = document.getElementById('fileLabel');

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

        $('#openSideVehicleForm').on("click",function(){
            $('#vehicleSideMenu').addClass('active')
        })
        $('#closeVehicleSideMenu').on("click",function(){
            $('#vehicleSideMenu').removeClass('active');
        })
        $('#openMasivaVehicle').on("click",function(){
            $('#masivaVehicleSideMenu').addClass('active')
        })
        $('#closeMasivaVehicle').on("click",function(){
            $('#masivaVehicleSideMenu').removeClass('active');
        })
        $('#closeVehicleInfoSideMenu').on("click",function(){
            $('#vehicleInfoSideMenu').removeClass('active');
        })

        $(document).ready(async function() {

            const RESPONSE_VEHICLES = await getVehiclesByBussiness(EMPRESA_ID);
            if(RESPONSE_VEHICLES.success){
                _allMyVehicles = RESPONSE_VEHICLES.data;
                printAllMyVehicles();
            }

        });
   
        const dataArrayIndex = ['Patente','Marca (opcional)','Modelo (opcional)','Tipo de Vehículo (opcional)',	'Propietario (opcional)','Costo viaje (opcional)']
        const dataArray = {
            'xlsxData': [
                {
                    'name': 'Patente',
                    'type': 'string',
                    'minlength': 6,
                    'maxlength': 6,
                    'notNull': false
                },
                {
                    'name': 'Marca (opcional)',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': true
                },
                {
                    'name': 'Modelo (opcional)',
                    'type': 'string',
                    'minlength': 6,
                    'maxlength': 6,
                    'notNull': true
                },
                {
                    'name': 'Tipo de Vehículo (opcional)',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': true
                },
                {
                    'name': 'Propietario (opcional)',
                    'type': 'string',
                    'minlength': 6,
                    'maxlength': 6,
                    'notNull': true
                },
                {
                    'name': 'Costo viaje (opcional)',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': true
                }
            ]
        }


        function GetFileExtension() {
            fileName = $('#excel_input').val();
            extension = fileName.split('.').pop();
            return extension;
        }

        $('#excel_input').on('change', async function() {
            const extension = GetFileExtension()
            if (extension == "xlsx") {



                const tableContent = await xlsxReadandWrite(dataArray);
                if (tableContent !== undefined) {



                    // const tableContent = await xlsxReadandWrite(dataArray);

                    let tableHead = $('#excelTable>thead')
                    let tableBody = $('#excelTable>tbody')
                    tableHead.append(tableContent.table[0])
                    tableBody.append(tableContent.table[1])
                    $('#fileName').text(tableContent[0]);
                    $('#excel_input').val("");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups',
                        text: 'El excel cargado no es el correcto, revise e intente nuevamente',
                    })
                }
            } else(
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'Debes cargar un Excel',
                })
            )
        })


        $('#excelTable>tbody').on('blur', 'td', function() {

            let value = $(this).text()

            //obtencion de las propiedades del TD
            let tdListClass = $(this).attr("class").split(/\s+/);
            let tdClass = tdListClass[0].replaceAll("_", " ");
            let tdPropertiesIndex = dataArrayIndex.indexOf(tdClass)
            let tdProperties = dataArray.xlsxData[tdPropertiesIndex]

            // SETEO DE PROPIEDADES
            let type = tdProperties.type
            let minlength = tdProperties.minlength
            let maxlength = tdProperties.maxlength
            let notNull = tdProperties.notNull

            //OBTENCION DE PROPIEDADES DE VALOR DE CELDA

            let tdType = isNumeric(value)
            let tdMinlength = minLength(value, minlength)
            let tdMaxlength = maxLength(value, maxlength)

            let tdNull = isNull(value);

            let errorCheck = false
            let tdTitle = ""

            //atributos return a td
            if (!notNull && tdNull) {
                errorCheck = false
                tdTitle = "Ingrese un valor"

            } else {

                if (type === "string" && tdType) {
                    errorCheck = true
                } else if (type === "int" && !tdType) {
                    errorCheck = false
                    tdTitle = "Ingrese un número"
                } else {
                    errorCheck = true
                }

                if (!notNull) {
                    if (!tdMinlength) {
                        tdTitle = `Debe tener un mínimo de ${minlength} caracteres`
                        errorCheck = false
                    }
                    if (!tdMaxlength) {
                        tdTitle = `Debe tener un máximo de ${maxlength} caracteres`
                        errorCheck = false
                    }
                } else {}
            }

            console.log("errorCheck", errorCheck);
            if (!errorCheck) {
                $(this).prop('title', tdTitle)
                $(this).addClass('err')
            } else {
                $(this).prop('title', "")
                $(this).removeClass('err')
            }
        })

        //Cerrar Modal

        $('#modalClose').on('click', function() {
            $('#masivavehicleCreation').modal('hide')
        });



        //GUARDAR REGISTROS MASIVA DENTRO DE MODAL
        $('#saveExcelData').on('click', function() {
            let counterErr = 0;


            $('#excelTable>tbody td').each(function() {

                var cellText = $(this).hasClass('err')
                if (cellText) {
                    counterErr++
                }

            });

            if (counterErr == 0) {

                let arrTd = []
                let preRequest = []

                $('#excelTable>tbody tr').each(function() {

                    arrTd = []
                    let td = $(this).find('td')

                    td.each(function() {
                        let tdTextValue = $(this).text()
                        arrTd.push(tdTextValue)
                    })
                    preRequest.push(arrTd)
                });

                const arrayRequest = preRequest.map(function(value,index) {
 
                    let BRAND  = _brands.find((brand)=>{ return brand.brand.toLowerCase() === value[1].toLowerCase()})
                    let MODEL  = _models.find((model)=>{ return model.model.toLowerCase() === value[2].toLowerCase()})
                    let TYPE  = _types.find((type)=>{ return type.tipo.toLowerCase() === value[3].toLowerCase()})
                    let owner = 1;
                    if(value[4].toLowerCase() === "externo"){
                        owner = 0 
                    }

                    if(BRAND === undefined){
                        BRAND = ""
                    }else{
                        BRAND = BRAND.id;
                    }
                    if(MODEL === undefined){
                        MODEL = ""
                    }else{
                        MODEL = MODEL.id;
                    }
                    if(TYPE === undefined){
                        TYPE = ""
                    }else{
                        TYPE = TYPE.id;
                    }

                    let returnArray = {
                        "empresa_id": EMPRESA_ID,
                        'patente':value[0] ,
                        'brand':BRAND,
                        'model':MODEL,
                        'type': TYPE,
                        'owner':owner,
                        'costPerTrip':value[5] 
                    }
                    return returnArray
                })
                
                $.ajax({
                    type: "POST",
                    url: "ws/vehiculo/addVehiculo.php",
                    data: JSON.stringify(arrayRequest),
                    dataType: 'json',
                    success: function(data) {

                        Swal.fire({
                            icon: 'info',
                            title: 'Excelente',
                            text: "Se han ingresado los vehículos"
                        });
                        _allMyVehicles = RESPONSE_VEHICLES.data;
                        printAllMyVehicles();
                    },
                    error: function(data) {
                        console.log(data.responseText);
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'Debe corregir los datos mal ingresado para continuar'
                })
            }
        })

        //DELETE VEHICULO 
        $(".deleteVehiculo").on('click', function() {

            let tr = $(this).closest('tr');
            let patente = $(this).closest('tr').find('.patente').text()
            let idVehiculo = $(this).closest('tr').find('.id_vehiculo').text()
            Swal.fire({
                icon: 'info',
                title: `Desea dar de baja el vehiculo: ${patente}`,
                showCancelButton: true,
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {

                    let arrayRequest = [{
                        id: idVehiculo
                    }]

                    $.ajax({
                        type: "POST",
                        url: "ws/vehiculo/deleteVehiculo.php",
                        data: JSON.stringify({
                            action: "deleteVehicle",
                            arrayIdVehicles: arrayRequest
                        }),
                        dataType: 'json',
                        success: async function(data) {
                            console.log(data);
                            tr.remove()
                            Swal.fire({
                                icon: 'success',
                                title: 'Excelente',
                                text: data.message
                            })

                        },
                        error: function(data) {
                            console.log(data.responseText);
                        }
                    })

                } else {
                    console.log("Cancelado");
                }
            })
        })
    </script>

</body>

</html>