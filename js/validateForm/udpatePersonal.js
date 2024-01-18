$('#updatePersonal').validate({
    rules: {
        'update_clientNameorDesc-dash': {
            required: true
        },
        'update_especialidadPersonal': {
            required: true
        },

    },
    messages: {
        'update_clientNameorDesc-dash': {
            required: "Ingrese un nombre"
        },
        'update_especialidadPersonal': {
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
            "update_nombrePersonal": $('#update_nombrePersonal').val(),
            "update_rutPersonal": $('#update_rutPersonal').val(),
            "update_especialidadPersonal": $('#update_especialidadPersonal').val(),
            "update_cargoPersonal": $('#update_cargoPersonal').val(),
            "update_tipoContratoPersonal": $('#update_tipoContratoPersonal').val(),
            "update_costoMensualPersonal":ClpUnformatter($('#update_costoMensualPersonal').val()),
            "update_correoPersonal": $('#update_correoPersonal').val(),
            "update_telefonoPersonal": $('#update_telefonoPersonal').val(),
            "persona_id":personalData.persona_id,
            "personal_id":personalData.personal_id
        }

        const response = await updatePersonal(PERSONAL_REQUEST, EMPRESA_ID,);
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
        unsetUpdateFormPersonal();
        $('#personalSideMenu-personalDash').removeClass("active");
    }
})

async function updatePersonal(request_personal, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "updatePersonal",
            'request': request_personal,
            'empresa_id': empresa_id
        }),
        success: function (response) {
            console.log(response);
        }
    });
}
let lastMensualCost = 0;
$('#update_costoMensualPersonal').on("click",function(){
    lastMensualCost = ClpUnformatter($(this).val());
    $(this).val(0)
})

$('#update_costoMensualPersonal').on("blur",function(){
    let value = $(this).val();
    if(!isNumeric(value)){
        $(this).val(CLPFormatter(lastMensualCost));
        return 
    }

    $(this).val(CLPFormatter(value));


})