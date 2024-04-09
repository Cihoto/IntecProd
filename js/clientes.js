let _selectedClient = [];

let selectedClientData = {
  "client": {

  },
  "events": {

  }
};

function FillClientes(empresaId) {

  $.ajax({
    type: "POST",
    url: "ws/cliente/cliente.php",
    dataType: 'json',
    data: JSON.stringify({
      "tipo": "getClientesByEmpresa",
      request: empresaId
    }),
    success: function (response) {

      $('#clienteSelect option').remove();

      console.log("RESPONSE clientes",response)

      $('#clienteSelect').append(new Option("", ""));
      response.forEach(client => {
        let clientName = client.nombre_fantasia;
        if (clientName === "" || clientName === null) {
          clientName = client.nombre_cliente
        }
        let opt = $('#clienteSelect').append(new Option(clientName, client.cliente_id))
        opt.addClass()
      });
      console.log("event_data.client_id",event_data.client_id);
      
      if(event_data.client_id !== ""){
        $('#clienteSelect').val(event_data.client_id);
        $('#clienteSelect').change();
        
      }
    }
  })
}

let canModify = true; 

function showEditClientControls(){
  canModify = true;
  $('#enableEditCliente').css("display","flex");
  $('#enableEditCliente').css('display', 'block');
  $('#addCliente p').text("Modificar y seleccionar");
  $('#formConfirmSection').css("display","none");
  disableClientEdit();
}
function hideEditClientControls(){
  canModify = false;
  $('#enableEditCliente').css("display","none");
  $('#addCliente p').text("Crear y seleccionar");
  $('#formConfirmSection').css("display","flex");
  enableClientEdit(); 
}

function enableClientEdit(){
  $('#sideclientForm input').attr("readonly",false);
  $('#sideclientForm input').attr("disabled",false);
}
function disableClientEdit(){
  $('#sideclientForm input').attr("readonly",true);
  $('#sideclientForm input').attr("disabled",true);
}

$('#enableEditCliente').on("click",function(){

  if(!canModify){
    return;
  }
  enableClientEdit();
  $('#formConfirmSection').css("display","flex");
});

function selectClientForEvent(){
  $('#clientSelectController').css('display', 'none');
  $('#enableEditCliente').css('display', 'none');
  $('#addClienteController').css('display', 'flex');
  $('#sideclientForm .form-group').css('display' , 'none');
}

function showSelectedClientForEvent(){
  $('#enableEditCliente').css('display', 'block');
  $('#addClienteController').css('display', 'flex');
  $('#sideclientForm .form-group').css('display' , 'block');
}

function showCreateNewClient(){
  $('#enableEditCliente').css('display', 'none');
  $('#addClienteController').css('display', 'flex');
  $('#sideclientForm .form-group').css('display' , 'block');
}

let createNewClient = false;

$('#addClienteController').on('click',function(){
  createNewClient = !createNewClient;

  if(createNewClient){
    $('#clientSelector').css('display','none');
    // $('#clienteSelect').val('');
    $('#enableEditCliente').css('display', 'none');
    $('#formConfirmSection').css("display","flex");
    $('#addCliente p').text("Guardar y seleccionar");
    $('#addClienteController p').text("Cancelar");
    $('#sideclientForm .form-group').css('display' , 'block');
    $('#sideclientForm input').val('');
    enableClientEdit()
  }else{
    $('#clientSelector').css('display','block');
    // $('#clienteSelect').val('');
    $('#clienteSelect').change();
    $('#enableEditCliente').css('display', 'block');
    $('#formConfirmSection').css("display","none");
    $('#addClienteController p').text("Crear Nuevo Cliente");
    $('#addCliente p').text("Guardar y seleccionar");
    $('#sideclientForm .form-group').css('display' , 'block');
    $('#sideclientForm input').val('');

  }
})

