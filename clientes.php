<?php 
$clientDash = true;
?>

<!DOCTYPE html>
<html lang="en">
<?php
require_once('./includes/head.php');
$active = 'clientes';
?>

<body>
    <?php include_once('./includes/Constantes/empresaId.php') ?>
    <?php include_once('./includes/Constantes/rol.php') ?>
    <script src="./assets/js/initTheme.js"></script>
    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div id="clientsContainer">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar y crear los vehículos para tus eventos</p>
                </div>

                <div class="row justify-content-end" style="margin:0px 14px;">
                    <button class="s-Button" id="openMasivaCliente" style="position: relative; right:-138px ; bottom: 50px;">
                        <p class="s-P">Agregar clientes masiva</p>
                    </button>
                    <button class="s-Button" id="openSideClientForm">
                        <p class="s-P">Agregar cliente</p>
                    </button>
                </div>

                <table class="s-table" id="dashClient-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Correo Eléctronico</th>
                            <th>Eventos</th>
                            <th>Facturación</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

            <?php if (in_array("9", $rol_id) || in_array("1", $rol_id) ||  in_array("2", $rol_id)) : ?>
            <?php endif; ?>
            <!-- <div class="page-header" style="margin-bottom: 30px;">
                <div style="display:flex; align-items: center;justify-content: space-between; ">
                    <h3 style="margin-right: 50px">Clientes</h3>
                    <a href="./ExcelFiles/Clientes.xlsx" download="Carga Masiva Clientes">
                        <div class="card">
                            <i style="font-size: 30px; color:#1D6F42; text-align: center;" class="fa-solid fa-download"></i>
                            <p style="font-size: 20px;">Descargar Formato Excel</p>
                        </div>
                    </a>
                </div>
                
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Carga unitaria</h5>
                                    <button class="btn btn-success" id="newClient">Agregar Nuevo Cliente</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-10">
                            <div class="card">
                                <div class="card-body" style="overflow-x: hidden;">
                                    <div class="row">
                                        <h5>Carga masiva de clientes</h5>
                                    </div>
                                    <input type="file" name="" id="excel_inputt">
                                </div>
                            </div>
                        </div>
                    </div>
            </div> -->
        </div>
        <?php require_once('./includes/footer.php') ?>
    </div>
    </div>
    
    <?php require_once('./includes/sidemenu/clientSideMenu.php') ?>
    <?php require_once('./includes/sidemenu/clientSideMenuDash.php') ?>
    <?php require_once('./includes/sidemenu/clienteMasivaSideMenu.php') ?>
    <?php require_once('./includes/footerScriptsJs.php') ?>

    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <!-- XSLX READER HJS CDN And JS CLASS FUNCTIONS-->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- SCRIPTS FUNCIONES JS -->
    <script src="./js/clientes.js"></script>
    <script src="./js/valuesValidator/validator.js"></script>
    <script src="./js/ClearData/clearFunctions.js"></script>
    <script src="./js/ProjectResume/viatico.js"></script>
    <script src="./js/validateForm/clientForm.js"></script>
    <script src="./js/validateForm/updateClient.js"></script>

</body>

