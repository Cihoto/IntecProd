// const EMPRESA_ID = document.getElementById('empresaId').textContent;
let executeClientAction = true;

$('#sideclientForm').validate({
    rules: {
        'clientNameorDesc': {
            required: true
        },
        'clientRazonSocial': {
            required: false
        },
        'clientRut': {
            required: false
        },
        'clientContacto': {
            required: false
        },
        'clientCorreo': {
            required: false
        },
        'clientTelefono': {
            required: false
        },
    },
    messages: {
        'clientNameorDesc': {
            required: "Ingrese un valor"
        },
        'clientRazonSocial': {
            required: "Ingrese un valor"
        },
        'clientRut': {
            required: "Ingrese un valor"
        },
        'clientContacto': {
            required: "Ingrese un valor"
        },
        'clientCorreo': {
            required: "Ingrese un valor"
        },
        'clientTelefono': {
            required: "Ingrese un valor"
        },
    },
    submitHandler: async function () {
        event.preventDefault();
        //DATOS DE CLIENTE

        if (!executeClientAction) {
            return
        }

        //   const  idClienteReq = "";
        let updatepersona = false;
        if ($('#clienteSelect').val() !== "") {
            updatepersona = true;
        }

        const requestCliente = {
            'empresaId': EMPRESA_ID,
            'clientNameorDesc': $('#clientNameorDesc').val(),
            'clientRazonSocial': $('#clientRazonSocial').val(),
            'clientRut': $('#clientRut').val(),
            'clientContacto': $('#clientContacto').val(),
            'clientCorreo': $('#clientCorreo').val(),
            'clientTelefono': $('#clientTelefono').val(),
            'clienteId': $('#clienteSelect').val(),
            'updatepersona': updatepersona
        }
        console.log("requestCliente", requestCliente);

        const response = await addOrUpdateClientData(requestCliente, EMPRESA_ID);
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
            setSelectedClient(response.client_id);


            $.ajax({
                type: "POST",
                url: "ws/cliente/cliente.php",
                dataType: 'json',
                data: JSON.stringify({
                    "tipo": "getClienteById",
                    request: response.client_id
                }),
                success: function (response) {
                    //   console.log("AJAX",_selectedClient);
                    response.cliente.forEach(cli => {
                        $('#idClienteModalResume').text(cli.id);
                        $('#clientNameorDesc').val(cli.nombre_fantasia);
                        $('#clientRazonSocial').val(cli.razon_social);
                        $('#clientRut').val(cli.rut);
                        $('#clientContacto').val(cli.persona_contacto);
                        $('#clientCorreo').val(cli.email);
                        $('#clientTelefono').val(cli.telefono);
                    });
                    setSelectedClient(response.cliente[0]);

                }
            })
            resetClientForm();

            const BUTTON = document.getElementById('addClienteController');
            BUTTON.click(); 
            addClienteController
            $("#clientSideMenu").removeClass('active');
        }
        executeClientAction = true;
    }

});

async function addOrUpdateClientData(requestCliente, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/cliente/cliente.php",
        dataType: 'json',
        data: JSON.stringify({
            "tipo": "AddClientForm",
            request: requestCliente,
            empresa_id: empresa_id
        }),
        success: function (response) {
            console.log(response);
        }
    });
}