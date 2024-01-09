<div id="providerSideMenu" class="sideMenu-s">
    <button onclick="resetPoroviderForm()" id="closeProviderSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes agregar un nuevo Proveedor</p>
    </div>
    <form id="sideProviderForm" style="margin: 15px; height: 100%;">
        <div class="centered-spaced">
            <div style="display: flex;flex-direction: column;justify-content: space-between;">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-7">
                        <label for="providerNameorDesc" class="inputLabel">*Nombre o descripción</label>
                        <input <?php echo $disabled; ?> id="providerNameorDesc" name="providerNameorDesc" type="text" class="form-control input-lg s-Input" />
                    </div>
                    <div class="form-group col-5">
                        <label for="providerRazonSocial" class="inputLabel">*Razón Social</label>
                        <input <?php echo $disabled; ?> id="providerRazonSocial" name="providerRazonSocial" type="text" class="form-control input-lg s-Input" value="" />
                    </div>
                    <div class="form-group col-7" style="margin: 0px !important;">
                        <label for="providerRut" class="inputLabel">*Rut</label>
                        <input <?php echo $disabled; ?> id="providerRut" name="providerRut" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                    </div>
                </div>
                <hr />
                <div class="row" style="margin-top: 10px;">
                    <div class="form-group col-7">
                        <label for="providerContacto" class="inputLabel">*Contacto</label>
                        <input <?php echo $disabled; ?> id="providerContacto" name="providerContacto" type="text" class="form-control input-lg s-Input" />
                    </div>
                    <div class="form-group col-5">
                        <label for="providerCorreo" class="inputLabel">*Correo</label>
                        <input <?php echo $disabled; ?> id="providerCorreo" name="providerCorreo" type="text" class="form-control input-lg s-Input" value="" />
                    </div>
                    <div class="form-group col-7" style="margin: 0px !important;">
                        <label for="providerTelefono" class="inputLabel">*Teléfono</label>
                        <input <?php echo $disabled; ?> id="providerTelefono" name="providerTelefono" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                    </div>
                </div>
                <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                    <div style="display: flex; margin-top: 250px; justify-content:space-between;">
                        <button type="button" class="s-Button" style="justify-self: start;" onclick="resetPoroviderForm()">
                            <p class="s-P">Limpiar Formulario</p>
                        </button>
                        <button type="submit" id="addProvider" class="s-Button">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <p class="s-P">Guardar</p>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>