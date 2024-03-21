<div class="dragableItems">
    <div class="formHeader" style="align-items: center!important; margin-left: 13px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99"></circle>
        </svg>
        <p class="header-P" style="margin-top: -3px;">Productos seleccionados</p>
    </div>
    <div id="selectedProdsPreview">

    <!-- SAMPLE CODE FOR SELECTED PRODUCT TABLE ON PRODUCT SELECTOR -->
        <!-- <div class="-t-container">
            <p class="--catName-SelProd">VIDEO</p>

            <table class="--t-sel-prod">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cant.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p>123123</p>
                                </td>
                                <td><input type="number" name="" id="" class=""></td>
                                <td><img src="../../assets/svg/trashCan-red.svg" alt=""></td>
                            </tr>
                        </tbody>
                    </table>
        </div> -->
    </div>
    <div class="row">
        <div class="notSelectedProd moveProd" id="selectableProducts">
        <!-- SELECTED PACKAGE DELETED SECTION -->
            <!-- <div class="row" style="min-height: 150px; max-height: 150px; overflow: scroll;width: 100%; margin: 20px 0px;overflow-x: hidden;">
                <table id="standardPackagesList">
                    <thead>
                        <th>Nombre</th>
                        <th></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div> -->



            <div id="itemList">
                <table id="tableProducts">
                    <thead>
                        <th>Categoría</th>
                        <th>Sub Categoría</th>
                        <th class="itemProd">Nombre</th>
                        <th>Cantidad</th>
                        <th>Disponibles</th>
                        <th>Agregar</th>
                    </thead>
                    <tbody id="tableDrop">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="projectSave-footer">
        <div class="returnPreviusPage">
            <button class="s-Button-w" style="width: 170px;">
                <p class="s-P-g">Guardar Borrador</p>
            </button>
        </div>

        <div class="saveProject">
            <button class="s-Button createOrContinue" id="" style="width: 170px;">
                <p class="s-P">guardar</p>
            </button>

        </div>
    </div>
</div>