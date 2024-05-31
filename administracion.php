<?php
ob_start();
if (session_id() == '') {
  session_start();
}

if (!isset($_SESSION['empresa_id'])) {
  header("Location: login.php");
  die();
} else {
  $empresaId = $_SESSION["empresa_id"];
}
$active = 'administracion';
$title = 'Intec - Clientes';
?>



<!DOCTYPE html>
<html lang="en">
<?php
require_once('./includes/head.php');
?>
<style>
    #bussinessUserTable td {
        width: 50%;
    }
</style>

<body>


    <?php include_once('./includes/Constantes/empresaId.php') ?>
    <?php include_once('./includes/Constantes/rol.php') ?>
    <script src="./assets/js/initTheme.js"></script>
    <div id="app">

        <?php require_once('./includes/sidebar.php') ?>
        <div id="main">

            <div id="userContainer">
                <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <circle cx="6" cy="6" r="6" fill="#069B99" />
                    </svg>
                    <p class="header-P">Aquí puedes ver, editar y crear tus usuarios</p>
                </div>

                <div class="row justify-content-end" style="margin:0px 14px;">
                    <button class="s-Button" id="openSideClientForm" onclick="getAndPrintUnablePersonalForUserCreation()">
                        <p class="s-P">Agregar usuario</p>
                    </button>
                </div>

                <table class="--table-s" style="width:40%" id="bussinessUserTable">
                    <thead>
                        <tr>
                            <th style="width:50%">Correo</th>
                            <th style="width:50%">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
<!-- 
            <div class="page-content">





                <div class="action-container">
                    <div class="action-box" id="CreateUser">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                </div>
              
                </div> -->
            </div>
        </div>
        <?php require_once('./includes/footer.php') ?>
    </div>
    </div>


    <?php require_once('./includes/Modal/cliente.php') ?>
    <?php require_once('./includes/footerScriptsJs.php') ?>

    <!-- require once de modal para ingresar clientes Masiva -->
    <?php require_once('./includes/Modal/productosMasiva.php') ?>

    <!-- Validador intec -->
    <script src="./js/valuesValidator/validator.js"></script>

    <!-- Validate.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <!-- XSLX READER HJS CDN And JS CLASS FUNCTIONS-->
    <script src="js/xlsxReader.js"></script>
    <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>

    <!-- SCRIPTS FUNCIONES JS -->
    <script src="/js/usuario.js"></script>
    <script src="/js/personal.js"></script>


    <!-- SIDE MENU INCLUDE -->
    <?php include_once('./includes/sidemenu/admSideMenu.php') ?>
    <?php include_once('./includes/sidemenu/admUserConfigMenu.php') ?>

</body>

