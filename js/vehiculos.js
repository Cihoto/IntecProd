let allVehicles = [];
let selectedVehicles = [];
let _allMyVehicles = [];
let _brands = [];
let _models = [];
let _types = [];
let vehicleData = {
    data:[

    ],
    events:[

    ],
    vehicle_id: ""
}

function searchVehiculoDrag() {
    let dragVehiculos = document.getElementById('sortable1').getElementsByTagName('li')
    let inputValue = document.getElementById('searchInputVehiculo').value.toUpperCase();
    for (let item of dragVehiculos) {
        let liValue = item.innerText.toUpperCase()
        if (!liValue.includes(inputValue)) {
            item.style.display = 'none';
        } else {
            item.style.display = '';
        }
    }
}

$(document).ready(async function () {
    const VEHICLES_BRANDS_MODELS = await getVehicleBrandsAndModels();
    _brands = VEHICLES_BRANDS_MODELS.brands;
    _models = VEHICLES_BRANDS_MODELS.models;
    _types = VEHICLES_BRANDS_MODELS.types;

    const selData = _brands.map((brand) => {
        return {
            'id': brand.id,
            'text': brand.brand
        }
    });

    const typeData = _types.map((type) => {
        return {
            'id': type.id,
            'text': type.tipo
        }
    });

    $('#vehicleCreateModel').select2({

    })
    $('#vehicleCreateBrand').select2({
        data : selData
    });
    $('#vehicleCreateType').select2({
        data : typeData
    });

    $('#vehicleUpdateModel').select2({

    })
    $('#vehicleUpdateBrand').select2({
        data : selData
    });
    $('#vehicleUpdateType').select2({
        data : typeData
    });
})

$('#vehicleCreateBrand').on("change",function(){
    const BRAND_ID = $(this).val();
    const modelSelData = _models.filter((model)=>{

        if(model.brand_id === BRAND_ID){

            return {
                'id' : model.id,
                'text' : model.model
            }
        }
    }).map((model)=>{
        return {
            'id' : model.id ,
            'text' : model.model
        }
    });

    $('#vehicleCreateModel').select2('destroy');
    $('#vehicleCreateModel').empty();
    $('#vehicleCreateModel').select2({
        data : modelSelData
    });
});

$('#vehicleUpdateBrand').on("change",function(){
    const BRAND_ID = $(this).val();

    getAndPrintModelsPerBrand(BRAND_ID);
});

function getAndPrintModelsPerBrand(brand_id){
    const modelSelData = _models.filter((model)=>{

        if(model.brand_id === brand_id){

            return {
                'id' : model.id,
                'text' : model.model
            }
        }
    }).map((model)=>{
        return {
            'id' : model.id ,
            'text' : model.model
        }
    });

    $('#vehicleUpdateModel').select2('destroy');
    $('#vehicleUpdateModel').empty();
    $('#vehicleUpdateModel').select2({
        data : modelSelData
    });
    
    if(vehicleData.data.model_id){
        $('#vehicleUpdateModel').val(vehicleData.data.model_id);
        $('#vehicleUpdateModel').change();
        
    }
}


$(document).on("click",'#vehiclesDashTable tbody tr',async function(){
    
    const VEHICLE_ID = $(this).closest('tr').attr('vehicle_id');
    const VEHICLE_EXISTS = _allMyVehicles.find((vehicle)=>{return vehicle.vehicle_id === VEHICLE_ID})

    
    console.log(VEHICLE_ID)
    console.log(VEHICLE_EXISTS)
    if(!VEHICLE_EXISTS){
        Swal.fire({
            "icon":"error",
            "title" : "Ups!",
            "text": "Intenta nuevamente"
        })
        return
    }
    
    
    $('#vehicleInfoSideMenu').addClass('active');
    const VEHICLE_INFO = await getVehicleInfoById(VEHICLE_ID, EMPRESA_ID);

    
    if(!VEHICLE_INFO.success){
        
        $('#vehicleInfoSideMenu').removeClass('active');
        Swal.fire({
            "icon":"error",
            "title" : "Ups!",
            "text": "Ha ocurrido un error intenta nuevamente"
        })
        return
        
    }

    vehicleData.data = VEHICLE_INFO.data
    vehicleData.events = VEHICLE_INFO.events
    vehicleData.vehicle_id = VEHICLE_INFO.data.id

    $('#vehicleUpdateType').val(vehicleData.data.vehicle_type_id);
    $('#vehicleUpdateType').change();

    $('#vehicleUpdateBrand').val(vehicleData.data.brand_id);
    $('#vehicleUpdateBrand').change();

    $('#vehicleUpdatePatente').val(vehicleData.data.patente);
    $('#vehicleUpdateOwner').val(vehicleData.data.ownCar);
    
    $('#vehicleUpdateCostPerTrip').val(vehicleData.data.vehicle_type_id);

    $('#vehicleUpdateModel').val(vehicleData.data.model_id);
    // $('#vehicleUpdateModel').change();

    console.log(vehicleData);               
    console.log(vehicleData);
    console.log(vehicleData);
    printVehicleEvents();
});


