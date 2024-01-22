let event_data = {
  address_id: "",
  client_id: "",
  event_id: ""
}

let requestProject = {
  'nombre_proyecto': "",
  'lugar_id': "",
  'fecha_inicio': "",
  'fecha_termino': "",
  'cliente_id': "",
  'comentarios': "",
  'empresa_id': "",
  'owner': "",
  'status_id': ""
}



// $('#createProject').on('click', function (){
//   const NOMBRE_EVENTO = $('#inputProjectName').val();
//   if (NOMBRE_EVENTO) {
//     $('#eventNameMessage').show();
//     return
//   }
// })

$('#inputProjectName').on('click', function () {
  $('#eventNameMessage').css('visibility', 'hidden');
})

async function SaveOrUpdateEvent() {


  clearBottomBar();
  initBottomBar();
  $('#footerInformation').addClass('active');
  preparingDocumentBottomBar("Guardando cambios");

  // SET event_data.event_id = projectDates.project_id

  if (projectDates.project_id !== "") {
    event_data.event_id = projectDates.project_id;
  }

  requestProject = {
    'nombre_proyecto': $('#inputProjectName').val(),
    'lugar_id': "",
    'fecha_inicio': $('#fechaInicio').val(),
    'fecha_termino': $('#fechaTermino').val(),
    'cliente_id': event_data.client_id,
    'comentarios': $('#commentProjectArea').val(),
    'empresa_id': EMPRESA_ID,
    'owner': $('#ownerSelect').val(),
    'status_id': $('#status-button').attr('status_id'),
    'event_type_id': $('#event_type').val()
  }

  console.log("requestProject", requestProject);

  if (requestProject.nombre_proyecto === "") {
    $('#details-tab')[0].click();
    $('#eventNameMessage').css('visibility', 'visible');
    $('#inputProjectName').focus();
    return false
  }

  // create or update project

  console.log("projectDates", projectDates);

  if (projectDates.project_id === "") {
    const RESPONSE_CREATE_EVENT = await createNewEvent(requestProject);
    if (RESPONSE_CREATE_EVENT.id_project) {
      event_data.event_id = RESPONSE_CREATE_EVENT.id_project;
      projectDates.project_id = RESPONSE_CREATE_EVENT.id_project;
    }
  } else {
    const RESPONSE_UPDATE_EVENT = await updateEvent(requestProject, event_data.event_id, EMPRESA_ID);
  }

  // CREATE AND ASSIGN EVENT ADDRESS 
  if ($('#dirInput').val() !== "") {
    const REQUEST_ASSIGN_ADDRESS = {
      'address_id': $('#dirInput').val(),
      'empresa_id': EMPRESA_ID,
      'event_id': event_data.event_id
    }

    await insertAddressAndAssignToProject($('#dirInput').val(), EMPRESA_ID, event_data.event_id);
  } else {
    await removeAddressFromEvent(event_data.event_id, EMPRESA_ID);
  }

  // CREATE OR REMOVE EVENT SCHEDULES
  if (_all_my_selected_schedules.length > 0) {
    await insertAndAssignSchedulesToEvent(event_data.event_id, EMPRESA_ID, _all_my_selected_schedules)
  } else {
    await removeAllSchedulesFromEvent(event_data.event_id, EMPRESA_ID)
  }

  //CREATE AND ASSIGN DOCUMENTS TO EVENT
  await saveSelectedFilesInServer();
  await assignFilesToEvent(_allmyUploadedFiles, event_data.event_id, EMPRESA_ID, PERSONAL_IDS);


  // SAVE ALL SELECTED PRODUCTS
  let arrayProducts = []
  _selectedProducts.forEach((product) => {
    arrayProducts.push({
      'idProject': event_data.event_id,
      'idProduct': product.id,
      'price': product.precio_arriendo,
      'quantity': product.quantityToAdd
    })
  });
  await assignProduct(arrayProducts);
  // SAVE OTHER PRODUCTS
  const requestOtherProducts = {
    'event_id' : event_data.event_id,
    'empresa_id' : EMPRESA_ID,
    'request' : _selectedOthersProducts
  }
  await assignOtherProdsToEvent(requestOtherProducts);

  // SAVE ALL SELECTED PACKAGES
  console.log("_selectedPackages",_selectedPackages);
  if (_selectedPackages.length > 0) {
    const arrayPackage = _selectedPackages.map((package) => {
      return {
        "proyecto_id": event_data.event_id,
        "package_id": package.package_id
      }
    });
    const packagesAssigment = await assignStandardPackageToProject(arrayPackage);
    console.log("packagesAssigment",packagesAssigment);
  }
  
  // SAVE ALL SELECTED PERSONAL
  const requestPersonal = allSelectedPersonal.map((personal) => {
    return {
      'idProject': event_data.event_id,
      'idPersonal': personal.id,
      'cost': personal.neto,
      'worked_hours': personal.horasTrabajadas
    };
  });
  await assignPersonal(requestPersonal);


  // SAVE ALL SELECTED VEHICLES
  const requestVehicle = selectedVehicles
    .map(vehicle => {
      return {
        'idProject': event_data.event_id,
        'idVehicle': vehicle.id,
        'trip_value': vehicle.tripValue,
        'trip_count': vehicle.cantidadViajes
      };
    })

  await assignvehicleToProject(requestVehicle);


// SAVE RENDICONES
const requestRendicion = allRendiciones
.map((rendicion)=>{
  return {
      'detalle' :rendicion.detalle,
      'personal_id' :rendicion.personal_id,
      'monto' :parseInt(ClpUnformatter(rendicion.monto)) ,
      'fecha' :rendicion.fecha,
      'comercio' :rendicion.comercio,
    }
  });
  await assignRendicionToEvent(requestRendicion,EMPRESA_ID,event_data.event_id);


  // SAVE OTHER PRODUCTS
  const requestOtherProds = _allMyOtherCosts
  .map((cost)=>{
    return{
      'name' : cost.name,
      'cantidad' : cost.cantidad,
      'monto' : cost.monto
    }
  });
  await assignOtherCostsToEvent(requestOtherProds,EMPRESA_ID,event_data.event_id);

  // SAVE OTHER SUBRENTS

  await assignSubRentToEvent(_subRentsToAssign,EMPRESA_ID,event_data.event_id);


  // SAVE INCOME AND COSTS
  const REQUEST_INCOME_COST ={
    "event_id":event_data.event_id,
    "ingreso": _totalIngresos,
    "costo": _totalEgresos 
  }
  const responseIncomeAndCosts =  await insertOrUpdateIncomeAndCosts(REQUEST_INCOME_COST);

  changesCompleted();
  setTimeout(()=>{
    closeBottomBar();
  },1500)
  return true;
}

