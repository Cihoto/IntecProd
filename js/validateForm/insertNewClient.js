// const EMPRESA_ID = document.getElementById('empresaId').textContent;
let executeClientAction = true;
$('#createNewClient').validate({
    rules: {
        'clientNameorDesc':{
            required : true
        },
        'clientRazonSocial':{
            required : false
        },
        'clientRut':{
            required : false
        },
        'clientContacto':{
            required : false
        },
        'clientCorreo':{
            required : false
        },
        'clientTelefono':{
            required : false
        },
    },
    messages: {
        'clientNameorDesc':{
            required : "Ingrese un valor"
        },
        'clientRazonSocial':{
            required : "Ingrese un valor"
        },
        'clientRut':{
            required : "Ingrese un valor"
        },
        'clientContacto':{
            required : "Ingrese un valor"
        },
        'clientCorreo':{
            required : "Ingrese un valor"
        },
        'clientTelefono':{
            required : "Ingrese un valor"
        },
    },
    submitHandler: async function() {
      event.preventDefault();
      //DATOS DE CLIENTE

      if(!executeClientAction){
        return
      }

     //   const  idClienteReq = "";
     let updatepersona = false;
     if($('#clienteSelect').val() !== ""){
        updatepersona = true;
     }

     const REQUEST_CLIENTE = {
        'empresaId': EMPRESA_ID,
        'clientNameorDesc': $('#clientNameorDesc').val(),
        'clientRazonSocial': $('#clientRazonSocial').val(),
        'clientRut': $('#clientRut').val(),
        'clientContacto': $('#clientContacto').val(),
        'clientCorreo': $('#clientCorreo').val(),
        'clientTelefono': $('#clientTelefono').val()
    }
      console.log("REQUEST_CLIENTE",REQUEST_CLIENTE);
      const response = await insertNewClient(REQUEST_CLIENTE);

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
        

        $('#createNewClient input').val("");
        $("#createNewClientSideMenu").removeClass('active');
        FillClientesTable_dash();
      }
      executeClientAction = true;
    }
    
  });

async function insertNewClient(requestCliente){
    return  $.ajax({
        type: "POST",
        url: "ws/cliente/cliente.php",
        dataType: 'json',
        data: JSON.stringify({
            "tipo": "insertNewClient",
            request: requestCliente
        }),
        success: function(response) {
            console.log(response);
        }
    });
}

function resetForm(element){
    
}