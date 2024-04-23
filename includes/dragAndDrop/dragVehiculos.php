<div class="">

    <div class=" col-12" style="max-height: 350px; overflow-y: scroll;overflow-x: hidden; scrollbar-width: none; ">
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

                <div id="selected-AllVehiclesResume">
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

                <div id="selected-vehiclesSideResume" class="--mo-active">

                    <div class="--selectedVehiclesHeader">
                        <div class="d-flex" style="gap: 8px;">
                            <img src="../../assets/svg/backDoubleArrows.svg" class="hideSelectedProds" id="closeSelectedVehicles" onclick="closeSelectedVehicles()">
                            <p>Vehículos agregados al evento</p>
                        </div>
                    </div>
                    <p class="--addElementHeader" >Vehículos a disponer</p>
                    <table id="selectedVehiculoSideResume">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <thead>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="--openSelectedPersonalContainer">
                    <button class="floatingButton" id="openSelectedVehicles" onclick="openSelectedVehicles()">
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

    <div class="saveProject">
        <button class="s-Button createOrContinue" id="" style="width: 170px;">
            <p class="s-P">guardar</p>
        </button>
    </div>
</div>

<script>

    function openSelectedVehicles(){
        $('#selected-vehiclesSideResume').addClass('--mo-active');
        $('#selected-AllVehiclesResume').removeClass('--mo-active');
        $('#openSelectedVehicles').css('display','none');
    }
    function closeSelectedVehicles(){
        $('#selected-vehiclesSideResume').removeClass('--mo-active');
        $('#selected-AllVehiclesResume').addClass('--mo-active');
        $('#openSelectedVehicles').css('display','flex');
    }
</script>