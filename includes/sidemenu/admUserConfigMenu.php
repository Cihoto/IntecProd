<div id="admConfigUserSideMenu" class="sideMenu-s">
    <button id="closeAdmConfigUserSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="user-options hiddenScroll">

        <section id="user-options-header" class="--st-head ">

            <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="6" fill="#069B99"></circle>
                </svg>
                <p class="header-P">Aquí puedes ver, editar y crear tus usuarios</p>
            </div>

            <button class="s-Button" id="saveRoles">
                <p class="s-P">Guardar Cambios</p>
            </button>
            <!-- <h4 style="text-align: start;">Configuración de usuario</h4>
         -->
            <!-- <div style="display: flex;justify-content: space-between;position: sticky; top: 0px;">
    </div> -->
        </section>

        <div id="rol-Container" class="hidden" user_id="">

            <div class="adm-container row-direction">
                <section id="user-options-header">
                    <p class="user-config-description" style="text-align: start;">Datos</p>
                </section>
                <div class="user-options-info" style="margin-left: 20px;">

                    <div class="form-group user-item">
                        <div class="col-6">
                            <label for="clientesEditEmail">Correo</label>
                            <input type="text" name="email" id="clientesEditEmail" readonly="readonly" placeholder="Correo" class="form-control">
                        </div>
                    </div>
                    <div class="form-group user-item">
                        <div class="col-6">
                            <label for="txtChangePass">Contraseña</label>
                            <input type="password" name="pass" id="txtChangePass" readonly="readonly" placeholder="Contraseña" class="form-control">
                            <label for="txtpass" id="passMessage"></label>
                        </div>
                        <i style="font-size: 20px; color:green; height: 25px;" class="fa-solid fa-pen-to-square"></i>
                    </div>
                </div>
            </div>
            <div class="adm-container row-direction">
                <section id="user-options-header">
                    <p class="user-config-description" style="text-align: start;">Roles</p>
                </section>
                <div class="user-options-info">
                    <?php if (in_array("1", $rol_id)) : ?>
                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Administrador">
                                    <input type="checkbox" class="rolActivator" value="2" id="checkbox-Administrador" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="row justify-content-center">
                                <p style="margin-left: 35%;margin-top: 10%;font-weight: 600;color: black;font-size: 24px;">
                                    Administrador
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="rol-options-container">
                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Clientes">
                                    <input type="checkbox" class="rolActivator" value="10" id="checkbox-Clientes" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="rol-prop">
                                <p>Clientes</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="checkbox-wrapper-1" style="margin-right: 10px !important;">
                                    <input id="clientesRead" class="substituted" checked disabled type="checkbox" value="10" aria-hidden="true" />
                                    <label for="clientesRead">Leer</label>
                                </div>
                                <div class="checkbox-wrapper-1">
                                    <input id="clientesEdit" class="substituted edit" value="9" type="checkbox" aria-hidden="true" />
                                    <label for="clientesEdit">Editar</label>
                                </div>
                            </div>
                        </div>

                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Personal">
                                    <input type="checkbox" class="rolActivator" value="12" id="checkbox-Personal" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="rol-prop">
                                <p>Personal</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="checkbox-wrapper-1" style="margin-right: 10px !important;">
                                    <input id="personalRead" class="substituted" value="12" checked disabled type="checkbox" aria-hidden="true" />
                                    <label for="personalRead">Leer</label>
                                </div>
                                <div class="checkbox-wrapper-1">
                                    <input id="personalEdit" class="substituted edit" value="11" type="checkbox" aria-hidden="true" />
                                    <label for="personalEdit">Editar</label>
                                </div>
                            </div>
                        </div>
                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Vehiculos">
                                    <input type="checkbox" class="rolActivator" value="14" id="checkbox-Vehiculos" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="rol-prop">
                                <p>Vehículos</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="checkbox-wrapper-1" style="margin-right: 10px !important;">
                                    <input id="vehiculoRead" class="substituted" value="14" checked disabled type="checkbox" aria-hidden="true" />
                                    <label for="vehiculoRead">Leer</label>
                                </div>
                                <div class="checkbox-wrapper-1">
                                    <input id="vehiculoEdit" class="substituted edit" value="13" type="checkbox" aria-hidden="true" />
                                    <label for="vehiculoEdit">Editar</label>
                                </div>
                            </div>
                        </div>

                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Inventario">
                                    <input type="checkbox" class="rolActivator" value="5" id="checkbox-Inventario" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="rol-prop">
                                <p>Inventario</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="checkbox-wrapper-1" style="margin-right: 10px !important;">
                                    <input id="inventarioRead" class="substituted" value="5" checked disabled type="checkbox" aria-hidden="true" />
                                    <label for="inventarioRead">Leer</label>
                                </div>
                                <div class="checkbox-wrapper-1">
                                    <input id="inventarioEdit" class="substituted edit" value="6" type="checkbox" aria-hidden="true" />
                                    <label for="inventarioEdit">Editar</label>
                                </div>
                            </div>
                        </div>

                        <div class="rol-item-container">
                            <div class="checkbox-wrapper-22">
                                <label class="switch" for="checkbox-Eventos">
                                    <input type="checkbox" class="rolActivator" value="8" id="checkbox-Eventos" />
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="    ">
                                <p>Eventos</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="checkbox-wrapper-1" style="margin-right: 10px !important;">
                                    <input id="eventosRead" class="substituted" value="8" checked disabled type="checkbox" aria-hidden="true" />
                                    <label for="eventosRead">Leer</label>
                                </div>
                                <div class="checkbox-wrapper-1">
                                    <input id="eventosEdit" class="substituted edit" value="7" type="checkbox" aria-hidden="true" />
                                    <label for="eventosEdit">Editar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="adm-container row-direction">
                <section id="user-options-header">
                    <p class="user-config-description" style="text-align: start;">Eliminar usuario</p>
                </section>
                <div class="user-options-info" style="margin: 10px 0px; ">
                    <div class="action-box-delete" id="delete-user">
                        <i class="fa-solid fa-user-minus"></i>
                    </div>
                    <p style="line-height: normal;text-align: start;margin-top: 15px!important;"> Esta acción eliminará de forma permanente al usuario seleccionado, sin embargo este puede ser creado nuevamente en caso de ser requerido</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>


<style>
    .--st-head{
        position: sticky;
        display: flex;
        flex-direction: row;
        padding: 0px 10px 20px 10px; 
        top: 0px;
        background-color: white;
        z-index: 1000;
    }
</style>