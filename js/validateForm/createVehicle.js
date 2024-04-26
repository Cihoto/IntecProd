$('#createVehicleForm').validate({
    rules: {
        'vehiclecreatePatente': {
            required : true
        }
    },
    messages: {
        'vehiclecreatePatente': {
            required: "Ingrese una patente"
        }
    },
    submitHandler: async function () {
        event.preventDefault();
        //DATOS DE CLIENTE

        //   const  idClienteReq = "";
        let updatepersona = false;
        if ($('#clienteSelect').val() !== "") {
            updatepersona = true;
        }

        const REQUEST_VEHICLE = {
            'type': $('#vehicleCreateType').val() ,
            'brand': $('#vehicleCreateBrand').val() ,
            'model': $('#vehicleCreateModel').val() ,
            'patente': $('#vehiclecreatePatente').val() ,
            'owner': $('#vehicleCreateOwner').val() ,
            'costPerTrip': $('#vehicleCreateCostPerTrip').val() ,
        }

        const response = await insertVehicle(REQUEST_VEHICLE, EMPRESA_ID);
        if (response.success) {
            Toastify({
                text: `${response.message}`,
                duration: 3000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(90deg, #36ABA9 0%, #10E5E1 70.29%)   ",
                },
            }).showToast();
        }
        if (response.error) {
            Swal.fire({
                "icon": error,
                "title": "ups!",
                "text": response.message
            })
        }

        if(REQUEST_FROM_EVENTS){
            await FillVehiculos(EMPRESA_ID)
            printSelectedVehicles();
            
        }
        closeVehicleSideMenu();
    }
})

async function insertVehicle(request_vehicle, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "insertVehicle",
            'request': request_vehicle,
            'empresa_id': empresa_id
        }),
        success: function (response) {
            console.log(response);
        }
    });
}

