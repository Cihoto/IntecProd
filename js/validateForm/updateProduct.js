let _executeUpdateProduct = true;

$('#updateProductSideMenu').validate({
    rules: {
        'nomProd': {
            required: true
        },
        'stockProd': {
            required: true
        },
        'catProd': {
            required: true
        },
        'subCatProd': {
            required: false
        },
        'brandProdUpdate': {
            required: false
        },
        'modelProd': {
            required: false
        },
        'priceProd': {
            required: false
        },
        'rentPriceProd': {
            required: false
        }
    },
    messages: {
        'nomProd': {
            required: "ingrese un valor"
        },
        'stockProd': {
            required: "ingrese un valor"
        },
        'catProd': {
            required: "ingrese un valor"
        },
        'subCatProd': {
            required: "ingrese un valor"
        },
        'brandProdUpdate': {
            required: "ingrese un valor"
        },
        'modelProd': {
            required: "ingrese un valor"
        },
        'priceProd': {
            required: "ingrese un valor"
        },
        'rentPriceProd': {
            required: "ingrese un valor"
        }

    },
    submitHandler: async function() {
        event.preventDefault();


        console.log('ESTOY ACTUALIZANDO EL PRODUCTO')

        if (!_executeUpdateProduct) {
            return;
        }
        _executeUpdateProduct = false;

        const UPDATEPRODUCTREQUEST = {
            'nomProd': $('#nomProd').val(),
            'stockProd': $('#stockProd').val(),
            'catProd': $('#catProd').val(),
            'subCatProd': $('#subCatProd').val(),
            'brandProd': $('#brandProdUpdate').val(),
            'priceProd': $('#priceProd').val(),
            'rentPriceProd': $('#rentPriceProd').val()
        }

        const RESPONSE_UPDATE_PRODUCT = await updateProductById(UPDATEPRODUCTREQUEST, EMPRESA_ID,_selectedProdId);

        if(!RESPONSE_UPDATE_PRODUCT.success){
            Swal.fire({
                "icon": "warning",
                "title": "Ups!",
                "text": "Por favor intente nuevamente"
            });
            _executeUpdateProduct = true;
            return ;
        };


        Toastify({
            text: 'Producto actualizado Exitosamente',
            duration: 3000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
              background: "linear-gradient(90deg, #36ABA9 0%, #10E5E1 70.29%)   ",
            },
          }).showToast();
        _executeUpdateProduct = true;
    }
})


// $("#").validate({
//     errorLabelContainer: "#messageBox",
//     wrapper: "li",
//     submitHandler: function() { alert("Submitted!") }
//   });

async function updateProductById(request, empresa_id, product_id) {
    return $.ajax({
        type: "POST",
        url: "ws/productos/Producto.php",
        data: JSON.stringify({
            action: "updateProductById",
            'request': request,
            'empresa_id': empresa_id,
            'product_id': product_id
        }),
        dataType: 'json',
        success: async function (data) {
            console.log(data);
        }
    })
}