function createNewEvent(requestProject) {
  return $.ajax({
    type: "POST",
    url: 'ws/proyecto/proyecto.php',
    data: JSON.stringify({
      request: {
        requestProject
      },
      action: "addProject"
    }),
    dataType: 'json',
    success: function (data) {
      console.log("RESPONSE CREATE PROYECTO", data);

    },
    error: function (response) {
      console.log(response.responseText);
    }
  })
}

function updateEvent(requestProject, event_id, empresa_id) {

  return $.ajax({
    type: "POST",
    url: 'ws/proyecto/proyecto.php',
    data: JSON.stringify({
      action: "updateProject",
      'empresa_id': empresa_id,
      'request': requestProject,
      'event_id': event_id,
    }),
    dataType: 'json',
    success: function (response) {
      console.log("RESPONSE UPDATE PROYECTO", response);
    },
    error: function (error) {
      console.log("ERROR UPDATE PROYECTO",error.responseText);
      console.log(error.responseText);
    }
  })

}


// SECTION ADDRESS CREATION AND ASSIGMENTS
async function insertAddressAndAssignToProject(address, empresa_id, event_id) {
  $.ajax({
    type: "POST",
    url: 'ws/direccion/Direccion.php',
    data: JSON.stringify({
      'action': 'addAndAssignToProject',
      'address': address,
      'empresa_id': empresa_id,
      'event_id': event_id
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response)
    },
    error: function (response) {
      console.log("ERROR insertAddressAndAssignToProject",error.responseText);
      console.log(error.responseText);
    }
  });
}

