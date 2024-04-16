let allPersonal = [];
let allTipoContrato = [];
let selectedTypeContract = [];
let allSelectedPersonal = [];
let allMyOwners = [];
let _allPersonalToList = [];
let _allCargos = []
let _allEspecialidades = []
let personalData = {
    "data": {

    },
    "events": {

    },
    "persona_id": 0,
    "personal_id": 0

}



let dash_personal_table
async function printPersonal() {
    const PERSONAL = await getPersonalByBussiness(EMPRESA_ID);
    if (!PERSONAL.success) {
        Swal.fire({
            icon: "error",
            title: "Ups!",
            text: "Intente nuevamente"
        })
        return;
    };

    _allPersonalToList = PERSONAL.data;

    if ($.fn.DataTable.isDataTable('#personalDashTable')) {
        $('#personalDashTable').DataTable()
            .clear()
            .draw();
        $('#personalDashTable').DataTable().destroy();
    }
    console.log(_allPersonalToList);
    _allPersonalToList.forEach((personal) => {

        if (personal.nombre === "") { personal.nombre = "-" }
        if (personal.rut === "") { personal.rut = "-" }
        if (personal.especialidad === "") { personal.especialidad = "-" }
        if (personal.telefono === "") { personal.telefono = "-" }
        if (personal.email === "") { personal.email = "-" }
        if (personal.contrato === "") { personal.contrato = "-" }
        if (personal.neto === "") { personal.neto = "-" }
        let tr = `<tr personal_id="${personal.personal_id}">
            <td class="ps-header">${personal.nombre} ${personal.apellido}</td>
            <td>${personal.rut}</td>
            <td>${personal.especialidad}</td>
            <td>${personal.telefono}</td>
            <td>${personal.email}</td>
            <td>${personal.contrato}</td>
            <td>${CLPFormatter(personal.neto)}</td>
        </tr>`;
        $('#personalDashTable tbody').append(tr);
    });
    if (!$.fn.DataTable.isDataTable('#personalDashTable')) {
        $('#personalDashTable').DataTable({
            columns: [
             { width: '11%' },
             { width: '11%' },
             { width: '11%' },
             { width: '11%' },
             { width: '11%' },
             { width: '11%' },
             { width: '11%' }
             ],
             columnDefs: [ 
                {
                    className: "ps-header",
                    "targets": [0]
                },
                {
                    "defaultContent": "-",
                    "targets": "_all"
                }
            ],

            lengthMenu: [5, 10, 20, 50, 100, 200, 500],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Técnicos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 100
        });
    }
}


$(document).on("click", "#personalDashTable tbody tr", async function () {
    const PERSONAL_ID = $(this).attr("personal_id");

    const PERSONAL_EXISTS = _allPersonalToList.find((personal) => personal.personal_id === PERSONAL_ID);

    if (!PERSONAL_EXISTS) {
        Swal.fire({
            icon: "error",
            title: "Ups!",
            text: "Intente nuevamente"
        })
        return;
    }
    const PERSONAL_BY_ID = await getPersonalById(PERSONAL_ID, EMPRESA_ID);

    if (!PERSONAL_BY_ID.success) {
        Swal.fire({
            icon: "error",
            title: "Ups!",
            text: "Intente nuevamente"
        })
        return;
    }
    personalData.data = PERSONAL_BY_ID.data;
    personalData.events = PERSONAL_BY_ID.events;
    personalData.persona_id = PERSONAL_BY_ID.data.persona_id;
    personalData.personal_id = PERSONAL_ID;

    console.log('personalData.data', personalData.data);

    $('#update_nombrePersonal').val(personalData.data.nombre);
    $('#update_rutPersonal').val(personalData.data.rut);
    $('#update_tipoContratoPersonal').val(personalData.data.tipo_contrato_id);
    $('#update_costoMensualPersonal').val(CLPFormatter(personalData.data.neto));
    $('#update_correoPersonal').val(personalData.data.email);
    $('#update_telefonoPersonal').val(personalData.data.telefono);
    $('#personalSideMenu-personalDash').addClass("active");

    // FILL ESPECIALIDAD
    const especialidad = await GetEspecialidad(EMPRESA_ID);
    $('#update_especialidadPersonal').val(personalData.data.especialidad_id).change();
    // FILL CARGOS
    const cargos = await GetCargo(EMPRESA_ID);
    $('#update_cargoPersonal').val(personalData.data.cargo_id);

    // console.log(personalData);
    // console.log(PERSONAL_BY_ID);



    if ($.fn.DataTable.isDataTable('#eventsPerPersonal_dash')) {
        $('#eventsPerPersonal_dash').DataTable()
            .clear()
            .draw();
        $('#eventsPerPersonal_dash').DataTable().destroy();
    }

    personalData.events.forEach((event) => {
        let color = "";
        if (event.estado == null) {
            event.estado = "borrador"
        }
        if (event.status_id === 1) {

        }
        if (event.status_id === 2) {
            color = "#27AE60"
        }
        if (event.status_id === 3) {
            color = "#7F45E3"
        }

        if (event.nombre_proyecto === null || event.nombre_proyecto === "") { event.nombre_proyecto = "-" }
        if (event.fecha_inicio === null || event.fecha_inicio === "") { event.fecha_inicio = "-" }
        if (event.estado === null || event.estado === "") { event.estado = "-" }
        if (event.costo === null || event.costo === "") { event.costo = 0 }
        let tr = `<tr event_id="${event.proyecto_id}">
            <td>${event.nombre_proyecto}</td>
            <td>${event.fecha_inicio}</td>
            <td><p class="event-status ${event.estado}">${event.estado[0].toUpperCase()}${event.estado.slice(1)}</p></td>
            <td>${CLPFormatter(parseInt(event.costo))}</td>
        </tr>`

        $('#eventsPerPersonal_dash').append(tr);
    })
    if (!$.fn.DataTable.isDataTable('#eventsPerPersonal_dash')) {
        $('#eventsPerPersonal_dash').DataTable({
            columnDefs: [
                { "defaultContent": "-", "targets": "_all" },
                { "width": "19%", "targets": "_all" }
            ],
            lengthMenu: [5, 10, 20, 50, 100, 200, 500],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Eventos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 5
        });
    }

});