<script>
    const EMPRESA_ID = $('#empresaId').text();


    //FUNCTION TO RETURN AND FILL ALL <LI> ON USER LIST

    async function FillUsers() {
        const users = $('#userList li')
        if (users.length > 0) {
            $(users).each((key, element) => {
                $(element).remove();
            })
        }
        const response = await GetAllUsuariosByEmpresa(EMPRESA_ID);
        return true
    }

    $(document).ready(function() {
        // GetAllUsuariosByEmpresa(EMPRESA_ID);
        FillUsers();
        // $('#personalSelect').select2();
        $('#openSideClientForm').on("click", function() {
            $('#admUserSideMenu').addClass('active');
        })
        $('#closeAdmUserSideMenu').on("click", function() {
            $('#admUserSideMenu').removeClass('active');
        })
        $('#closeAdmConfigUserSideMenu').on("click", function() {
            $('#admConfigUserSideMenu').removeClass('active');
        })
    });




    // FILTER USER BY NAME
    $('#searchUser').on('keyup', function() {
        const valueToSearch = $(this).val();
        const users = $('.user-element');
        $(users).each((key, element) => {
            let userName = $(element).find('.userName').text();
            console.log(userName);
            console.log(valueToSearch.toLowerCase());
            if (userName.match()) {
                $(element).show();
            } else {
                $(element).hide();
            }
        })
    })


    // ******USER CONFIG******* 


    // FUNCTIONS FOR CHECKBOX

    // UNCHECK ALL CHECK BUTTON, PUT IT ON CHECKED === FALSE
    function resetAllCheckButtons() {

        const mainCheck = $('.rolActivator');
        const editCheck = $('.edit');

        $(mainCheck).each((key, element) => {
            if ($(element).closest('.rol-item-container').hasClass('active')) {
                $(element).trigger('click')
            }
        })
        $(editCheck).each((key, element) => {
            $(element).prop('checked', false);
        })
    }

    // CHECK ALL CHECK BUTTON, PUT IT ON CHECKED === FALSE
    function checkAllCheckButtons() {
        const mainCheck = $('.rolActivator');
        const editCheck = $('.edit');

        $(mainCheck).each((key, element) => {
            if (!$(element).closest('.rol-item-container').hasClass('active')) {
                $(element).trigger('click');
                // $(element).prop(':checked',true);
            }
        })
        $(editCheck).each((key, element) => {
            $(element).prop('checked', true);
        })
    }



    // CHECKBOX ACTIVATORS 

    $('.rolActivator').on('click', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.rol-item-container').addClass('active');
            $(this).closest('input').attr("disabled", false)
        } else {
            $(this).closest('.rol-item-container').removeClass('active');
            $(this).closest('.rol-item-container').attr('disabled', 'disabled');
        }
    })

    $('.substituted').on('click', function() {

        const checkbox = $(this).closest('.rol-item-container').find('.checkbox-wrapper-22').find('.switch').find('.rolActivator')
        const optionContainer = $(this).closest('.rol-item-container');
        if (!$(optionContainer).hasClass('active')) {
            $(checkbox).trigger('click')
        }
    })


    // SOFT DELETE USER ON USER CONFIG
    $('#delete-user').on('click', async function() {
        Swal.fire({
            title: '¿Quieres eliminar a este usuario de tu organización?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sí',
            denyButtonText: `No`,
        }).then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                const user_id = $('.user-options').attr('user_id');

                const isDeleted = await DeleteUser(user_id);

                if (isDeleted.success) {
                    Swal.fire('Usuario eliminado exitosamente', '', 'success')
                        .then(() => {
                            FillUsers();
                        })
                }
                if (isDeleted.error) {
                    Swal.fire('Ha ocurrido un error, por favor intente nuevamente', '', 'error')
                }

            } else if (result.isDenied) {}
        })
    })
    // END USER DELETE


    // *******USER CONFIG*******


    $('#checkbox-Administrador').on('click', function() {
        if ($(this).is(':checked')) {
            checkAllCheckButtons();
        } else {
            resetAllCheckButtons();
        }
    })

    function removeActiveFromUserElement() {
        const userElement = $('.user-element');
        $(userElement).each((key, element) => {
            if ($(element).hasClass('active')) {
                $(element).removeClass('active');
            }
        })
    }

    // CLICK ON USER TO DISPLAY HIS INFO, ROLES , ETC

    $(document).on('click', '.user-element', async function() {

        $('#admConfigUserSideMenu').addClass('active');
        resetAllCheckButtons();
        removeActiveFromUserElement();

        const admContainer_user_id = $('.user-options');
        // $('#rol-Container input[type="checkbox"]').each((key,element)=>{
        //     $(element).prop("checked", false);
        // })
        $('#rol-Container').addClass('hidden');
        $(this).addClass('active');
        const user_id = $(this).attr('user_id');
        const roles = await GetUserRol(user_id);
        if (roles.success) {
            $(admContainer_user_id).attr('user_id', user_id);
            console.log(roles.user_data);
            $('#clientesEditEmail').val(roles.user_data[0].user);
            const lengthPass = roles.user_data[0].pass_length;
            let secretPass = '';
            for (let index = 0; index < lengthPass; index++) {
                secretPass += '*';
            }

            $('#txtChangePass').val(secretPass);
            $('#rol-Container').removeClass('hidden');
            let arrayRolId = [];
            roles.data.forEach(rol => {
                arrayRolId.push(rol.rol_id);
            });
            console.log(arrayRolId);
            if (arrayRolId.includes(1)) {
                // checkAllCheckButtons() 
            }

            $('#rol-Container input[type="checkbox"]').each((key, element) => {
                if (arrayRolId.includes("2") || arrayRolId.includes("1")) {
                    checkAllCheckButtons();
                } else {

                    if ($(element).hasClass('rolActivator') && arrayRolId.includes($(element).attr('value'))) {
                        $(element).trigger('click');
                    }
                    if ($(element).hasClass('substituted') && arrayRolId.includes($(element).attr('value'))) {
                        $(element).trigger('click');
                    }
                }
            })
        }
    })
    $(document).on('click', '#bussinessUserTable tbody tr', async function() {
        _selectedUser = "";
        $('#admConfigUserSideMenu').addClass('active');
        resetAllCheckButtons();
        removeActiveFromUserElement();

        const admContainer_user_id = $('.user-options');

        $('#rol-Container').addClass('hidden');
        const user_id = $(this).attr('user_id');

        _selectedUser = user_id;

        const roles = await GetUserRol(user_id);
        if (roles.success) {
            $(admContainer_user_id).attr('user_id', user_id);
            console.log(roles.user_data);
            $('#clientesEditEmail').val(roles.user_data[0].user);
            const lengthPass = roles.user_data[0].pass_length;
            let secretPass = '';
            for (let index = 0; index < lengthPass; index++) {
                secretPass += '*';
            }
            $('#txtChangePass').val(secretPass);
            $('#rol-Container').removeClass('hidden');
            let arrayRolId = [];
            roles.data.forEach(rol => {
                arrayRolId.push(rol.rol_id);
            });
            console.log(arrayRolId);
            if (arrayRolId.includes(1)) {
                // checkAllCheckButtons() 
            }

            $('#rol-Container input[type="checkbox"]').each((key, element) => {
                if (arrayRolId.includes("2") || arrayRolId.includes("1")) {
                    checkAllCheckButtons();
                } else {

                    if ($(element).hasClass('rolActivator') && arrayRolId.includes($(element).attr('value'))) {
                        $(element).trigger('click');
                    }
                    if ($(element).hasClass('substituted') && arrayRolId.includes($(element).attr('value'))) {
                        $(element).trigger('click');
                    }
                }
            })
        }
    });

    // CHANGE ROLES TO USER
    async function AssignRoles(arrayRoles, user_id) {
        return $.ajax({
            type: "POST",
            url: "ws/Usuario/usuario.php",
            dataType: 'json',
            data: JSON.stringify({
                "action": "AssignRoles",
                "user_id": user_id,
                arrayRoles: arrayRoles
            }),
            success: function(response) {
                console.log(response);

            }
        })
    }


    // USER CREATION MODULE

    // CHECK IF EMAIL IS TAKEN FROM OTHER USER
    async function CheckIfEmailExist(email) {

        $('#txtemail').removeClass('err');
        $('#txtemail').removeClass('success');
        $('#emailMessage').text('')
        if (email !== "") {
            const isEmail = await validateEmail(email)

            if (isEmail === true) {
                console.log(`ES UN EMAIL ${isEmail}`);

                const checkifEmailExist = await GetEmailusuario(email);
                if (checkifEmailExist) {
                    $('#txtemail').addClass('err')
                    $('#emailMessage').text('Correo utilizado por otro usuario')
                } else {
                    $('#txtemail').addClass('success')
                    $('#emailMessage').text('Correo disponible')
                }

            } else {
                $('#txtemail').addClass('err')
                $('#emailMessage').text('Ingrese un correo valido')
            }
        }
    }

    /*
        PUT VALUE OF <SELECT> ON TXTEMAIL, THEN
        CALL FUNCTION IF EMAIL IS TAKEN FROM OTHER USER ON APP
    */
    $(document).on('change', '#personalSelect', function() {
        const correo = $(this).val();
        $('#txtemail').val(correo);
        CheckIfEmailExist(correo)
    })
    // CHECK IF EMAIL IS TAKEN ON BLUR ACTION IN INPUT EMAIL
    $('#txtemail').on('blur', function() {
        console.log($(this).val());
        CheckIfEmailExist($(this).val());
    })


    // REMOVE ERR CLASS OR SUCCESS CLASS ON  EMAIL INPUT FOR NEW VALIDATION
    $('#txtemail').on('focus', function() {
        $('#emailMessage').text('')
        if ($(this).hasClass('err')) {
            $(this).removeClass('err')
        }
        if ($(this).hasClass('success')) {
            $(this).removeClass('success')
        }
    })

    // VALIDATE EMAIL FORMAT
    async function validateEmail(email) {
        var regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
        return regex.test(email);
    }

    async function getAndPrintUnablePersonalForUserCreation() {
        const PERSONAL_RESPONSE = await GetPersonalByEmpresa(EMPRESA_ID);

        if (!PERSONAL_RESPONSE.success) {
            return;
        }

        const PERSONAL = PERSONAL_RESPONSE.data;
        $("#personalSelect").empty();
        $("#personalSelect").append(new Option('', ''))

        $('#CreateNewUser input').val("");
        PERSONAL.forEach(personal => {
            $("#personalSelect").append(new Option(personal.nombre, personal.email));

            let lastOption = $('#personalSelect option').last();
            lastOption.attr('personal_id', `${personal.personal_id}`);
        });
        // $('.existingPersonal').addClass('greenback');
        // $('#newUserPersonalExist').prop('disabled', false);
        // $('#newUserPersonalData').removeClass('hidden');
    }


    // CREATE USER FROM EXISTING PERSONAL
    $('#newUserPersonalExist').on('click', async function() {
        // if (!$(this).is(':checked')) {

        //     $('#newUserPersonalData').addClass('hidden');
        //     $('.existingPersonal').removeClass('greenback');

        // } else {

        //     $('#newUserPersonalExist').prop('disabled', true);
        //     if (personal.data.length > 0) {

        //     } else {
        //         $('#newUserPersonalExist').prop('disabled', false);
        //         Swal.fire({
        //             title: 'Ups!',
        //             text: "No hay ténicos creados o todos los que posees ya tienen un usuario asociado",
        //             showConfirmButton: false,
        //             timer: 2000
        //         })
        //     }
        // }
    })

    // SAVE CHANGES FROM USER CONFIGURATION 
    $('#saveRoles').on('click', async function() {
        // $('#rol-Container').addClass('hidden');
        let arrayRoles = [];
        let user_id = "";
        $('#rol-Container .rolActivator:checked').each((key, element) => {
            $(element).closest('.rol-item-container').find('.substituted:checked').each((key, el) => {
                arrayRoles.push({
                    rol_id: $(el).attr('value')
                })
            })
        });

        if ($('#checkbox-Administrador').is(':checked')) {
            arrayRoles.push({
                rol_id: "2"
            })
        }

        console.log(arrayRoles);

        $('.user-element').each((key, element) => {
            if ($(element).hasClass('active')) {
                user_id = $(element).attr('user_id');
            }
        });

        if (_selectedUser === "" || _selectedUser === undefined || _selectedUser === null) {

            Swal.fire({
                icon: 'error',
                title: 'ups!',
                text: 'Recargue la página e intente nuevamente',
                showConfirmButton: false,
                timer: 15000
            });
            return;
        }
        const RESPONSE_ASSIGN_ROLES = await AssignRoles(arrayRoles, _selectedUser);

        if (RESPONSE_ASSIGN_ROLES.success) {
            $('#admConfigUserSideMenu').removeClass('active');
            Toastify({
                text: "Cambios guardados exitosamente",
                duration: 3000,
                style: {
                    background: "linear-gradient(90deg, #36ABA9 0%, #10E5E1 82.29%)",
                },
            }).showToast();
        }
    });

    // START PASS CODING AND SECURITY

    function addErrToPassInput(message) {
        if ($('#txtpass').hasClass('success')) {
            $('#txtpass').removeClass('success')
        }
        $('#txtpass').addClass('err');
        $('#passMessage').text(message)

    }

    function removeClassToPassInput() {
        $('#txtpass').removeClass('success');
        $('#txtpass').removeClass('err');
    }

    function containsUppercase(password) {
        return /[A-Z]/.test(password);
    }

    function containsWhitespace(password) {
        return /\s/.test(password);
    }

    $('#txtpass').on('click', function() {
        removeClassToPassInput()
    })

    $('#txtpass').on('blur', function() {
        const correo = $(this).val();
        console.log(correo);
        $('#passMessage').text('')
        if (correo === "") {
            addErrToPassInput('Ingrese una contraseña');
            return
        }
        if (containsWhitespace(correo)) {
            addErrToPassInput('No debe contener espacios');
            return
        }
        if (correo.length <= 5) {
            addErrToPassInput('Mínimo 6 caracteres');
            return
        }
        if (!containsUppercase(correo)) {

            addErrToPassInput('Debe contener una mayúscula');
            return
        }
        $('#txtpass').addClass('success');
    });
    // END PASS CODING AND SECURITY

    // ADD USER TO BUSSINESS
    $('#addUsuario').on('click', async function() {
        if ($('#txtemail').hasClass('err') || $('#txtpass').hasClass('err')) {
            Swal.fire({
                icon: 'error',
                title: "Ups!",
                text: 'Datos incorrectos, por favor corrija los errores',
                showConfirmButton: false,
                timer: 2000
            })
            return
        }

        const request = {
            personal_id: $('#personalSelect option:selected').attr('personal_id'),
            email: $('#txtemail').val(),
            pass: $('#txtpass').val(),
            empresa_id: EMPRESA_ID
        }
        const userWasCreated = await CreateUser(request)

        if (userWasCreated.error) {
            Swal.fire({
                icon: 'error',
                title: 'Lo sentimos',
                text: userWasCreated.message,
                showConfirmButton: false
            })
        }
        if (userWasCreated.success) {
            Swal.fire({
                icon: 'success',
                title: 'Excelente',
                text: userWasCreated.message,
                showConfirmButton: false,
                timer: 2000
            }).then(async function() {

                $('#admUserSideMenu').removeClass('active');

                const fillUsers = await GetAllUsuariosByEmpresa(EMPRESA_ID);
                if (fillUsers) {
                    const users = $('.user-element');
                    console.log("USERS", users);
                    $(`#bussinessUserTable tbody tr[user_id="${userWasCreated.user_id}"]`)[0].click();

                    $('#txtemail').val('');
                    $('#txtpass').val('');
                    $('#newUserPersonalExist').trigger('click');
                    $('#users').removeClass('hidden');
                    $('.collapsableFormContainer').addClass('hidden');
                }
            })
        }
    })
    // OPEN FORM TO CREATE NEW USER
    $('#CreateUser').on('click', function() {
        $('#users').addClass('hidden');
        $('.collapsableFormContainer').removeClass('hidden');
    })
    // CANCEL USER CREATIONS AND COLSE MODAL, SHOW USER LIST AND INFORMATION
    $('#cancelUserCreation').on('click', function() {
        $('#txtemail').val('');
        $('#txtpass').val('');
        $('#users').removeClass('hidden');
        $('.collapsableFormContainer').addClass('hidden');
    })
