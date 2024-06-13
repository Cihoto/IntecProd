async function addVehiclesMasiveOnDemoAccount() {
    try {
        const response = await fetch('./js/demoAccount/addVehiclesDemo/vehiclesData.json');
        const json = await response.json();
        const INSERTED_VEHICLES =  await insertVehicles(json);
        return INSERTED_VEHICLES;
    } catch (error) {
        console.log(error);
    }
}


// function insert

async function insertVehicles(request) {
    try {
        const response = await fetch('./ws/vehiculo/demoAccount/addVehicleToDemoAccount.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ request, empresaId: EMPRESA_ID })
        });

        const vehicles = await response.json();

        if (vehicles.error) {
            console.log('Error:', vehicles.message);
            throw new Error(vehicles.message);
        }

        console.log('Success:', vehicles);
        return vehicles;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}