$('#enableEditPersonal').on("click", function () {
    $('#updatePersonal input').attr("readonly", false)
    $('#updatePersonal input').attr("disabled", false)
    $('#updatePersonal select').attr("readonly", false)
    $('#updatePersonal select').attr("disabled", false)
    $('#confirmEditPersonal').css("display", "flex")
})
function unsetUpdateFormPersonal() {
    $('#updatePersonal input').attr("readonly", true)
    $('#updatePersonal input').attr("disabled", true)
    $('#updatePersonal select').attr("readonly", true)
    $('#updatePersonal select').attr("disabled", true)
    $('#confirmEditPersonal').css("display", "none");
    $('#update_nombrePersonal').val(personalData.data.nombre);
    $('#update_rutPersonal').val(personalData.data.rut);
    $('#update_especialidadPersonal').val(personalData.data.especialidad_id);
    $('#update_cargoPersonal').val(personalData.data.cargo_id);
    $('#update_tipoContratoPersonal').val(personalData.data.tipo_contrato_id);
    $('#update_costoMensualPersonal').val(CLPFormatter(personalData.data.neto));
    $('#update_correoPersonal').val(personalData.data.email);
    $('#update_telefonoPersonal').val(personalData.data.telefono);
}



$(document).on('click','#eventsPerPersonal_dash tbody tr',function(){
    const EVENT_ID = $(this).attr('event_id');
    openEvent(EVENT_ID);
})



$('#deletePersonalDash').on('click', async function () {

    const PERSONAL_ID = parseInt(personalData.personal_id);


    Swal.fire({
        title: "¿Quieres eliminar a este técnico?",
        text: "Esta acción es irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar!"
    }).then(async (result) => {
        if (result.isConfirmed) {

            const REMOVE_VEHICLE_RESPONSE = await deletePersonalDash(EMPRESA_ID, PERSONAL_ID);

            console.log('REMOVE_VEHICLE_RESPONSE', REMOVE_VEHICLE_RESPONSE);

            if (!REMOVE_VEHICLE_RESPONSE) {
                Swal.fire({
                    title: "Ups!",
                    text: "No se ha podido eliminar al técnico, intenta nuevamente!",
                    icon: "error"
                });
                return
            }

            Swal.fire({
                title: "Excelente!",
                text: "Técnico eliminado.",
                icon: "success"
            });

            $('#personalSideMenu-personalDash').removeClass('active');
            $(`#personalDashTable tbody tr[personal_id="${PERSONAL_ID}"]`).remove();

        }
    });



})


function deletePersonalDash(empresa_id, personal_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "deletePersonalDash",
            'personal_id': personal_id,
            'empresa_id': empresa_id
        }),
        success: function (response) {
            console.log('response delete vehicle', response)
        }, error: function (error) {
            console.log('error', error);
        }
    })
}






function searchPersonalDrag() {
    let dragPersonal = document.getElementById('sortablePersonal1').getElementsByTagName('li')
    let inputValue = document.getElementById('searchInputPersonal').value.toUpperCase();
    for (let item of dragPersonal) {
        let liValue = item.innerText.toUpperCase()
        if (!liValue.includes(inputValue)) {
            item.style.display = 'none';
        } else {
            item.style.display = '';
        }
    }
}

async function getPersonalById(personal_id, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getPersonalById",
            'personal_id': personal_id,
            'empresa_id': empresa_id
        }),
        success: function (response) {
            // console.log(response);
        }, error: function (error) {
            console.log(error);
        }
    })
}
async function getPersonalByBussiness(empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getPersonalByBussiness",
            'empresa_id': empresa_id
        }),
        success: function (response) {
            // console.log(response);
        }, error: function (error) {
            console.log(error);
        }
    })
}
async function insertPersonal(arrayPersonal, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "insertPersonal",
            'empresa_id': empresa_id,
            'personalData': arrayPersonal
        }),
        success: function (response) {
            // console.log(response);
        }, error: function (error) {
            console.log(error);
        }
    })
}

async function GetAllPersonal(empresaId) {
    $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getPersonal",
            empresaId: empresaId
        }),
        success: function (response) {
            allPersonal = response;

            allPersonal = allPersonal.map((personal) => {
                return {
                    'cargo': personal.cargo,
                    'cargo_id': personal.cargo_id,
                    'contrato': personal.contrato,
                    'especialidad': personal.especialidad,
                    'id': personal.id,
                    'rut': personal.rut,
                    'neto': personal.neto,
                    'nombre': personal.nombre,
                    'isPicked': false,
                    'isSelected': false,
                    'horasTrabajadas': 0,
                    'isDelete': personal.IsDelete
                }
            })
            setAllTipoContrato();
            setAllMyOwners();
            printAllSelectedPersonal()
            // fillPersonal();
        }
    })
}

function setAllMyOwners() {
    allMyOwners = [];
    allMyOwners = allPersonal.map((personal) => {
        return {
            'id': personal.id,
            'nombre': personal.nombre
        }
    });
    printAllMyOwners();
}

function printAllMyOwners() {
    $('#ownerSelect option').remove();
    // const personal_id = PERSONAL_IDS[0].personal_id;

    $('#ownerSelect').append(new Option('', '', false, false));
    allMyOwners.forEach((owner) => {
        $('#ownerSelect').append(new Option(owner.nombre, owner.id, false, false));
    })

    $('#ownerSelect').select2();

}

