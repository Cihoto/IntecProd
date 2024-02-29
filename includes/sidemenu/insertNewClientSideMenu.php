<div id="createNewClientSideMenu" class="sideMenu-s">
    <button id="closeCreateNewClientSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>

        <p class="header-P">Aquí puedes agregar un nuevo cliente</p>

    </div>
    <form id="createNewClient" style="margin: 15px; height: 70%;display: flex;justify-content: space-between;flex-direction: column;" >
            <div style="display: flex;justify-content: space-between; flex-direction: column;">
                <div style="display: flex;flex-direction: column;justify-content: space-between; margin-top: 30px;">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="form-group col-md-7 col-11 ">
                            <label for="clientNameorDesc" class="inputLabel">*Nombre o descripción</label>
                            <input id="clientNameorDesc" name="clientNameorDesc" type="text" class="form-control input-lg s-Input" />
                        </div>
                        <div class="form-group col-md-5 col-11">
                            <label for="clientRazonSocial" class="inputLabel">*Razón Social</label>
                            <input id="clientRazonSocial" name="clientRazonSocial" type="text" class="form-control input-lg s-Input" value="" />
                        </div>
                        <div class="form-group col-md-7 col-11" style="margin: 0px !important;">
                            <label for="clientRut" class="inputLabel">*Rut</label>
                            <input id="clientRut" name="clientRut" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                        </div>
                    </div>
                    <hr />
                    <div class="row" style="margin-top: 10px;">
                        <div class="form-group col-md-7 col-11">
                            <label for="clientContacto" class="inputLabel">*Contacto</label>
                            <input id="clientContacto" name="clientContacto" type="text" class="form-control input-lg s-Input" />
                        </div>
                        <div class="form-group col-md-5 col-11">
                            <label for="clientCorreo" class="inputLabel">*Correo</label>
                            <input id="clientCorreo" name="clientCorreo" type="text" class="form-control input-lg s-Input" value="" />
                        </div>
                        <div class="form-group col-md-7 col-11" style="margin: 0px !important;">
                            <label for="clientTelefono" class="inputLabel">*Teléfono</label>
                            <input id="clientTelefono" name="clientTelefono" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                        </div>
                    </div>
                </div>
            </div>
            <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                    <div style="display: flex;align-items: end;justify-content: start;margin-top: 10px;">
                        <button type="submit" id="addCliente" class="s-Button">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <p class="s-P">Guardar</p>
                        </button>
                    </div>
                <?php endif; ?>

    </form>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>

