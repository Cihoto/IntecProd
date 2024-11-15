

// OBJECT CONTAINS INFO ABOUT START AND FINISH DATE ON EVENT 
// TO SHOW PERSONAL, VEHICLES AND PERSONAL ON LIVE AVAILABILITY 
// ON TABLES
let projectDates = {
  'start_date': '',
  'finish_date': '',
  'total_days': '',
  'selectDates': false,
  'project_id' : ""
}



// MY EVENT PAGE ELEMENTS
const PERSONAL_FILTER = document.getElementById('especialidadPersonalAssigmentFilter');
const VEHICLE_FILTER_OPT = document.getElementById('vehicleTypeVlist');




// END MY EVENT PAGE ELEMENTS

//BOTON DE TEST
$('#verarray').on('click', async function(){
  // localStorage.clear();
  // console.log("asdjhasd,jahkdsjhasd");
  // $('#arriendosModal').modal('show');
  // console.log(selectedPackages);
  // setEgresos();
  // setIngresos();                                                             
})
//FIN BOTON TEST
$('#inputProjectName').on('change', function() {
  $('#projectNameResume').text($(this).val());
})

$('#fechaInicio').on('change', async function() {

  const differenceBtw = getDiffBtwDays();
  if (differenceBtw < 0) {

    // $(this).val();
    $('#fechaTermino').val($(this).val());
    // Swal.fire('Ups!', 'La fecha de inicio debe ser mayor a la fecha de termino', 'warning');
    // $(this).val(currentFinishDate)
    // return;
  }

  if ($('#fechaTermino').val() === "") {
    $('#fechaTermino').val($(this).val());
    $('#fechaTermino').prop('disabled', false);
    projectDates.finish_date = $(this).val();
  }

  $('#fechaProjectResume').text($(this).val())
  projectDates.start_date = $(this).val();
  const TotalDays = setTotalDays();
  if (!TotalDays) {
    alert("Seleccione un rango de fecha");
    return;
  }
  projectDates.selectDates = true;
  await setTakenProdsByRangeDate();
  setAllProducts_DiscountTakenProd();
  printAllProductsOnTable();
  setCategoriesAndSubCategories();
  printAllSelectedProducts();
  setIngresos();
  
  await setTakenPersonalByRangeDate();
  console.log("event_data",event_data.event_id)
  setAllPersonal_DiscountTakenPersonal();
  printAllSelectedPersonal();

})


let currentFinishDate = "";
$('#fechaTermino').on('click', function() {
  currentFinishDate = $(this).val();
})

$('#fechaTermino').on('change', async function() {
  const differenceBtw = getDiffBtwDays();
  if (differenceBtw < 0) {

    $('#fechaInicio').val($(this).val());

    // Swal.fire('Ups!', 'La fecha de inicio debe ser mayor a la fecha de termino', 'warning');
    // $(this).val(currentFinishDate)
    // return;
  }
  projectDates.finish_date = $(this).val();
  const TotalDays = setTotalDays();
  if (!TotalDays) {
    alert("Seleccione un rango de fecha");
    return;
  }
  await setTakenProdsByRangeDate();
  setAllProducts_DiscountTakenProd();
  printAllProductsOnTable();
  setCategoriesAndSubCategories();
  printAllSelectedProducts();
  setIngresos();
  $('#fechaProjectResume').text($('#fechaProjectResume').text() + '  /  ' + $(this).val());

  await setTakenPersonalByRangeDate();
  setAllPersonal_DiscountTakenPersonal();
  printAllSelectedPersonal();
})

$('#commentProjectArea').on('change', function() {
  $('.comentariosProjectResume').text($(this).val())
})
$('#dirInput').on('change', function() {
  $('#lugarProjectResume').text($(this).val())
})


function getDiffBtwDays() {
  const date_1 = new Date($('#fechaInicio').val());
  const date_2 = new Date($('#fechaTermino').val());
  const differenceTime = date_2.getTime() - date_1.getTime();
  const differenceDays = Math.ceil(differenceTime / (1000 * 60 * 60 * 24));

  return differenceDays;
}

