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
ob_end_flush();
$title = "Intec - Eventos";
?>

<!DOCTYPE html>
<html lang="en">
<?php
require_once('./includes/head.php');
$active = 'inventario';
?>
<body>
    <?php include_once('./includes/Constantes/empresaId.php') ?>
    <?php include_once('./includes/Constantes/rol.php') ?>
    <div id="app">

        <?php require_once('./includes/sidebar.php');?>

        <div id="main">
            <div id="module-container">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar el inventario</p>
                </div>
                <div class="row justify-content-between align-items-center">

                    <div class="row justify-content-start col-4" style="gap :8px;">
                        <div class="form-group" style="width:180px">
                            <label for="catSelect" class="inputLabel">Categoría</label>
                            <select id="catSelect" name="catSelect" type="text" class="form-select s-Select-g">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group" style="width:180px">
                            <label for="subcatSelect" class="inputLabel subcatSelect">Sub Categoría</label>
                            <select id="subcatSelect" name="subcatSelect" type="text" class="form-select s-Select-g">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-end col-7" style="margin:0px; gap :8px;">
                        <!-- <button class="s-Button" id="buttonProductoUnitario" onclick="openCreateProdSideMenu()">
                            <p class="s-P">Agregar nuevo producto</p>
                        </button> -->
                        <button class="s-Button" id="buttonProductosMasiva">
                            <p class="s-P">Agregar producto masivo</p>
                        </button>
                        <!-- <button class="s-Button" id="buttonAddCatItem">
                            <p class="s-P">Agregar categorías y subcategorías</p>
                        </button> -->
                    </div>
                </div>

                <table class="" id="productsDashTable">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Sub Categoría</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Precio Arriendo</th>
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

    <!-- Side Menu -->
    <?php require_once('./includes/sidemenu/productoMasivaSideMenu.php') ?>
    <?php require_once('./includes/sidemenu/addNewProductSideMenu.php') ?>

    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <!-- xlsx Reader -->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- JS FUNCTIONS REFERENCES -->
    <script src="/js/valuesValidator/validator.js"></script>
    <script src="/js/inventory/invTable/printInvTable.js"></script>
    <script src="/js/inventory/invTable/showProdData.js"></script>
    <script src="/js/inventory/prodData/deleteProduct.js"></script>
    <script src="/js/inventory/catsAndSubcats/catAndSubcatsSelector.js"></script>
    <script src="/js/inventory/invHandlers.js"></script>



    <!-- <script src="/js/categorias.js"></script>
    <script src="/js/marca.js"></script> -->
    <!-- <script src="/js/item.js"></script> -->
    <script src="/js/bottomBar.js"></script>


    <!-- PROD GET UPDATE FUNCTIONS -->
    <!-- <script src="./js/products/getProductInfo.js"></script> -->
    <!-- PRODS SIDE MENUS -->
    <?php require_once('./includes/sidemenu/productDataSideMenu.php'); ?>
    <!-- UPDATE PRODUCT FORM VALIDATION -->
    <script src="./js/validateForm/updateProduct.js"></script>
    <!-- FORM VALIDATION -->
    <script src="./js/validateForm/createNewProductSideMenu.js"></script>
