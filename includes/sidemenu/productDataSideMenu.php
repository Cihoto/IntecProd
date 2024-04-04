<div id="productDataSideMenu" class="sideMenu-s">
    <button id="closePordDataSideMenu" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <!-- <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P"
    </div> -->
    <div class="collapsableFormContainer hidden">
        <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P" id="productName"></p>
        </div>
        <form id="updateProductSideMenu">
            <div class="modal-body">
                <div class="row justify-conetent-end">
                    <!-- <div class="col-2">
                        <button class="s-Button-w changeInvertHover" style="width: 100%;margin-top: 10px;" id="">
                            <p>Editar</p>
                        </button>
                    </div> -->
                </div>
                <div class="row justify-content-center mb-5">
                    <section style="margin-top: 15px;" class="row">
                        <div class="form-group col-md-9 col-10">
                            <label for="nomProd">Nombre</label>
                            <input type="text" name="nomProd" id="nomProd" class="form-control">
                        </div>
                        <div class="form-group col-md-3 col-10">
                            <label for="stockProd">Stock</label>
                            <input type="text" name="stockProd" id="stockProd" class="form-control">
                        </div>

                        <div class="col-10 col-lg-6">
                            <div class="row">
                                <div class="form-group col-10">
                                    <label for="catProd" class="inputLabel">Categoría</label>
                                    <select id="catProd" name="catProd" type="text" class="form-select s-Select-g">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-2 d-flex" style="align-content: center;align-items: center;color:#069B99!important; ">
                                    <button class="s-Button-w changeInvertHover" style="width: 100%;margin-top: 10px;" id="">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-lg-6">
                            <div class="row">
                                <div class="form-group col-10">
                                    <label for="subCatProd" class="inputLabel ">Sub categoría</label>
                                    <select id="subCatProd" name="subCatProd" type="text" class="form-select s-Select-g ">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-2 d-flex" style="align-content: center;align-items: center;color:#069B99!important; ">
                                    <button class="s-Button-w changeInvertHover" style="width: 100%;margin-top: 10px;" id="">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-6 col-10">
                                <label for="brandProdUpdate">Marca</label>
                                <input type="text" name="brandProdUpdate" id="brandProdUpdate" class="form-control">
                            </div>
                        </div>
                        <!-- <div class="form-group col-md-6 col-10">
                            <label for="modelProd">Modelo</label>
                            <input type="text" name="modelProd" id="modelProd" class="form-control">
                        </div> -->
                        <div class="form-group col-md-6 col-10">
                            <label for="priceProd">Precio Compra</label>
                            <input type="text" name="priceProd" id="priceProd" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-10">
                            <label for="rentPriceProd">Precio Arriendo</label>
                            <input type="text" name="rentPriceProd" id="rentPriceProd" class="form-control">
                        </div>
                    </section>
                </div>
            </div>

            <div class="modal-footer row" style="justify-content: end;">
                <!-- <button type="button" id="cancelUserCreation" class="btn btn-danger col-4" data-bs-dismiss="modal">
                    <span class="d-none d-sm-block">Cancelar</span>
                </button>
                <button type="button" id="addUsuario" class="btn btn-success ml-1 col-4">
                    <span class="d-none d-sm-block">Crear usuario</span>
                </button> -->
                <button type="submit" class="s-Button" id="buttonProductosMasiva">
                    <p class="s-P">Guardar Cambios</p>
                </button>
            </div>
        </form>
    </div>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>


<script>
    function openProdSideMenu() {
        $('#productDataSideMenu').addClass('active');
    }

    function closeProDataSideMenu() {
        console.log("removeclass active to side menu")
        $('#productDataSideMenu').removeClass('active')
    }
</script>

<style>
    .changeInvertHover:hover {
        color: white;
    }
</style>

<!-- <div class="form-group col-md-6 col-10">
                            <label for="catProd">Categoría</label>
                            <input type="text" name="catProd" id="catProd" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-10">
                            <label for="subCatProd">Sub categoría</label>
                            <input type="text" name="subCatProd" id="subCatProd" class="form-control">
                        </div> -->