function setTotalDays() {

  const date_1 = new Date($('#fechaInicio').val());
  const date_2 = new Date($('#fechaTermino').val());

  const differenceTime = Math.abs(date_1.getTime() - date_2.getTime());
  const differenceDays = Math.ceil(differenceTime / (1000 * 60 * 60 * 24));

  if (differenceDays === 0) {
    projectDates.total_days = 1;
    return true
  } else {
    projectDates.total_days = differenceDays;
    return true
  }
  return false;
}

async function getAssignedElements() {

  console.table(listProductArray)

  console.table(allMyTakenPoducts)
  const fecha_inicial = $('#fechaInicio').val();
  const fecha_termino = $('#fechaTermino').val();


  if (fecha_inicial === "" || fecha_termino === "") {
    return false;
  }

  // return to stock or availability last taken prods on selected date range
  if (allMyTakenPoducts.length > 0) {
    returnLastTakenProds();
  }

  // set dates to get taken prods and substract from productList
  const dates = {
    'fecha_inicio': projectDates.start_date,
    'fecha_termino': projectDates.finish_date
  }

  const takenProds = await GetUnavailableProductsByDate(dates, EMPRESA_ID);

  allMyTakenPoducts = takenProds.data;
  console.table("allMyTakenPoducts", allMyTakenPoducts);

  allMyTakenPoducts.forEach((takenProd) => {
    const listProdExists = listProductArray.find((listedProd) => {
      if (listedProd.id === takenProd) {

      }
    })
  });
}

  

  async function getTakenProducts() {

    const fecha_inicial = $('#fechaInicio').val();
    const fecha_termino = $('#fechaTermino').val();

    if (fecha_inicial === "" || fecha_termino === "") {
      Swal.fire("Ups!", "Debes seleccionar un rango de fechas", "warning");
      return
    }

    const dates = {
      'fecha_inicio': fecha_inicial,
      'fecha_termino': fecha_termino
    }
    const takenProds = await GetUnavailableProductsByDate(dates, EMPRESA_ID)
  }

  function returnLastTakenProds() {
    // console.table(allMyTakenPoducts);
    allMyTakenPoducts.forEach((takenProd) => {
      const listedProdExists = listProductArray.find((listedProd) => {
        if (listedProd.id === takenProd.product_id) {
          return true
        }
      })

      if (listedProdExists) {
        listedProdExists.quantityToAdd = parseInt(listedProdExist.disponibles) + parseInt(takenProd.cantidad);
      }
    })
  }
let prodReady = false;
let perReady = false;
let vReady = false;
let checkIfDemoIsNeeded = false;

function checkIfDemoIsExecutable(){
  if(prodReady && perReady && vReady){
    checkIfDemoIsNeeded = true
  }
} 

  // ADD PACKAGE TO PROJECT ON PLUS ICON ON PACKAGE LIST