</body>
<script>
    const IDEMPRESA = <?php echo $empresaId; ?>;
    const EMPRESA_ID = <?php echo $empresaId; ?>;
    // const EMPRESA_ID = 2;


    // let _allCats = [];
    // let _allSubCats_ = [];
    
    // let tempCats = [];
    // let tempSubCats = [];
    const fileInput = document.getElementById('excel_input');
    const fileNameDisplay = document.getElementById('fileName');
    const fileLabel = document.getElementById('fileLabel');

    $(document).ready(async function() {
        
        getCatsFromInventory(EMPRESA_ID);
        getBrandFromInventory();
        getCatsAndSubCatsByBussiness(EMPRESA_ID);
        getAllMyProductsToList(EMPRESA_ID);
        GetItems();

        // if (catsSubCats.success) {
        //     _allCats = catsSubCats.cats
        //     _allSubCats_ = catsSubCats.subcats;
        //     tempCats = catsSubCats.cats;
        //     tempSubCats = catsSubCats.allSubCats;

        //     printMyCats();

        // }
        // if (prods) {
        //     // console.log('_allProductsToList', _allProductsToList);
        //     // printMyProducts();
        // }
        // $('#example').DataTable({
        //     fixedHeader: true
        // });

        // getCatsFromInventory();



        fileInput.addEventListener('change', function() {
            const fileName = fileInput.files[0].name;
            fileNameDisplay.textContent = `Archivo seleccionado: ${fileName}`;
        });

        $('#closePordDataSideMenu').on('click', function() {
            $('#productDataSideMenu').removeClass('active');
        })
    });


    function getCatsFromInventory(empresa_id) {

        fetch('/ws/productos/getCategories.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    empresaId: empresa_id,
                    action: "getCategorias",
                })
            })
            .then((response) => response.json())
            .then((json) => {
                // insertProds(json)
                let select = $('#categoriaSelect')
                json.forEach(cat => {
                    let opt = $(select).append(new Option(capitalizeFirstLetter(cat.nombre), cat.id))
                });
                // console.log('getCatsFromInventory', json);
                // console.log('getCatsFromInventory', json);
                // console.log('getCatsFromInventory', json);
                // console.log('getCatsFromInventory', json);
                // console.log('getCatsFromInventory', json);
            })
            .catch((err) => console.log(err));
    }

    function getBrandFromInventory() {


        fetch('/ws/productos/getBrands.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: "getMarca",
                    empresaId: IDEMPRESA
                })
            })
            .then((response) => response.json())
            .then((json) => {
                let select = $('#marcaSelect')
                json.forEach(cat => {
                    let opt = $(select).append(new Option(capitalizeFirstLetter(cat.marca), cat.id))
                });
                // console.log('getBrandFromInventory', json)
                // console.log('getBrandFromInventory', json)
                // console.log('getBrandFromInventory', json)
                // console.log('getBrandFromInventory', json)
            })
            .catch((err) => console.log(err));
    }



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

    const dataArrayIndex = ['Categoria', 'Sub categoria', 'Nombre producto', 'marca', 'modelo', 'cantidad', 'precio compra', 'precio arriendo']
    const dataArray = {
        'xlsxData': [{
                'name': 'Categoria',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': false
            },

            {
                'name': 'Sub categoria',
                'type': 'string',
                'minlength': 3,
                'maxlength': 15,
                'notNull': true
            },

            {
                'name': 'Nombre producto',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': false
            },
            {
                'name': 'marca',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },

            {
                'name': 'modelo',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },
            {
                'name': 'cantidad',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': false
            },

            {
                'name': 'precio compra',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },

            {
                'name': 'precio arriendo',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            },
            // {
            //     'name': 'sku',
            //     'type': 'string',
            //     'minlength': 3,
            //     'maxlength': 50,
            //     'notNull': true
            // }
        ]
    }

    //Funcion que verifica la extension del archivo ingresado
    function GetFileExtension() {
        fileName = $('#excel_input').val();
        extension = fileName.split('.').pop();
        return extension;
    }

    $('#excel_input').on('change', async function() {
        const exInput = document.getElementById('excel_input');

        console.log($(exInput).files);

        const extension = GetFileExtension()
        if (extension == "xlsx") {
            // const tableContent = await xlsxReadandWrite(dataArray);
            const tableContent = await xlsxReadandWrite(dataArray);

            let tableHead = $('#excelTable>thead');
            let tableBody = $('#excelTable>tbody');
            $('#excelTable thead tr').remove();
            $('#excelTable tbody tr').remove();

            tableHead.append(tableContent.table[0])
            tableBody.append(tableContent.table[1])
            $('#fileName').text(tableContent[0]);

            setNoCatOrNoSubCat();

            orderExcelTable_printErrOnTop();

            const TABLE_WIDTH = $(tableBody).width();
            const TABLE_ROWS = $('#excelTable tbody tr').length;
            console.log(TABLE_ROWS);
            if (TABLE_ROWS <= 8) {
                tableBody.css('width', 'calc(100%)');
            } else {
                tableBody.css('width', 'calc(100% + 14px)');
            }

        } else(
            Swal.fire({
                icon: 'error',
                title: 'Ups',
                text: 'Debes cargar un Excel',
            })
        )
    });

    function setNoCatOrNoSubCat() {
        $('#excelTable tbody tr').each((index, tr) => {

            if ($(tr).find('td:eq(0)').text() === '') {
                $(tr).find('td:eq(0)').text('Sin categoría');
                $(tr).find('td:eq(0)').removeClass('err')
            }
            if ($(tr).find('td:eq(1)').text() === '') {
                $(tr).find('td:eq(1)').text('Sin Subcategoría')
                $(tr).find('td:eq(1)').removeClass('err')
            }


        });
    }


    function orderExcelTable_printErrOnTop() {
        const EXCEL_TABLE = $('#excelTable tr');
        const EXCEL_TABLE_BODY_FIRST_ROW = $('#excelTable tbody tr:first');
        EXCEL_TABLE.each((index, row) => {
            let tempRow = $(row);
            let cells = $(row).find('td');
            cells.each((index, cell) => {
                if ($(cell).hasClass('err')) {
                    EXCEL_TABLE_BODY_FIRST_ROW.before(tempRow);
                    return true;
                }
            })
        })
    }


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
        $('#masivaProductoCreation').modal('hide')
    })


    let confirmCatsAndSubCats = true;
    let exp_cats = [];
    let exp_subcats = [];
    //GUARDAR REGISTROS MASIVA DENTRO DE MODAL
    $('#saveExcelData').on('click', async function() {
        let counterErr = 0;

        $('#excelTable>tbody td').each(function() {

            var cellText = $(this).hasClass('err')
            if (cellText) {
                counterErr++
            }

        });

        if (counterErr > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Ups',
                text: 'Debe corregir los datos mal ingresado para continuar'
            });
            return;
        };

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

        const showExceptions = setAndPrintCatsAndSubCatExceptions(preRequest, false, true);

        if (showExceptions && confirmCatsAndSubCats) {
            setAndPrintCatsAndSubCatExceptions(preRequest, true, false);
            confirmCatsAndSubCats = false
            return;
        }


        confirmCatsAndSubCats = true;
        restoreMasivaSideMenu();

        const catsSubcategories = await catsSubCats(EMPRESA_ID);
        console.log('catsSubcategories', catsSubcategories);
        console.log('catsSubcategories', catsSubcategories);
        console.log('catsSubcategories', catsSubcategories);
        console.log('catsSubcategories', catsSubcategories);
        console.log('catsSubcategories', catsSubcategories);


        tempSubCats = [];
        tempCat = [];
        if (catsSubcategories.success) {
            tempCat = catsSubcategories.cats
            tempSubCats = catsSubcategories.allSubCats;
        }
        const arrayRequest = preRequest.map(function(value) {


            console.log("value[1]", value[1])
            console.log("value[0]", value[0])

            const CAT_EXISTS = tempCat.find((cat) => {
                return cat.nombre.toUpperCase() === value[0].toUpperCase()
            })
            const SUBCAT_EXISTS = tempSubCats.find((subCat) => {
                return subCat.item.toUpperCase() === value[1].toUpperCase()
            })
            if (CAT_EXISTS && SUBCAT_EXISTS) {
                console.log("INSERT");

                // let sku = value[8];
                // let sku = "";
                // if (sku === "" || sku === undefined || sku === null) {
                //     let arrName =  
                //     value[2]
                //     .replaceAll(" de ", " ")
                //      .replaceAll("+","_")
                //       .split(" ");
                //     let skuNameFormatt = ""
                //     arrName.forEach((namePiece) => {
                //         if (namePiece.length === 1) {
                //             skuNameFormatt += namePiece.toUpperCase();
                //         }
                //         if (namePiece.length === 2) {
                //             skuNameFormatt += namePiece.toUpperCase();
                //         }
                //         if (namePiece.length >= 3) {
                //             skuNameFormatt += namePiece.slice(0, 3).toUpperCase();
                //         } 
                //     })
                //     let bra_model_str = "";
                //     marca = value[3];
                //     modelo = value[4];
                //     if(marca === "" || marca === null ||marca === undefined){
                //         marca.slice(0,1).toUpperCase();
                //     }
                //     if(modelo === "" || modelo === null ||modelo === undefined){
                //         modelo.slice(0,1).toUpperCase();
                //     }
                //     sku = `${value[0].slice(0,3).toUpperCase()}-${value[1].slice(0,3).toUpperCase()}-${skuNameFormatt}_${marca}-${modelo}`;
                // }

                let returnArray = {
                    "categoria": value[0],
                    "item": value[1],
                    "categoria_id": CAT_EXISTS.id,
                    "subCat_id": SUBCAT_EXISTS.id,
                    "nombre": value[2],
                    "marca": value[3],
                    "modelo": value[4],
                    "stock": value[5],
                    "precioCompra": value[6] === "" ? 0 : value[6],
                    "precioArriendo": value[7] === "" ? 0 : value[7],
                    'sku': ""
                }
                return returnArray
            }
        }).filter((item) => {
            return item !== undefined
        });

        console.log('arrayRequest', arrayRequest);

        addProdsOnMasiveExcel(arrayRequest);
    });


    async function addProdsOnMasiveExcel(arrayRequest) {


        showProductosMasivaTableLoader();
        setProductosMasivaTableLoader();
        const RESPONSE_ADD_PRODS = await addProdsMasiva(arrayRequest, EMPRESA_ID);

        if (RESPONSE_ADD_PRODS.success) {
            Toastify({
                text: `Se han agregado ${RESPONSE_ADD_PRODS.insert_count} de ${RESPONSE_ADD_PRODS.total} productos`,
                duration: 5000
            }).showToast();
            setProductosMasivaTableSuccess();
            setTimeout(() => {
                hideProductosMasivaTableLoader();
                setTimeout(async () => {
                    $('#masivaProductoSideMenu').removeClass("active");
                    $('#excelTable thead tr').remove();
                    $('#excelTable tbody tr').remove();
                    const prods = await getAllMyProductsToList(EMPRESA_ID);
                    if (prods) {
                        _allProductsToList = prods;
                        printMyProducts();
                    }
                }, 500);
            }, 1500);
        } else {
            hideProductosMasivaTableLoader();
        }

    };

    function setProductosMasivaTableSuccess() {
        $('#spinnerProdsMasiva').remove();
        $('#loader-prods-masiva-content').append(SUCCESS);
    }

    function showProductosMasivaTableLoader() {
        $('#loading-section-prods-masiva').addClass("active");
    }

    function hideProductosMasivaTableLoader() {
        $('#loading-section-prods-masiva').removeClass("active");
    }

    function setProductosMasivaTableLoader() {
        $('#loader-prods-masiva-content div').remove();
        $('#loader-prods-masiva-content').append(`<div class="loadingio-spinner-rolling-a4dt90r28kv" id="spinnerProdsMasiva">
            <div class="ldio-r2lhg8dn3dg">
                <div></div>
            </div>
        </div>`);
    };
    async function addProdsMasiva(request, empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "addProdsMasiva",
                'empresa_id': empresa_id,
                'request': request
            }),
            success: function(response) {

            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    function setAndPrintCatsAndSubCatExceptions(preRequest, printData, stopExc) {
        let excel_cats_name = [];
        const MY_CATS_NAME = tempCats.map(({
            nombre
        }) => {
            return nombre.toUpperCase()
        });

        const EXCEL_CATS_NAME = preRequest.map((value) => {
            return value[0].toUpperCase();
        });

        const UNIQUE_CATS = [...new Set(EXCEL_CATS_NAME)]
        const NOT_EXISTING_CATS = UNIQUE_CATS.filter((cat) => {
            return !MY_CATS_NAME.includes(cat.toUpperCase())
        });

        const MY_SUBCATS_NAME = tempSubCats.map(({
            item
        }) => {
            return item.toUpperCase()
        });

        const EXCEL_SUBCATS_NAME = preRequest.map((value) => {
            return value[1].toUpperCase();
        });

        const UNIQUE_SUBCATS = [...new Set(EXCEL_SUBCATS_NAME)]
        const NOT_EXISTING_SUBCATS = UNIQUE_SUBCATS.filter((cat) => {
            return !MY_SUBCATS_NAME.includes(cat.toUpperCase())
        });

        exp_cats = NOT_EXISTING_CATS;
        exp_subcats = NOT_EXISTING_SUBCATS;

        if ((NOT_EXISTING_SUBCATS.length > 0 || NOT_EXISTING_CATS.length > 0) && stopExc) {
            return true;
        };

        if (printData) {

            $('#categorie-exp-table tbody tr').remove();
            $('#subCategorie-exp-table tbody tr').remove();
            $('.--exp-content').css('display', 'block');
            $('#exceptionContainer').css('display', 'flex');
            $('#excelTable').css('display', 'none');



            $('#cats-exp-card').hide();
            $('#subCats-exp-card').hide();

            if (NOT_EXISTING_CATS.length > 0) {
                $('#cats-exp-card').show();

                NOT_EXISTING_CATS.forEach((cat) => {
                    let tr = `<tr>
                        <td class="--ds-td" style="width:60%"><p class="--desc">${cat}</p></td>
                        <td class="--exp-add-cat" style="width:40%"><p class="s-P-g">Agregar</p></td>
                    </tr>`
                    $('#categorie-exp-table tbody').append(tr);
                })
            }

            if (NOT_EXISTING_CATS.length > 0) {
                $('#subCats-exp-card').show();
                NOT_EXISTING_SUBCATS.forEach((subcat) => {
                    let tr = `<tr>
                        <td style="width:60%"><p class="--desc">${subcat}</p></td>
                        <td class="--exp-add-subCat" style="width:40%"><p class="s-P-g">Agregar</p></td>
                    </tr>`
                    $('#subCategorie-exp-table tbody').append(tr);
                });
            }
        } else {}
    }

    function restoreMasivaSideMenu() {
        $('.--exp-content').css('display', 'none');
        $('#exceptionContainer').css('display', 'none');
        $('#excelTable').css('display', 'table');
    }


    $(document).on("click", ".--exp-add-cat", async function() {

        const CAT_NAME = $(this).closest('tr').find('.--desc').text();

        let arrCategories = [{
            "nombre": CAT_NAME
        }]

        const CAT_RESPONSE = await addCatsAndGetResponse(arrCategories);

        if (CAT_RESPONSE) {
            $(this).closest('tr').fadeOut(500, function() {
                $(this).remove();
            });
        }
    });



    $(document).on("click", "#addAllCategories", async function() {

        const catTr = $('#categorie-exp-table tbody tr')

        const arrCats = $(catTr).map((index, cat) => {
                let name = $(cat).find('.--desc').text();
                return {
                    "nombre": name
                }
            })
            .toArray();
        showCatLoader();
        setCatLoader();
        const ADD_ALL_CATS = await addCatsAndGetResponse(arrCats);

        if (ADD_ALL_CATS) {

            setCatSuccess();
            setTimeout(() => {
                hideCatLoader();
                setTimeout(() => {
                    $('#cats-exp-card').hide("slow");
                }, 500);
            }, 1500);

        } else {
            hideCatLoader();
        }



    });


    function setCatSuccess() {
        $('#spinnerCats').remove();
        $('#loader-cat-content').empty();
        $('#loader-cat-content').append(SUCCESS);
    }


    function showCatLoader() {
        $('#loading-section').addClass("active");
    }

    function hideCatLoader() {
        $('#loading-section').removeClass("active");
    }

    function setCatLoader() {
        $('#loader-cat-content').empty();
        $('#loader-cat-content').append(`<div class="loadingio-spinner-rolling-a4dt90r28kv" id="spinnerCats">
            <div class="ldio-r2lhg8dn3dg">
                <div></div>
            </div>
        </div>`);
    };

    $(document).on("click", "#addAllSubCategories", async function() {

        const catTr = $('#subCategorie-exp-table tbody tr')

        const arrSubCats = $(catTr).map((index, cat) => {
                let name = $(cat).find('.--desc').text();
                return {
                    "nombre": name
                }
            })
            .toArray();

        console.log(arrSubCats);
        showSubCatLoader();
        setSubCatLoader();
        const ADD_ALL_CATS = await addSubCatsAndGetResponse(arrSubCats);

        if (ADD_ALL_CATS) {
            setSubCatSuccess();
            setTimeout(() => {
                hideSubCatLoader();
                setTimeout(() => {
                    $('#subCats-exp-card').hide("slow");
                }, 500);
            }, 1500);
        } else {
            hideSubCatLoader();
        }
    });



    function showSubCatLoader() {
        $('#loader-sub-cat-content').empty();
        $('#loading-section-subcats').addClass("active");
    }

    function hideSubCatLoader() {
        $('#loading-section-subcats').removeClass("active");
    }

    function setSubCatLoader() {
        $('#loader-sub-cat-content').empty();
        // $('#loader-sub-cat-content div').remove();
        $('#loader-sub-cat-content').append(`<div class="loadingio-spinner-rolling-a4dt90r28kv" id="spinnerSubCats">
            <div class="ldio-r2lhg8dn3dg">
                <div></div>
            </div>
        </div>`);
    }

    function setSubCatSuccess() {
        $('#spinnerSubCats').remove();
        $('#loader-sub-cat-content').append(SUCCESS);
    }



    async function addCatsAndGetResponse(arrCategories) {
        const CAT_INSERT_RESPONSE = await insertCatsOnArr(arrCategories, EMPRESA_ID);
        if (CAT_INSERT_RESPONSE.fatalError) {
            Swal.fire({
                icon: 'error',
                title: "Ups!",
                'text': CAT_INSERT_RESPONSE.message
            })
            return;
        }
        if (CAT_INSERT_RESPONSE.success) {

            if (arrCategories.length === 1) {

                Toastify({
                    text: `${arrCategories[0].nombre} agregado`,
                    duration: 3000
                }).showToast();
            } else {
                Toastify({
                    text: `Categorías agregadas exitosamente`,
                    duration: 3000
                }).showToast();

            }
            return true;
        }
    }
    async function addSubCatsAndGetResponse(arrSubCats) {
        const SUBCAT_INSERT_RESPONSE = await insertSubCatOnArr(arrSubCats, EMPRESA_ID);
        if (SUBCAT_INSERT_RESPONSE.fatalError) {
            Swal.fire({
                icon: 'error',
                title: "Ups!",
                'text': SUBCAT_INSERT_RESPONSE.message
            })
            return;
        }
        if (SUBCAT_INSERT_RESPONSE.success) {

            if (arrSubCats.length === 1) {

                Toastify({
                    text: `${arrSubCats[0].nombre} agregado`,
                    duration: 3000
                }).showToast();
            } else {
                Toastify({
                    text: `Subcategorías agregadas exitosamente`,
                    duration: 3000
                }).showToast();

            }
            return true;
        }
    }

    $(document).on("click", ".--exp-add-subCat", async function() {

        const SUBCAT_NAME = $(this).closest('tr').find('.--desc').text();
        let arrSubCategories = [{
            "nombre": SUBCAT_NAME
        }];
        const SUBCAT_INSERT_RESPONSE = await addSubCatsAndGetResponse(arrSubCategories);


        if (SUBCAT_INSERT_RESPONSE) {
            $(this).closest('tr').fadeOut(500, function() {
                $(this).remove();
            });
        }
    });

    async function insertCatsOnArr(arrCats, empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "insertCatsOnArr",
                'empresa_id': empresa_id,
                'arrCats': arrCats
            }),
            success: function(response) {

            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    async function insertSubCatOnArr(arrCats, empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "insertSubCatOnArr",
                'empresa_id': empresa_id,
                'arrCats': arrCats
            }),
            success: function(response) {

            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    $('#buttonProductosMasiva').on('click', function() {
        $('#masivaProductoSideMenu').addClass('active')
    });

    $('#closeMasivaProductos').on('click', function() {
        $('#masivaProductoSideMenu').removeClass('active')
    });

    $('#buttonProductoUnitario').on('click', function() {
        $('#productoUnitarioCreation').modal('show');
    });

    function printSubCats(filtered) {

        $('#subcatSelect option').remove();
        $('#subcatSelect').append(new Option("Todas", "all"));
        filtered.forEach((subcat) => {
            let option = new Option(subcat.item, subcat.subcat_id);
            $('#subcatSelect').append(option);
        });
    }

    function printSubcatsOnProdSideMenu(filtered){
        $('#subCatProd option').remove();
        $('#subCatProd').append(new Option("Todas", "all"))
        filtered.forEach((subcat) => {
            let option = new Option(subcat.item, subcat.subcat_id);
            $('#subCatProd').append(option);
        });
    }



    // function AddCategoria() {
    //     let string = $('#CatName').val()
    //     if (string !== "") {

    //         const arrayCategorias = string.split(",")
    //         $.ajax({
    //             type: "POST",
    //             url: "ws/categoria_item/categoria.php",
    //             data: JSON.stringify({
    //                 action: "AddCategorias",
    //                 request: arrayCategorias,
    //                 empresaId: EMPRESA_ID
    //             }),
    //             dataType: 'json',
    //             success: async function(data) {
    //                 console.log(data);
    //             }
    //         })

    //     } else {
    //         Swal.fire({
    //             'icon': 'error',
    //             'title': 'Ups!',
    //             'text': 'Ingrese al menos una categoría'
    //         })
    //     }
    // }

    // function AddItem() {
    //     let string = $('#ItemName').val()
    //     if (string !== "") {
    //         const arrayItems = string.split(",")
    //         $.ajax({
    //             type: "POST",
    //             url: "ws/categoria_item/item.php",
    //             data: JSON.stringify({
    //                 action: "AddItems",
    //                 request: arrayItems,
    //                 empresaId: EMPRESA_ID
    //             }),
    //             dataType: 'json',
    //             success: async function(data) {
    //                 console.log(data);
    //             }
    //         })

    //     } else {
    //         console.log("INGRESE UN VALOR");
    //     }
    // }
</script>
</html>