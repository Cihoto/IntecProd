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
</body>

<script>


document.addEventListener("DOMContentLoaded", (event) => {
    getCatsFromInventory(2)
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
        console.log('getCatsFromInventory', json);
        console.log('getCatsFromInventory', json);
        console.log('getCatsFromInventory', json);
        console.log('getCatsFromInventory', json);
        console.log('getCatsFromInventory', json);
    })
    .catch((err) => console.log(err));
}
</script>
</html>