$('#clienteSelect').on('change', function () {

  
  const CLIENTE_ID = $(this).val();

  if (CLIENTE_ID === "" ) {
    resetClientForm();
    hideEditClientControls();
    resetClientSelection();
    return;
  }
  console.log(CLIENTE_ID);
  // $('#addCliente p').text("Seleccionar");
  showEditClientControls();
  showSelectedClientForEvent();
  if (CLIENTE_ID !== "" ) {

    $.ajax({
      type: "POST",
      url: "ws/cliente/cliente.php",
      dataType: 'json',
      data: JSON.stringify({
        "tipo": "getClienteById",
        request: CLIENTE_ID
      }),
      success: function (response) {
  
        // console.log(response);
        // console.log(response.cliente);
        
        console.log("AJAX",_selectedClient);
        console.log("AJAX response",response);
  
        response.cliente.forEach(cli => {
          $('#idClienteModalResume').text(cli.id);
          $('#clientNameorDesc').val(cli.nombre_fantasia);
          $('#clientRazonSocial').val(cli.razon_social);
          $('#clientRut').val(cli.rut);
          $('#clientContacto').val(cli.persona_contacto);
          $('#clientCorreo').val(cli.email);
          $('#clientTelefono').val(cli.telefono);
        })
  
        setSelectedClient(response.cliente[0]);
        $('#clienteProjectResume').text(response.cliente[0].nombre_fantasia)
  
      }
    })
  }else{
    resetClientSelection();
  }
})

function setSelectedClient(selectedClient) {
  _selectedClient = [];

  if (typeof event_data !== 'undefined'){
    event_data.client_id = selectedClient.id;
  }
  _selectedClient = selectedClient;
  
  $('#inputNombreCliente').val(_selectedClient.nombre_fantasia);
  console.log(_selectedClient.nombre_fantasia);
  console.log(_selectedClient);

  console.log("FUNCTION",_selectedClient);

}

function resetClientSelection() {
  _selectedClient = [];
  if (typeof event_data !== 'undefined') {
    event_data.client_id = "";
  }
  $('#inputNombreCliente').val("");
}

function CleanCliente() {
  // document.getElementById("sideclientForm").reset();
  $('#sideclientForm').reset();
}

function resetPoroviderForm() {
  $('#sideProviderForm')[0].reset();
}


function UpdateCliente(request) {
  $.ajax({
    type: "POST",
    url: 'ws/cliente/cliente.php',
    data: JSON.stringify({
      "request": {
        request
      },
      "tipo": "UpdateCliente"
    }),
    dataType: 'json',
    success: function (response) {
      $('#clientDataBtn').text("Guardar");
      // console.log(response);
    }, error: function (response) {
      // console.log(response)
    }
  })
}

function GetClientData(empresa_id) {

  return $.ajax({
    type: "POST",
    url: 'ws/cliente/cliente.php',
    data: JSON.stringify({
      "tipo": "getClientData",
      'empresa_id': empresa_id
    }),
    dataType: 'json',
    success: function (response) {
      console.log(response);

      if (response.success) {
        console.log(response.data);

      }
      if (response.error) {
        console.log(response.error);

      }
    }, error: function (response) {

    }
  })
}

async function FillCientesDisplay() {
  const dataClientes = await GetClientData(EMPRESA_ID);
  console.log(dataClientes);
  if (!dataClientes.success) {
    return
  }

  if (dataClientes.data.length > 0) {
    const container = $('#clients-container')

    dataClientes.data.forEach(cliente => {

      let boxCliente = `<div class="client-box">

          <h4>${cliente.nombre_fantasia}</h4>
          <hr>
          <div class="client-box-body">
            <p>${cliente.nombre} ${cliente.apellido}</p>
            <p>${cliente.rut_df}</p>
            <p>${cliente.direccion}</p>
            <p>${cliente.telefono}</p>
            <p>${cliente.email}</p>
          </div>
        </div>`;

      container.append(boxCliente);
    });

  }
}