$(document).ready(async function(){
  await GetAllPersonal(EMPRESA_ID);
  await FillVehiculos(EMPRESA_ID);
  await fillProductsTable();
  GetEspecialidadByBussiness(EMPRESA_ID);
  appendPersonalOptions();
  // FillAllProducts();
  FillStandardPackages();
  $('#tableResume').DataTable({})
  //fillvehiculos
  appendVehiclesFilters();
  // Fill Clientes
  FillClientes(EMPRESA_ID);
  //FILL DIRECCIONES
  FillDirecciones();

  //FILL PRODUCTOS
  // FillProductos(EMPRESA_ID);
  //FILL PERSONAL
  // FillPersonal(EMPRESA_ID)
  // CALL ALL PERSONAL
  // CLEAR LOCALSTORGE
  localStorage.clear();
  // FILL REGIONES
  FillRegiones(EMPRESA_ID);


  activateDemoFromEvents();

  getAllMyProviders(EMPRESA_ID);

  $(document).on('click', '.logoRemove', function() {
    let productId = $(this).closest('.detailsProduct-box').find('.itemId').text();
    removeProduct(productId);
    $(this).closest('.detailsProduct-box').remove()
    $('#resumeBody').find(`.idProd${productId}`).remove();
  });




  // SHOW BILLING DATA 
  $('#clientHasFacturacion').on('click', function() {
    if ($(this).is(':checked')) {

      $('#clientFactData').addClass('active');
    } else {

      $('#clientFactData').removeClass('active');
    }
  })
    // VALIDAR FORM AGREGAR DIRECCION
$('#direccionAddForm').validate({
  rules: {
    txtDir: {
      required: true
    },
    txtNumDir: {
      required: true
    },
    regionSelect: {
      required: true
    },
    comunaSelect: {
      required: true
    }
  },
  messages: {
    txtDir: {
      required: "Debe ingresar un valor"
    },
    txtNumDir: {
      required: "Debe ingresar un valor"
    },
    regionSelect: {
      required: "Debe ingresar un valor"
    },
    comunaSelect: {
      required: "Debe ingresar un valor"
    }
  },
  submitHandler: function() {

    event.preventDefault();
    // localStorage.clear();
    //CREAR LOCALE STORAGE TO DIRECCIONES
    $("#direccionModal ").modal('hide');
    //DATOS DE DIRECCION
    let dir = $('#txtDir').val();
    let numDir = $('#txtNumDir').val();
    let depto = $('#txtDepto').val();
    let region = $('#regionSelect').val();
    let comuna = $('#comunaSelect').val();
    let regionInput = $('#regionSelect option:selected').text();
    let comunaInput = $('#comunaSelect option:selected').text();
    let postal_code = $('#txtcodigo_postal').val();
    let idDireccion = $('#idDireccionModal').text();
    $('#direccionInput').val(`${dir} ${numDir} ${depto}, ${comunaInput}, ${regionInput}`);
    $('#lugarProjectResume').text(`${dir} ${numDir} ${depto}, ${comunaInput}, ${regionInput}`);

    if (localStorage.getItem("direccion") === null) {
      localStorage.setItem("direccion", JSON.stringify([{
        dir,
        numDir,
        depto,
        region,
        comuna,
        regionInput,
        comunaInput,
        postal_code,
        idDireccion
      }]))
    } else {
      let allDirs = JSON.parse(localStorage.getItem("direccion"))
      allDirs.push({
        dir,
        numDir,
        depto,
        region,
        comuna,
        regionInput,
        comunaInput,
        postal_code,
        idDireccion
      });
      localStorage.setItem("direccion", JSON.stringify(allDirs));
    }

    // localStorage.setItem("direccion",JSON.stringify())
  }
})

$('#arriendoForm').validate({
  rules: {
    nombreArriendo: {
      required: true
    },
    valorArriendo: {
      required: true
    },
    txtNombre: {
      required: true
    },
    txtApellidos: {
      required: true
    },
    txtRut: {
      required: true
    },
    txtCorreo: {
      required: true
    },
    txtTelefono: {
      required: true
    },
    txtRut: {
      required: true
    },
    txtRazonSocial: {
      required: true
    },
    txtNombreFantasia: {
      required: true
    },
    txtDireccionDatosFacturacion: {
      required: true
    },
    txtCorreoDatosFacturacion: {
      required: true
    }
  },
  messages: {
    nombreArriendo: {
      required: "Ingrese un valor"
    },
    valorArriendo: {
      required: "Ingrese un valor"
    },
    txtNombre: {
      required: "Ingrese un valor"
    },
    txtApellidos: {
      required: "Ingrese un valor"
    },
    txtRut: {
      required: "Ingrese un valor"
    },
    txtCorreo: {
      required: "Ingrese un valor"
    },
    txtTelefono: {
      required: "Ingrese un valor"
    },
    txtRut: {
      required: "Ingrese un valor"
    },
    txtRazonSocial: {
      required: "Ingrese un valor"
    },
    txtNombreFantasia: {
      required: "Ingrese un valor"
    },
    txtDireccionDatosFacturacion: {
      required: "Ingrese un valor"
    },
    txtCorreoDatosFacturacion: {
      required: "Ingrese un valor"
    }
  },
  submitHandler: function() {
    event.preventDefault();
    const form = $('#arriendoForm').serializeArray();

    let request = convertFormToJSON(form);
    console.table(request);

    $.ajax({
      type: "POST",
      url: 'ws/Arriendos/arriendos.php',
      data: JSON.stringify({
        action: 'SetNewRent',
        request: request,
        empresa_id: EMPRESA_ID
      }),
      dataType: 'json',
      success: function(data) {

        // console.log("REQUEST ENVIADO", data);

      },
      error: function(response) {
        // console.log(response.responseText);
      }
    })
  }
})

// VALIDAR FORM CLIENTE Y DATOS DE FACTURACION
$('#clienteForm').validate({
  rules: {
    txtNombreCliente: {
      required: true
    },
    txtApellidos: {
      required: true
    },
    txtRut: {
      required: false
    },
    txtCorreo: {
      required: true
    },
    txtTelefono: {
      required: true
    },
    txtRut: {
      required: false
    },
    txtRazonSocial: {
      required: false
    },
    txtNombreFantasia: {
      required: false
    },
    txtDireccionDatosFacturacion: {
      required: false
    },
    txtCorreoDatosFacturacion: {
      required: false
    }
  },
  messages: {
    txtNombreCliente: {
      required: "Ingrese un valor"
    },
    txtApellidos: {
      required: "Ingrese un valor"
    },
    txtRut: {
      required: "Ingrese un valor"
    },
    txtCorreo: {
      required: "Ingrese un valor"
    },
    txtTelefono: {
      required: "Ingrese un valor"
    },
    txtRut: {
      required: "Ingrese un valor"
    },
    txtRazonSocial: {
      required: "Ingrese un valor"
    },
    txtNombreFantasia: {
      required: "Ingrese un valor"
    },
    txtDireccionDatosFacturacion: {
      required: "Ingrese un valor"
    },
    txtCorreoDatosFacturacion: {
      required: "Ingrese un valor"
    }
  },
  submitHandler: function() {
    event.preventDefault();
    //DATOS DE CLIENTE
    let nombreCliente = $('#inputNombreClienteForm').val();
    let apellidos = $('#inputApellidos').val();
    let rutCliente = $('#inputRutCliente').val();
    let correo = $('#inputCorreo').val();
    let telefono = $('#inputTelefono').val();
    let rut = $('#inputRut').val();
    let razonSocial = $('#inputRazonSocial').val();
    let nombreFantasia = $('#inputNombreFantasia').val();
    let direccionDatosFacturacion = $('#inputDireccionDatosFacturacion').val();
    let correoDatosFacturacion = $('#inputCorreoDatosFacturacion').val();
    $('#inputNombreCliente').val(`${nombreCliente} ${apellidos}`);
    $("#clienteProjectResume").text(`${nombreCliente} ${apellidos}`);
    $("#clienteModal ").modal('hide');
  }
})
});


