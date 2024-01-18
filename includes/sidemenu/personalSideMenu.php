<div id="personaSideMenu" class="sideMenu-s">
    <button id="closePersonalSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes agregar un nuevo técnico</p>
    </div>
    <form id="sidePersonalForm" style="margin: 15px; height: 100%;">

        <div class="centered-spaced">

            <div style="display: flex;flex-direction: column;justify-content: space-between;">
                <div class="row" >
                    <div class="form-group col-8">
                        <label for="nombrePersonal" class="inputLabel">*Nombre</label>
                        <input <?php echo $disabled; ?> id="nombrePersonal" name="nombrePersonal" type="text" class="form-control input-lg s-Input" />
                    </div>
                    <div class="form-group col-4">
                        <label for="rutPersonal" class="inputLabel">Rut</label>
                        <input  id="rutPersonal" name="rutPersonal" type="text" class="form-control input-lg s-Input" value="" />
                    </div>
                    <div class="form-group col-4" >
                        <label for="especialidadPersonal" class="inputLabel">*Especialidad</label>
                        <select id="especialidadPersonal" name="especialidadPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-4" >
                        <label for="cargoPersonal" class="inputLabel">Cargo</label>
                        <select id="cargoPersonal" name="cargoPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-4" >
                        <label for="tipoContratoPersonal" class="inputLabel">Tipo Contrato</label>
                        <select id="tipoContratoPersonal" name="tipoContratoPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        <option value="4">Indefinido</option>
                        <option value="5">Freelance</option>
                        <option value="6">Plazo Fijo</option>
                        </select>
                    </div>
                    <div class="form-group col-4" style="margin: 0px !important;">
                        <label for="costoMensualPersonal" class="inputLabel">Costo Mensual</label>
                        <input <?php echo $disabled; ?> id="costoMensualPersonal" name="costoMensualPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                    </div>
                </div>
                <!-- <hr /> -->
                <div class="row">
                    <div class="form-group col-8" style="margin: 0px !important;">
                        <label for="correoPersonal" class="inputLabel">Correo Eléctronico</label>
                        <input <?php echo $disabled; ?> id="correoPersonal" name="correoPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                    </div>
                    <div class="form-group col-4" style="margin: 0px !important;">
                        <label for="telefonoPersonal" class="inputLabel">Teléfono</label>
                        <input <?php echo $disabled; ?> id="telefonoPersonal" name="telefonoPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                    </div>
                </div>
                <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                <?php endif; ?>
                    <div style="display: flex; margin-top: 350px; justify-content:space-between;">

                        <!-- <div style="display: flex; margin-top: 250px; justify-content:space-between;"> -->

                            <button type="button" class="s-Button" style="justify-self: start;" onclick="resetClientForm()">
                                <p class="s-P">Limpiar Formulario</p>
                            </button>
                            <button type="submit" id="addPersonal" class="s-Button">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <p class="s-P">Guardar</p>
                            </button>
                        </div>
                </div>
            </div>
    </form>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>