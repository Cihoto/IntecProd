<div>
    <div class="col-12 " style="max-height: 800px; overflow-y: scroll;overflow-x: hidden;">
        <div class="row">
            <div class="formHeader" style="margin-left:18px ;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="6" fill="#069B99" />
                </svg>
                <p class="header-P">Asigna el personal para el evento</p>
            </div>
        </div>
        <div class="card-body">
            <div class="--personalContainer-listSelected">
                <div class="--personalListSelector">
                    <div class="searchRow" id="searchRowPersonal" style="margin-bottom: 20px;">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="especialidadPersonalAssigmentFilter" class="inputLabel">*Especialidad</label>
                            <select id="especialidadPersonalAssigmentFilter" name="especialidadPersonalAssigmentFilter" type="text" class="form-select input-lg s-Select">
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
                            <button class="s-Button-w" id="openModalNewFree" style="width: 150px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                    <path d="M9.5 17C13.6421 17 17 13.6421 17 9.5C17 5.35786 13.6421 2 9.5 2C5.35786 2 2 5.35786 2 9.5C2 13.6421 5.35786 17 9.5 17Z" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.5 6.5V12.5" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.5 9.5H12.5" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="s-P-g">Crear técnico</p>
                            </button>
                        </div>
                    </div>

                    <div class="tableContainer">
                        <table id="personalResumeAssigment" class="--mo-active">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rut</th>
                                    <th>Especialidad</th>
                                    <th>Tipo Contrato</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="selected-PersonalSideResume" class="--selectedPersonal">

                    <div class="--sel-personal-header">

                        <div class="d-flex" style="gap: 8px;">
                            <img src="../../assets/svg/backDoubleArrows.svg" class="hideSelectedProds" id="closeSelectedPersonal" onclick="closeSelectedPersonal()">
                            <p>Personal agregado al evento</p>
                        </div>
                    </div>

                    <!-- <p>Personal a disponer</p> -->

                    <div class="--divider-sideSelected"></div>
                    <table id="selectedPersonalSideResume">
                        <thead>
                            <th colspan="2"><p>Nombre</p></th>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <div class="--openSelectedPersonalContainer">
                    <button class="floatingButton" id="openSelectesdPersonal" onclick="openSelectedPersonal()">
                        <p>Agregados</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="projectSave-footer">
    <div class="returnPreviusPage">
        <!-- <button class="s-Button-w" style="width: 170px;">
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
    function openSelectedPersonal() {
        $('#selected-PersonalSideResume').addClass('--mo-active');
        $('#personalResumeAssigment').removeClass('--mo-active');
        $('#openSelectesdPersonal').css('display', 'none');
        $('#searchRowPersonal').css('display', 'none');
    }

    function closeSelectedPersonal() {
        $('#selected-PersonalSideResume').removeClass('--mo-active');
        $('#personalResumeAssigment').addClass('--mo-active');
        $('#openSelectesdPersonal').css('display', 'flex');
        $('#searchRowPersonal').css('display', 'flex');
    }
</script>