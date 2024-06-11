let _selectedProdId = 0;


$(document).on('click', '#productsDashTable tbody tr', async function () {

    const PROD_ID = $(this).closest('tr').attr('product_id');
    _selectedProdId = PROD_ID;

    getProductById(PROD_ID, EMPRESA_ID);
    openProdSideMenu();
    printSubcatsOnProdSideMenu(_allSubCats_);
    
});


function getProductById(product_id, empresa_id) {

    fetch('ws/productos/Producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "action": "getProductById",
            'empresa_id': empresa_id,
            'product_id': product_id
        })
    })
    .then((response) => response.json())
    .then((productData) => {
        if (!productData.success) {
            return;
        }
        printProductDataOnForm(productData.data);
      
    })
    .catch((err) => console.log(err));

    // return $.ajax({
    //     type: "POST",
    //     url: "ws/productos/Producto.php",
    //     dataType: 'json',
    //     data: JSON.stringify({
    //         "action": "getProductById",
    //         'empresa_id': empresa_id,
    //         'product_id': product_id
    //     }),
    //     success: function (response) {

    //     },
    //     error: function (error) {
    //         console.log(error);
    //     }
    // })
}




function printProductDataOnForm(prodData) {
    // "data":{
    //     "id":"378",
    //     "nombre":"producto  DE PRUEBA 2",
    //     "desc":null,
    //     "marca_id":"35",
    //     "categoria_has_item_id":"77",
    //     "codigo_barra":"",
    //     "precio_compra":"20000",
    //     "precio_arriendo":"2000",
    //     "createAt":"2024-02-01",
    //     "modifiedAt":null,
    //     "IsDelete":"0",
    //     "deleteAt":null,
    //     "empresa_id":"2",
    //     "subcat_id":"140",
    //     "categorie_id":"

    console.log('prodData',prodData);
    console.log('prodData',prodData);
    console.log('prodData',prodData);
    console.log('prodData',prodData);
    console.log('prodData',prodData);

    $('#productName').text(prodData.nombre);
    $('#nomProd').val(prodData.nombre);
    $('#stockProd').val(prodData.stock);
    $('#catProd').val(prodData.categorie_id);
    $('#subCatProd').val(prodData.subcat_id);
    $('#brandProdUpdate').val(prodData.marca);
    $('#priceProd').val(prodData.precio_compra);
    $('#rentPriceProd').val(prodData.precio_arriendo);
    $('#brandProd').val(prodData.marca);


}