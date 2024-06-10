<?php
// require_once('./ws/bd/bd.php');
// $conn = new bd();
// $conn->conectar();

// $categorias = [];

// $queryProductos = 'Select c.nombre , i.item, p.nombre, mo.modelo, p.precio_arriendo from producto p 
//                     INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
//                     INNER JOIN categoria c on c.id =p.categoria_has_item_id 
//                     INNER JOIN item i on i.id  = p.categoria_has_item_id 
//                     INNER JOIN marca m on m.id = p.marca_id
//                     INNER JOIN modelo mo on mo.marca_id = m.id 
//                     WHERE p.empresa_id = 1';

// $queryCategorias = 'select c.nombre ,c.id  from categoria c';
// // inner join categoria_has_item chi on chi.categoria_id = c.id 
// // INNER JOIN producto p on p.categoria_has_item_id  = chi.id 
// // where p.empresa_id = 1
// // group by c.nombre ';


// if ($categoriasBdResponse = $conn->mysqli->query($queryCategorias)) {
//     while ($dataCategorias = $categoriasBdResponse->fetch_object()) {
//         $categorias[] =  $dataCategorias;
//     }
// } else {
// }

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
$title = "Intec - Eventos"
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
                    <p class="header-P">Aquí puedes ver, editar el inventario123123</p>
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
                        <button class="s-Button" id="buttonProductoUnitario" onclick="openCreateProdSideMenu()">
                            <p class="s-P">Agregar nuevo producto</p>
                        </button>
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


    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <!-- Side Menu -->
    <?php require_once('./includes/sidemenu/productoMasivaSideMenu.php') ?>
    <?php require_once('./includes/sidemenu/addNewProductSideMenu.php') ?>


    <!-- xlsx Reader -->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- JS FUNCTIONS REFERENCES -->
    <script src="/js/valuesValidator/validator.js"></script>
    <script src="/js/categorias.js"></script>
    <script src="/js/marca.js"></script>
    <script src="/js/item.js"></script>
    <script src="/js/bottomBar.js"></script>


    <!-- PROD GET UPDATE FUNCTIONS -->
    <script src="./js/products/getProductInfo.js"></script>
    <!-- PRODS SIDE MENUS -->
    <?php require_once('./includes/sidemenu/productDataSideMenu.php'); ?>
    <!-- UPDATE PRODUCT FORM VALIDATION -->
    <script src="./js/validateForm/updateProduct.js"></script>

    <!-- FORM VALIDATION -->
    <script src="./js/validateForm/createNewProductSideMenu.js"></script>
</body>

</html>