function printVehicleEvents(){

    // vehicleData.events.forEach(())
    console.log(vehicleData.events)
    console.log(vehicleData.events)
    console.log(vehicleData.events)
    console.log(vehicleData.events)
    console.log(vehicleData.events)



    if ($.fn.DataTable.isDataTable('#eventsPerVehicle_dash')) {
        $('#eventsPerVehicle_dash').DataTable()
            .clear()
            .draw();
        $('#eventsPerVehicle_dash').DataTable().destroy();
    }
    vehicleData.events.forEach((evento) => {

        let fecha = evento.fecha_inicio;


        if(evento.fechaTermino !== '' || evento.fechaTermino !== null){
            fecha = `${evento.fecha_inicio}-${evento.fecha_termino}`
        }

        let eventStatus = evento.estado;

        if (evento.estado == null) {
            evento.estado = "borrador"
        }
        if (evento.estado == 'No va') {
            evento.estado = "No_va"
        }
        if (evento.estado_id === 1) {

        }
        if (evento.estado_id === 2) {
            color = "#27AE60"
        }
        if (evento.estado_id === 3) {
            color = "#7F45E3"
        }

        let tr = `<tr event_id="${evento.id}">
            <td><p class="--h-text-flex">${evento.nombre_proyecto}</p></td>
            <td><p class="--h-text-flex">${fecha}</p></td>
            <td><p class="event-status ${evento.estado}">${eventStatus[0].toUpperCase()}${eventStatus.slice(1)}</p> </td>
            <td><p class="--h-text-flex">${CLPFormatter(parseInt(evento.price_per_trip) * parseInt(evento.trip_count)) }</p></td>
        </tr>`;
        $('#eventsPerVehicle_dash tbody').append(tr)
    });
    if (!$.fn.DataTable.isDataTable('#eventsPerVehicle_dash')) {
        $('#eventsPerVehicle_dash').DataTable({
            columns:[{'width':'10%'},{'width':'10%'},{'width':'10%'},{'width':'10%'}],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ eventos",
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
            "pageLength": 10
        });
    }
}



$(document).on('click','#eventsPerVehicle_dash tbody tr',function(){
    const EVENT_ID = $(this).attr('event_id');
    openEvent(EVENT_ID);
})



$('#deleteVehicleDash').on('click',async function(){

    const VEHICLE_ID = parseInt(vehicleData.vehicle_id);
  
  
    Swal.fire({
      title: "¿Quieres eliminar este vehículo?",
      text: "Esta acción es irreversible!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Eliminar!"
    }).then(async (result) => {
      if (result.isConfirmed) {
  
        const REMOVE_VEHICLE_RESPONSE = await deleteVehicleDash(EMPRESA_ID,VEHICLE_ID);

        console.log('REMOVE_VEHICLE_RESPONSE',REMOVE_VEHICLE_RESPONSE);

        if(!REMOVE_VEHICLE_RESPONSE){
          Swal.fire({
            title: "Ups!",
            text: "No se ha podido eliminar el vehículo, intenta nuevamente!",
            icon: "error"
          });
          return 
        }
        Swal.fire({
          title: "Excelente!",
          text: "Vehículo eliminado.",
          icon: "success"
        });
        $('#vehicleInfoSideMenu').removeClass('active');
  
  
        $(`#vehiclesDashTable tbody tr[vehicle_id="${VEHICLE_ID}"]`).remove();
  
      }
    });
    
  
  
  })
  
  
  function deleteVehicleDash(empresa_id, vehicle_id){
    return $.ajax({
      type: "POST",
      url: "ws/vehiculo/Vehiculo.php",
      dataType: 'json',
      data: JSON.stringify({
        "action": "deleteVehicleDash",
        'vehicle_id': vehicle_id,
        'empresa_id': empresa_id
      }),
      success: function (response){
        console.log('response delete vehicle',response)
      }, error: function (error) {
        console.log('error',error);
      }
    })
  }

