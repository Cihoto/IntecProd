$('#sideProviderForm').validate({
    rules: {
        "providerNameorDesc":{
            required:true
        },
        "providerRazonSocial":{
            required:false
        },
        "providerRut":{
            required:false
        },
        "providerContacto":{
            required:false
        },
        "providerCorreo":{
            required:false
        },
        "providerTelefono":{
            required:false
        }
    },
    messages: {
        "providerNameorDesc":{
            required:"Ingrese un valor"
        },
        "providerRazonSocial":{
            required:"Ingrese un valor"
        },
        "providerRut":{
            required:"Ingrese un valor"
        },
        "providerContacto":{
            required:"Ingrese un valor"
        },
        "providerCorreo":{
            required:"Ingrese un valor"
        },
        "providerTelefono":{
            required:"Ingrese un valor"
        }
      
    },
    submitHandler: async function() {
      event.preventDefault();

        const requestProvider = {
            'nombre_fantasia' : $('#providerNameorDesc').val(),
            'razon_social' : $('#providerRazonSocial').val(),
            'rut' : $('#providerRut').val(),
            'nombre' : $('#providerContacto').val(),
            'correo' : $('#providerCorreo').val(),
            'telefono' : $('#providerTelefono').val()
        };

        console.log("requestProvider",requestProvider)

        const providerInserted = await addNewProvider(requestProvider,EMPRESA_ID);

        if(providerInserted.success === true){
            Swal.fire({
                title: 'Excelente!',
                text: providerInserted.message,
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                timer:2000
            });
        }

        printNewRow_subRent();
    }
  })