// APPEND ALL PERSONAL SELECT FILTER OPTIONS
function appendPersonalOptions(){
  _allEspecialidades.forEach((esp)=>{

      let option = document.createElement('option')
      option.value = esp.especialidad;
      option.text = esp.especialidad;
      PERSONAL_FILTER.append(option)
  });

}

function filterPersonalTable(esp){

  let filtered_personal = [];
  if(esp === 'all'){
    filtered_personal = allPersonal;
  }else{

    filtered_personal = allPersonal.filter((personal)=>{
      return personal.especialidad === esp
    });

  }

  $('#personalResumeAssigment tbody tr').remove();

  filtered_personal.forEach((personal)=>{

    if(personal.isDelete == 1){
      return;
    }
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
  })

}

// APPEND VEHICLES FILTER OPTIONS

function appendVehiclesFilters(){
  _types.forEach((vType)=>{

    console.log('vType',vType);

    let option = document.createElement('option')
    option.value = vType.tipo;
    option.text = vType.tipo;
    VEHICLE_FILTER_OPT.append(option)
  });
}


function filterVehiclesTable(vType){
  let filteredVehicles = [];
  if(esp === 'all'){
    filteredVehicles = allVehicles;
  }else{

    filteredVehicles = allVehicles.filter((vehicle)=>{
      return vehicle.tipo === vType
    });

  }

  $('#allVehiclesTable tbody tr').remove();

  filteredVehicles.forEach((vehiculo) => {

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

    let owner = "Propio";
    if (vehiculo.ownCar === '0') {
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
}
//OPEN MODAL DIRECCION
$('#direccionInput').on('click', function() {
  $('#direccionModal').modal('show');
})

//OPEN MODAL CLIENTE
$('#inputNombreCliente').on('click', function() {
  // $('#clienteModal').modal('show');
  $('#clientSideMenu').addClass('active');
  
  FillClientes(EMPRESA_ID);
  selectClientForEvent()
})



// GUARDAR CLIENTE EN INPUT CLIENTE
$('#addCliente').on('click', function() {})
//GATILLAR EVENTO CLICK EN BOTON SUBMIT DE FORM PARA CREACION DEL PROYECTO
$('#submitProject').on('click', function() {
  $('#hiddenAddProject').trigger('click')
})

$('#tableResumeView').on('click', function() {
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#resumen').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#resumen').removeClass('fade').addClass('active show');
  }
})

$('#getAvailableProducts').on('click', function (){
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active');
    $('#vehicle').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active');
    $('#vehicle').removeClass('fade');
    $('#vehicle').addClass('active show');
  }
})

$('#tabVenta').on('click', function(){
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#venta').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#venta').removeClass('fade').addClass('active show');
  }
})