function setAllTipoContrato() {
    allPersonal.forEach((personal) => {
        if (allTipoContrato.includes(personal.contrato)) {

        } else {
            allTipoContrato.push(personal.contrato);
        }
    })

    // console.log("allTipoContrato",allTipoContrato);
}

function setSelectedContractType() {
    selectedTypeContract = [];

    if (allSelectedPersonal.length === 0) {
        return
    }
    allSelectedPersonal.forEach((personal) => {
        if (selectedTypeContract.includes(personal.contrato)) {

        } else {
            selectedTypeContract.push(personal.contrato);
        }
    })
}

function FillPersonal(empresaId) {
    $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getPersonal",
            empresaId: empresaId
        }),
        success: function (response) {
            // console.table(response);
            // response.forEach(personal => {
            //     if(personal.neto ==="" || personal.neto === null || personal.neto === undefined){
            //         personal.neto = 0;
            //     }
            //     let li = `<li style="display:flex; justify-content:space-between;" class="${personal.id}">
            //             ${personal.nombre} | ${personal.cargo} ${personal.especialidad}                             
            //             <p class="tipoContrato" style="display:none">${personal.contrato}</p>
            //             <div class="personalPricing" style="display:flex;align-content: center;">
            //                 <input type="number" name="price" class="personalPrice" value="${personal.neto}" placeholder="Costo"/>
            //                 <i onclick="AddPersonal(this)"class="fa-solid fa-plus addPersonal"></i>
            //                 <i onclick="removePersonal(this)" class="fa-solid fa-minus removePersonal" style="display:none; color: #b92413;"></i>
            //             </div>
            //         </li>`;
            //     $('#sortablePersonal1').append(li)
            // });
        }
    })
}

function fillPersonal() {

    allPersonal.forEach((personal) => {
        let tr = `<tr personal_id="${personal.id}">
            <td> <p class="--h-text-flex">${personal.nombre}</p></td>
            <td>${personal.rut}</td>
            <td>${personal.contrato}</td>
            <td>${CLPFormatter(parseInt(personal.neto))}</td>
            <td class="addPersonalToResume"><p class="s-P-g">Agregar</p></td>
        <tr>`
        $('#personalResumeAssigment').append(tr)
    })
    console.table(allTipoContrato);

    $('#filterAllPersonal').append(new Option("Todos", "Todos"))
    allTipoContrato.forEach((contrato) => {
        // console.log(contrato);
        $('#filterAllPersonal').append(new Option(contrato, contrato))
    })
}

function printFilterDataAllPersonal(personalArray) {
    $('#personalResumeAssigment tbody tr').remove();

    const allSelectedIds = allSelectedPersonal.map((selected) => {
        return selected.id;
    })

    const filteredPersonalByContract = personalArray.filter((personal) => {
        return !allSelectedIds.includes(personal.id)
    })

    filteredPersonalByContract.forEach((filterPersonal) => {
        let tr = `<tr personal_id="${filterPersonal.id}">
            <td><p class="--h-text-flex">${filterPersonal.nombre}</p></td>
            <td>${filterPersonal.contrato}</td>
            <td>${CLPFormatter(parseInt(filterPersonal.neto))}</td>
            <td class=""><i class="fa-solid fa-plus pointer addPersonalToResume"></i></td>
        <tr>`
        $('#personalResumeAssigment > tbody').append(tr);
    })
}

$(document).on('change', '#filterAllPersonal', function () {
    const contract = $(this).val();
    if (contract === "Todos") {
        printFilterDataAllPersonal(allPersonal);
        return;
    }
    const allPersonalFiltered = allPersonal.map((personal) => {
        if (personal.contrato === contract) {
            return personal;
        }
        return
    })
        .filter((personal) => {
            return personal !== undefined
        })

    // console.log("PERSONAL CON CONTRATOS", allPersonalFiltered)
    printFilterDataAllPersonal(allPersonalFiltered)

})

$(document).on('click', '.addPersonalToResume', function () {

    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("11")) {
        const personal_id = $(this).closest('tr').attr('personal_id');
        const personalExists = checkIfPersonalAIdsExists(personal_id);
        if (!personalExists) {
            return;
        }

        const personalIsSelected = allSelectedPersonal.find((selectedPersonal) => {
            return selectedPersonal.id === personal_id
        })
        if (personalIsSelected) {
            swal.fire({
                'icon': 'warning',
                'title': 'Ups!',
                'text': 'Técnico ya seleccionado',
                'showConfirmButton': false,
                'timer': 2000
            })
            return
        }

        AddSelectedPersonal(personal_id);
        setAllTipoContrato();
        printAllSelectedPersonal();
    } else {
        Swal.fire({
            title: 'Lo sentimos',
            text: "No tienes los persisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido"
        })
    }
})

let personalCurrentValue = 0;
$(document).on('click', '.personalValueInput', function () {
    personalCurrentValue = ClpUnformatter($(this).val());
    $(this).val("")
});
$(document).on('blur', '.personalValueInput', function () {
    const valor = parseInt($(this).val());
    if (valor === "" || valor === undefined || valor === null) {

        $(this).val(CLPFormatter(personalCurrentValue))
        return
    }

    if (!isNumeric($(this).val())) {
        Swal.fire({
            title: 'Ups!',
            text: "Debes ingresar un número",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido",
            timer: 2000
        })
        $(this).val(CLPFormatter(parseInt(personalCurrentValue)));
        return;
    }

    const personal_id = $(this).closest('tr').attr('personal_id');
    const personalExists = checkIfPersonalAIdsExists(personal_id);

    if (!personalExists) {
        Swal.fire({
            title: 'Ups!',
            text: "Ha ocurrido un error",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido",
            timer: 2000
        })
        return;
    }

    const availableContract = checkTypeContract(personal_id);
    if (availableContract.contrato !== "Freelance") {

        const personalData = allPersonal.find((personal) => {
            if (personal.id === personal_id) {
                return true;
            }
        })
        Swal.fire({
            title: 'Ups!',
            text: `${personalData.nombre} posee un contrato ${personalData.contrato}, lo que no permite poder modificar el valor total a pagar para este evento`,
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido"
        })
        $(this).val(CLPFormatter(parseInt(personalCurrentValue)));
        return;
    }
    $(this).val(CLPFormatter(valor))
    changePersonalAmount(personal_id, valor);
    printAllSelectedPersonal();
    setEgresos();
})

