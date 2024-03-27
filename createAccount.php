<!DOCTYPE html>
<html lang="en">
<?php require_once('./includes/head.php'); ?>

<body style="background-color: white;">


    <div class="--page-content">


        <div class="row p-2">
            <div class="col-12 d-flex justify-content-center">
                <img style="min-height: 40px;" src="./assets/images/logo/intecMainLogo.png" alt="" height="180">
            </div>
            <div class="col-lg-12 col-12">
                <form action="" id="createAccount">
                    <div class="d-flex" style="width: 100%; margin-top: 35px;">
                        <div class="txtDivider">
                            <p style="width: 190px;font-weight: 600;color:#069B99;">Datos de empresa</p>
                        </div>
                    </div>
                    <div class="row  -jcc">
                        <div class="form-group col-12 col-md-6">
                            <label for="c-acc-fan-name" class="inputLabel">*Nombre fantasía</label>
                            <input id="c-acc-fan-name" name="c-acc-fan-name" type="text" class="form-control input-lg s-Input" />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="c-acc-ra-soc" class="inputLabel">Razón Social</label>
                            <input id="c-acc-ra-soc" name="c-acc-ra-soc" type="text" class="form-control input-lg s-Input" />
                        </div>
                    </div>
                    <div class="row -jcc">
                        <div class="form-group col-12 col-lg-5">
                            <label for="c-acc-rut" class="inputLabel">Rut</label>
                            <input id="c-acc-rut" name="c-acc-rut" type="text" class="form-control input-lg s-Input" />
                        </div>
                        <div class="form-group col-12 col-lg-7">
                            <label for="c-acc-addr" class="inputLabel">Dirección</label>
                            <input id="c-acc-addr" name="c-acc-addr" type="text" class="form-control input-lg s-Input" />
                        </div>
                    </div>

                    <div class="d-flex" style="width: 100%; margin-top: 35px;">
                        <div class="txtDivider">
                            <p style="width: 190px;font-weight: 600;color:#069B99;">Datos de usuario</p>
                        </div>
                    </div>

                    <div class="row -jcs">
                        <div class="form-group col-8">
                            <label for="c-acc-email" class="inputLabel">Correo</label>
                            <input id="c-acc-email" name="c-acc-email" type="text" class="form-control input-lg s-Input" />
                        </div>
                    </div>
                    <div class="row -jcs-b">
                        <div class="col-12 col-lg-6">
                            <div class="form-group col-12">
                                <label for="c-acc-pass" class="inputLabel">Contraseña</label>
                                <input id="c-acc-pass" name="c-acc-pass" type="password" class="form-control input-lg s-Input -ps-conf" />
                            </div>
                            <div id="passConfProperties" class="d-flex" style="color: red;margin-top: 10px;">
                                <div class="passPropertiesContainer">
                                    <p class="passProperty charLength">Debe tener mínimo 6 caracteres</p>
                                </div>
                                <div class="passPropertiesContainer">
                                    <p class="passProperty upperLength">Al menos una letra en mayúscula</p>
                                </div>
                                <div class="passPropertiesContainer">
                                    <p class="passProperty numberLength">Al menos 1 número</p>
                                </div>
                                <div class="passPropertiesContainer">
                                    <p class="passProperty specCharLength">Al menos un caracter especial (* ' # % & @ ,etc.)</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-lg-6">
                            <label for="c-acc-conf-pass" class="inputLabel">Contraseña</label>
                            <input id="c-acc-conf-pass" name="c-acc-conf-pass" type="password" class="form-control input-lg s-Input -ps-conf" />
                            <div id="passConfErrMessage" class="d-flex" style="color: red;margin-top: 10px;">
                                <i class="fa-solid fa-xmark"></i>
                                <p style="margin: 0px 10px!important;line-height: 16px;">Las contraseñas no coinciden</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end" style="margin-right: 0px; margin-top: 40px;">
                        <button class="s-Button-w changeInvertHover" style="width: 150px;" id="addAllSubCategories">
                            <p class="s-P-g">Crear cuenta</p>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php require_once('./includes/footer.php') ?>
    <?php require_once('./includes/footerScriptsJs.php') ?>
    <script src="./js/createAccount.js"></script>
    <script src="./js/validateForm/createAccount.js"></script>
    <script src="./js/valuesValidator/rutValidator.js"></script>
</body>

<script>


    $('#c-acc-rut').on('keyup',async function(e){
        const rut = document.getElementById('c-acc-rut');

        if (e.target === rut) {
            let rutFormateado = darFormatoRUT(rut.value);
            rut.value = rutFormateado;
        }
    })



    $('.-ps-conf').on('keyup', function(event) {
        const pass = $('#c-acc-pass').val();
        const passConfirm = $('#c-acc-conf-pass').val();

        if (/^[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/.test(event.key)) {


            checkPassProperties(pass)
        }
    })

    $('#c-acc-conf-pass').on('blur', function() {
        checkPassword();
    });

    function checkPassword() {
        if ($('#c-acc-pass').val() !== $('#c-acc-conf-pass').val()) {
            $('#passConfErrMessage').css('visibility', 'visible');
            return false;
        }
        $('#passConfErrMessage').css('visibility', 'hidden');
        return true;
    }

    function checkPassProperties(pass) {

        let mayusculas = 0;
        let minusculas = 0;
        let numeros = 0;
        let especiales = 0;
        // Recorrer cada carácter de la contraseña
        for (let i = 0; i < pass.length; i++) {
            const caracter = pass.charAt(i);

            // Verificar el tipo de carácter
            if (/[A-Z]/.test(caracter)) {
                mayusculas++;
            } else if (/[a-z]/.test(caracter)) {
                minusculas++;
            } else if (/\d/.test(caracter)) {
                numeros++;
            } else {
                especiales++;
            }
        }

        if ((pass.length) >= 6) {
            $('.charLength').addClass('active');
        } else {
            $('.charLength').removeClass('active');
        }

        if (minusculas >= 1) {
            $('.letterLength').addClass('active');
        } else {
            $('.letterLength').removeClass('active');
        }
        if (mayusculas >= 1) {
            $('.upperLength').addClass('active');
        } else {
            $('.upperLength').removeClass('active');
        }
        if (pass.toString().match(/[0-9]/g) || [].length >= 1) {
            $('.numberLength').addClass('active');
        } else {
            $('.numberLength').removeClass('active');
        }
        const isContainsSymbol = /^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).*$/;
        if (isContainsSymbol.test(pass)) {
            $('.specCharLength').addClass('active');
        } else {
            $('.specCharLength').removeClass('active');
        }
        // if (pass.search(/[0-9]/) >= 1) {
        //     $('.numberLength').css("color", 'green');
        // }
    }
</script>

</html>

<style>
    #passConfProperties {
        display: flex;
        flex-direction: column;
        align-items: start;
        gap: 4px;
    }

    .passPropertiesContainer {
        display: flex;

    }

    .passProperty {
        margin: 0px 10px !important;
        line-height: normal;
        font-size: 12px;
        color: grey;
    }

    .passProperty.active {
        font-weight: 600;
        color: green;
    }

    #passConfErrMessage {
        visibility: hidden;
    }

    .--page-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        /* background-color: red; */
    }

    .-jcc {
        justify-content: center;
    }

    .-jcs {
        justify-content: start;
    }

    .-jcs-b {
        justify-content: space-between;
    }

    input.error {
        border: 1px solid red;
    }

    label.error {
        color: red;
    }
</style>