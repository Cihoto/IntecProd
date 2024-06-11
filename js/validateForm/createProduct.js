$('#productosCreateUnitario').validate({
    rules: {
        txtNombreProducto: {
            required: true
        },
        categoriaSelect: {
            required: false
        },
        marcaSelect: {
            required: true
        },
        itemSelect: {
            required: true
        },
        txtCantidad: {
            required: true
        },
        txtPrecioCompra: {
            required: false
        },
        txtPrecioEstimadoArriendo: {
            required: false
        }
    },
    messages: {
        txtNombreProducto: {
            required: "Ingrese un valor"
        },
        categoriaSelect: {
            required: "Ingrese un valor"
        },
        marcaSelect: {
            required: "Ingrese un valor"
        },
        itemSelect: {
            required: "Ingrese un valor"
        },
        txtCantidad: {
            required: "Ingrese un valor"
        },
        txtPrecioCompra: {
            required: "Ingrese un valor"
        },
        txtPrecioEstimadoArriendo: {
            required: "Ingrese un valor"
        }
    },
    submitHandler: function() {
        event.preventDefault();

        // console.log('CREATING NEW PROADUCT');

        let NombreProducto = $('#inputNombreProducto').val();
        let categoriaSelect = $('#categoriaSelect selectedIndex').text();
        let marcaSelect = $('#marcaSelect selectedIndex').text();
        let itemSelect = $('#itemSelect selectedIndex').text();
        let cantidad = $('#inputCantidad').val();
        let precioCompra = $('#inputPrecioCompra').val();
        let precioEstimadoArriendo = $('#inputPrecioEstimadoArriendo').val();

        let arrayRequest = [{
            "nombre": NombreProducto.trim(),
            "marca": marcaSelect.trim(),
            "modelo": "Generico",
            "categoria": categoriaSelect.trim(),
            "item": itemSelect.trim(),
            "stock": cantidad.trim(),
            "precioCompra": precioCompra.trim() === "" ? 0 : precioCompra.trim(),
            "precioArriendo": precioEstimadoArriendo.trim() === "" ? 0 : precioCompra.trim()
        }]

        $.ajax({
            type: "POST",
            url: "ws/productos/addProductos.php",
            data: JSON.stringify(arrayRequest),
            dataType: 'json',
            success: async function(data) {
                console.log(data);
            }
        })
    }
})