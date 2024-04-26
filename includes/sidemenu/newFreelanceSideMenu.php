<div id="newFreelanceSideMenu" class="sideMenu-s">
    <button id="closeNewFreelanceSideMenu" class="sideMenuCloseButton" onclick="closeFreelanceSideMenu()">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes agregar un nuevo técnico freelance</p>
    </div>
    <form id="addNewFreeLanceSideMenuForm" style="padding: 16px;">
        <div class="d-flex" style="flex-direction: column; width: 100%;">
            <div class="row">
                <div style="display: flex;
                                align-items: flex-start;
                                gap: 20px;">
                    <div class="form-group">
                        <label class="inputLabel">Tipo de contrato</label>
                        <input type="text" class="form-control input-lg s-Input" readonly value="Freelance" />
                    </div>
                    <div class="form-group">
                        <label for="especialidadSelect" class="inputLabel">*Especialidad</label>
                        <select id="especialidadSelect" name="especialidadSelect" type="text" class="form-select input-lg s-Select">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-8 col-12">
                    <label for="nombreInput" class="inputLabel">*Nombre</label>
                    <input id="nombreInput" name="nombreInput" type="text" class="form-control input-lg s-Input" />
                </div>
                <div class="form-group col-lg-4 col-12">
                    <label for="rutInput" class="inputLabel">*Rut</label>
                    <input id="rutInput" name="rutInput" type="text" class="form-control input-lg s-Input shortFree" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-8 col-12">
                    <label for="correoInput" class="inputLabel">*Correo electrónico</label>
                    <input id="correoInput" name="correoInput" type="text" class="form-control input-lg s-Input" />
                </div>
                <div class="form-group col-lg-4 col-12">
                    <label for="telefonoInput" class="inputLabel">*Teléfono</label>
                    <input id="telefonoInput" name="telefonoInput" type="text" class="form-control input-lg s-Input shortFree" />
                </div>
            </div>
        </div>

        <!-- <input type="submit"  id="createNewFreeLance" value="alskdjlaksjd"> -->
        
            <div class="row" style="justify-content: end;">
                    <button class="s-Button col-3" id="triggerNewFreeLance">
                        <p class="s-P">Crear Nuevo Técnico</p>
                    </button>
            </div>

    </form>

    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>