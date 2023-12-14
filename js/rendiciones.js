let allRendiciones = [];
let lastRenTotalValue = 0;
let rendicion_temp_id = 1;

$(document).on('blur', '.rendDetalle', function () {
    checkIfRendicionIsReady($(this));
})
$(document).on('blur', '.renPersonal', function () {
    checkIfRendicionIsReady($(this));
})
$(document).on('blur', '.renMonto', function () {
    checkIfRendicionIsReady($(this));
})
$(document).on('blur', '.renFecha', function () {
    checkIfRendicionIsReady($(this));
})
$(document).on('blur', '.renComercio', function () {
    checkIfRendicionIsReady($(this));
})

function checkIfRendicionIsReady(el) {
const element = $(el).closest('.rend-item');
if ($(element).find('.rendDetalle').val() !== "" &&
    $(element).find('.renPersonal').val() !== "" &&
    $(element).find('.renMonto').val() !== "" &&
    $(element).find('.renFecha').val() !== "" &&
    $(element).find('.renComercio').val() !== "") 
{



    $(element).removeClass("incomplete");
    allRendiciones.push({
        'temp_id':rendicion_temp_id,
        'detalle': $(element).find('.rendDetalle').val(),
        'personal_id': $(element).find('.renPersonal').val(),
        'monto': $(element).find('.renMonto').val(),
        'fecha': $(element).find('.renFecha').val(),
        'comercio': $(element).find('.renComercio').val()
    });
    rendicion_temp_id ++;

} else {
    $(element).addClass("incomplete");
    // const TEMP_ID = $(element).attr()
    // const checkIsRendExists = checkIsRendExists();
}

    
}

$('#addNewRowRendicion').on('click', function () {
    $('#rendicionTable .rend-item').remove();
    allRendiciones.forEach((rendicion) => {
        createNewFinancialReportingRow(rendicion.detalle, rendicion.personal_id, rendicion.monto, rendicion.fecha, rendicion.comercio,rendicion.temp_id)
    })
    createNewFinancialReportingRow("", "", "", "", "","")
})

function createNewFinancialReportingRow(detalle, personal_id, monto, fecha, comercio,temp_id) {


    let options = '<option value=""></option>';

    allPersonal.forEach((personal) => {
        if (personal_id === "") {
            options += `<option value="${personal.id}">${personal.nombre}</option>`
        } else {
            options += `<option value="${personal.id}" selected>${personal.nombre}</option>`
        }
    });

    let tr = `<tr class="rend-item" rend_id="${temp_id}">
        <td>
            <input class="form-control rendDetalle" type="text" id="" value="${detalle}">
        </td>
        <td>
            <select name="" class="form-select renPersonal" id="">
                ${options}
            </select>
        </td>
        <td>
            <input class="form-control renMonto" type="text" id="" value="${monto}">
        </td>
        <td>
            <input class="form-control renFecha" type="date" id="" value="${fecha}">
        </td>
        <td>
            <input class="form-control renComercio" type="text" id="" value="${comercio}">
        </td>
    </tr>`

    $('#rendicionTable').append(tr);
}


$(document).on('click','.renMonto',function(){
    lastRenTotalValue = 0;
    if($(this).val() !==""){
        lastRenTotalValue = parseInt(ClpUnformatter($(this).val()));
    }
    $(this).val("")
})
$(document).on('blur','.renMonto',function(){
    let currentValue = $(this).val();

    if(currentValue === ""){
        $(this).val(CLPFormatter(lastRenTotalValue));
        return
    }
    
    if(!isNumeric(currentValue)){
        $(this).val(CLPFormatter(lastRenTotalValue));
        return
    }

    $(this).val(CLPFormatter(currentValue));
    
})