async function removeAddressFromEvent(event_id, empresa_id) {
  $.ajax({
    type: "POST",
    url: 'ws/proyecto/proyecto.php',
    data: JSON.stringify({
      'action': 'removeAddressFromEvent',
      'event_id': event_id,
      'empresa_id': empresa_id
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response)
    },
    error: function (response) {
      console.log("ERROR removeAddressFromEvent",error.responseText);
      console.log(error.responseText);
    }
  });
}

// SECTION SCHEDULES, CREATE, ASSIGN OR REMOVE FROM EVENT

async function insertAndAssignSchedulesToEvent(event_id, empresa_id, schedules) {
  $.ajax({
    type: "POST",
    url: 'ws/schedules/schedule.php',
    data: JSON.stringify({
      'action': 'insertAndAssignSchedulesToEvent',
      'event_id': event_id,
      'empresa_id': empresa_id,
      'schedules': schedules
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response)
    },
    error: function (response) {
      console.log("ERROR UinsertAndAssignSchedulesToEvent",error.responseText);
      console.log(error.responseText);
    }
  });
}

async function removeAllSchedulesFromEvent(event_id, empresa_id) {
  $.ajax({
    type: "POST",
    url: 'ws/schedules/schedule.php',
    data: JSON.stringify({
      'action': 'removeAllSchedulesFromEvent',
      'event_id': event_id,
      'empresa_id': empresa_id
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response)
    },
    error: function (response) {
      console.log(response.responseText);
    }
  });
}

// SECTION FILES CONTROLLER
async function assignFilesToEvent(_allmyUploadedFiles, event_id, empresa_id, personal_id) {
  $.ajax({
    type: "POST",
    url: 'ws/BussinessDocuments/assignFilesToEvent.php',
    data: JSON.stringify({
      'event_id': event_id,
      'empresa_id': empresa_id,
      'files': _allmyUploadedFiles,
      'personal_id': personal_id
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response)
    },
    error: function (response) {
      console.log(response.responseText);
    }
  });
}


// SECTION PRODUCTS 
async function assignProduct(requestAssignFunction) {
  try {
    return $.ajax({
      type: "POST",
      url: 'ws/productos/Producto.php',
      data: JSON.stringify({
        request: requestAssignFunction,
        action: "assignProductToProject"
      }),
      dataType: 'json',
      success: function (data) {

        console.log("RESPONSE AGIGNACION PRODUCTOS", data);

      },
      error: function (response) {
        console.log(response.responseText);
      }
    })
  } catch (e) {
    console.log(e);
  }
}