$(document).on('click', '.removePersonalToAssigment', function () {

    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("11")) {
        let personal_id = $(this).closest('tr').attr('personal_id');
        const personalExists = checkIfPersonalAIdsExists(personal_id);
        if (!personalExists) {
            return;
        }
        RemoveSelectedPersonal(personal_id);
        printAllSelectedPersonal();
    } else {
        Swal.fire({
            title: 'Lo sentimos',
            text: "No tienes los persisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido"
        })
    }
})

function checkIfPersonalAIdsExists(personal_id) {
    const personalExists = allPersonal.find((personal) => {
        if (personal.id === personal_id) {
            return true;
        }
    })
    if (personalExists) {
        return true;
    } else {
        return false;
    }
}

function checkTypeContract(personal_id) {
    const tipoContrato = allPersonal.find((personal) => {
        if (personal.id === personal_id) {
            return personal.contrato
        }
    })

    return tipoContrato;
}
function changePersonalAmount(personal_id, newCost) {
    allSelectedPersonal.forEach((personal) => {
        if (personal.id === personal_id) {
            personal.neto = newCost;
            console.table(personal);
        }
    })
}

function AddSelectedPersonal(personal_id) {
    const personal = allPersonal.find((personal) => {
        if (personal.id === personal_id) {
            return true;
        }
    });
    if (personal) {
        personal.isSelected = true;
        allSelectedPersonal.push(personal);
    }


    // console.log("ESTE ES EL BOTON DE AGREGAR EL PERSONAL LLASELECTEDPERSONAL", allSelectedPersonal);
}

function RemoveSelectedPersonal(personal_id) {
    const personal = allPersonal.find((personal) => {
        return personal.id === personal_id
    })

    if (personal) {
        personal.isSelected = false;
        allSelectedPersonal = allSelectedPersonal.filter((personal) => { return personal.id !== personal_id });
    }
}

function printAllSelectedPersonal() {
    // console.log("allSelectedPersonal", allSelectedPersonal)
    // console.log("allPersonal", allPersonal)
    // console.log("projectDates",projectDates);
    $('#personalResumeAssigment tbody tr').remove();
    $('#selectedPersonalSideResume tbody tr').remove();
    $('#selectedPersonalAssigtment tbody tr').remove();
    $('.personalResumeTable').remove();
    $('#searchAllPersonal option').remove();
    allPersonal.forEach((personal) => {



        if(personal.isDelete == 1){
            return;
        }
        // const personalExists = allSelectedPersonal.find((personalSelected)=>{
        //     if(personalSelected.id === personal.id){
        //         return true;
        //     }
        // })
        // if(!personalExists){

        let personalStatus = "";
        if (personal.isSelected) {
            personalStatus = "personalSelected"
        }
        if (personal.isPicked === true) {
            personalStatus = "isPicked";
        }
        if (personal.isPicked && personal.isSelected) {
            personalStatus = "pickedAndSelected"
        }

        let tr = `<tr personal_id="${personal.id}" class="${personalStatus}">
            <td> <p class="--h-text-flex">${personal.nombre}</p></td>
            <td>${personal.rut}</td>
            <td>${personal.especialidad}</td>
            <td>${personal.contrato}</td>
            <td class="addPersonalToResume"><p class="s-P-g">Agregar</p></td>
        <tr>`;
        $('#personalResumeAssigment > tbody').append(tr);
        // }
    });

    allSelectedPersonal.forEach((personal) => {
        let personalStatus = "";
        if (personal.isSelected) {
            personalStatus = ""
        }
        if (personal.isPicked === true) {
            personalStatus = "isPicked";
        }
        if (personal.isPicked && personal.isSelected) {
            personalStatus = "pickedAndSelected"
        }

        let horaHombre = 0;
        let tr = "";
        if (personal.contrato !== "Freelance") {
            horaHombre = (parseInt(personal.neto) / 180);
            let totalHombre = 0;
            let totalHorasTrabajadas = personal.horasTrabajadas;
            totalHombre = parseInt(horaHombre) * totalHorasTrabajadas;

            tr = `<tr class="personalResumeTable ${personalStatus}" personal_id="${personal.id}">
                <td class="">${personal.nombre}</td>
                <td class="">${personal.especialidad}</td>
                <td class="tipoContratoProjectResume">${personal.contrato}</td>
                <td>${CLPFormatter(parseInt(horaHombre))}</td>
                <td class="horasTrabajadas"><input type="number" class="input-horasTrabajadas" value="${totalHorasTrabajadas}"></td>
                <td class="total">${CLPFormatter(parseInt(totalHombre))}</td>
            </tr>`;
            personal.horasTrabajadas = parseInt(totalHorasTrabajadas);
        } else {
            horaHombre = 0;
            tr = `<tr class="personalResumeTable ${personalStatus}" personal_id="${personal.id}">
                <td>${personal.nombre}</td>
                <td>${personal.especialidad}</td>
                <td>${personal.contrato}</td>
                <td></td>
                <td></td>
                <td><input type="text" class="freeLanceValue" value="${CLPFormatter(parseInt(personal.neto))}"></td>
            </tr>`;
        }
        // APPEND TO RESUME ON PERSONAL
        let trResume = `<tr class="${personalStatus}" personal_id="${personal.id}">
            <td>${personal.nombre}</td>
            <td>${personal.especialidad}</td>
            <td class="removePersonalToAssigment c-pointer">
                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 4H3.33333H14" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5.33334 4.00065V2.66732C5.33334 2.3137 5.47381 1.97456 5.72386 1.72451C5.97391 1.47446 6.31305 1.33398 6.66667 1.33398H9.33334C9.68696 1.33398 10.0261 1.47446 10.2761 1.72451C10.5262 1.97456 10.6667 2.3137 10.6667 2.66732V4.00065M12.6667 4.00065V13.334C12.6667 13.6876 12.5262 14.0267 12.2761 14.2768C12.0261 14.5268 11.687 14.6673 11.3333 14.6673H4.66667C4.31305 14.6673 3.97391 14.5268 3.72386 14.2768C3.47381 14.0267 3.33334 13.6876 3.33334 13.334V4.00065H12.6667Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.33334 7.33398V11.334" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66666 7.33398V11.334" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </td>
        </tr>`
        $('#selectedPersonalSideResume tbody').append(trResume);
        $('#selectedPersonalAssigtment').append(tr);
    });

    tippy('.isPicked', {
        content: '<strong>Técnico reservado para otro evento en la fecha seleccionada</strong>'
    });
    tippy('.pickedAndSelected', {
        content: '<strong>Técnico seleccionado para este y otro(s) evento(s)</strong>'
    });

    setEgresos();
}

