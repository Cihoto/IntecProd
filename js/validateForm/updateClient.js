// const EMPRESA_ID = document.getElementById('empresaId').textContent;

$('#updateClient').validate({
    rules: {
        'clientNameorDesc-dash':{
            required : true
        },
       
    },
    messages: {
        'clientNameorDesc-dash':{
            required : "Ingrese un valor"
        },
    },
    submitHandler: async function() {
      event.preventDefault();
        //DATOS DE CLIENTE

        //   const  idClienteReq = "";
        let updatepersona = false;
        if($('#clienteSelect').val() !== ""){
            updatepersona = true;
        }


        const requestCliente = {
            'empresaId': EMPRESA_ID,
            'clientNameorDesc': $('#clientNameorDesc-dash').val(),
            'clientRazonSocial': $('#clientRazonSocial-dash').val(),
            'clientRut': $('#clientRut-dash').val(),
            'clientContacto': $('#clientContacto-dash').val(),
            'clientCorreo': $('#clientCorreo-dash').val(),
            'clientTelefono': $('#clientTelefono-dash').val(),
            'clienteId':selectedClientData.client[0].client_id,
            'updatepersona':true
        }
        console.log("requestCliente",requestCliente);
        const response = await addOrUpdateClientData(requestCliente,EMPRESA_ID);
        if(response.success){
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
        await FillClientesTable_dash();
        $('#clientSideMenu-clientDash').removeClass("active");
    }
})


async function addOrUpdateClientData(requestCliente,empresa_id){
return  $.ajax({
    type: "POST",
    url: "ws/cliente/cliente.php",
    dataType: 'json',
    data: JSON.stringify({
        "tipo": "AddClientForm",
        request: requestCliente,
        empresa_id:empresa_id
    }),
    success: function(response) {
        console.log(response);
    }
    });
}