async function assignOtherProdsToEvent(requestAssignFunction) {
  try {
    return $.ajax({
      type: "POST",
      url: 'ws/productos/Producto.php',
      data: JSON.stringify({
        request: requestAssignFunction,
        action: "assignOtherProdsToEvent"
      }),
      dataType: 'json',
      success: function (response) {
        console.log("RESPONSE AGIGNACION OTHERS PRODS", response);
      },
      error: function (response) {
        console.log(response.responseText);
      }
    })
  } catch (e) {
    console.log(e);
  }
}
async function assignRendicionToEvent(request,empresa_id,event_id) {
  try {
    return $.ajax({
      type: "POST",
      url: 'ws/rendicion/rendicion.php',
      data: JSON.stringify({
        'action' : "assignRendicionToEvent",
        'request' : request,
        'empresa_id' : empresa_id,
        'event_id' : event_id
      }),
      dataType: 'json',
      success: function (response) {
        console.log("RESPONSE AGIGNACION assignRendicionToEvent", response);
      },
      error: function (response) {
        console.log(response.responseText);
      }
    })
  } catch (e) {
    console.log(e);
  }
}
async function assignOtherCostsToEvent(request,empresa_id,event_id) {
  try {
    return $.ajax({
      type: "POST",
      url: 'ws/otherCosts/otherCosts.php',
      data: JSON.stringify({
        'action' : "assignOtherCostsToEvent",
        'request' : request,
        'empresa_id' : empresa_id,
        'event_id' : event_id
      }),
      dataType: 'json',
      success: function (response) {
        console.log("RESPONSE AGIGNACION assignOtherCostsToEvent", response);
      },
      error: function (response) {
        console.log(response.responseText);
      }
    })
  } catch (e) {
    console.log(e);
  }
}
async function assignSubRentToEvent(request,empresa_id,event_id) {
  try {
    return $.ajax({
      type: "POST",
      url: 'ws/subRent/subRent.php',
      data: JSON.stringify({
        'action' : "assignSubRentToEvent",
        'request' : request,
        'empresa_id' : empresa_id,
        'event_id' : event_id
      }),
      dataType: 'json',
      success: function (response) {
        console.log("RESPONSE AGIGNACION assignSubRentToEvent", response);
      },
      error: function (response) {
        console.log(response.responseText);
      }
    })
  } catch (e) {
    console.log(e);
  }
}


async function assignStandardPackageToProject(request){
  return $.ajax({
    type: "POST",
    url: 'ws/standard_package/standard_package.php',
    data: JSON.stringify({
      'request': request,
      'action': "assignStandardPackageToProject"
    }),
    dataType: 'json',
    success: function (data){
      
    },
    error: function (response){
      console.log(response.responseText);
    }
  })
}
async function insertOrUpdateIncomeAndCosts(request){
  return $.ajax({
    type: "POST",
    url: 'ws/proyecto/proyecto.php',
    data: JSON.stringify({
      'request': request,
      'action': "insertOrUpdateIncomeAndCosts"
    }),
    dataType: 'json',
    success: function (data){
      
    },
    error: function (response){
      console.log(response.responseText);
    }
  })
}

async function addAssignedPackagesToEvent(){

  // const package_id = $(element).closest('tr').attr('package_id');

  // console.log(PACKAGE_LIST);



  const idExists = PACKAGE_LIST.find((package) => {
    return parseInt(package.id) === parseInt(package_id)
  });

  if (!idExists) {
    Swal.fire(
      'Lo sentimos!',
      'Algo ha ido mal, intenta nuevamente',
      'error'
    )
  }

  if (_selectedPackages.length > 0) {
    const packageExists = _selectedPackages.find((selectedPackage) => {
      return selectedPackage.package_id === package_id
    });

    if (packageExists) {
      Swal.fire(
        'Lo sentimos!',
        'No se puede seleccionar mas de una vez el mismo paquete',
        'warning'
      )
      return;
    }
  }

  // GET ALL PACKAGE PRODUCTS
  const productsOnPackage = await GetPackageDetails(package_id);
  const productsToAdd = productsOnPackage.products.map((productsOnPackage) => {
    return {
      'id': productsOnPackage.product_id,
      'quantityToAdd': productsOnPackage.quantity
    }
  })

  _selectedPackages.push({
    'package_id': productsOnPackage.data[0].id,
    'package_name': productsOnPackage.data[0].nombre,
    'package_products': productsOnPackage.products
  });

  const addProd = setSelectedProduct_AddNewProducts(productsToAdd);

  printAllProductsOnTable();
  setCategoriesAndSubCategories();
  printAllSelectedProducts();
  setIngresos();
}


