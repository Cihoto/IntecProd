<div class="dragableItems">
    <div class="--prodListContainer">
        <div id="productListResponsiveHeader">
            <div class="--search-container">
                <div class="form-group --mb-0 --top">
                    <label for="dashIndexInput" class="inputLabel">Buscar</label>
                    <input id="dashIndexInput" name="dashIndexInput" type="text" onkeyup="filterInventiryTable(this.value)" class="form-control input-lg s-Input prodSearchBar" value="">
                </div>
                <img src="./assets/svg/searchLent.svg" alt="" style="margin-top: 15px;">
            </div>
            <button id="openSelectedProdsMobile" class="floatingButton">
                <p>Agregados</p>
            </button>
        </div>

        <div class="-prods-table">
            <table id="tableProducts" class="--prodDataTable-ss">
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

        <div class="--selProdContainer">

            <div class="--sel-prod-header">
                <div class="d-flex" style="gap: 8px;">
                    <img src="../../assets/svg/backDoubleArrows.svg" class="hideSelectedProds" id="closeSelectedProducts">
                    <p>Equipos agregados al evento</p>
                </div>
                <!-- <i class="fa-solid fa-x"></i> -->
            </div>

            <table class='itc-table-standard' id="-a-m-SelProds">
                <thead>
                    <tr>
                        <th>
                            <p class="--ts">Elemento</p>
                        </th>
                        <th>
                            <p class="--tc">Cantidad</p>
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr product_id="">
                    <td class="--ts"> <p></p> </td>
                    <td class="--tc"><input type="number" name="" id="" class="selProdQty" min="1"  value=""></td>
                    <td><img src="../../assets/svg/trashCan-red.svg" alt="" class="rmv-sel-prod"></td>
                </tr> -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- <div c lass="notSelectedProd moveProd" id="selectableProducts"> -->
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
    <!-- <div id="itemList">

        </div>
    </div> -->

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
</div>


<script>

    // OPEN OR CLOSE SELECTED PRODS ON MOBILE VERSION

    $('#openSelectedProdsMobile').on('click',function(){
        openSelectedProdsMobile()
    });
    $('#closeSelectedProducts').on('click',function(){
        closeSelectedProdsMobile()
    });
    
    
    function openSelectedProdsMobile(){
        $('.--selProdContainer').addClass('--mo-active');
        $('#tableProducts_wrapper').removeClass('--mo-active');
        // $('#openSelectedProdsMobile').css('display','none');
        $('#productListResponsiveHeader').removeClass('--mo-active')
        // .css('display','none');
    }
    function closeSelectedProdsMobile(){
        $('.--selProdContainer').removeClass('--mo-active');
        $('#tableProducts_wrapper').addClass('--mo-active');
        // $('#openSelectedProdsMobile').css('display','flex');
        $('#productListResponsiveHeader').addClass('--mo-active')
        // $('#productListResponsiveHeader').css('display','flex');
    }


</script>