function FillAvailablepersonal(empresaId, fechaInicio, fechaTermino) {
    $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getAvailablePersonal",
            request: {
                "empresaId": empresaId,
                "fechaInicio": fechaInicio,
                "fechaTermino": fechaTermino
            }

        }),
        success: function (response) {
            console.table(response);
            // response.forEach(personal => {

            //     if(personal.neto ==="" || personal.neto === null || personal.neto === undefined){
            //         personal.neto = 0;
            //     }
            //     let li = `<li style="display:flex; justify-content:space-between;" class="${personal.id}">
            //             ${personal.nombre} | ${personal.cargo} ${personal.especialidad}                             
            //             <p class="tipoContrato" style="display:none">${personal.contrato}</p>
            //             <div class="personalPricing" style="display:flex;align-content: center;">
            //                 <input type="number" name="price" class="personalPrice" value="${personal.neto}" placeholder="Costo"/>
            //                 <i onclick="AddPersonal(this)"class="fa-solid fa-plus addPersonal"></i>
            //                 <i onclick="removePersonal(this)" class="fa-solid fa-minus removePersonal" style="display:none; color: #b92413;"></i>
            //             </div>
            //         </li>`;
            //     $('#sortablePersonal1').append(li)
            // });
        }
    })
}

function AddPersonal(el) {
    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("11")) {

        let idProd = el.closest('li').className;
        let li = el.closest('li');
        let valor = CLPFormatter(el.previousElementSibling.value);
        let notFormattedValue = el.previousElementSibling.value;
        let tipoContrato = $(el).closest('li').find('.tipoContrato').text();

        let nombrePersonal = el.closest('li').innerText;
        let idPersonal = el.closest('li').className;

        let tbodyPersonal = $('#projectPersonal tbody > tr');

        if (notFormattedValue === undefined || notFormattedValue === "" || notFormattedValue === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Ups!',
                text: 'Ingresa el costo de este trabajador antes de asignarlo a este evento'
            })
        } else {

            $(el).hide();
            $(el).closest(li).find('.removePersonal').show();
            li.remove()

            $('#sortablePersonal2').append(li)
            PersonalLocalStorage(idPersonal, nombrePersonal, notFormattedValue, tipoContrato);
            TotalCosts(notFormattedValue);
            changePersonalTableResume("add");
        }

    } else {
        Swal.fire({
            title: 'Lo sentimos',
            text: "No tienes los persisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido"
        })
    }

}

function removePersonal(element) {

    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("11")) {
        let li = $(element).closest('li');
        let idProduct = li.attr('class');
        $(element).closest(li).find('.addPersonal').show();
        $(element).hide();
        li.remove();
        $('#sortablePersonal1').append(li);
        removeProductStorage(idProduct);
        console.log(GetPersonalStorage());
        removePersonalFromResume(idProduct);
    } else {
        Swal.fire({
            title: 'Lo sentimos',
            text: "No tienes los persisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Entendido"
        })
    }

}

function removePersonalFromResume(id) {
    let tdPersonal = $('#projectPersonal tbody').find('.idPersonal')
    tdPersonal.each((index, td) => {
        if ($(td).text() === id) {
            $(td).closest('tr').remove();
        }
    })
    SetResumePersonalValue();
}

function SetResumePersonalValue() {
    let personalCost = $('.valorPersonalResume')
    let totalPersonalContratado = 0
    let totalPersonalBHE = 0;
    let totalPersonal = 0;
    Array.from(personalCost).forEach(pCost => {
        let tipoContrato = $(pCost).closest('tr').find('.tipoContratoProjectResume').text();

        if (tipoContrato === "BHE") {
            totalPersonalBHE = totalPersonalBHE + parseInt(ClpUnformatter($(pCost).text()));
        } else {
            totalPersonalContratado = totalPersonalContratado + parseInt(ClpUnformatter($(pCost).text()));
        }
    });

    total = totalPersonalContratado + totalPersonalBHE;
    $('#totalResumePersonal').text(CLPFormatter(total))
    // console.log("totalPersonalContratado", totalPersonalContratado);
    $('#totalPersonalDes').text(CLPFormatter(totalPersonalContratado));
    $('#totalPersonalBHEDes').text(CLPFormatter(totalPersonalBHE));
}


