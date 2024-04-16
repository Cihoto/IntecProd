<div id="vehicleInfoSideMenu" class="sideMenu-s">
    <button id="closeVehicleInfoSideMenu" style="border: none;background-color: none;padding: 30px;">
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
            <form id="createVehicleForm" style="margin: 15px; height: 100%;">

                <div class="col-12 d-flex justify-content-end">
                    <button type="button" id="deleteVehicleDash" style="border: none; background-color: white;">
                        <img src="../../assets/svg/trash-2.svg" alt="">
                    </button>
                    <button type="button" id="enableEditPersonal" style="border: none;background-color: white;">
                        <img src="../../assets/svg/edit.svg" alt="">
                    </button>
                </div>

                <div class="centered-spaced">

                    <div style="display: flex;flex-direction: column;justify-content: space-between;">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="vehicleUpdateType" class="inputLabel" style="z-index: 9;">Tipo de vehículo</label>
                                <select id="vehicleUpdateType" name="vehicleUpdateType" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="vehicleUpdateBrand" class="inputLabel" style="z-index: 9;">*Marca</label>
                                <select id="vehicleUpdateBrand" name="vehicleUpdateBrand" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="vehicleUpdateModel" class="inputLabel" style="z-index: 9;">Modelo</label>
                                <select id="vehicleUpdateModel" name="vehicleUpdateModel" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="vehicleUpdatePatente" class="inputLabel">*Patente</label>
                                <input <?php echo $disabled; ?> id="vehicleUpdatePatente" name="vehicleUpdatePatente" type="text" class="form-control input-lg s-Input" />
                            </div>
                            <div class="form-group col-4">
                                <label for="vehicleUpdateOwner" class="inputLabel">Propietario</label>
                                <select id="vehicleUpdateOwner" name="vehicleUpdateOwner" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                                    <option value=""></option>
                                    <option value="1">Propio</option>
                                    <option value="0">Externo</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="vehicleUpdateCostPerTrip" class="inputLabel">Costo por viaje</label>
                                <input id="vehicleUpdateCostPerTrip" name="vehicleUpdateCostPerTrip" type="text" class="form-control input-lg s-Input" value="" />
                            </div>
                        </div>
                        <?php if (in_array("7", $rol_id) || in_array("1", $rol_id) || in_array("2", $rol_id)) : ?>
                        <?php endif; ?>
                        <div style="display: flex; margin-top: 520px; justify-content:space-between;">

                            <!-- <div style="display: flex; margin-top: 250px; justify-content:space-between;"> -->

                            <button type="button" class="s-Button" style="justify-self: start;" onclick="resetClientForm()">
                                <p class="s-P">Limpiar Formulario</p>
                            </button>
                            <button type="submit" id="addVehicle" class="s-Button">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <p class="s-P">Guardar</p>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade tab-data" id="events" role="tabpanel" aria-labelledby="events-tab" style=" height: 100%;">
            <div style="display: flex;">
                <table class="s-table" id="eventsPerVehicle_dash">
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
    </div>

    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>