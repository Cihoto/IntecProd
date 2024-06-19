<?php



$active = "pruebas3";
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

    <?php require_once('./includes/Constantes/empresaId.php') ?>
    <?php require_once('./includes/Constantes/rol.php') ?>

    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>

        <div id="main">

            <h1>API TEST</h1>

        </div>
    </div>


    <?php require_once('./includes/footer.php'); ?>
    <?php require_once('./includes/footerScriptsJs.php'); ?>

    </div>
    </div>
</body>

<script>
    // create a get fetch request to https://api.clay.cl/v1/cuentas_bancarias/movimientos/?numero_cuenta=63741369&rut_empresa=77604901&limit=200&offset=0&fecha_desde=2020-01-01
    // to get the bank movements of the company
    // the response will be an array of objects with the following structure
    // {
    //   "status": true,
    //   "data": {
    //     "records": {
    //       "total_records": 0,
    //       "items": 0,
    //       "limit": 0,
    //       "offset": 0,
    //       "fecha_ultima_actualizacion": 0,
    //       "banco": "string",
    //       "numero_cuenta": "string",
    //       "cuenta_validada": true,
    //       "tipo_moneda": "string",
    //       "log_conexion": {
    //         "error": true,
    //         "mensaje": "string"
    //       }
    //     },
    //     "items": [
    //       {
    //         "id": "string",
    //         "fecha": 0,
    //         "fecha_humana": "string",
    //         "numero_documento": "string",
    //         "reconocido": true,
    //         "pagado": true,
    //         "abono": true,
    //         "sucursal": "string",
    //         "descripcion": "string",
    //         "monto": 0,
    //         "monto_original": 0,
    //         "saldo_insoluto": 0,
    //         "mas_info": {
    //           "contraparte": "string",
    //           "rut": "string",
    //           "dv": "string",
    //           "banco": "string",
    //           "numero_cuenta": "string",
    //           "mensaje": "string"
    //         },
    //         "matches": [
    //           {
    //             "fecha_emision": 0,
    //             "fecha_emision_humana": "string",
    //             "tipo_obligacion": "string",
    //             "subtipo_obligacion": "string",
    //             "numero": "string",
    //             "monto": 0,
    //             "monto_conciliado": 0,
    //             "fecha_match": 0,
    //             "fecha_match_humana": "string",
    //             "email_usuario_match": "string",
    //             "tipo_cambio": 0,
    //             "monto_local": 0,
    //             "rut_contraparte": "string",
    //             "razon_social_contraparte": "string",
    //             "descripcion_primer_item": "string"
    //           }
    //         ],
    //         "contablemente_correcto": "string",
    //         "fecha_humana_creacion": "string",
    //         "fecha_creacion": 0
    //       }
    //     ]
    //   }
    // }

    // on winddow load call the function getBankMovements


    getBankMovements();

    function getBankMovements() {
        console.log('GET BANK MOVEMENTS')
        fetch('http://api.clay.cl/v1/cuentas_bancarias/movimientos/?numero_cuenta=63741369&rut_empresa=77604901&limit=200&offset=0&fecha_desde=2020-01-01', {
                mode: 'cors',
                headers: {
                    'Access-Control-Allow-Origin': '*'
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('DATA CLAY', data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }
</script>


<style>

</style>

</html>