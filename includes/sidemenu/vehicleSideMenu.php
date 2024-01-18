<div id="vehicleSideMenu" class="sideMenu-s">
    <button id="closeVehicleSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes agregar un nuevo vehículo</p>
    </div>
    <form id="createVehicleForm" style="margin: 15px; height: 100%;">

        <div class="centered-spaced">

            <div style="display: flex;flex-direction: column;justify-content: space-between;">
                <div class="row" >
                    <div class="form-group col-4" >
                        <label for="vehicleCreateType" class="inputLabel"  style="z-index: 9;">Tipo de vehículo</label>
                        <select id="vehicleCreateType" name="vehicleCreateType" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-4" >
                        <label for="vehicleCreateBrand" class="inputLabel" style="z-index: 9;">*Marca</label>
                        <select id="vehicleCreateBrand" name="vehicleCreateBrand" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-4" >
                        <label for="vehicleCreateModel" class="inputLabel"  style="z-index: 9;">Modelo</label>
                        <select id="vehicleCreateModel" name="vehicleCreateModel" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="vehiclecreatePatente" class="inputLabel">*Patente</label>
                        <input <?php echo $disabled; ?> id="vehiclecreatePatente" name="vehiclecreatePatente" type="text" class="form-control input-lg s-Input" />
                    </div>
                    <div class="form-group col-4" >
                        <label for="vehicleCreateOwner" class="inputLabel">Propietario</label>
                        <select id="vehicleCreateOwner" name="vehicleCreateOwner" type="text" class="form-select s-Select-g" style="border: 1px solid gray!important;box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                        <option value=""></option>
                        <option value="1">Propio</option>
                        <option value="0">Externo</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="vehicleCreateCostPerTrip" class="inputLabel">Costo por viaje</label>
                        <input  id="vehicleCreateCostPerTrip" name="vehicleCreateCostPerTrip" type="text" class="form-control input-lg s-Input" value="" />
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
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>


<style>

.select2-container--default .select2-selection--single .select2-selection__rendered {
    
    line-height: 30px !important;
}
.select2-container .select2-selection--single {
    height: 40px !important;
    padding: .375rem 1.75rem .375rem .75rem !important;
    border: 1px solid gray!important;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px!important;
}
.select2-selection__arrow {
    top: -5px!important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 8px!important;
}


#vehicleCreateType-error{
    position: relative;
    top: 70px;
}
#vehicleCreateType .err .selection{
    position: relative;
    top: -10px;
}


</style>