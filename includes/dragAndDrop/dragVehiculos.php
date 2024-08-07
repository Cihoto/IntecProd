<div class="">
    <!-- vvv demo reminder hidden by default and show and append button when client has no own data vvv-->
    <div class="--demo-btn-container" id='vehReminder'>
    </div>
    <!-- ^^^^ do not remove ^^^^ -->
    <div class=" col-12" style="max-height: 350px; overflow-y: scroll;overflow-x: hidden; scrollbar-width: none;flex-direction: column; " id="veaLCtn">
        <div>
            <div class="formHeader" style="margin-left:18px ;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="6" fill="#069B99" />
                </svg>
                <p class="header-P">Asigna vehículos al evento</p>
            </div>
        </div>
        <!-- <div class="card-body" id="DragVehiculos"> -->
        <!-- <div class="serachInputDrag">
                <label for="searchInputVehiculo">Búscar Vehiculos:</label>
                <input type="text" name="" oninput="searchVehiculoDrag()" id="searchInputVehiculo">
            </div> -->

        <section id="vehicles-Assigment-section">
            <div id="selected-AllVehiclesResume" class="--mo-active">
                <div class="searchRow --mo-active" id="searchRowVehicles" style="margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <label for="vehicleTypeVlist" class="inputLabel">*Tipo Vehículo</label>
                        <select onchange="filterVehiclesTable(this.value)" id="vehicleTypeVlist" name="vehicleTypeVlist" type="text" class="form-select input-lg s-Select">
                            <option value="all">Todos</option>
                        </select>
                    </div>
                    <!-- <div class="d-flex" style="align-items: end;">
                            <div style="margin-right: 8px;">
                            </div>
                            <button class="s-Button-w">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                    <path d="M17 2.75H2L8 9.845V14.75L11 16.25V9.845L17 2.75Z" stroke="#069B99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="s-P-g">Filtros</p>
                            </button>
                        </div> -->
                    <div>
                        <button class="s-Button-w" id="openModalNewFree" style="width: 155px;" onclick="openVehicleSideMenu()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                <path d="M9.5 17C13.6421 17 17 13.6421 17 9.5C17 5.35786 13.6421 2 9.5 2C5.35786 2 2 5.35786 2 9.5C2 13.6421 5.35786 17 9.5 17Z" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.5 6.5V12.5" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6.5 9.5H12.5" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="s-P-g">Crear Vehículo</p>
                        </button>
                    </div>
                </div>
                <table id="allVehiclesTable">
                    <thead>
                        <tr>
                            <th>
                                Tipo
                            </th>
                            <th>
                                Propietario
                            </th>
                            <th>
                                Patente
                            </th>
                            <th>
                                CostoViaje
                            </th>
                            <th>
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>

            <div id="selected-vehiclesSideResume">

                <div class="--selectedVehiclesHeader">
                    <div class="d-flex" style="gap: 8px;">
                        <img src="../../assets/svg/backDoubleArrows.svg" class="hideSelectedProds" id="closeSelectedVehicles" onclick="closeSelectedVehicles()">
                        <p>Vehículos agregados al evento</p>
                    </div>
                </div>
                <p class="--addElementHeader">Vehículos a disponer</p>
                <table id="selectedVehiculoSideResume">
                    <thead>
                        <th><p>Tipo</p></th>
                        <th><p>Patente</p></th>
                        <th></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="--openSelectedPersonalContainer">
                <button class="floatingButton --mo-hide" id="openSelectedVehicles" onclick="openSelectedVehicles()">
                    <p>Agregados</p>
                </button>
            </div>
        </section>
        <!-- </div> -->
    </div>
</div>
<div class="projectSave-footer">
    <div class="returnPreviusPage">
        <!-- <button class="s-Button-w" style="width: 170px;" id="saveDraft">
            <p class="s-P-g">Guardar Borrador</p>
        </button> -->
    </div>

    <div class="saveProject --mo-hide-ev-save">
        <button class="s-Button createOrContinue" id="" style="width: 170px;">
            <p class="s-P">guardar</p>
        </button>
    </div>
</div>

<script>
    function openSelectedVehicles() {
        $('#selected-vehiclesSideResume').addClass('--mo-active');
        $('#selected-AllVehiclesResume').removeClass('--mo-active');
        $('#openSelectedVehicles').removeClass('--mo-active');
        // $('#openSelectedVehicles').removeClass('--mo-active');
    }

    function closeSelectedVehicles() {
        $('#selected-vehiclesSideResume').removeClass('--mo-active');
        $('#selected-AllVehiclesResume').addClass('--mo-active');
        $('#openSelectedVehicles').addClass('--mo-active');
    }
</script>