let dash_Client_table = "";
async function FillClientesTable_dash() {

  $('#dashClient-table tbody tr').remove();
  const dataClientes = await GetClientData(EMPRESA_ID);
  console.log(dataClientes);
  if (!dataClientes.success) {
    return
  }


  if ($.fn.DataTable.isDataTable('#dashClient-table')) {
    $('#dashClient-table').DataTable()
    .clear()
    .draw();
    $('#dashClient-table').DataTable().destroy();
  }

  dataClientes.data.forEach((cliente, index) => {

    let name = "";
    let correo = cliente.cli_correo;
    if (cliente.nombre_fantasia) {

      name = cliente.nombre_fantasia
    } else if (cliente.nombre_persona) {
      name = cliente.nombre_persona
    } else if (cliente.nombre_contacto) {

      name = cliente.nombre_contacto
    } else {
      name = '-'
    }

    if(correo === "" || correo === null ){
      correo = cliente.df_correo;
    }
    if(correo === "" || correo === null ){
      correo = "-";
    }
    

    let tr = `<tr client_id="${cliente.cliente_id}">
      <td>${name}</td>
      <td>${cliente.event_quantity}</td>
      <td>${CLPFormatter(cliente.totalPerClient)}</td>
      <td>${cliente.rut_df}</td>
      <td>${correo}</td>
    </tr>`;
    
    $('#dashClient-table tbody').append(tr);
  });

  if (!$.fn.DataTable.isDataTable('#dashClient-table')) {

    dash_Client_table = new DataTable('#dashClient-table', {
      "responsive": false,
      "paging": true,
      "scrollX": false,
      "autoWidth": false,
      'lengthMenu': [5, 10, 20, 50, 100, 200, 500],
      'pageLength': 100,
      'language': {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Clientes",
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
      columnDefs: [
        { 
          "width": "17%", "targets": "_all" 
        }, 
        {
          className: "ps-header", "targets": [0] 
        }
        , 
        { 
          className: "tc", "targets": [3] 
        },
        {
          "defaultContent": "-",
          "targets": "_all"
        }
    ],
      "pageLength": 100

    });

  }
  // $("select[name='dashClient-table_length']").val("5").change();
}

$(document).on("click", "#dashClient-table tbody tr", async function () {
  selectedClientData = {
    "client": {
  
    },
    "events": {
  
    }
  };

  $('#eventsPerClient_dash tbody tr').remove();
  const CLIENT_ID = $(this).closest('tr').attr("client_id");

  const CLIENT_DATA_AND_EVENTS = await getClienteById_dataAndEvents(CLIENT_ID, EMPRESA_ID)     

  console.log(CLIENT_DATA_AND_EVENTS)

  if (!CLIENT_DATA_AND_EVENTS.success) {
    Swal.fire({
      title: "Ups!",
      text: "No se ha completado la solicitud, intente nuevamente",
      icon: "error",
      timer: 4000
    });
    return
  }
  selectedClientData.events = CLIENT_DATA_AND_EVENTS.events
  selectedClientData.client = CLIENT_DATA_AND_EVENTS.data


  CLIENT_DATA_AND_EVENTS.data.forEach(cli => {
    $('#idClienteModalResume-dash').text(cli.id);
    $('#clientNameorDesc-dash').val(cli.nombre_fantasia);
    $('#clientRazonSocial-dash').val(cli.razon_social);
    $('#clientRut-dash').val(cli.rut_razon_social);
    $('#clientContacto-dash').val(cli.persona_contacto);
    $('#clientCorreo-dash').val(cli.email);
    $('#clientTelefono-dash').val(cli.telefono);
  });

  if ($.fn.DataTable.isDataTable('#eventsPerClient_dash')){
    $('#eventsPerClient_dash').DataTable()
    .clear()
    .draw();
    $('#eventsPerClient_dash').DataTable().destroy();
  }
  selectedClientData.events.forEach((evento) => {
    let tr =`<tr event_id="${evento.event_id}">
      <td>${evento.nombre_proyecto}</td>
      <td>${evento.fecha_inicio}</td>
      <td>${evento.estado}</td>
      <td>${CLPFormatter(evento.income)}</td>
    </tr>`;
    $("#eventsPerClient_dash tbody").append(tr);
  });

  if (!$.fn.DataTable.isDataTable('#eventsPerClient_dash')) {

    dash_Client_table = new DataTable('#eventsPerClient_dash',{
      "responsive": false,
      "paging": true,
      "scrollX": false,
      "autoWidth": false,
      lengthMenu: [5, 10, 20, 50, 100, 200, 500],
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Clientes",
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
      columnDefs: [{ "width": "18.6%", "targets": "_all" },
      {
        "defaultContent": "-",
        "targets": "_all"
      }],
      "pageLength": 100
    });

  }
  $('#clientSideMenu-clientDash').addClass('active')
  console.log(CLIENT_DATA_AND_EVENTS);

});


$('#deleteClientDash').on('click',async function(){

  const CLIENT_ID = parseInt(selectedClientData.client[0].client_id);


  Swal.fire({
    title: "¿Quieres eliminar este cliente?",
    text: "Esta acción es irreversible!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar!"
  }).then(async (result) => {
    if (result.isConfirmed) {

      const REMOVE_CLIENT_RESPONSE = await deleteClient(EMPRESA_ID,CLIENT_ID);

      console.log('REMOVE_CLIENT_RESPONSE',REMOVE_CLIENT_RESPONSE);

      if(!REMOVE_CLIENT_RESPONSE){
        Swal.fire({
          title: "Ups!",
          text: "No se ha podido eliminar al cliente, intenta nuevamente!",
          icon: "error"
        });
        return 
      }
      Swal.fire({
        title: "Excelente!",
        text: "Cliente eliminado.",
        icon: "success"
      });
      $('#clientSideMenu-clientDash').removeClass('active');


      $(`#dashClient-table tbody tr[client_id="${CLIENT_ID}"]`).remove()

    }
  });
  


});




$(document).on('click','#eventsPerClient_dash tbody tr',function(){
  const EVENT_ID = $(this).attr('event_id');
  openEvent(EVENT_ID);
})


function deleteClient(empresa_id, client_id){
  return $.ajax({
    type: "POST",
    url: "ws/cliente/cliente.php",
    dataType: 'json',
    data: JSON.stringify({
      "tipo": "deleteClient",
      'client_id': client_id,
      'empresa_id': empresa_id
    }),
    success: function (response){
      console.log('response delete client',response)
    }, error: function (error) {
      console.log(error.responseText)
    }
  })
}









$('#enableEditClient').on("click",function(){
  $('#updateClient input[type="text"]').attr("readonly",false)
  $('#updateClient input[type="text"]').attr("disabled",false)
  $('#editConfirmClient').css("display","flex")
  
})

function cancelEdit(){
  console.log(selectedClientData.client)
  $('#idClienteModalResume-dash').text(selectedClientData.client[0].client_id);
  $('#clientNameorDesc-dash').val(selectedClientData.client[0].nombre_fantasia);
  $('#clientRazonSocial-dash').val(selectedClientData.client[0].razon_social);
  $('#clientRut-dash').val(selectedClientData.client[0].rut_razon_social);
  $('#clientContacto-dash').val(selectedClientData.client[0].persona_contacto);
  $('#clientCorreo-dash').val(selectedClientData.client[0].email);
  $('#clientTelefono-dash').val(selectedClientData.client[0].telefono);
  $('#updateClient input[type="text"]').attr("readonly",true)
  $('#updateClient input[type="text"]').attr("disabled",true)
  $('#editConfirmClient').css("display","none");
 
}

async function getClienteById_dataAndEvents(client_id, empresa_id) {
  return $.ajax({
    type: "POST",
    url: "ws/cliente/cliente.php",
    dataType: 'json',
    data: JSON.stringify({
      "tipo": "getClienteById_dataAndEvents",
      'cliente_id': client_id,
      'empresa_id': empresa_id
    }),
    success: function (response){

    }, error: function (error) {
      console.log(error.responseText)
    }
  })
}

function getClientInformation(cliente_id) {
  return $.ajax({
    type: "POST",
    url: 'ws/cliente/cliente.php',
    data: JSON.stringify({
      "tipo": "getClientInformation",
      'cliente_id': cliente_id
    }),
    dataType: 'json',
    success: function (response) {

    }, error: function (error) {

    }
  })
}



function ResetClienteForm() {
  $("#clienteSelect").val("");
  $("#inputNombreClienteForm").val("");
  $("#inputApellidos").val("");
  $("#inputRutCliente").val("");
  $("#inputCorreo").val("");
  $("#inputTelefono").val("");
  $("#inputRut").val("");
  $("#inputRazonSocial").val("");
  $("#inputNombreFantasia").val("");
  $("#inputDireccionDatosFacturacion").val("");
  $("#inputCorreoDatosFacturacion").val("");
}