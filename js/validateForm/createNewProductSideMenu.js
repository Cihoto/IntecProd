let _executeCreateNewProduct = true;

$('#createProductSideMenu').validate({
    rules: {
        'createNomProd':{
            required:true
        },
        'createStockProd':{
            required:true
        },
        'createCatProd':{
            required:true
        },
        'createSubCatProd':{
            required:false
        },
        'createBrandProd':{
            required:false
        },
        'createPriceProd':{
            required:false
        },
        'createRentPriceProd':{
            required:false
        },
    },
    messages: {
        'createNomProd':{
            required:'Ingrese un nombre'
        },
        'createStockProd':{
            required:'Ingrese el stock '
        },
        'createCatProd':{
            required:'Ingrese una categoría'
        },
        'createSubCatProd':{
            required:false
        },
        'createBrandProd':{
            required:false
        },
        'createPriceProd':{
            required:false
        },
        'createRentPriceProd':{
            required:false
        },

    },
    submitHandler: async function() {
        event.preventDefault();

        console.log('ESTOY CREANDO EL PRODUCTO')


        if (!_executeCreateNewProduct) {
            return;
        }
        _executeCreateNewProduct = false;


        const NEW_PRODUCT_REQUEST = {
            'createNomProd': $('#createNomProd').val(),
            'createStockProd': $('#createStockProd').val(),
            'createCatProd': $('#createCatProd').val(),
            'createSubCatProd': $('#createSubCatProd').val(),
            'createBrandProd': $('#createBrandProd').val(),
            'createPriceProd': $('#createPriceProd').val(),
            'createRentPriceProd': $('#createRentPriceProd').val(),
            'empresaId': EMPRESA_ID
        }
        console.log('NEW_PRODUCT_REQUEST',NEW_PRODUCT_REQUEST);

        _executeCreateNewProduct = true;
        // console.log('response',await createNewProduct(NEW_PRODUCT_REQUEST.createCatProd,NEW_PRODUCT_REQUEST.createSubCatProd));

       

        const RESPONSE_INSERT_PRODUCT = await createNewProduct(NEW_PRODUCT_REQUEST);

        if(!RESPONSE_INSERT_PRODUCT){
            Swal.fire({
                "icon": "warning",
                "title": "Ups!",
                "text": "Por favor intente nuevamente"
            });
            _executeCreateNewProduct = true;
            return ;
        };


        Toastify({
            text: 'Producto creado Exitosamente',
            duration: 3000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(90deg, #36ABA9 0%, #10E5E1 70.29%)   ",
            },
        }).showToast();

          
    }
})


// $("#").validate({
//     errorLabelContainer: "#messageBox",
//     wrapper: "li",
//     submitHandler: function() { alert("Submitted!") }
//   });

async function createNewProduct(request) {
    return $.ajax({
        type: "POST",
        url: "ws/productos/Producto.php",
        data: JSON.stringify({
            action: "createNewProduct",
            'request': request
        }),
        dataType: 'json',
        success: async function (data) {
            console.log(data);
        }
    })
}
async function test_1(catid,subcatId) {
    return $.ajax({
        type: "POST",
        url: "ws/productos/Producto.php",
        data: JSON.stringify({
            action: "test_1",
            'catid':catid,
            'subcatId':subcatId,
        }),
        dataType: 'json',
        success: async function (data) {
            console.log(data);
        }
    })
}