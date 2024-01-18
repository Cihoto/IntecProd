<div id="especialidadCargoCrud" class="sideMenu-s">
    <button id="closeEspecialidadCargoCrud" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item " role="presentation">
            <a class="nav-link active" id="cargo-tab" data-bs-toggle="tab" href="#cargo" role="tab" aria-controls="cargo" aria-selected="true">
                Crear cargo
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="especialidad-tab" data-bs-toggle="tab" href="#especialidad" role="tab" aria-controls="especialidad" aria-selected="false">
                Crear Especialidad
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent" style="padding: 0px 15px;">
        <div class="tab-pane fade show active tab-data" id="cargo" role="tabpanel" aria-labelledby="cargo-tab">
            <form id="addCategoria">
                <div class="row">
                    <div class="col-12">
                        <label for="CargoName">Nombre del cargo</label>
                        <input type="text" name="CargoName" class="form-control" id="CargoName">
                    </div>
                    <p>Para poder agregar multiples cargos separe los nombres por una coma</p>
                    <p>Ejemplo : Cargo 1 , Cargo 2, Cargo 3</p>
                </div>
            </form>
            <div class="modal-footer">
                <div class="row">
                    <input type="button" class="btn btn-success" id="btnConfirmCargo" value="Agregar">
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <table class="s-table" id="cargo-table-controller">
                    <thead>
                        <tr>
                            <th>Cargo</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>Cargo</td>
                            <td>Eliminar</td>
                        </tr> -->
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>

        </div>
        <div class="tab-pane fade" id="especialidad" role="tabpanel" aria-labelledby="especialidad-tab">
            <form id="addItem">
                <div class="row">
                    <div class="col-12">
                        <label for="especialidadName">Nombre de la Especialidad</label>
                        <input type="text" name="especialidadName" class="form-control" id="especialidadName">
                    </div>
                    <p>Para poder agregar multiples items separe los nombres por una coma</p>
                    <p>Ejemplo : Especialidad 1 , Especialidad 2, Especialidad 3</p>
                </div>
            </form>
            <div class="modal-footer">
                <div class="row">
                    <input type="button" class="btn btn-success" id="btnConfirmEspecialidad" value="Agregar">
                </div>
            </div>
            </form>
            <!-- <table class="s-table" id="esp-table-crud"> -->

            <div class="d-flex justify-content-center mt-3">
                <table class="s-table " id="esp-table-crud">
                    <thead>
                        <tr>
                            <th>Especialidad</th>
                            <th>Eliminar</th>
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
</div>


<style>
    #addCategoria p {
        margin: 0px !important;
        line-height: 24px !important;
        text-align: start;
    }

    #addItem p {
        margin: 0px !important;
        line-height: 24px !important;
        text-align: start;
    }

    #cargo-table-controller tr {
        display: flex;
        padding: var(--none, 0px);
        align-items: center;
        gap: var(--1, 0px);
        border-radius: var(--none, 0px);
        border-top: var(--none, 0px) solid var(--Line-table, #DDDDE1);
        border-right: 1px solid var(--Line-table, #DDDDE1);
        border-bottom: 1px solid var(--Line-table, #DDDDE1);
        border-left: 1px solid var(--Line-table, #DDDDE1);
    }

    #cargo-table-controller thead tr {
        display: flex;
        padding: var(--none, 0px);
        gap: var(--none, 5px);
        align-items: center;
        border-radius: var(--none, 0px);
        border: 1px solid var(--Line-table, #DDDDE1);
        background: var(--Fondo-cyan, #E8F3F3);
    }

    #cargo-table-controller thead th {
        width: 50%;
        display: flex;
        padding: 16px;
        align-items: center;
        flex-shrink: 0;
        border-right: 1px solid var(--Line-table, #DDDDE1);
        background: rgba(0, 0, 0, 0.00);
    }

    #cargo-table-controller tbody tr {
        gap: 5px;
    }

    #cargo-table-controller td {
        width: 12%;
        display: flex;
        padding: 16px;
        align-items: center;
        flex-shrink: 0;
        border-right: 1px solid var(--Line-table, #DDDDE1);
        background: rgba(0, 0, 0, 0.00);
        justify-content: center;
    }







    /* #esp-table-crud tr {
        display: flex;
        padding: var(--none, 0px);
        align-items: center;
        gap: var(--1, 0px);
        border-radius: var(--none, 0px);
        border-top: var(--none, 0px) solid var(--Line-table, #DDDDE1);
        border-right: 1px solid var(--Line-table, #DDDDE1);
        border-bottom: 1px solid var(--Line-table, #DDDDE1);
        border-left: 1px solid var(--Line-table, #DDDDE1);
    } */

    #esp-table-crud{
        width: 70%!important;
    }

    #esp-table-crud thead tr {
        display: flex;
        padding: var(--none, 0px);
        gap: var(--none, 5px);
        align-items: center;
        border-radius: var(--none, 0px);
        /* border: 1px solid var(--Line-table, #DDDDE1); */
        background: var(--Fondo-cyan, #E8F3F3);
    }

    /* #esp-table-crud thead th {
        display: flex;
        padding: 16px;
        align-items: center;
        flex-shrink: 0;
        border-right: 1px solid var(--Line-table, #DDDDE1);
        background: rgba(0, 0, 0, 0.00);
    } */

    #esp-table-crud tbody tr {
        gap: 10px;
    }

    #esp-table-crud td {
        display: flex;
        padding: 16px;
        align-items: center;
        flex-shrink: 0;
        border-right: 1px solid var(--Line-table, #DDDDE1);
        background: rgba(0, 0, 0, 0.00);
        justify-content: center;
    }

    .w-85 {
        width: 67% !important;
    }
    .w-15 {
        width: 16% !important;
    }

    .e-1 {
        width: 50% !important;
    }
    .e-2 {
        width: 31% !important;
    }
</style>