function changePersonalTableResume(tipo) {

    let lStorage = GetPersonalStorage();
    let arrayLength = lStorage.length;
    lStorage = lStorage[arrayLength - 1];

    if (tipo === "add") {
        let newTr = `<tr>
                        <td class="idPersonal" style="display:none">${lStorage.idPersonal}</td>
                        <td class="tbodyHeader">${lStorage.nombrePersonal}</td>
                        <td class="tipoContratoProjectResume">${lStorage.tipoContrato}</td>
                        <td class="valorPersonalResume">${CLPFormatter(lStorage.valor)}</td>
                    </tr>`;
        for (let i = arrayLength - 1; i === arrayLength - 1; i++) {
            $("#projectPersonal tr:last").before(newTr);
        }
        SetResumePersonalValue();
        $('#totalCostProject').text(CLPFormatter(parseInt(GetTotalCosts())));
    }

    if (tipo === "delete") {

    }

}

function AppendPersonalTableResumeArray(arrayPersonal) {

    for (let i = 0; i < arrayPersonal.length; i++) {
        let newTr = `<tr>
                        <td class="idPersonal" style="display:none">${arrayPersonal[i].idPersonal}</td>
                        <td class="tbodyHeader">${arrayPersonal[i].nombrePersonal}</td>
                        <td class="tipoContratoProjectResume">${arrayPersonal[i].tipoContrato}</td>
                        <td class="valorPersonalResume">${CLPFormatter(arrayPersonal[i].valor)}</td>
                    </tr>`;

        $("#projectPersonal tr:last").before(newTr);
        TotalCosts(arrayPersonal[i].valor);
    }

    SetResumePersonalValue();
    $('#totalCostProject').text(CLPFormatter(parseInt(GetTotalCosts())));

}


function AddEspecialidad(empresaId) {
    let string = $('#especialidadName').val()
    if (string !== "") {

        const arrayCargos = string.split(",")
        $.ajax({
            type: "POST",
            url: "ws/personal/Personal.php",
            data: JSON.stringify({
                action: "AddEspecialidad",
                request: { arrayCargos },
                "empresaId": empresaId
            }),
            dataType: 'json',
            success: async function (data) {
                Swal.fire({
                    'icon': 'success',
                    'title': 'Excelente!',
                    'text': 'Datos ingresados con exito',
                    'timer': 1500
                }).then(() => {
                    $('#especialidadName').val("");
                    $('#cargoEspecialidad').modal('hide');
                })
            }
        })

    } else {
        Swal.fire({
            'icon': 'error',
            'title': 'Ups!',
            'text': 'Ingrese al menos una especialidad'
        })
    }
}
async function AddEspecialidadGivenArray(empresaId, valor) {
    let arrayCargos = valor
    let response;
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "AddEspecialidad",
            request: { arrayCargos },
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: function (data) {
            return true;
        }, error: function () {
            return false;
        }
    })
}
async function AddCargoGivenArray(empresaId, valor) {

    let arrayCargos = valor
    let response;
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "AddCargo",
            request: { arrayCargos },
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: function (data) {
            console.log('ESPECIALIDADES AGREGADAS A LA BASE DE DATOS', data);
            return true;
        }, error: function () {
            return false;
        }
    })
}

function AddCargo(empresaId) {
    let string = $('#CargoName').val();
    if (string !== "") {

        const arrayCargos = string.split(",")
        $.ajax({
            type: "POST",
            url: "ws/personal/Personal.php",
            data: JSON.stringify({
                action: "AddCargo",
                request: { arrayCargos },
                "empresaId": empresaId
            }),
            dataType: 'json',
            success: async function (data) {
                Swal.fire({
                    'icon': 'success',
                    'title': 'Excelente!',
                    'text': 'Cargos ingresados exitosamente',
                    'timer': 2500
                }).then(() => {
                    $('#CargoName').val("");
                    $('#cargoEspecialidad').modal('hide');

                })
            }
        })
    } else {
        Swal.fire({
            'icon': 'error',
            'title': 'Ups!',
            'text': 'Ingrese al menos un cargo'
        })
    }
}

function printEspecialidadOnCrud(especialidades) {
    if ($.fn.DataTable.isDataTable('#esp-table-crud')) {
        $('#esp-table-crud').DataTable()
            .clear()
            .draw();
        $('#esp-table-crud').DataTable().destroy();
    }

    especialidades.especialidades.forEach((cargo) => {

        let tr = `<tr especialidad_id="${cargo.id}">
            <td>${cargo.especialidad}</td>
            <td class="deleteEpecialidad"><img src="./assets/svg/trash-2.svg" alt="trashCan icon"></td>
        </tr>`

        $('#esp-table-crud').append(tr);
    });

    if (!$.fn.DataTable.isDataTable('#esp-table-crud')) {
        $('#esp-table-crud').DataTable({
            columnDefs: [
                { "defaultContent": "-", "targets": "_all" },
                { "width": "84%", "targets": [0] },
                { "width": "15%", "targets": [1] },
                { "className": "e-1", "targets": [0] },
                { "className": "e-2", "targets": [1] }
            ],
            lengthMenu: [3, 5, 10, 20],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Eventos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 5
        });
    }
}