</script>


<style>
    .checkbox-wrapper-1 *,
    .checkbox-wrapper-1 ::after,
    .checkbox-wrapper-1 ::before {
        box-sizing: border-box;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted {
        margin: 0;
        width: 0;
        height: 0;
        display: inline;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted+label:before {
        content: "";
        display: inline-block;
        vertical-align: top;
        height: 1.15em;
        width: 1.15em;
        margin-right: 0.6em;
        color: rgba(0, 0, 0, 0.275);
        border: solid 0.06em;
        box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em inset, 0 0 0 0.07em transparent inset;
        border-radius: 0.2em;
        background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xml:space="preserve" fill="white" viewBox="0 0 9 9"><rect x="0" y="4.3" transform="matrix(-0.707 -0.7072 0.7072 -0.707 0.5891 10.4702)" width="4.3" height="1.6" /><rect x="2.2" y="2.9" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 12.1877 2.9833)" width="6.1" height="1.7" /></svg>') no-repeat center, white;
        background-size: 0;
        will-change: color, border, background, background-size, box-shadow;
        transform: translate3d(0, 0, 0);
        transition: color 0.1s, border 0.1s, background 0.15s, box-shadow 0.1s;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:enabled:active+label:before,
    .checkbox-wrapper-1 [type=checkbox].substituted:enabled+label:active:before {
        box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset;
        background-color: #f0f0f0;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:checked+label:before {
        background-color: #3B99FC;
        background-size: 0.75em;
        color: rgba(0, 0, 0, 0.075);
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:checked:enabled:active+label:before,
    .checkbox-wrapper-1 [type=checkbox].substituted:checked:enabled+label:active:before {
        background-color: #0a7ffb;
        color: rgba(0, 0, 0, 0.275);
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:focus+label:before {
        box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset, 0 0 0 3.3px rgba(65, 159, 255, 0.55), 0 0 0 5px rgba(65, 159, 255, 0.3);
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:focus:active+label:before,
    .checkbox-wrapper-1 [type=checkbox].substituted:focus+label:active:before {
        box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset, 0 0 0 3.3px rgba(65, 159, 255, 0.55), 0 0 0 5px rgba(65, 159, 255, 0.3);
    }

    .checkbox-wrapper-1 [type=checkbox].substituted:disabled+label:before {
        opacity: 0.5;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted.dark+label:before {
        color: rgba(255, 255, 255, 0.275);
        background-color: #222;
        background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xml:space="preserve" fill="rgba(34, 34, 34, 0.999)" viewBox="0 0 9 9"><rect x="0" y="4.3" transform="matrix(-0.707 -0.7072 0.7072 -0.707 0.5891 10.4702)" width="4.3" height="1.6" /><rect x="2.2" y="2.9" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 12.1877 2.9833)" width="6.1" height="1.7" /></svg>');
    }

    .checkbox-wrapper-1 [type=checkbox].substituted.dark:enabled:active+label:before,
    .checkbox-wrapper-1 [type=checkbox].substituted.dark:enabled+label:active:before {
        background-color: #444;
        box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(255, 255, 255, 0.1) inset;
    }

    .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked+label:before {
        background-color: #a97035;
        color: rgba(255, 255, 255, 0.075);
    }

    .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked:enabled:active+label:before,
    .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked:enabled+label:active:before {
        background-color: #c68035;
        color: rgba(0, 0, 0, 0.275);
    }
</style>

</html>