<div id="personalSideMenu-personalDash" class="sideMenu-s">
    <button id="closeUpdatePersonalSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
        <!-- <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P">Aquí puedes modificar un nuevo cliente</p>
        </div> -->


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Detalles</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="events-tab" data-bs-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">Eventos</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active tab-data" id="details" role="tabpanel" aria-labelledby="details-tab">
            <form id="updatePersonal" style="margin: 15px; height: 100%;">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" id="deletePersonalDash" style="border: none; background-color: white;">
                        <img src="../../assets/svg/trash-2.svg" alt="">
                    </button>
                    <button type="button" id="enableEditPersonal" style="border: none;background-color: white;">
                        <img src="../../assets/svg/edit.svg" alt="">
                    </button>
                </div>

                <div class="centered-spaced">

                    <div style="display: flex;flex-direction: column;justify-content: space-between;">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="update_nombrePersonal" class="inputLabel">*Nombre</label>
                                <input readonly disabled <?php echo $disabled; ?> id="update_nombrePersonal" name="update_nombrePersonal" type="text" class="form-control input-lg s-Input" />
                            </div>
                            <div class="form-group col-4">
                                <label for="update_rutPersonal" class="inputLabel">Rut</label>
                                <input readonly disabled id="update_rutPersonal" name="update_rutPersonal" type="text" class="form-control input-lg s-Input" value="" />
                            </div>
                            <div class="form-group col-4">
                                <label for="update_especialidadPersonal" class="inputLabel">*Especialidad</label>
                                <select readonly disabled id="update_especialidadPersonal" name="update_especialidadPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="update_cargoPersonal" class="inputLabel">Cargo</label>
                                <select readonly disabled id="update_cargoPersonal" name="update_cargoPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="update_tipoContratoPersonal" class="inputLabel">Tipo Contrato</label>
                                <select readonly disabled id="update_tipoContratoPersonal" name="update_tipoContratoPersonal" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                    <option value="4">Indefinido</option>
                                    <option value="5">Freelance</option>
                                    <option value="6">Plazo Fijo</option>
                                </select>
                            </div>
                            <div class="form-group col-4" style="margin: 0px !important;">
                                <label for="update_costoMensualPersonal" class="inputLabel">Costo Mensual</label>
                                <input readonly disabled <?php echo $disabled; ?> id="update_costoMensualPersonal" name="update_costoMensualPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                            </div>
                        </div>
                        <!-- <hr /> -->
                        <div class="row">
                            <div class="form-group col-8" style="margin: 0px !important;">
                                <label for="update_correoPersonal" class="inputLabel">Correo Eléctronico</label>
                                <input readonly disabled <?php echo $disabled; ?> id="update_correoPersonal" name="update_correoPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                            </div>
                            <div class="form-group col-4" style="margin: 0px !important;">
                                <label for="update_telefonoPersonal" class="inputLabel">Teléfono</label>
                                <input readonly disabled <?php echo $disabled; ?> id="update_telefonoPersonal" name="update_telefonoPersonal" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                            </div>
                        </div>
                        <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                        <?php endif; ?>
                        <div style="display: none; margin-top: 370px; justify-content:space-between;" id="confirmEditPersonal">

                            <!-- <div style="display: flex; margin-top: 250px; justify-content:space-between;"> -->

                            <button type="button" class="s-Button" style="justify-self: start;" onclick="unsetUpdateFormPersonal()">
                                <p class="s-P">Cancelar</p>
                            </button>
                            <button type="submit" id="updatePersonal" class="s-Button">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <p class="s-P">Guardar</p>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade tab-data" id="events" role="tabpanel" aria-labelledby="events-tab" style="margin: 15px; height: 100%;">
            <table class="s-table" id="eventsPerPersonal_dash">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>