<script>

    const EMPRESA_ID = <?php echo $empresaId;?>;
    // Obtener el elemento de input file y el elemento de visualización del nombre del archivo
    const fileInput = document.getElementById('excel_input');
    const fileNameDisplay = document.getElementById('fileName');
    const fileLabel = document.getElementById('fileLabel');

    $(document).ready(async function() {
        // fILL MAIN TABLE ON CLIENT
        FillClientesTable_dash();
        // Fill Clientes ON CLIENTE SELECT AND SIDE MENU
        // FillClientes(EMPRESA_ID);

        $('#openSideClientForm').on('click', function() {
            $('#clientSideMenu').addClass('active');
        })
        $('#closeThis').on('click', function() {
            $('#clientSideMenu').removeClass('active');
        })
        $('#openMasivaCliente').on('click', function() {
            $('#masivaClienteSideMenu').addClass('active');
        })
        $('#closeMasivaClientes').on('click', function() {
            $('#masivaClienteSideMenu').removeClass('active');
        });
        $('#closeDashClientSideMenu').on('click', function() {
            $('#clientSideMenu-clientDash').removeClass('active');
        });

        // Escuchar cambios en el input file y actualizar el nombre del archivo selec cionado
        fileInput.addEventListener('change', function() {
            const fileName = fileInput.files[0].name;
            fileNameDisplay.textContent = `Archivo seleccionado: ${fileName}`;
        });
    })

    // Evitar el comportamiento predeterminado del arrastre sobre el label
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

    const dataArrayIndex = ['Nombre Cliente', 'Razón social (opcional)', 'Rut (opcional)', 'Contacto (opcional)', 'Correo (opcional)' , 'Teléfono (opcional)']
    const dataArray = {
        'xlsxData': [{
                'name': 'Nombre Cliente',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': false
            },
            {
                'name': 'Razón social (opcional)',
                'type': 'string',
                'minlength': 3,
                'maxlength': 15,
                'notNull': true
            },
            {
                'name': 'Rut (opcional)',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },
            {
                'name': 'Contacto (opcional)',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },

            {
                'name': 'Correo (opcional)',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },
            {
                'name': 'Teléfono (opcional)',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            }
        ]
    }


    //Funcion que verifica la extension del archivo ingresado
    function GetFileExtension() {
        fileName = $('#excel_input').val();
        extension = fileName.split('.').pop();
        return extension;
    }

    $('#excel_input').on('change', async function() {
        const extension = GetFileExtension()
        if (extension === "xlsx") {

            const tableContent = await xlsxReadandWrite(dataArray);

            let tableHead = $('#excelTable>thead')
            let tableBody = $('#excelTable>tbody')
            tableHead.append(tableContent.table[0])
            tableBody.append(tableContent.table[1])
            $('#fileName').text(tableContent[0]);
            $('#excel_input').val("");
        } else(
            Swal.fire({
                icon: 'error',
                title: 'Ups',
                text: 'Debes cargar un Excel',
            })
        )
    })

    $('#excelTable>tbody').on('blur', 'td', function() {

        let value = $(this).text();
        //obtencion de las propiedades del TD
        let tdListClass = $(this).attr("class").split(/\s+/);
        let tdClass = tdListClass[0].replaceAll("_", " ");
        let tdPropertiesIndex = dataArrayIndex.indexOf(tdClass);
        let tdProperties = dataArray.xlsxData[tdPropertiesIndex];

        // SETEO DE PROPIEDADES
        let type = tdProperties.type;
        let minlength = tdProperties.minlength;
        let maxlength = tdProperties.maxlength;
        let notNull = tdProperties.notNull;

        //OBTENCION DE PROPIEDADES DE VALOR DE CELDA
        let tdType = isNumeric(value);
        let tdMinlength = minLength(value, minlength);
        let tdMaxlength = maxLength(value, maxlength);
        let tdNull = isNull(value);
        let errorCheck = false;
        let tdTitle = "";

        //atributos return a td
        if (!notNull && tdNull) {
            errorCheck = false;
            tdTitle = "Ingrese un valor";
        } else {
            if (type === "string" && tdType) {
                errorCheck = true
            } else if (type === "int" && !tdType) {
                errorCheck = false;
                tdTitle = "Ingrese un número";
            } else {
                errorCheck = true
            }
            if (!notNull) {
                if (!tdMinlength) {
                    tdTitle = `Debe tener un mínimo de ${minlength} caracteres`;
                    errorCheck = false;
                }
                if (!tdMaxlength) {
                    tdTitle = `Debe tener un máximo de ${maxlength} caracteres`;
                    errorCheck = false;
                }
            } else {}
        }
        if (!errorCheck) {
            $(this).prop('title', tdTitle);
            $(this).addClass('err');
        } else {
            $(this).prop('title', "");
            $(this).removeClass('err');
        }
    })



    //GUARDAR REGISTROS MASIVA DENTRO DE MODAL
    $('#saveExcelData').on('click', function() {
        let counterErr = 0;

        $('#excelTable>tbody td').each(function() {

            var cellText = $(this).hasClass('err');
            if (cellText) {
                counterErr++;
            }

        });

        if (counterErr == 0) {

            let arrTd = [];
            let preRequest = [];

            $('#excelTable tbody tr').each(function(index,element) {

                console.log(element)

                arrTd = [];
                let td = $(this).find('td');

                td.each(function() {
                    let tdTextValue = $(this).text();
                    arrTd.push(tdTextValue);
                })
                preRequest.push(arrTd);
            });

            console.log(preRequest);

            const arrayRequest = preRequest.map(function(value) {
                let  req_cliente ={
                    "nombre":value[0],
                    "razonSocial": value[1],
                    "rut": value[2],
                    "contacto": value[3],
                    "correo": value[4],
                    "telefono": value[5],
                }
                return req_cliente;
            })
            // console.table(arrayRequest);
            // console.log(arrayRequest);

            $.ajax({
                type: "POST",
                url: "ws/cliente/cliente.php",
                data: JSON.stringify({
                    tipo: 'AddClientMasiva',
                    request: arrayRequest,
                    "empresa_id": EMPRESA_ID
                }),
                dataType: 'json',
                success: async function(response){
                    if(response.success){
                        
                        $('#masivaClienteSideMenu').removeClass('active');
                        Swal.fire({
                            'icon': "success",
                            'title': 'Excelente',
                            'text': 'Clientes ingresados exitosamente',
                            'showConfirmButton': false,
                            'timer':2500
                        }).then(() => {
                            FillClientesTable_dash();
                        });
                        
                        $('#excelTable thead tr').remove();
                        $('#excelTable tbody tr').remove();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ups',
                text: 'Debe corregir los datos mal ingresado para continuar'
            })
        }
    });

    $('#showEventsRecord').on('click', function() {
        ShowEventRecord();
    })

    function ifNull(value) {
        if (value == null || value === undefined || value === "") {
            return "";
        } else {
            return value;
        }
    }
</script>

</html>