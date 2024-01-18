<div id="clientSideMenu-clientDash" class="sideMenu-s">
    <button id="closeDashClientSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes agregar un nuevo cliente</p>
    </div>


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
            <form id="updateClient" style="margin: 15px; height: 100%;">
                <div class="centered-spaced">
                    <div class="col-12 d-flex justify-content-between" >
                        <button type="button" id="deleteClientDash" style="border: none; background-color: white;">
                            <img src="../../assets/svg/trash-2.svg" alt="">
                        </button>
                        <button type="button" id="enableEditClient" style="border: none;background-color: white;">
                            <img src="../../assets/svg/edit.svg" alt="">
                        </button>
                    </div>
                    <div style="display: flex;flex-direction: column;justify-content: space-between;">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="form-group col-7">
                                <label for="clientNameorDesc-dash" class="inputLabel">*Nombre o descripción</label>
                                <input readonly disabled id="clientNameorDesc-dash" name="clientNameorDesc-dash" type="text" class="form-control input-lg s-Input" />
                            </div>
                            <div class="form-group col-5">
                                <label for="clientRazonSocial-dash" class="inputLabel">*Razón Social</label>
                                <input readonly disabled id="clientRazonSocial-dash" name="clientRazonSocial-dash" type="text" class="form-control input-lg s-Input" value="" />
                            </div>
                            <div class="form-group col-7" style="margin: 0px !important;">
                                <label for="clientRut-dash" class="inputLabel">*Rut</label>
                                <input readonly disabled id="clientRut-dash" name="clientRut-dash" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                            </div>
                        </div>
                        <hr />
                        <div class="row" style="margin-top: 10px;">
                            <div class="form-group col-7">
                                <label for="clientContacto-dash" class="inputLabel">*Contacto</label>
                                <input readonly disabled id="clientContacto-dash" name="clientContacto-dash" type="text" class="form-control input-lg s-Input" />
                            </div>
                            <div class="form-group col-5">
                                <label for="clientCorreo-dash" class="inputLabel">*Correo</label>
                                <input readonly disabled id="clientCorreo-dash" name="clientCorreo-dash" type="text" class="form-control input-lg s-Input" value="" />
                            </div>
                            <div class="form-group col-7" style="margin: 0px !important;">
                                <label for="clientTelefono-dash" class="inputLabel">*Teléfono</label>
                                <input readonly disabled id="clientTelefono-dash" name="clientTelefono-dash" type="text" class="form-control input-lg s-Input" value="" style="margin-right: 0px!important;" />
                            </div>
                        </div>
                        <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                            <div style="margin-top: 270px; justify-content:space-between;display: none;" id="editConfirmClient">
                                <button type="button" class="s-Button" style="justify-self: start;" onclick="cancelEdit()">
                                    <p class="s-P">Cancelar</p>
                                </button>
                                <button type="submit" class="s-Button">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <p class="s-P">Guardar</p>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade tab-data" id="events" role="tabpanel" aria-labelledby="events-tab" style="margin: 15px; height: 100%;">>
            <table class="s-table" id="eventsPerClient_dash">
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