async function getVehicleInfoById(vehicle_id, empresa_id){
    return $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getVehicleInfoById",
            'vehicle_id': vehicle_id,
            'empresa_id': empresa_id
        }),
        success: function (response) {

        },error:function(error){
            
        }
    })
}


function FillVehiculos(empresaId) {

    $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getVehiculosForEvents",
            empresaId: empresaId
        }),
        success: function (response) {

            allVehicles = response.map((vehicle) => {
                return {
                    'id': vehicle.id,
                    'patente': vehicle.patente,
                    'ownCar': vehicle.ownCar,
                    'tripValue': vehicle.tripValue,
                    'tipoVehiculo': vehicle.tipo,
                    'cantidadViajes': 2,
                    'isSelected': false,
                    'isPicked': false,
                    'isDelete': vehicle.IsDelete
                }
            });
            console.log("allVehicles", allVehicles)
            printSelectedVehicles();
        }
    })
}
function getVehicleBrandsAndModels() {

    return $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getVehicleBrandsAndModels"
        }),
        success: function (response) {

        }, error: function (error) {

        }
    })
}
function getVehiclesByBussiness(empresa_id) {

    return $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getVehiclesByBussiness",
            'empresa_id': empresa_id
        }),
        success: function (response) {

        }, error: function (error) {

        }
    })
}

