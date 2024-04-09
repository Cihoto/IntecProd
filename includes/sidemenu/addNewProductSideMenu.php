<div id="addProductDataSideMenu" class="sideMenu-s" >
    <button id="closeAddProductDataSideMenu" style="border: none;background-color: none;padding: 30px;" onclick="closeCreateProdSideMenu()">
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
            <p class="header-P">Aquí puedes crear un nuveo producto</p>
        </div>
        <form id="createProductSideMenu">
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
                            <label for="createNomProd">Nombre</label>
                            <input type="text" name="createNomProd" id="createNomProd" class="form-control">
                        </div>
                        <div class="form-group col-md-3 col-10">
                            <label for="createStockProd">Stock</label>
                            <input type="text" name="createStockProd" id="createStockProd" class="form-control">
                        </div>

                        <div class="col-10 col-lg-6">
                            <div class="row">
                                <div class="form-group col-10">
                                    <label for="createCatProd" class="inputLabel">Categoría</label>
                                    <select id="createCatProd" name="createCatProd" type="text" class="form-select s-Select-g">
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
                                    <label for="createSubCatProd" class="inputLabel ">Sub categoría</label>
                                    <select id="createSubCatProd" name="createSubCatProd" type="text" class="form-select s-Select-g ">
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
                                <label for="createBrandProd">Marca</label>
                                <input type="text" name="createBrandProd" id="createBrandProd" class="form-control">
                            </div>
                        </div>
                        <!-- <div class="form-group col-md-6 col-10">
                            <label for="modelProd">Modelo</label>
                            <input type="text" name="modelProd" id="modelProd" class="form-control">
                        </div> -->
                        <div class="form-group col-md-6 col-10">
                            <label for="createPriceProd">Precio Compra</label>
                            <input type="text" name="createPriceProd" id="createPriceProd" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-10">
                            <label for="createRentPriceProd">Precio Arriendo</label>
                            <input type="text" name="createRentPriceProd" id="createRentPriceProd" class="form-control">
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
                <button type="submit" class="s-Button">
                    <p class="s-P">Crear Producto</p>
                </button>
            </div>
        </form>
    </div>
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->
</div>


<script>
    function openCreateProdSideMenu() {
        $('#addProductDataSideMenu').addClass('active');
        $('#createSubCatProd option').remove();
        $('#createCatProd option').remove();

        $('#createCatProd').append(new Option('',''));
        _allCats.forEach((cat)=>{
            
            $('#createCatProd').append(new Option(cat.nombre,cat.id));
        })

        $('#createSubCatProd').append(new Option('',''));
        _allSubCats_.forEach((subcat)=>{
            
            $('#createSubCatProd').append(new Option(subcat.item,subcat.id));
        })
    }

    function closeCreateProdSideMenu() {

        $('#addProductDataSideMenu').removeClass('active')
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
</div> 
-->