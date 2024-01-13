let _selectedClient = [];

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

      // console.log("RESPONSE clientes",response)

      $('#clienteSelect').append(new Option("", ""));
      response.forEach(client => {


        let clientName = client.nombre_fantasia;

        if (clientName === "" || clientName === null) {
          clientName = client.nombre_cliente
        }

        let opt = $('#clienteSelect').append(new Option(clientName, client.cliente_id))
        opt.addClass()
      })
    }
  })

}

$('#clienteSelect').on('change', function () {

  const CLIENTE_ID = $(this).val();


  if (CLIENTE_ID === "") {
    resetClientForm();
    return;
  }
  console.log(CLIENTE_ID);

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

      setSelectedClient(response.cliente);
      console.log(_selectedClient);

      response.cliente.forEach(cli => {
        $('#idClienteModalResume').text(cli.id);
        $('#clientNameorDesc').val(cli.nombre_fantasia);
        $('#clientRazonSocial').val(cli.razon_social);
        $('#clientRut').val(cli.rut);
        $('#clientContacto').val(cli.persona_contacto);
        $('#clientCorreo').val(cli.email);
        $('#clientTelefono').val(cli.telefono);
      })


    }
  })
})

function setSelectedClient(selectedClient) {
  _selectedClient = [];
  if(typeof event_data !==  'undefined'){

    event_data.client_id = selectedClient;
  }
  _selectedClient = selectedClient;
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
async function FillClientesTable() {

  const dataClientes = await GetClientData(EMPRESA_ID);
  console.log(dataClientes);
  if (!dataClientes.success) {
    return
  }

  if (!$.fn.DataTable.isDataTable('#dashClient-table')) {

    dash_Client_table = new DataTable('#dashClient-table', {
      "responsive": false,
      "paging": true,
      "scrollX": false,
      "autoWidth": false,
      lengthMenu: [5,10, 20, 50, 100, 200, 500],
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Patentes",
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
      columnDefs: [{ "width": "17%", "targets": "_all" },{ className: "ps-header", "targets": [ 0 ] }, { className: "tc", "targets": [ 3 ] },
      {
        "defaultContent": "",
        "targets": "_all"
      }],
    });
  } else {
    dash_Client_table
      .rows()
      .remove()
      .draw();
    // table.clear();
  }
  dataClientes.data.forEach((cliente) => {
    console.log(cliente);


    let name = "";
    let email = ""
    let address = "";
    let rut = "";

    if(cliente.persona_contacto !== ""){
      name = cliente.persona_contacto;
    }else{
      name = '-'
    }
    if(cliente.nombre_persona !== ""){
      name = cliente.nombre_persona;
    }else{
      name = '-'
    }
    if(cliente.nombre_fantasia !== ""){
      name = cliente.nombre_fantasia;
    }else{
      name = '-'
    }
    dash_Client_table.row
      .add([
        name,
        cliente.rut_df,
        cliente.df_correo,
        cliente.event_quantity,
        CLPFormatter(cliente.totalPerClient) 
      ])
      .draw(true);
  });
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