function printAllMyVehicles() {

    if ($.fn.DataTable.isDataTable('#vehiclesDashTable')) {
        $('#vehiclesDashTable').DataTable()
            .clear()
            .draw();
        $('#vehiclesDashTable').DataTable().destroy();
    }
    _allMyVehicles.forEach((vehicle) => {
        
        let ownCar = "Propio"

        if (vehicle.ownCar === "0") {
            ownCar = "Externo"
        }
        let tr = `<tr vehicle_id="${vehicle.vehicle_id}">
            <td class="ps-header"><p class="--h-text-flex">${vehicle.tipo === null ? "-" : vehicle.tipo}</p></td>
            <td><p class="--h-text-flex">${vehicle.brand === null ? "-" : vehicle.brand}</p></td>
            <td><p class="--h-text-flex">${vehicle.model === null ? "-" : vehicle.model}</p></td>
            <td><p class="--h-text-flex">${vehicle.patente === null ? "-" : vehicle.patente.toUpperCase()}</p></td>
            <td><p class="--h-text-flex">${ownCar}</p></td>
            <td>${vehicle.tripValue === null ? "-" : CLPFormatter(vehicle.tripValue)}</td>
        </tr>`;
        $('#vehiclesDashTable tbody').append(tr)
    });
    if (!$.fn.DataTable.isDataTable('#vehiclesDashTable')) {
        $('#vehiclesDashTable').DataTable({
            columns:[
                {'width': '20%'},
                {'width': '20%'},
                {'width': '20%'},
                {'width': '20%'},
                {'width': '10%'},
                {},
            ],
            columnDefs: [
                 {
                    className: "ps-header",
                    "targets": [0]
                }
            ],
            lengthMenu: [3,5,10,20,50,100],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Vehículos",
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

function GetAvailableVehicles(empresaId, fechaInicio, fechaTermino) {
    let arrayRequest = [{ "empresaId": empresaId, "fechaInicio": fechaInicio, "fechaTermino": fechaTermino }];
    $.ajax({
        type: "POST",
        url: "ws/vehiculo/Vehiculo.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getAvailableVehiculos",
            request: { arrayRequest }
        }),
        success: function (response) {
            console.log("vehiculos", response);
            allVehicles = response
            $('#DragVehiculos').show();
            response.forEach(vehiculo => {

                let li = `<li style="display:flex; justify-content:space-between;" class="${vehiculo.id}">
                        ${vehiculo.patente}
                        <div class="personalPricing" style="display:flex;align-content: center;">
                            <input type="number" name="price" class="vehiclePrice" placeholder="Costo"/>
                            <i onclick="AddVehiculo(this)"class="fa-solid fa-plus addPersonal addVehicle"></i>
                            <i onclick="removeVehicle(this)" class="fa-solid fa-minus addVehicle" style="display:none; color: #b92413;"></i>
                        </div>
                    </li>`;
                // let li = `<li class="${vehiculo.id}">${vehiculo.patente}</li>`
                $('#sortable1').append(li)
            });
        }
    })
}

function AddVehiculo(element) {

    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("13")) {
        console.log(allVehicles)

        const valorVehiculo = $('.addVehicle').closest('.personalPricing').find('.vehiclePrice').val();

        let idVehiculo = $(element).closest('li').attr('class').trim();

        if (valorVehiculo === undefined || valorVehiculo === "" || valorVehiculo === 0) {

            Swal.fire({
                icon: 'info',
                title: 'Ups!',
                text: 'Ingresa el costo de este Vehículo antes de asignarlo a este evento'
            })

            return;
        }
        const vehicleExists = allVehicles.find((vehicle) => {

            if (vehicle.id === idVehiculo) {
                return true
            }

        })

        if (vehicleExists) {

            selectedVehicles.push({
                'id': vehicleExists.id,
                'patente': vehicleExists.patente,
                'valor': valorVehiculo
            })

        }
        printSelectedVehicles();
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

function removeVehicle(element) {
    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("13")) {
        let vehicle_id = $(element).closest('li').attr('vehicle_id');
        const existsToDelete = selectedVehicles.find((selected, index) => {
            if (selected.id === vehicle_id) {
                selectedVehicles.splice(index, 1);
                return true
            }
        })
        printSelectedVehicles();
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

function printSelectedVehicles() {
    $('#sortable2 li').remove();
    $('#sortable1 li').remove();
    $("#vehiculosProject .resumeVehicleData").remove();
    $('#selectedVehiculoSideResume tbody tr').remove();
    $('#allVehiclesTable tbody tr').remove();
    $('#selectedVehiclesCosts tbody tr').remove();

    // allVehiclesTable
    allVehicles.forEach((vehiculo) => {

        console.log
        if(vehiculo.isDelete == 1){
            return
        }

        let vehicleStatus = "";


        if (vehiculo.isSelected === true) {
            vehicleStatus = "isSelected"
        }

        if (vehiculo.tripValue === null) {
            vehiculo.tripValue = 0
        }

        let owner = "";

        if (vehiculo.propietario === true) {
            owner = "Propio";
        } else {
            owner = "Externo";
        }

        let tr = `<tr vehiculo_id="${vehiculo.id}" class="${vehicleStatus}">
            <td>${vehiculo.tipoVehiculo}</td>
            <td>${owner}</td>
            <td>${vehiculo.patente}</td>
            <td>${CLPFormatter(parseInt(vehiculo.tripValue))}</td>
            <td class="addVehicleToResume"><p class="s-P-g">Agregar</p></td>
        </tr>`

        $('#allVehiclesTable tbody').append(tr);
    })

    selectedVehicles.forEach((selectedVehicle) => {
        let owner = "";
        let tripCostTd = ``;
        let total = 0;
        total = parseInt(selectedVehicle.cantidadViajes) * parseInt(selectedVehicle.tripValue);

        if (selectedVehicle.ownCar === "1") {
            owner = "Propio";
            total = parseInt(selectedVehicle.cantidadViajes) * parseInt(selectedVehicle.tripValue);
        } else {
            owner = "Externo";
            // total = parseInt(selectedVehicle.tripValue) * parseInt();
        }

        let tr = `<tr vehiculo_id="${selectedVehicle.id}">
            <td>${selectedVehicle.tipoVehiculo}</td>
            <td>${owner}</td>
            <td> <input type="text" class="tripValueInput" value="${CLPFormatter(selectedVehicle.tripValue)}"> </td>
            <td><input type="number" class="cantidadViajesInput" value="${selectedVehicle.cantidadViajes}"></td>
            <td>${CLPFormatter(total)}</td>
        </tr>`
        $('#selectedVehiclesCosts').append(tr);

        let trResume = `<tr class="" vehiculo_id="${selectedVehicle.id}">
            <td>${selectedVehicle.patente}</td>
            <td>${owner}</td>
            <td class="removeVehiculoToAssigment c-pointer">
                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 4H3.33333H14" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5.33334 4.00065V2.66732C5.33334 2.3137 5.47381 1.97456 5.72386 1.72451C5.97391 1.47446 6.31305 1.33398 6.66667 1.33398H9.33334C9.68696 1.33398 10.0261 1.47446 10.2761 1.72451C10.5262 1.97456 10.6667 2.3137 10.6667 2.66732V4.00065M12.6667 4.00065V13.334C12.6667 13.6876 12.5262 14.0267 12.2761 14.2768C12.0261 14.5268 11.687 14.6673 11.3333 14.6673H4.66667C4.31305 14.6673 3.97391 14.5268 3.72386 14.2768C3.47381 14.0267 3.33334 13.6876 3.33334 13.334V4.00065H12.6667Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.33334 7.33398V11.334" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66666 7.33398V11.334" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </td>
        </tr>`;
        $('#selectedVehiculoSideResume ').append(trResume);
    })

    tippy('.isPicked', {
        content: '<strong></strong>'
    });

    setEgresos();

}

// capture current vehicle value and use it on case to invalid user input

let lastVehicleValue = 0;
$(document).on('click', '.vehiclePrice', function () {
    lastVehicleValue = $(this).val();
    console.log(lastVehicleValue);
})

$(document).on('change', '.vehiclePrice', function () {

    const valor = $(this).val();
    if (isNumeric(valor)) {

    } else {
        $(this).val(lastVehicleValue);
        Swal.fire({
            'title': 'Ups!',
            'text': 'Ingresa un precio valido',
            'icon': 'warning'
        })
        return
    }

    if (valor < 0) {
        Swal.fire({
            'title': 'Ups!',
            'text': 'Ingresa un precio valido',
            'icon': 'warning'
        })
    }
})

function removeVehicle_old(element) {

    if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("13")) {
        let li = $(element).closest('li');
        let idVehiculoDelete = li.attr('class');
        let patente = li.text();
        element.previousElementSibling.style.display = "block";
        element.style.display = "none";
        li.remove();
        $('#sortable1').append(li)
        removeVehicleStorage(idVehiculoDelete, patente)
        console.log(GetVehicleStorage())

        RemoveVehicleFromResume(idVehiculoDelete);

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

function RemoveVehicleFromResume(id) {

    let tdPersonal = $('#vehiculosProject tbody').find('.idVehicleResume')
    tdPersonal.each((index, td) => {
        if ($(td).text() === id) {
            $(td).closest('tr').remove();
        }
    })
}

function AppendVehiculoToResume(tipo) {

    let lStorage = GetVehicleStorage();
    let arrayLength = lStorage.length;
    lStorage = lStorage[arrayLength - 1];
    console.log(lStorage);
    if (tipo === "add") {
        let newTr = `<tr>
                        <td class="idVehicleResume" style="display:none">${lStorage.idVehiculo}</td>
                        <td class="tbodyHeader">${lStorage.patente}</td>
                        <td></td>
                        <td></td>
                    </tr>`;
        for (let i = arrayLength - 1; i === arrayLength - 1; i++) {
            $("#vehiculosProject tr:last").before(newTr);
        }
    }
}

function AppendVehiculoTableResumeArray(arrayVehiculos) {
    for (let i = 0; i < arrayVehiculos.length; i++) {

        let newTr = `<tr>
            <td class="idVehicleResume" style="display:none">${arrayVehiculos[i].idVehiculo}</td>
            <td class="tbodyHeader">${arrayVehiculos[i].patente}</td>
            <td></td>
            <td></td>
        </tr>`;
        $("#vehiculosProject tr:last").before(newTr);
    }
    $('#totalCostProject').text(CLPFormatter(parseInt(GetTotalCosts())));
}


$(document).on('click', '.addVehicleToResume', function () {
    const vehiculo_id = $(this).closest('tr').attr('vehiculo_id');
    addVehicle(vehiculo_id);
})

function addVehicle(vehiculo_id){

    const vehiculo_exists = allVehicles.find((vehiculo) => {
        return vehiculo.id == vehiculo_id;
    });

    if (!vehiculo_exists){
        // Swal.fire({
        //     'icon': "error",
        //     'title': "Ups!",
        //     'text': "Ha ocurrido un error al asignar vehículos",
        //     'showConfirmButton': false,
        //     // 'timer': 2000
        // });
        return;
    };
    const vehiculoIsSelected = selectedVehicles.find((selected) => {
        return selected.id === vehiculo_id;
    });

    if (vehiculoIsSelected) {
        return;
    };

    vehiculo_exists.isSelected = true;
    selectedVehicles.push(vehiculo_exists);
    printSelectedVehicles();

    console.log('selectedVehicles',selectedVehicles)
}

let lastCostoPorViaje = 0;
$(document).on('click', '.tripValueInput', function () {
    lastCostoPorViaje = ClpUnformatter($(this).val());

    $(this).val("")
})

$(document).on('blur', '.tripValueInput', function () {

    const value = $(this).val();
    const vehiculo_id = $(this).closest('tr').attr('vehiculo_id');
    if (value === "" || value === undefined || value === null) {
        $(this).val(CLPFormatter(lastCostoPorViaje))
        return;
    }

    if (!isNumeric(value)) {
        Swal.fire({
            icon: 'warning',
            title: 'Ups!',
            text: 'Ingrese un número',
            showConfirmButton: false,
            timer: 2000
        });
        $(this).val(CLPFormatter(lastCostoPorViaje))
        return
    }

    const vehiculoExiste = allVehicles.find((vehiculo) => {
        return vehiculo.id === vehiculo_id;
    })

    if (!vehiculoExiste) {
        Swal.fire({
            icon: 'error',
            title: 'Ups!',
            text: 'Ha ocurrido un error',
            showConfirmButton: false,
            timer: 2000
        });
        $(this).val(CLPFormatter(lastCostoPorViaje))
        return;
    }


    vehiculoExiste.tripValue = parseInt(value);

    printSelectedVehicles();



})

let cantidadViajes = 0;
$(document).on('click', '.cantidadViajesInput', function () {
    cantidadViajes = $(this).val();
    $(this).val("")
})

$(document).on('blur', '.cantidadViajesInput', function () {
    
    const value = $(this).val();
    const vehiculo_id = $(this).closest('tr').attr('vehiculo_id');
    if (value === "" || value === undefined || value === null) {
        $(this).val(cantidadViajes)
        return;
    }

    if (!isNumeric(value)) {
        Swal.fire({
            icon: 'warning',
            title: 'Ups!',
            text: 'Ingrese un número',
            showConfirmButton: false,
            timer: 2000
        });
        $(this).val(cantidadViajes)
        return
    }

    const vehiculoExiste = allVehicles.find((vehiculo) => {
        return vehiculo.id === vehiculo_id;
    })

    if (!vehiculoExiste) {
        Swal.fire({
            icon: 'error',
            title: 'Ups!',
            text: 'Ha ocurrido un error',
            showConfirmButton: false,
            timer: 2000
        });
        $(this).val(cantidadViajes)
        return;
    }

    const SELECTED_VEHICLE = selectedVehicles.find((selVehicle)=>{return selVehicle.id === vehiculo_id})

    SELECTED_VEHICLE.cantidadViajes = parseInt(value)
    // vehiculoExiste.cantidadViajes = parseInt(value);
    printSelectedVehicles();
})

$(document).on('click', '.removeVehiculoToAssigment', function () {

    const vehiculo_id = $(this).closest('tr').attr('vehiculo_id');
    const vehiculo_exists = allVehicles.find((vehiculo) => {
        return vehiculo.id === vehiculo_id;
    });

    if (!vehiculo_exists) {
        Swal.fire({
            'icon': "error",
            'title': "Ups!",
            'text': "Ha ocurrido un error",
            'showConfirmButton': false,
            'timer': 2000
        });
        return;
    };
    const vehiculoIsSelected = selectedVehicles.find((selected) => {
        return selected.id === vehiculo_id;
    });

    if (!vehiculoIsSelected) {
        return;
    };

    vehiculo_exists.isSelected = false;
    // console.log("INDEX OF",selectedVehicles.indexOf(vehiculoIsSelected))
    selectedVehicles.splice(selectedVehicles.indexOf(vehiculoIsSelected), 1);
    printSelectedVehicles();

})