$('#getAvailablePersonal').on('click', function() {
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#personal').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#personal').removeClass('fade').addClass('active show');
  }
})

$('#getAvailableVehicles').on('click', function() {
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#vehicle').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#vehicle').removeClass('fade').addClass('active show');
  }
});

$('#tabCostos').on('click', function() {
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#costo').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#costo').removeClass('fade').addClass('active show');
  }
});

$('#openInventory').on('click',function (){
    $('#products-tab')[0].click();
})

$('#openPersonal').on('click',function (){
    $('#personal-tab')[0].click();
})

$('#openVehiculos').on('click',function (){
    $('#vehicle-tab')[0].click();
})

$('#openVenta').on('click',function (){
    $('#venta-tab')[0].click();
})

$('#openCostos').on('click',function (){
    $('#costo-tab')[0].click();
})

$('#openResumen').on('click',function (){
    $('#resumen-tab')[0].click();
})


// VALIDAR DATOS Y CREAR PROYECTO
    $('#projectForm').validate({
      rules: {
      },
      messages:{ 
      },
      submitHandler: function(event) {
        event.preventDefault()}
      })

  //       const SELECTED = $('#ownerSelect').find(':selected');

  //       //DATOS PROYECTO
  //       let projectName = $('#inputProjectName').val();
  //       let fechaInicio = $('#fechaInicio').val();
  //       let fechaTermino = $('#fechaTermino').val();
  //       let comentarios = $('#commentProjectArea').val();   
  //       const OWNER = $(SELECTED).val()
  //       const STATUS_ID = $('#status-button').attr('status_id');

  //       //CREAR CLIENTE PARA PROYECTO
  //       let idCliente;
  //       let nombre = $('#txtNombreCliente').val()


  //       let nombreCliente = $('#inputNombreClienteForm').val()
  //       let apellidos = $('#inputApellidos').val()
  //       let rutCliente = $('#inputRutCliente').val()
  //       let correoCliente = $('#inputCorreo').val()
  //       let telefono = $('#inputTelefono').val()
  //       let rut = $('#inputRut').val()
  //       let razonSocial = $('#inputRazonSocial').val()
  //       let nombreFantasia = $('#inputNombreFantasia').val()
  //       let direccionDatosFacturacion = $('#inputDireccionDatosFacturacion').val()
  //       let correoDatosFacturacion = $('#inputCorreoDatosFacturacion').val()
  //       let idClienteReq = $('#clienteSelect').val();

  //       let requestCliente = {
  //         empresaId: EMPRESA_ID,
  //         nombreCliente: nombreCliente,
  //         apellidos: apellidos,
  //         rutCliente: rutCliente,
  //         correoCliente: correoCliente,
  //         telefono: telefono,
  //         rut: rut,
  //         razonSocial: razonSocial,
  //         nombreFantasia: nombreFantasia,
  //         direccionDatosFacturacion: direccionDatosFacturacion,
  //         correoDatosFacturacion: correoDatosFacturacion
  //       }

  //       if (idClienteReq === "" || idClienteReq === null || idClienteReq === undefined) {

  //       } else {
  //         requestCliente["idCliente"] = idClienteReq
  //         // requestCliente.push({
  //         //   "idCliente": idClienteReq
  //         // })
  //       }

  //       //DATOS DE DIRECCION
  //       let dir = $('#txtDir').val()
  //       let numDir = $('#txtNumDir').val()
  //       let depto = $('#txtDepto').val()
  //       let region = $('#regionSelect').val()
  //       let comuna = $('#comunaSelect').val()
  //       let regionInput = $('#regionSelect option:selected').text()
  //       let comunaInput = $('#comunaSelect option:selected').text()
  //       let postal_code = $('#txtcodigo_postal').val()
  //       let id_direccion;
  //       let id_lugar;
  //       let requestDir = [{
  //         direccion: dir,
  //         numero: numDir,
  //         depto: depto,
  //         region: region,
  //         codigo_postal: postal_code,
  //         comuna: comuna
  //       }]
  //       if ($('#direccionInput').val() !== "") {
  //         const resultDireccion = await Promise.all([addDir(requestDir)]);
  //         id_direccion = resultDireccion[0].id_direccion;
  //         let lugarRequest = [{
  //           lugar: dir,
  //           direccion_id: id_direccion
  //         }]
  //         const responseLugar = await Promise.all([addLugar(lugarRequest)]);
  //         id_lugar = responseLugar[0].id_lugar;
  //       }

  //       if ($('#inputNombreCliente').val() !== "") {
  //         console.table(requestCliente);
  //         const resultCliente = await Promise.all([addCliente(requestCliente)]);
  //         idCliente = resultCliente[0].idCliente

  //         // DATOS PARA LA CRECION BASE DE UN PROYECTO
  //         let direccion = $('#direccionInput').val();
  //         let nombreCliente = $('#inputNombreCliente').val();
  //       }

  //       //PUT CLIENT ID VALUE ON "" WHEN INPUT IS EMPTY ON PROJECT REQUEST
  //       if ($('#inputNombreCliente').val() === "") {
  //         idCliente = "";
  //       }

  //       //PUT PLACE ID VALUE ON "" WHEN INPUT IS EMPTY ON PROJECT REQUEST
  //       if ($('#direccionInput').val() === "") {
  //         id_direccion = "";
  //         id_lugar = "";
  //       }

  //       let requestProject = {
  //         'nombre_proyecto': projectName,
  //         'lugar_id': id_lugar,
  //         'fecha_inicio': fechaInicio,
  //         'fecha_termino': fechaTermino,
  //         'cliente_id': idCliente,
  //         'comentarios': comentarios,
  //         'empresa_id': EMPRESA_ID,
  //         'owner' : OWNER,
  //         'status_id' : STATUS_ID
  //       }
  //       const responseProject = await Promise.all([createProject(requestProject)])
  //       idProject = responseProject[0].id_project;



  //       const requestVehicle = selectedVehicles.map(vehicle => {
  //         return {
  //           'idProject' : idProject,
  //           'idVehicle' : vehicle.id,
  //           'trip_value' : vehicle.tripValue,
  //           'trip_count' : vehicle.cantidadViajes
  //         };
  //       })

  //       const requestPersonal = allSelectedPersonal.map((personal) => {
  //         return {
  //           'idProject': idProject,
  //           'idPersonal': personal.id,
  //           'cost': personal.neto,
  //           'worked_hours' : personal.horasTrabajadas
  //         };
  //       })

  //       // ASIGNACION DE LOS PAQUETES DE PRODUCTOS SELECCIONADOS
  //       if (selectedPackages.length > 0) {
  //         const arrayPackage = selectedPackages.map((package) => {
  //           return {
  //             "proyecto_id": idProject,
  //             "paquete_id": package.id
  //           }
  //         })
  //         const packagesAssigment = await assignStandardPackageToProject(arrayPackage);
  //       }

  //       // FIN ASIGNACION PAQUETES STANDARD
  //       let arrayProducts = []
  //       _selectedProducts.forEach((product) => {
  //         arrayProducts.push({
  //           'idProject': idProject,
  //           'idProduct': product.id,
  //           'price': product.precio_arriendo,
  //           'quantity': product.quantityToAdd
  //         })
  //       });


  //       const responseAssignPersonal = await Promise.all([assignvehicleToProject(requestVehicle), assignPersonal(requestPersonal), assignProduct(arrayProducts)])
  //       response = responseAssignPersonal

  //       let arrayViaticos = $('#projectViatico > tbody tr .tbodyHeader');
  //       if (arrayViaticos.length > 0) {
  //         $('#projectViatico > tbody tr .tbodyHeader').each((key, el) => {
  //           SetViatico(idProject, $(el).closest('tr').find('.totalViaticoInput').val(), $(el).closest('tr').find('.inputViaticoName').val());
  //         })

  //         let arrayViaticosRequest = GetProjectViaticos();
  //         if (arrayViaticosRequest !== false) {
  //           $.ajax({
  //             type: "POST",
  //             url: 'ws/personal/Personal.php',
  //             data: JSON.stringify({
  //               action: 'setviatico',
  //               request: arrayViaticosRequest
  //             }),
  //             dataType: 'json',
  //             success: function(data) {

  //               // console.log("RESPONSE AGIGNACION VIATICOS", data);

  //             },
  //             error: function(response) {
  //               // console.log(response.responseText);
  //             }
  //           })
  //         }
  //       }

  //       // 'detalle': $(element).find('.rentDetail').val(),
  //       // 'proveedor_id': $(element).find('.allProvidersSelect').val(),
  //       // 'valor': parseInt(ClpUnformatter($(element).find('.subArriendoValue').val()))

  //       const subRentRequest = _subRentsToAssign.map((subRent)=>{
  //           return {
  //               'proyecto_id': idProject,
  //               'detalle':subRent.detalle,
  //               'proveedor_id':subRent.proveedor_id,
  //               'valor':subRent.valor
  //           }
  //       })

  //       let arrayArriendos = $('#projectSubArriendos > tbody tr .tbodyHeader');
  //       let arrayRequestRent = [];
  //       if (arrayArriendos.length > 0) {
  //         $('#projectSubArriendos > tbody tr .tbodyHeader').each((key, el) => {
  //           arrayRequestRent.push({
  //             proyecto_id: idProject,
  //             arriendo_id: $(el).closest('tr').attr('id'),
  //             costo: $(el).closest('tr').find('.inputSubValue').val()
  //           })
  //         })
  //         console.table()
  //         let responseRents = await AssignRents(arrayRequestRent);
  //       } else {
  //         console.log("NO RENT TO ASSIGN");
  //       }

  //       // _selectedOthersProducts.push({
  //       //     'detalle': $(element).find('.nameOthers').val(),
  //       //     'cantidad': parseInt(ClpUnformatter($(element).find('.cantidadOthers').val())),
  //       //     'total': parseInt(ClpUnformatter($(element).find('.totalOthers').val()))
  //       //   });
  //       const OTHERS_PRODUCTS =  _selectedOthersProducts.map((other)=>{
  //           return{
  //               'detalle': other.detalle,
  //               'cantidad': other.cantidad,
  //               'total': other.total
  //           }
  //       })

  //       const RESPONSE_OTHERS_PRODUCTS_ASSIGMENT = await assignOtherProdsToProject(OTHERS_PRODUCTS, idProject);

  //       console.log("RESPONSE_OTHERS_PRODUCTS_ASSIGMENT",RESPONSE_OTHERS_PRODUCTS_ASSIGMENT);

  //     }
  //   })
  // })