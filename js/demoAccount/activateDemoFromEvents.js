


function activateDemoFromEvents() {

    console.log('_productos', _productos);
    console.log('allPersonal', allPersonal);
    console.log('allVehicles', allVehicles);

    if (!isDemoAvailable){

        if (_productos.length === 0) {
            $('#prodReminder').append(`<button class="--module-btn-reminder">
                <a class="--rLink" href="./inventario.php">Carga tu inventario</a>
            </button>`);

            // HIDE TABLES
            // prods
            document.getElementById('palCtn').style.display = 'none';
        }

        // if (allPersonal.length === 0) {
        //     $('#perReminder').append(`<button class="--module-btn-reminder">
        //         <a class="--rLink" href="./personal.php">Carga tu personal</a>
        //     </button>`);
        //     // personal
        //     document.getElementById('peralCtn').style.display = 'none';
        // }

        // if (allVehicles.length === 0) {
        //     $('#vehReminder').append(`<button class="--module-btn-reminder">
        //         <a class="--rLink" href="./vehiculos.php">Carga tu transporte</a>
        //     </button>`);
        //     // vehicles
        //     document.getElementById('veaLCtn').style.display = 'none';
        //     // hideAllEventAssigmentTables();
        //     return
        // }
    }

    if (bussinessIsDemo) {
        return;
    }

    if ((_productos.length > 0 || allPersonal.length > 0 || allVehicles.length > 0) && !bussinessIsDemo) {

        showAllEventAssigmentTables();

        return;
    }

    hideAllEventAssigmentTables();

    $('.--demo-btn-container').append(`<button class="--demo-btn-reminder">
        <p>Cargar datos demo</p>
    </button>`);
    
}

function hideAllEventAssigmentTables() {
    // HIDE TABLES
    // prods
    document.getElementById('palCtn').style.display = 'none';

    // personal
    document.getElementById('peralCtn').style.display = 'none';

    // vehicles
    document.getElementById('veaLCtn').style.display = 'none';
}

function showAllEventAssigmentTables() {
    // SHOW TABLES
    // prods
    document.getElementById('palCtn').style.display = 'flex';

    // personal
    document.getElementById('peralCtn').style.display = 'flex';

    // vehicles
    document.getElementById('veaLCtn').style.display = 'flex';
}

$(document).on('click', '.--demo-btn-reminder', async function () {
    // await activateDemoDataonNewAccount(EMPRESA_ID);

    showModalAddDemoData();
    // window.location = './index.php';
});