$(document).on("click", ".deleteEpecialidad", async function () {
    const ESPECIALIDAD_ID = $(this).closest('tr').attr('especialidad_id');

    const ESP_EXISTS = _allEspecialidades.find((esp) => { return esp.id === ESPECIALIDAD_ID })

    if (!ESP_EXISTS) {
        Swal.fire({
            'icon': 'error',
            'title': "Ups!",
            'text': 'Intente nuevamente'
        })
        return
    }

    const DELETE_ESPECIALIDAD_RESPONSE = await deleteEspecialidad(ESPECIALIDAD_ID, EMPRESA_ID);
    if (!DELETE_ESPECIALIDAD_RESPONSE.success) {
        Swal.fire({
            'icon': 'warning',
            'title': "Ups!",
            'text': DELETE_ESPECIALIDAD_RESPONSE.message
        })
        return
    }

    Swal.fire({
        'icon': 'success',
        'title': "Excelente!",
        'text': DELETE_ESPECIALIDAD_RESPONSE.message
    });

    const ESPECIALIDADES = await GetEspecialidadByBussiness(EMPRESA_ID);
    printEspecialidadOnCrud(ESPECIALIDADES);
})
function printCargosOnCrud(cargos) {

    if ($.fn.DataTable.isDataTable('#cargo-table-controller')) {
        $('#cargo-table-controller').DataTable()
            .clear()
            .draw();
        $('#cargo-table-controller').DataTable().destroy();
    }

    cargos.cargos.forEach((cargo) => {

        let tr = `<tr cargo_id="${cargo.id}">
            <td>${cargo.cargo}</td>
            <td class="deleteCargo"><img src="./assets/svg/trash-2.svg" alt="trashCan icon"></td>
        </tr>`

        $('#cargo-table-controller').append(tr);
    });

    if (!$.fn.DataTable.isDataTable('#cargo-table-controller')) {
        $('#cargo-table-controller').DataTable({
            columnDefs: [
                { "defaultContent": "-", "targets": "_all" },
                { "width": "85%", "targets": [0] },
                { "width": "15%", "targets": [1] },
                { "className": "w-85", "targets": [0] },
                { "className": "w-15", "targets": [1] }
            ],
            lengthMenu: [3, 5, 10, 20],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Eventos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 5
        });
    }
}

$(document).on("click", ".deleteCargo", async function () {
    const CARGO_ID = $(this).closest('tr').attr('cargo_id');
    console.table(_allCargos)
    console.table(CARGO_ID)

    const CARGO_EXISTS = _allCargos.find((car) => { return car.id === CARGO_ID })

    if (!CARGO_EXISTS) {
        Swal.fire({
            'icon': 'error',
            'title': "Ups!",
            'text': 'Intente nuevamente'
        })
        return
    }

    const DELETE_CARGO_RESPONSE = await deleteCargo(CARGO_ID, EMPRESA_ID);
    if (!DELETE_CARGO_RESPONSE.success) {
        Swal.fire({
            'icon': 'warning',
            'title': "Ups!",
            'text': DELETE_CARGO_RESPONSE.message
        })
        return
    }

    Swal.fire({
        'icon': 'success',
        'title': "Excelente!",
        'text': DELETE_CARGO_RESPONSE.message
    });


    const CARGOS = await GetCargoByBussiness(EMPRESA_ID);
    printCargosOnCrud(CARGOS);
})


async function GetEspecialidadByBussiness(empresaId) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "getEspecialidad",
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: async function (data) {
            _allEspecialidades = data.especialidades

        }, error: function (error) {
            console.log(error)
        }
    })
}

async function GetEspecialidad(empresaId) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "getEspecialidad",
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: async function (data) {
            $('#especialidadPersonal').empty();
            $('#especialidadPersonal').append(new Option("", ""));
            data.especialidades.forEach(esp => {
                $('#especialidadPersonal').append(new Option(`${esp.especialidad}`, esp.id))
            })
            $('#update_especialidadPersonal').empty();
            $('#update_especialidadPersonal').append(new Option("", ""));
            data.especialidades.forEach(esp => {
                $('#update_especialidadPersonal').append(new Option(`${esp.especialidad}`, esp.id))
            })
        }
    })
}

async function deleteEspecialidad(especialidad_id, empresa_id) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "deleteEspecialidad",
            "empresa_id": empresa_id,
            "especialidad_id": especialidad_id
        }),
        dataType: 'json',
        success: async function (data) {

        }, error: function (error) {
            // console.log(error)
        }
    })
}

async function deleteCargo(cargo_id, empresa_id) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "deleteCargo",
            "empresa_id": empresa_id,
            "cargo_id": cargo_id
        }),
        dataType: 'json',
        success: async function (data) {

        }, error: function (error) {
            // console.log(error)
        }
    })
}

function getAllEspecialidades(empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "getEspecialidad",
            "empresaId": empresa_id
        }),
        dataType: 'json',
        success: async function (data) {
            // console.log("ESPECIALIDADES", data);
        }
    })
}

async function GetCargoByBussiness(empresaId) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "getCargo",
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: async function (data) {
            _allCargos = data.cargos;
        }, error: function (error) {
            // console.log(error)
        }
    })

}
async function GetCargo(empresaId) {

    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "getCargo",
            "empresaId": empresaId
        }),
        dataType: 'json',
        success: async function (data) {
            // console.log(data);
            $('#cargoPersonal').empty();
            $('#cargoPersonal').append(new Option("", ""));
            data.cargos.forEach(car => {
                $('#cargoPersonal').append(new Option(`${car.cargo}`, car.id))
            })
            $('#update_cargoPersonal').empty();
            $('#update_cargoPersonal').append(new Option("", ""));
            data.cargos.forEach(car => {
                $('#update_cargoPersonal').append(new Option(`${car.cargo}`, car.id))
            })
        }
    })

}

async function GetPersonalByEmpresa(empresaId) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        data: JSON.stringify({
            action: "GetPersonalByEmpresa",
            "empresa_id": empresaId
        }),
        dataType: 'json',
        success: async function (response) {
        }
    })
}

function getTakenPersonalByDateRange(data, empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/personal/Personal.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getTakenPersonalByDateRange",
            'empresa_id': empresa_id,
            'request': {
                'data': data
            }
        }),
        success: function (response) {

        },
        error: function (error) {
            // console.log(error);
        }
    })
}
_takenPersonal = [];
async function setTakenPersonalByRangeDate() {
    const fecha_inicial = $('#fechaInicio').val();
    const fecha_termino = $('#fechaTermino').val();
    if (fecha_inicial === "" || fecha_termino === "") {
        return false;
    }
    // set dates to get taken prods and substract from productList
    const dates = {
        'fecha_inicio': projectDates.start_date,
        'fecha_termino': projectDates.finish_date
    }
    const takenPersonal = await getTakenPersonalByDateRange(dates, EMPRESA_ID);
    _takenPersonal = takenPersonal.data;
    console.table("_takenPersonal", _takenPersonal);
    return true;


}

