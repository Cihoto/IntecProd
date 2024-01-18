$('#sidePersonalForm').validate({
    rules: {
        'clientNameorDesc-dash': {
            required: true
        },
        'especialidadPersonal': {
            required: true
        },

    },
    messages: {
        'clientNameorDesc-dash': {
            required: "Ingrese un nombre"
        },
        'especialidadPersonal': {
            required: "Ingrese una especialidad"
        },
    },
    submitHandler: async function () {
        event.preventDefault();
        //DATOS DE CLIENTE

        //   const  idClienteReq = "";
        let updatepersona = false;
        if ($('#clienteSelect').val() !== "") {
            updatepersona = true;
        }

        const PERSONAL_REQUEST = {
            "nombrePersonal": $('#nombrePersonal').val(),
            "rutPersonal": $('#rutPersonal').val(),
            "especialidadPersonal": $('#especialidadPersonal').val(),
            "cargoPersonal": $('#cargoPersonal').val(),
            "tipoContratoPersonal": $('#tipoContratoPersonal').val(),
            "costoMensualPersonal": $('#costoMensualPersonal').val(),
            "correoPersonal": $('#correoPersonal').val(),
            "telefonoPersonal": $('#telefonoPersonal').val()
        }

        const response = await insertPersonal(PERSONAL_REQUEST, EMPRESA_ID);
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
        if(response.error){
            Swal.fire({
                "icon":error,
                "title":"ups!",
                "text": response.message 
            })
        }
        await  printPersonal();
        $('#personaSideMenu').removeClass("active");
    }
})

async function insertPersonal(request_personal, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "insertPersonalForm",
            'request': request_personal,
            'empresa_id': empresa_id
        }),
        success: function (response) {
            console.log(response);
        }
    });
}