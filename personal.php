<!DOCTYPE html>
<html lang="en">

<?php
require_once('./includes/head.php');
$active = 'personal';
?>

<body>
    <script src="./assets/js/initTheme.js"></script>
    <?php include_once('./includes/Constantes/empresaId.php'); ?>
    <?php include_once('./includes/Constantes/rol.php'); ?>
    <?php
    require_once('./ws/bd/bd.php');
    $conn = new bd();
    $conn->conectar();
    $arregloPersonal = [];

    $queryContrato = 'select contrato FROM tipo_contrato tc';

    // //BUILD DATA PERSONAL
    // $responseDbPersonal = $conn->mysqli->query($queryPersonal);

    // while ($dataPersonal = $responseDbPersonal->fetch_object()) {
    //     $arregloPersonal[] = $dataPersonal;
    // }

    //BUILD TIPO CONTRATO DATA
    $responseDbTipoContrato = $conn->mysqli->query($queryContrato);

    while ($dataContratos = $responseDbTipoContrato->fetch_object()) {
        $contratos[] = $dataContratos;
    }
    ?>


    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>

        <div id="main">

            <div id="module-container">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar y crear los técnicos para tus eventos</p>
                </div>
                <div class="row justify-content-end" style="margin:0px 14px; gap :8px;">
                    <button class="s-Button-w" style="width: 250px;" id="openEspCarController">
                        <p class="s-P-g">Agregar cargo especialidad</p>
                    </button>
                    <button class="s-Button-w" style="width: 220px;" id="openMasivaPersonal" style="position: relative; right:-395px ; bottom: 50px;">
                        <p class="s-P-g">Agregar personal masiva</p>
                    </button>
                    <button class="s-Button" style="width: 220px;" id="openSidePersonalForm">
                        <p class="s-P">Agregar personal</p>
                    </button>
                </div>

                <div class="-t-container-x-scroll">

                    <table class="" id="personalDashTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Rut</th>
                                <th>Especialidad</th>
                                <th>Teléfono</th>
                                <th>Correo eléctronico</th>
                                <th>Tipo contrato</th>
                                <th>Costo mensual </th>
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

            </div>



            <!-- < 
                if (in_array("11", $rol_id) || in_array("1", $rol_id) ||  in_array("2", $rol_id)) : 
                > -->
            <!-- <p endif; > -->
            <!-- <div class="row justify-content-center">
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" id="btnPersonalUnitario" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#xlarge">
                                    Agregar personal
                                </button>
                                <button class="btn mt-2" onclick="ExportToExcel('xlsx')">
                                    <h4>Exportar a Excel</h4>
                                </button>
                            </div>
                        </div>
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" disabled class="btn btn-success" data-bs-toggle="modal" data-bs-target="#xlarge">
                                    Agregar personal masivo
                                </button>
                                <input class="form-control form-control-sm" id="excel_input" type="file" />
                            </div>
                        </div>
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cargoEspecialidad">
                                    Agregar Especialidades y cargos
                                </button>
                            </div>
                        </div>
                    </div> -->


            <!-- FIN modal masiva -->
            <?php require_once('./includes/footer.php') ?>
            <?php require_once('./includes/Modal/masivaProblems.php') ?>

        </div>
    </div>

    <?php require_once('./includes/footerScriptsJs.php') ?>

    <!-- REQUIRE SIDEMENU PERSONAL -->
    <?php require_once('./includes/sidemenu/personalSideMenu.php') ?>
    <?php require_once('./includes/sidemenu/personalSideMenuDash.php') ?>
    <?php require_once('./includes/sidemenu/personalMasivaSideMenu.php') ?>
    <?php require_once('./includes/sidemenu/especialidadCargoCrud.php') ?>
    <!-- xlsx Reader -->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <!-- FUNCTIONS (JS AJAX WITH PHP) PERSONAL MANAGEMENT  -->
    <script src="/js/personal.js"></script>

    <!-- valida form Create new personal -->
    <script src="./js/validateForm/personalSideMenu.js"></script>
    <!-- VALIDATE UPDATE PERSONAL -->
    <script src="./js/validateForm/udpatePersonal.js"></script>
    <script>
        const EMPRESA_ID = $('#empresaId').text();
        const fileInput = document.getElementById('excel_input');
        const fileNameDisplay = document.getElementById('fileName');
        const fileLabel = document.getElementById('fileLabel');

        $('#btnConfirmEspecialidad').on('click', function() {
            AddEspecialidad(EMPRESA_ID);
        });
        $('#btnConfirmCargo').on('click', function() {
            AddCargo(EMPRESA_ID);
        });
        $('#openSidePersonalForm').on('click', function() {
            // FILL ESPECIALIDAD
            GetEspecialidad(EMPRESA_ID);
            // FILL CARGOS
            GetCargo(EMPRESA_ID);
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

        function FillPersonalAllData(empresaId) {
            $.ajax({
                type: "POST",
                url: "ws/personal/Personal.php",
                data: JSON.stringify({
                    'action': 'getAllPersonalData',
                    'empresaId': EMPRESA_ID
                }),
                dataType: 'json',
                success: function(data) {

                    console.log("TODO EL PERSONAL", data);

                    if ($('#AllPersonalTable tbody tr').length > 0) {
                        $('#AllPersonalTable').empty();
                    }
                    if ($.fn.DataTable.isDataTable('#AllPersonalTable')) {
                        $('#AllPersonalTable').DataTable().destroy();
                    }
                    data.forEach(per => {
                        console.log("dentro del foreach");
                        let newTr = `<td class="id" align="center" style ="display:none"> ${per.id}</td>
                                    <td class="nombre" align="center"> ${per.nombre} </td>
                                    <td class="apellido" align="center"> ${per.apellido} </td>
                                    <td align="center">${per.rut} </td>
                                    <td align="center">${per.email}</td>
                                    <td align="center">${per.telefono}</td>
                                    <td align="center">${per.cargo}</td>
                                    <td align="center">${per.especialidad}</td>
                                    <td align="center">${per.contrato}</td>
                                    <td align="center"><input type="radio"></td>
                                    <td align="center"><i class="fa-solid fa-trash deletePersonal"></i><i style="left-margin:5px" class="fa-solid fa-pencil"></i></td>`
                        $('#AllPersonalTable').append(`<tr>${newTr}</tr>`);
                    });
                    $('#AllPersonalTable').DataTable({
                        fixedHeader: true,
                        scrollX: true
                    })
                },
                error: function(data) {
                    console.log(data.responseText);
                }
            })
        }

        function GetContratos() {
            return $.ajax({
                type: "POST",
                url: "ws/personal/Personal.php",
                data: JSON.stringify({
                    action: "getAllContratos"
                }),
                dataType: 'json',
                success: function(data) {
                    // console.table(data);
                    // console.log(data);

                },
                error: function(data) {
                    console.log(data.responseText);
                }
            });
        }

        function printContratos(contratos) {
            $('#contrato_Select').empty();
            $('#contrato_Select').append(new Option("", ""));
            contratos.forEach(contract => {
                $('#contrato_Select').append(new Option(`${contract.contrato}`, contract.id))
            });
        }

        $('#openSidePersonalForm').on("click", async function() {
            $('#personaSideMenu').addClass('active');
        })
        $('#closePersonalSideMenu').on("click", async function() {
            $('#personaSideMenu').removeClass('active');
        })
        $('#closeUpdatePersonalSideMenu').on("click", async function() {
            $('#personalSideMenu-personalDash').removeClass('active');
        })

        $('#openMasivaPersonal').on("click", async function() {
            $('#masivaPersonalSideMenu').addClass('active');
        })
        $('#closeMasivaPersonal').on("click", async function() {
            $('#masivaPersonalSideMenu').removeClass('active');
        })

        $('#openEspCarController').on("click", async function() {
            const ESPECIALIDADES = await GetEspecialidadByBussiness(EMPRESA_ID);
            printEspecialidadOnCrud(ESPECIALIDADES);
            const CARGOS = await GetCargoByBussiness(EMPRESA_ID);
            printCargosOnCrud(CARGOS);
            $('#especialidadCargoCrud').addClass('active');
        });


        $('#closeEspecialidadCargoCrud').on("click", async function() {
            $('#especialidadCargoCrud').removeClass('active');
        })


        $(document).ready(async function() {

            printPersonal();
            const contratos = await GetContratos();
            printContratos(contratos);

            $('#addPersonal').validate({
                rules : {
                    nombres: {
                        required: true,
                        minlength: 3
                    },
                    apellidos: {
                        required: true,
                        minlength: 3
                    },
                    rut: {

                    },
                    especialidad_select: {
                        required: true
                    },
                    contrato_Select: {
                        required: true
                    },
                    cargo_select: {
                        required: true
                    },
                    telefono: {
                        required: true
                    },
                    correoPersonalAddUnitario: {
                        required: true
                    },
                    neto: {

                    }
                },
                messages: {
                    nombres: {
                        required: "Ingrese un valor",
                        minlength: "El largo mínimo es de 3 caracteres"
                    },
                    apellidos: {
                        required: "Ingrese un valor",
                        minlength: "El largo mínimo es de 3 caracteres"
                    },
                    rut: {
                        required: "Ingrese un valor"
                    },
                    especialidad_select: {
                        required: "Ingrese un valor"
                    },
                    contrato_Select: {
                        required: "Ingrese un valor"
                    },
                    cargo_select: {
                        required: "Ingrese un valor"
                    },
                    telefono: {
                        required: "Ingrese un valor"
                    },
                    correoPersonalAddUnitario: {
                        required: "Ingrese un valor"
                    },
                    neto: {

                    }

                },
                submitHandler: function(form) {
                    event.preventDefault();
                    console.log("AGREGAR PERSONAL UNITARIO");
                    let nombres = $('#nombres').val();
                    let apellidos = $('#apellidos').val();
                    let rut = $('#rut').val();
                    let especialidad = $('#especialidad_select').val();
                    let contrato = $('#contrato_Select').val();
                    let cargo = $('#cargo_select').val();
                    let correoPersonal = $('#correoPersonalAddUnitario').val();
                    let telefonoPersonal = $('#inputTelefonoPersonal').val();
                    let neto = $('#neto').val();

                    let arrayRequest = [{
                        "nombre": nombres,
                        "apellido": apellidos,
                        "rut": rut,
                        "telefono": telefonoPersonal,
                        "correo": correoPersonal,
                        "cargo": cargo,
                        "especialidad": especialidad,
                        "idContrato": contrato,
                        "neto": neto
                    }]
                    console.log(arrayRequest);
                    $.ajax({
                        type: "POST",
                        url: "ws/personal/Personal.php",
                        data: JSON.stringify({
                            'action': 'AddPersonal',
                            'request': arrayRequest,
                            'empresaId': EMPRESA_ID
                        }),
                        dataType: 'json',
                        success: function(data) {
                            console.log("RESPONSE ADD PERSONAL UNITARIO", data);

                            if (data.success) {
                                Swal.fire({
                                    'icon': 'success',
                                    'title': "Listo",
                                    'text': data.success.message,
                                    'timer': 2500
                                })
                            }
                            if (data.error) {
                                Swal.fire({
                                    'icon': 'error',
                                    'title': "Ups!",
                                    'text': data.error.message,
                                    'timer': 2500
                                })
                            }
                        },
                        error: function(data) {
                            console.log(data.responseText);
                        }
                    }).then(() => {
                        $('#xlarge').modal('hide');
                        FillPersonalAllData(empresaId)
                    })
                }
            })
        });

        const dataArrayIndex = ['Nombre', 'Rut (opcional)', 'Especialidad', 'Cargo (opcional)', 'Tipo contrato (opcional)', 'Costo Mensual (opcional)', 'Correo (opcional)', 'Teléfono (opcional)']
        const dataArray = {
            'xlsxData': [{
                    'name': 'Nombre',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': false
                },
                {
                    'name': 'Rut (opcional)',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': true
                },
                {
                    'name': 'Especialidad',
                    'type': 'string',
                    'minlength': 1,
                    'maxlength': 15,
                    'notNull': false
                },
                {
                    'name': 'Cargo (opcional)',
                    'type': 'string',
                    'minlength': 1,
                    'maxlength': 50,
                    'notNull': true
                },
                {
                    'name': 'Tipo contrato (opcional)',
                    'type': 'string',
                    'minlength': 3,
                    'maxlength': 50,
                    'notNull': true
                },
                {
                    'name': 'Costo Mensual (opcional)',
                    'type': 'string',
                    'minlength': 1,
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
            if (extension == "xlsx") {


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
                } else {

                }

            }
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
            $('#masivaPersonalCreation').modal('hide')
        })

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
                const arrayRequest = preRequest.map(function(value) {
                    let returnArray = {
                        "nombre": value[0],
                        "apellido": "",
                        "rut": value[1],
                        "especialidad": value[2],
                        "cargo": value[3],
                        "contrato": value[4],
                        "neto": value[5],
                        "correo": value[6],
                        "telefono": value[7],
                    }
                    return returnArray
                })
                $.ajax({
                    type: "POST",
                    url: "ws/personal/Personal.php",
                    data: JSON.stringify({
                        action: "addPersonalMasiva",
                        request: arrayRequest,
                        empresaId: EMPRESA_ID
                    }),
                    dataType: 'json',
                    success: function(data) {
                        $('#masivaProblems').modal('show');
                        $('#masivaProblemsTitle').text('Resumen del ingreso del personal');
                        let table = $('#tableProblems')
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                "icon": "success",
                                "title": "Excelente!",
                                "text": "Técnicos agregados exitosamente",
                                "timer": 2500
                            });
                            $('#masivaPersonalSideMenu').removeClass('active');
                            $('#excelTable tr').remove();
                            $('#excel_input').val("");
                            $('#fileName').text("");


                        }
                        if (data.error) {
                            let responseArray = data.error.arrErr
                            let cargos = [];
                            let especialidades = [];
                            let contratos = [];
                            responseArray.forEach(el => {
                                if (el.problem === "Especialidad") {
                                    if (especialidades.includes(el.data.especialidad)) {} else {
                                        especialidades.push(el.data.especialidad)
                                    }
                                }
                                if (el.problem === "Cargo") {
                                    if (cargos.includes(el.data.cargo)) {} else {
                                        cargos.push(el.data.cargo)
                                    }
                                }
                                if (el.problem === "Contrato") {
                                    if (contratos.includes(el.data.contrato)) {} else {
                                        contratos.push(el.data.contrato)
                                    }
                                }
                                let tdToSearch = $(`#tableProblems .excelRow`);
                                if (tdToSearch.length > 0) {

                                    let arrayRows = [];

                                    $(`#tableProblems .excelRow`).each((key, element) => {

                                        let row = $(element).text();
                                        if (arrayRows.includes(row)) {

                                        } else {
                                            arrayRows.push(row);
                                        }
                                    })

                                    console.log("ARRAY ROWS", arrayRows);

                                    if (arrayRows.includes(`${el.row}`)) {

                                        let element = $(`#tableProblems .excelRow:contains('${el.row}')`)
                                        if (el.problem === "Cargo") {
                                            let cargo = $(element).closest('tr').find('.cargo');
                                            if (!$(cargo).hasClass('err')) {
                                                $(cargo).addClass('err');
                                                $(cargo).text(el.data.cargo);
                                            }
                                        }

                                        if (el.problem === "Especialidad") {
                                            let especialidad = $(element).closest('tr').find('.especialidad');
                                            if (!$(especialidad).hasClass('err')) {

                                                $(especialidad).addClass('err');
                                                $(especialidad).text(el.data.especialidad);

                                            }
                                        }
                                        if (el.problem === "Contrato") {

                                            let contrato = $(element).closest('tr').find('.contrato');

                                            if (!$(contrato).hasClass('err')) {

                                                $(contrato).addClass('err');
                                                $(contrato).text(el.data.contrato);

                                            }
                                        }
                                    } else {
                                        let tr = `<tr><td class="excelRow">${el.row}</td>
                                            <td class="nombre" >${el.data.nombre}</td>
                                            <td class="apellido" >${el.data.apellido}</td>
                                            <td class="rut" >${el.data.rut}</td>
                                            <td class="telefono" >${el.data.telefono}</td>
                                            <td class="correo" >${el.data.correo}</td>
                                            <td class="cargo ${el.problem === "Cargo" ? "err" :""}">${el.data.cargo}</td>
                                            <td class="especialidad ${el.problem === "Especialidad" ? "err" :""}">${el.data.especialidad}</td>
                                            <td class="contrato ${el.problem === "Contrato" ? "err" :""}">${el.data.contrato}</td></tr>`;
                                        table.append(tr);
                                    }
                                } else {
                                    let tr = `<tr><td class="excelRow">${el.row}</td>
                                        <td>${el.data.nombre}</td>
                                        <td>${el.data.apellido}</td>
                                        <td>${el.data.rut}</td>
                                        <td>${el.data.telefono}</td>
                                        <td>${el.data.correo}</td>
                                        <td class="cargo ${el.problem === "Cargo" ? "err" :""}">${el.data.cargo}</td>
                                        <td class="especialidad ${el.problem === "Especialidad" ? "err" :""}">${el.data.especialidad}</td>
                                        <td class="contrato ${el.problem === "Contrato" ? "err" :""}">${el.data.contrato}</td></tr>`;
                                    table.append(tr);
                                }
                            })

                            let ulEspecialidades = $('#ulEspecialidades');
                            let ulCargos = $('#ulCargos');

                            especialidades.forEach(el => {
                                ulEspecialidades.append(`<li> <p class="especialidadName">${el}</p>
                                                            <div class="container-end">
                                                                <div class="actionContainer">
                                                                    <p onclick="AddEspecialidadFromModal(this)" class="addDynamic">Agregar</p><i class="fa-solid fa-plus plus"></i>
                                                                </div>
                                                                <div class="actionContainer">
                                                                    <p  onclick="removeLi(this)" class="deleteDynamic">Quitar</p><i class="fa-solid fa-minus minus"></i>
                                                                </div>
                                                            </div>
                                                        </li>`);
                            });

                            cargos.forEach(el => {
                                ulCargos.append(`<li> <p class="cargoName">${el}</p>
                                                    <div class="container-end">
                                                        <div class="actionContainer">
                                                            <p onclick="AddCargoFromModal(this)" class="addDynamic">Agregar</p><i class="fa-solid fa-plus plus"></i>
                                                        </div>
                                                        <div class="actionContainer">
                                                            <p onclick="removeLi(this)" class="deleteDynamic">Quitar</p><i class="fa-solid fa-minus minus"></i>
                                                        </div>
                                                    </div>
                                                </li>`);
                            });
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
        })

        //DELETE PERSONAL 
        $(".deletePersonal").on('click', function() {

            let tr = $(this).closest('tr');
            let nombre = $(this).closest('tr').find('.nombre').text();
            let apellido = $(this).closest('tr').find('.apellido').text();
            let idPersonal = $(this).closest('tr').find('.id').text();

            Swal.fire({
                icon: 'info',
                title: `Desea dar de baja a: ${nombre} ${apellido}`,
                showCancelButton: true,
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {

                    let arrayRequest = [{
                        id: idPersonal
                    }]

                    $.ajax({
                        type: "POST",
                        url: "ws/personal/deletePersonal.php",
                        data: JSON.stringify(arrayRequest),
                        dataType: 'json',
                        success: async function(data) {

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

        async function AddespecialidadMasiva() {

            let names = $('#ulEspecialidades li');
            let arrayEspecialidades = [];

            if (names.length > 0) {
                $(names).each((key, value) => {
                    arrayEspecialidades.push($(value).find('.especialidadName').text());
                })
                const response = await Promise.all([AddEspecialidadGivenArray(EMPRESA_ID, arrayEspecialidades)]);

                if (response.length > 0) {
                    let li = $('#ulEspecialidades');
                    li.hide('slow', function() {
                        li.empty();
                    });
                    Swal.fire({
                        'icon': 'success',
                        'title': 'Excelente!',
                        'text': 'Datos ingresados con exito',
                        'timer': 1500,
                        'position': 'bottom-end',
                        'showConfirmButton': false
                    }).then(() => {
                        RemoveErrClass('especialidad', arrayEspecialidades);
                    })
                } else {
                    Swal.fire({
                        'icon': 'error',
                        'title': 'Ups!',
                        'text': `No se ha podido ingresar las especialidades`,
                        'timer': 1500,
                        'position': 'bottom-end',
                        'showConfirmButton': false
                    }).then(() => {})
                }
            } else {
                Swal.fire({
                    'icon': 'error',
                    'title': 'Ups!',
                    'text': `No hay especialidades para agregar`,
                    'timer': 2000,
                    'position': 'bottom-end',
                    'showConfirmButton': false
                })
            }
        }


        async function AddEspecialidadFromModal(element) {

            let valor = $(element).closest('li').find('.especialidadName').text();
            let li = $(element).closest('li');

            const response = await Promise.all([AddEspecialidadGivenArray(EMPRESA_ID, [valor])]);
            if (response.length > 0) {
                li.hide('slow', function() {
                    li.remove();
                });
                Swal.fire({
                        'icon': 'success',
                        'title': 'Excelente!',
                        'text': 'Datos ingresados con exito',
                        'timer': 1500,
                        'position': 'bottom-end',
                        'showConfirmButton': false
                    })
                    .then(() => {
                        RemoveErrClass('especialidad', [valor]);
                    })

            } else {

                Swal.fire({
                    'icon': 'error',
                    'title': 'Ups!',
                    'text': `No se ha podido ingresar la especialidad ${valor}`,
                    'timer': 1500,
                    'position': 'bottom-end',
                    'showConfirmButton': false
                }).then(() => {
                    $('#especialidadName').val("");
                    $('#cargoEspecialidad').modal('hide');
                })

            }
        }

        async function AddCargoFromModal(element) {
            let valor = $(element).closest('li').find('.cargoName').text();
            let li = $(element).closest('li');

            const response = await Promise.all([AddCargoGivenArray(EMPRESA_ID, [valor])]);
            if (response.length > 0) {

                li.hide('slow', function() {
                    li.remove();
                });

                Swal.fire({
                        'icon': 'success',
                        'title': 'Excelente!',
                        'text': 'Datos ingresados con exito',
                        'timer': 1500,
                        'position': 'bottom-end',
                        'showConfirmButton': false
                    })
                    .then(() => {
                        RemoveErrClass('cargo', [valor]);
                    })

            } else {

                Swal.fire({
                    'icon': 'error',
                    'title': 'Ups!',
                    'text': `No se ha podido ingresar la especialidad ${valor}`,
                    'timer': 1500,
                    'position': 'bottom-end',
                    'showConfirmButton': false
                })
            }
        }

        async function AddCargoMasiva() {

            let names = $('#ulCargos li');
            let arrayCargos = [];

            if (names.length > 0) {
                $(names).each((key, value) => {
                    arrayCargos.push($(value).find('.cargoName').text());
                })
                const response = await Promise.all([AddCargoGivenArray(EMPRESA_ID, arrayCargos)]);

                if (response.length > 0) {
                    let li = $('#ulCargos');
                    li.hide('slow', function() {
                        li.empty();
                    });
                    Swal.fire({
                            'icon': 'success',
                            'title': 'Excelente!',
                            'text': 'Datos ingresados con exito',
                            'timer': 1500,
                            'position': 'bottom-end',
                            'showConfirmButton': false
                        })
                        .then(() => {
                            RemoveErrClass('cargo', arrayCargos)
                        })

                } else {

                    Swal.fire({
                        'icon': 'error',
                        'title': 'Ups!',
                        'text': `No se ha podido ingresar las especialidades`,
                        'timer': 1500,
                        'position': 'bottom-end',
                        'showConfirmButton': false
                    })
                }
            } else {

                Swal.fire({
                    'icon': 'error',
                    'title': 'Ups!',
                    'text': `No hay especialidades para agregar`,
                    'timer': 2000,
                    'position': 'bottom-end',
                    'showConfirmButton': false
                })
            }
        }


        function RemoveErrClass(tipo, arrayToEvaulate) {
            const evaluateArray = arrayToEvaulate;
            if (tipo === "especialidad") {
                const arrayEspecialidad = $('#tableProblems > tbody tr .especialidad');
                $(arrayEspecialidad).each((key, element) => {
                    console.log($(element).text());
                    if ($(element).hasClass('err') && evaluateArray.includes($(element).text())) {
                        $(element).removeClass('err')
                    }
                })
            }
            if (tipo === "cargo") {
                const arrayEspecialidad = $('#tableProblems > tbody tr .cargo');
                $(arrayEspecialidad).each((key, element) => {
                    if ($(element).hasClass('err') && evaluateArray.includes($(element).text())) {
                        $(element).removeClass('err');
                    }
                });
            }
        }

        function AddPersonalFromModalProblems() {
            let arrayPersonal = [];

            $('#tableProblems > tbody tr').each((key, element) => {
                if (!$(element).find('.cargo').hasClass('err') && !$(element).find('.especilidad').hasClass('err')) {
                    arrayPersonal.push({
                        nombre: $(element).find('.nombre').text(),
                        apellido: $(element).find('.apellido').text(),
                        rut: $(element).find('.rut').text(),
                        correo: $(element).find('.telefono').text(),
                        telefono: $(element).find('.correo').text(),
                        neto: $(element).find('.neto').text(),
                        especialidad: $(element).find('.especialidad').text(),
                        contrato: $(element).find('.contrato').text(),
                        cargo: $(element).find('.cargo').text()
                    });
                }
            });

            if (arrayPersonal.length > 0) {
                $.ajax({
                        type: "POST",
                        url: "ws/personal/Personal.php",
                        data: JSON.stringify({
                            action: "addPersonalMasiva",
                            request: arrayPersonal,
                            empresaId: EMPRESA_ID
                        }),
                        dataType: 'json',
                        success: function(data) {

                        }
                    })
                    .then(() => {
                        FillPersonalAllData(EMPRESA_ID);
                    })
            }
        }

        function removeLi(element) {
            let li = $(element).closest('li');
            li.hide('slow', function() {
                li.remove();
            });
        }
    </script>

</body>

</html>