function setAllPersonal_DiscountTakenPersonal() {
    // MODIFY ALLPERSONAL ARRAY AND ADD IF IS PICKED

    // console.log("selectedPersonal", allSelectedPersonal);


    allPersonal.forEach((personal) => {
        personal.isPicked = false
    })
    _takenPersonal.forEach((takenPersonal) => {
        if (takenPersonal.proyecto_id !== projectDates.project_id) {
            // DISCOUNTS ON ALLPERSONAL ON NO SELECTED ARRAY
            const personalExists = allPersonal.find((personal) => {
                return personal.id === takenPersonal.personal_id;
            })
            if (personalExists) {
                personalExists.isPicked = true;
            }
            // DISOCUNT TAKEN PRODUCTS ON SELECTED PRODUCTS
            const selectedPersonal = allSelectedPersonal.find((selectedPersonal) => {
                return selectedPersonal.id === takenPersonal.personal_id
            })
            if (selectedPersonal) {
                personalExists.isPicked = true;
            }
        }
    })
};

let lastFreeLanceValue = 0;
$(document).on('click', '.freeLanceValue', function () {
    const currentValue = ClpUnformatter($(this).val());
    lastFreeLanceValue = currentValue;
    $(this).val("")
})
$(document).on('blur', '.freeLanceValue', function () {
    const valor = $(this).val();
    const personal_id = $(this).closest('tr').attr('personal_id');


    if (valor === "" || valor === undefined || valor === null) {
        $(this).val(CLPFormatter(parseInt(lastFreeLanceValue)));
        return
    }
    if (!isNumeric(valor)) {
        Swal.fire({
            title: "Ups!",
            text: "Ingrese un número",
            icon: "warning",
            timer: 2000
        });
        $(this).val(CLPFormatter(lastFreeLanceValue));
        return;
    }

    const personalSelectedExists = allSelectedPersonal.find((selectedPersonal) => {
        return selectedPersonal.id === personal_id
    })

    if (!personalSelectedExists) {
        Swal.fire({
            title: "Ups!",
            text: "Ha ocurrido un error",
            icon: "error",
            timer: 2000
        });
        return;
    }
    if (personalSelectedExists.contrato !== "Freelance") {
        Swal.fire({
            title: "Ups!",
            text: "No se puede modificar el total a pagar a un técnico que no sea freeLance",
            icon: "info",
            timer: 2000
        });
        return;
    }
    personalSelectedExists.neto = valor;
    $(this).val(CLPFormatter(parseInt(valor)));
    printAllSelectedPersonal();

})



let lastHorasTrabajadas = 0;
$(document).on('click', '.input-horasTrabajadas', function () {
    lastHorasTrabajadas = parseInt($(this).val());
    $(this).val("")
})

$(document).on('blur', '.input-horasTrabajadas', function () {
    const newHorasTrabajadas = $(this).val();

    if (newHorasTrabajadas === "" || newHorasTrabajadas === undefined || newHorasTrabajadas === null) {
        Swal.fire({
            title: "Ups!",
            text: "No se puede modificar el total a pagar a un técnico que no sea freeLance",
            icon: "info",
            timer: 2000
        });
        $(this).val(lastHorasTrabajadas);
        return;
    }

    if (!isNumeric(newHorasTrabajadas)) {
        Swal.fire({
            title: "Ups!",
            text: "Debes ingresar un número",
            icon: "info",
            timer: 2000
        });
        $(this).val(lastHorasTrabajadas);
        return;
    }

    const personal_id = $(this).closest('tr').attr('Personal_id');

    const personalExiste = allSelectedPersonal.find((selectedPersonal) => {
        return selectedPersonal.id === personal_id;
    })

    if (!personalExiste) {
        Swal.fire({
            title: "Ups!",
            text: "Ha ocurrido un error",
            icon: "error",
            timer: 2000
        });
        return;
    }

    personalExiste.horasTrabajadas = parseInt(newHorasTrabajadas);

    printAllSelectedPersonal();
})

$('#openModalNewFree').on('click', async function () {
    // $('#newFreeLance-Modal').modal('show');


    
    
    
    
    const especialidades = await getAllEspecialidades(EMPRESA_ID);
    console.log('especialidades',especialidades)
    console.log('especialidades',especialidades)
    console.log('especialidades',especialidades)
    console.log('especialidades',especialidades)
    console.log('especialidades',especialidades)
    console.log($('#especialidadSelect'));
    console.log($('#especialidadSelect'));
    console.log($('#especialidadSelect'));
    $('#especialidadSelect option').remove();
    especialidades.especialidades.forEach((especialidad) => {
        $('#especialidadSelect').append(new Option(especialidad.especialidad, especialidad.id))
    });


    $('#newFreelanceSideMenu').addClass('active');
})

function closeFreelanceSideMenu(){

    $('#newFreelanceSideMenu').removeClass('active');
}
$('#closeNewFreelanceSideMenu').on('click',function(){
})

$('#triggerNewFreeLance').on('click', function () {
    $('#createNewFreeLance').trigger('click')
});



function setNetoPersonal(selPersonal){

    selPersonal.forEach((selPersonal)=>{
        

        const PERSONAL = allPersonal.find((personal)=>{
            return personal.id == selPersonal.id
        });

        if(PERSONAL){
            selPersonal.neto = PERSONAL.neto
        }
    })

}



$('#triggerNewFreeLance').on('click',function(){
    console.log($('#createNewFreeLance'))
    $('#createNewFreeLance')[0].click()
})




