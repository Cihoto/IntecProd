<div id="admUserSideMenu" class="sideMenu-s">
    <button id="closeAdmUserSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <!-- <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>

        <p class="header-P"></p>

    </div> -->
    <div class="collapsableFormContainer hidden">
        <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P">Aquí puedes crear un nuevo usuario</p>
        </div>
        <form id="CreateNewUser">
            <div class="modal-body">
                <div class="row justify-content-center mb-5">
                    <section id="newUserPersonalData">
                        <div class="form-group">
                            <label for="personalSelect">Búscar Técnico</label>
                            <select class="form-select" name="personalSelector" id="personalSelect" aria-label="">
                                <option value=""></option>
                            </select>
                        </div>
                    </section>
                    <hr />
                    <section style="margin-top: 15px;" class="row">
                        <div class="form-group col-md-6 col-10">
                            <label for="clientesEdit">Correo</label>
                            <input type="text" name="email" id="txtemail" placeholder="Correo" class="form-control">
                            <label for="txtemail" id="emailMessage"></label>
                        </div>
                        <div class="form-group col-md-6 col-10">
                            <label for="clientesEdit">Contraseña</label>
                            <input type="password" name="pass" id="txtpass" placeholder="Contraseña" class="form-control">
                            <label for="txtpass" id="passMessage"></label>
                        </div>
                        <p style="font-weight: bolder;">*Los roles de este usuario se asignarán posterior a su creación </p>
                    </section>
                </div>
            </div>

            <div class="modal-footer row" style="justify-content: space-between;">
                <button type="button" id="cancelUserCreation" class="btn btn-danger col-4" data-bs-dismiss="modal">
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" id="addUsuario" class="btn btn-success ml-1 col-4">
                    <span class="d-none d-sm-block">Crear usuario</span>
                </button>
            </div>
        </form>
    </div>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>