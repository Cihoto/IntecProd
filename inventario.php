<?php
require_once('./ws/bd/bd.php');
$conn = new bd();
$conn->conectar();

$categorias = [];

$queryProductos = 'Select c.nombre , i.item, p.nombre, mo.modelo, p.precio_arriendo from producto p 
                    INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
                    INNER JOIN categoria c on c.id =p.categoria_has_item_id 
                    INNER JOIN item i on i.id  = p.categoria_has_item_id 
                    INNER JOIN marca m on m.id = p.marca_id
                    INNER JOIN modelo mo on mo.marca_id = m.id 
                    WHERE p.empresa_id = 1';

$queryCategorias = 'select c.nombre ,c.id  from categoria c';
// inner join categoria_has_item chi on chi.categoria_id = c.id 
// INNER JOIN producto p on p.categoria_has_item_id  = chi.id 
// where p.empresa_id = 1
// group by c.nombre ';


if ($categoriasBdResponse = $conn->mysqli->query($queryCategorias)) {
    while ($dataCategorias = $categoriasBdResponse->fetch_object()) {
        $categorias[] =  $dataCategorias;
    }
} else {
}
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
    <script src="./assets/js/initTheme.js"></script>
    <div id="app">

        <?php
        require_once('./includes/sidebar.php');
        ?>

        <div id="main">
            <div id="module-container">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar el inventario</p>
                </div>
                <div class="row justify-content-between align-items-center">

                    <div class="row justify-content-start col-4" style="margin:0px 14px; gap :8px;">
                        <div class="form-group" style="width:180px">
                            <label for="catSelect" class="inputLabel">Categoría</label>
                            <select id="catSelect" name="catSelect" type="text" class="form-select s-Select-g">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group" style="width:180px">
                            <label for="subcatSelect" class="inputLabel">Sub Categoría</label>
                            <select id="subcatSelect" name="subcatSelect" type="text" class="form-select s-Select-g">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-end col-7" style="margin:0px 14px; gap :8px;">
                        <button class="s-Button" id="buttonProductoUnitario">
                            <p class="s-P">Agregar nuevo producto</p>
                        </button>
                        <button class="s-Button" id="buttonProductosMasiva">
                            <p class="s-P">Agregar producto masivo</p>
                        </button>
                        <button class="s-Button" id="buttonAddCatItem">
                            <p class="s-P">Agregar categorías y subcategorías</p>
                        </button>
                    </div>
                </div>

                <table class="s-table" id="productsDashTable">
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
            <!-- <nav class="topbar navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul id="topBar-Content" class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="">Categorías</a>
                            <ul class="dropdown-menu"> -->
                                <!-- <php
                                if (count($categorias) === 0) {
                                    echo '<li><a href="">Haz click aquí para poder Crear tus categorías</a></li>';
                                } else {
                                    foreach ($categorias as $key => $value) {
                                        $catNombre = $value->nombre;

                                        echo '<li> <a class="' . strtolower($catNombre) . ' categoria dropdown-item">' . ucfirst($catNombre) . ' &raquo</a>';

                                        $queryItems = "SELECT i.item , c.nombre  from item i 
                                                            INNER JOIN categoria_has_item chi on chi.item_id = i.id 
                                                            INNER JOIN categoria c on c.id =chi.categoria_id 
                                                            INNER JOIN producto p on p.categoria_has_item_id = chi.id
                                                            WHERE LOWER(c.nombre) = '" . $catNombre . "'
                                                            GROUP BY chi.id ";

                                        $items = [];
                                        $responseBdItems = $conn->mysqli->query($queryItems);
                                        while ($dataItems = $responseBdItems->fetch_object()) {
                                            $items[] = $dataItems;
                                        }

                                        if (count($items) > 0) {
                                            echo '<ul class="dropdown-menu submenu">';
                                            foreach ($items as $key => $item) {

                                                echo '<li><a class="' . $item->item . ' ' . $catNombre . ' item dropdown-item">' . $item->item . ' </a></li>';
                                            }
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                }
                                ?>
                            </ul> -->
                        <!-- </li> -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="">Items</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Item 1 &raquo;</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a href="" class="dropdown-item">SubItem</a></li>
                                        <li><a href="" class="dropdown-item">SubItem 2</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="">Item 2</a></li>
                                <li><a class="dropdown-item" href="">Item 3</a></li>
                            </ul>
                        </li> -->
                    <!-- </ul>
                </div>
            </nav>

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-header">

                <div style="display:flex; align-items: center; margin-bottom: 30px;">
                    <h3 style="margin-right: 50px">Inventario</h3>
                    <a id="download-Excel" style="height: 20px; line-height: 20px;font-size: 30px;" href="./ExcelFiles/ProductosM.xlsx" download="Carga Masiva Equipos"><i class="fa-solid fa-file-excel" style="color: #1D6F42; "></i></a>
                </div>
                <php if (in_array("1", $rol_id) || in_array("2", $rol_id) || in_array("6", $rol_id)) : ?>
                    <div class="row">
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" id="buttonProductoUnitario" class="btn btn-success">
                                    Agregar Nuevo Producto
                                </button>
                            </div>
                        </div>
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" class="btn btn-success" id="buttonProductosMasiva" data-bs-toggle="modal" data-bs-target="#masivaProductoCreation">
                                    Agregar Productos masivo
                                </button>
                                <input class="form-control form-control-sm" id="excel_input" type="file" />
                            </div>
                        </div>
                        <div class="col-8 col-lg-3 col-sm-4">
                            <div class="card">
                                <button type="button" class="btn btn-success" id="buttonAddCatItem" data-bs-toggle="modal" data-bs-target="#modalCatItemAdd">
                                    Agregar una nueva categoría o ítem
                                </button>
                            </div>
                        </div>
                    </div> -->
                <!-- <php endif; ?> -->
            <!-- </div> -->


            <!-- modal agregar Producto -->
            <?php include_once('./includes/Modal/productoModal.php') ?>
            <!-- END MODAL AGREGAR PRODUCTO -->

            <!-- INCLUDE MODAL ACTEGORIA ITEM  -->
            <?php include_once('./includes/Modal/categoriaItem.php') ?>
            <!-- END MODAL CATEGORIA ITEM -->
<!-- 
            <div class="page-content">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body px-4 py-4">
                                    <table class="table" id="tableProductos" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Categoría</th>
                                                <th style="text-align: center;">Sub Categoría</th>
                                                <th style="text-align: center;">Producto</th>
                                                <th style="text-align: center;">Modelo</th>
                                                <th style="text-align: center;">Cantidad total</th>
                                                <th style="text-align: center;">Cantidad disponible</th>
                                                <th style="text-align: center;">Precio Arriendo</th>
                                                <th style="text-align: center;">Estado</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;">Categoría</th>
                                                <th style="text-align: center;">Sub Categoría</th>
                                                <th style="text-align: center;">Producto</th>
                                                <th style="text-align: center;">Modelo</th>
                                                <th style="text-align: center;">Cantidad total</th>
                                                <th style="text-align: center;">Cantidad disponible</th>
                                                <th style="text-align: center;">Precio Arriendo</th>
                                                <th style="text-align: center;">Estado</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Modal agregar productos masiva -->
            <!-- < include_once('./includes/Modal/productosMasiva.php'); ?> -->
            <!-- end modal agregar producots masiva -->

            <!-- Modal errores post agregar Masiva -->
            <!-- <div class="modal fade modal-xl" id="modalErrMasiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Desea ingresar esta información</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div style="margin:0px 30px" class="modal-body">
                            <table class="table" id="errTable">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="modalClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-success" id="saveExcelData">Guardar</button>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- FIN modal -->

            <?php require_once('./includes/footer.php') ?>

        </div>
    </div>

    <?php require_once('./includes/footerScriptsJs.php') ?>

    <!-- xlsx Reader -->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <!-- Side Menu -->
    <?php require_once('./includes/sidemenu/productoMasivaSideMenu.php')?>
    <!-- JS FUNCTIONS REFERENCES -->
    <script src="/js/valuesValidator/validator.js"></script>
    <script src="/js/categorias.js"></script>
    <script src="/js/marca.js"></script>
    <script src="/js/item.js"></script>

</body>
<script>
    const IDEMPRESA = document.getElementById('empresaId').textContent;

    const EMPRESA_ID = $('#empresaId').text();


    $('#buttonProductosMasiva').on('click', function() {
        // $('#masivaProductoCreation').modal('show');

        $('#masivaProductoSideMenu').addClass('active')
    })
    $('#closeMasivaProductos').on('click', function() {
        // $('#masivaProductoCreation').modal('show');

        $('#masivaProductoSideMenu').removeClass('active')
    })

    $('#buttonProductoUnitario').on('click', function() {
        console.log("BOTON UNITARIO");
        $('#productoUnitarioCreation').modal('show');

        console.log($('#productoUnitarioModal'))
    });


    let _allCats = [];
    let _allSubCats_ = [];
    let _allProductsToList = [];

    function printMyCats() {
        $('#catSelect option').remove();
        $('#catSelect').append(new Option("Todas", "all"))
        _allCats.forEach((cat) => {
            let option = new Option(cat.nombre, cat.id);
            $('#catSelect').append(option);
        })

    }

    function printSubCats(filtered) {
        $('#subcatSelect option').remove();
        $('#subcatSelect').append(new Option("Todas", "all"))
        filtered.forEach((subcat) => {
            let option = new Option(subcat.item, subcat.subcat_id);
            $('#subcatSelect').append(option);
        })

    }

    function printMyProducts() {
        if ($.fn.DataTable.isDataTable('#productsDashTable')) {
            $('#productsDashTable').DataTable()
                .clear()
                .draw();
            $('#productsDashTable').DataTable().destroy();
        }

        _allProductsToList.forEach((producto, index) => {

            let tr = `<tr client_id="1">
                <td>${producto.categoria}</td>
                <td>${producto.subcategoria}</td>
                <td>${producto.nombre_producto}</td>
                <td>${producto.stock}</td>
                <td>${CLPFormatter(producto.precio_arriendo)}</td>
            </tr>`
            $('#productsDashTable tbody').append(tr);

        });

        if (!$.fn.DataTable.isDataTable('#productsDashTable')) {

            dash_Client_table = new DataTable('#productsDashTable', {
                "responsive": false,
                "paging": true,
                "scrollX": false,
                "autoWidth": false,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Clientes",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                columnDefs: [{
                        "width": "17%",
                        "targets": "_all"
                    }, {
                        className: "ps-header",
                        "targets": [0]
                    }, {
                        className: "tc",
                        "targets": [3]
                    },
                    {
                        "defaultContent": "-",
                        "targets": "_all"
                    }
                ],
                "pageLength": 5

            });

        }


    }



    async function getCatsAndSubCatsByBussiness(empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            data: JSON.stringify({
                action: "getCatsAndSubCatsByBussiness",
                empresa_id: empresa_id
            }),
            dataType: 'json',
            success: async function(data) {
                console.log(data);
            }
        })
    }
    async function getAllMyProductsToList(empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            data: JSON.stringify({
                action: "getAllMyProductsToList",
                empresaId: empresa_id
            }),
            dataType: 'json',
            success: async function(data) {
                console.log(data);
            }
        })
    }
    async function customProdSearch(request, empresa_id) {
        return $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            data: JSON.stringify({
                action: "customProdSearch",
                request: request,
                empresaId: empresa_id
            }),
            dataType: 'json',
            success: async function(data) {
                console.log(data);
            }
        })
    }



    $('#catSelect').on("change", async function() {
        let cat = $('#catSelect').val();
        let subCat = $('#subcatSelect').val();


        if (cat === "all") {

            printSubCats(_allSubCats_);
        } else {
            const subCatToPrint = _allSubCats_.filter((subcat) => {
                return subcat.cat_id === cat
            })

            printSubCats(subCatToPrint);
        }

        let request = {
            'cat': cat,
            'subcat': subCat
        }
        const prods = await customProdSearch(request, EMPRESA_ID);



        if (!prods.success) {
            Swal.fire({
                "icon": "error",
                "title": "Ups!",
                "text": "Intente nuevamente"
            })
            return
        }

        _allProductsToList = prods.data;

        printMyProducts();
    })
    $('#subcatSelect').on("change", async function() {
        let cat = $('#catSelect').val();
        let subCat = $('#subcatSelect').val();

        let request = {
            'cat': cat,
            'subcat': subCat
        }
        const prods = await customProdSearch(request, EMPRESA_ID);

        if (!prods.success) {
            Swal.fire({
                "icon": "error",
                "title": "Ups!",
                "text": "Intente nuevamente"
            })
            return
        }

        _allProductsToList = prods.data;

        printMyProducts();
    })

    $(document).ready(async function() {


        const catsSubCats = await getCatsAndSubCatsByBussiness(EMPRESA_ID);

        const prods = await getAllMyProductsToList(EMPRESA_ID);

        if (catsSubCats.success) {
            _allCats = catsSubCats.cats
            _allSubCats_ = catsSubCats.subcats;
            printMyCats();
        }
        if (prods) {
            _allProductsToList = prods;
            printMyProducts();
        }



        $('#example').DataTable({
            fixedHeader: true
        });

        GetCategorias();
        GetMarca();
        GetItems();

        $('#productosCreateUnitario').validate({
            rules: {
                txtNombreProducto: {
                    required: true
                },
                categoriaSelect: {
                    required: false
                },
                marcaSelect: {
                    required: true
                },
                itemSelect: {
                    required: true
                },
                txtCantidad: {
                    required: true
                },
                txtPrecioCompra: {
                    required: false
                },
                txtPrecioEstimadoArriendo: {
                    required: false
                }
            },
            messages: {
                txtNombreProducto: {
                    required: "Ingrese un valor"
                },
                categoriaSelect: {
                    required: "Ingrese un valor"
                },
                marcaSelect: {
                    required: "Ingrese un valor"
                },
                itemSelect: {
                    required: "Ingrese un valor"
                },
                txtCantidad: {
                    required: "Ingrese un valor"
                },
                txtPrecioCompra: {
                    required: "Ingrese un valor"
                },
                txtPrecioEstimadoArriendo: {
                    required: "Ingrese un valor"
                }
            },
            submitHandler: function() {
                event.preventDefault();

                let NombreProducto = $('#inputNombreProducto').val();
                let categoriaSelect = $('#categoriaSelect selectedIndex').text();
                let marcaSelect = $('#marcaSelect selectedIndex').text();
                let itemSelect = $('#itemSelect selectedIndex').text();
                let cantidad = $('#inputCantidad').val();
                let precioCompra = $('#inputPrecioCompra').val();
                let precioEstimadoArriendo = $('#inputPrecioEstimadoArriendo').val();

                let arrayRequest = [{
                    "nombre": NombreProducto.trim(),
                    "marca": marcaSelect.trim(),
                    "modelo": "Generico",
                    "categoria": categoriaSelect.trim(),
                    "item": itemSelect.trim(),
                    "stock": cantidad.trim(),
                    "precioCompra": precioCompra.trim() === "" ? 0 : precioCompra.trim(),
                    "precioArriendo": precioEstimadoArriendo.trim() === "" ? 0 : precioCompra.trim()
                }]

                $.ajax({
                    type: "POST",
                    url: "ws/productos/addProductos.php",
                    data: JSON.stringify(arrayRequest),
                    dataType: 'json',
                    success: async function(data) {
                        console.log(data);
                    }
                })

            }
        })
    });


    function AddCategoria() {
        let string = $('#CatName').val()
        if (string !== "") {

            const arrayCategorias = string.split(",")
            $.ajax({
                type: "POST",
                url: "ws/categoria_item/categoria.php",
                data: JSON.stringify({
                    action: "AddCategorias",
                    request: arrayCategorias,
                    empresaId: EMPRESA_ID
                }),
                dataType: 'json',
                success: async function(data) {
                    console.log(data);
                }
            })

        } else {
            Swal.fire({
                'icon': 'error',
                'title': 'Ups!',
                'text': 'Ingrese al menos una categoría'
            })
        }
    }

    function AddItem() {
        let string = $('#ItemName').val()
        if (string !== "") {
            const arrayItems = string.split(",")
            $.ajax({
                type: "POST",
                url: "ws/categoria_item/item.php",
                data: JSON.stringify({
                    action: "AddItems",
                    request: arrayItems,
                    empresaId: EMPRESA_ID
                }),
                dataType: 'json',
                success: async function(data) {
                    console.log(data);
                }
            })

        } else {
            console.log("INGRESE UN VALOR");
        }
    }

    $('.categoria').on('click', async function() {
        let categoria = $(this).text().split(' ')[0];
        let item = $(this).attr('class').split(' ')[1];

        $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            data: JSON.stringify({
                action: "sortProducts",
                requestJson: {
                    categoria: categoria,
                    item: item,
                    tipo: "categoria"
                }
            }),
            dataType: 'json',
            success: async function(data) {
                let tr = ''
                data.forEach(value => {
                    tr = `<tr class="centerText">
                                    <td>${value.categoria}</td>
                                    <td>${value.Item}</td>
                                    <td>${value.nombre}</td>
                                    <td></td>
                                    <td>${value.cantidad}</td>
                                    <td>Disponibles</td>
                                    <td>${value.arriendo}</td>
                                    <td>${value.compra}</td>
                                    <td>estado</td>
                                    <td><i class="fa-solid fa-trash"></i></td>
                                </tr>`
                    $('#tableProductos>tbody').append(tr);
                });


            },
            error: function(data) {
                console.log(data.responseText);
            }
        })
    })

    $('.item').on('click', function() {
        let categoria = $(this).attr('class').split(' ')[1];
        let item = $(this).attr('class').split(' ')[0];

        console.log(categoria);

        $.ajax({
            type: "POST",
            url: "ws/productos/Producto.php",
            data: JSON.stringify({
                action: "sortProducts",
                requestJson: {
                    categoria: categoria,
                    item: item,
                    tipo: "item"
                }
            }),
            dataType: 'json',
            success: async function(data) {
                console.log(data);
                let tr = ''
                $('#tableProductos>tbody').empty()
                data.forEach(value => {
                    tr = `<tr class="centerText">
                                <td>${value.categoria}</td>
                                <td>${value.Item}</td>
                                <td>${value.nombre}</td>
                                <td>${value.modelo}</td>
                                <td>${value.cantidad}</td>
                                <td>Disponibles</td>
                                <td>${value.arriendo}</td>
                                <td>${value.compra}</td>
                                <td>estado</td>
                                <td><i class="fa-solid fa-trash"></i></td>
                            </tr>`
                    $('#tableProductos>tbody').append(tr);
                });

            },
            error: function(data) {
                console.log(data.responseText);
            }
        })
    })

    const dataArrayIndex = ['Categoria', 'Sub categoria', 'Nombre producto', 'marca', 'modelo', 'cantidad', 'precio compra', 'precio estimado arriendo']
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
                'name': 'precio estimado arriendo',
                'type': 'string',
                'minlength': 3,
                'maxlength': 50,
                'notNull': true
            }
        ]
    }
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

    //Funcion que verifica la extension del archivo ingresado
    function GetFileExtension() {
        fileName = $('#excel_input').val();
        extension = fileName.split('.').pop();
        return extension;
    }

    $('#excel_input').on('change', async function() {
        const extension = GetFileExtension()
        if (extension == "xlsx") {

            // const tableContent = await xlsxReadandWrite(dataArray);


            
            const tableContent = await xlsxReadandWrite(dataArray);

            console.log(tableContent)
            console.log(tableContent)
            console.log(tableContent)
            console.log(tableContent)

            let tableHead = $('#excelTable>thead')
            let tableBody = $('#excelTable>tbody')
            tableHead.append(tableContent.table[0])
            tableBody.append(tableContent.table[1])
            $('#fileName').text(tableContent[0]);
            // $('#excel_input').val("");
            
            
            // let tableHead = $('#excelTable>thead')
            // let tableBody = $('#excelTable>tbody')
            // tableBody.empty()
            // tableHead.empty()
            // tableHead.append(tableContent.table[0])
            // tableBody.append(tableContent.table[1])
            // $('#fileName').text(tableContent[0]);
            // $('#excel_input').val("");
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
                    "categoria": value[0],
                    "item": value[1],
                    "nombre": value[2],
                    "marca": value[3],
                    "modelo": value[4],
                    "stock": value[5],
                    "precioCompra": value[6] === "" ? 0 : value[6],
                    "precioArriendo": value[7] === "" ? 0 : value[7]
                }
                return returnArray
            })

            $.ajax({
                type: "POST",
                url: "ws/productos/addProductos.php",
                data: JSON.stringify({
                    arrayRequest: arrayRequest,
                    empresaId: EMPRESA_ID
                }),
                dataType: 'json',
                success: async function(data) {
                    console.log(data);
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
</script>

</html>