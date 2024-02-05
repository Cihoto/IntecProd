$('#createAccount').validate({
  rules: {
    'c-acc-fan-name': {
      required: true,
    },
    'c-acc-ra-soc': {
      required: true,
    },
    'c-acc-rut': {
      required: true,
    },
    'c-acc-addr': {
      required: true,
    },
    'c-acc-email': {
      required: true,
      email: true
    },
    'c-acc-pass': {
      required: true,
    },
    'c-acc-conf-pass': {
      required: true,
    },
  },
  messages: {
    'c-acc-fan-name': {
      required: "Ingrese un valor",
    },
    'c-acc-ra-soc': {
      required: "Ingrese un valor",
    },
    'c-acc-rut': {
      required: "Ingrese un valor",
    },
    'c-acc-addr': {
      required: "Ingrese un valor",
    },
    'c-acc-email': {
      required: "Ingrese un correo",
      email: "Correo invalido"
    },
    'c-acc-pass': {
      required: "",
    },
    'c-acc-conf-pass': {
      required: "",
    },
  },
  submitHandler: async function () {
    event.preventDefault();
    let pass = $('#c-acc-pass').val();
    let passConf = $('#c-acc-conf-pass').val();


    const passIsCorrect = await checkPassword();

    if(!passIsCorrect){
      return
    }
    const ACC_REQUEST = {
      'nombre_fanta': $('#c-acc-fan-name').val(),
      'razon_social': $('#c-acc-ra-soc').val(),
      'rut': $('#c-acc-rut').val(),
      'address': $('#c-acc-addr').val(),
      'email': $('#c-acc-email').val(),
      'pass': $('#c-acc-pass').val(),
    }

    const RESPONSE_NEW_ACCOUNT = await addNewAccount(ACC_REQUEST);

    if(!RESPONSE_NEW_ACCOUNT.success){
      Swal.fire({
        'icon' : 'warning',
        'title' : 'Ups!',
        'text' : 'Error al crear su cuenta, por favor intente nuevamente'
      });
      return;  
    }
    window.location = "login.php"
  }
});

async function addNewAccount(requestAccount) {
  return $.ajax({
    type: "POST",
    url: "ws/Usuario/usuario.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "createNewAccount",
      request: requestAccount
    }),
    success: function (response) {
      console.log(response);
    }
  });
}