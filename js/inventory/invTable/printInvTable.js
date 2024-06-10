let _allProductsToList = [];

function getAllMyProductsToList(empresa_id) {


    fetch('ws/productos/Producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body:
            JSON.stringify({
                action: "getAllMyProductsToList",
                empresaId: empresa_id
            })
    })
        .then((response) => response.json())
        .then((json) => {
            // insertProds(json)
            console.log('getAllMyProductsToList', json);
            _allProductsToList = json;
            printMyProducts();
            console.log('getAllMyProductsToList', json);
            console.log('getAllMyProductsToList', json);
        })
        .catch((err) => console.log(err));
}
// return $.ajax({
//     type: "POST",
//     url: "ws/productos/Producto.php",
//     data: JSON.stringify({
//         action: "getAllMyProductsToList",
//         empresaId: empresa_id
//     }),
//     dataType: 'json',
//     success: async function (data) {
//         console.log(data);
//     }
// })

function customProdSearch(request, empresa_id) {

    fetch('ws/productos/Producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: "customProdSearch",
            request: request,
            empresaId: empresa_id
        })
    })
        .then((response) => response.json())
        .then((json) => {
            // insertProds(json)

            if (!json.success) {
                Swal.fire({
                    "icon": "error",
                    "title": "Ups!",
                    "text": "Intente nuevamente"
                })
                return
            }
            console.log('customProdSearch', json);
            console.log('customProdSearch', json.data);
            _allProductsToList = json.data;
            printMyProducts()

        })
        .catch((err) => console.log(err));
}

// $.ajax({
//         type: "POST",
//         url: "ws/productos/Producto.php",
//         data: JSON.stringify({
//             action: "customProdSearch",
//             request: request,
//             empresaId: empresa_id
//         }),
//         dataType: 'json',
//         success: async function(data) {
//             console.log(data);
//         }
//     });




function printMyProducts() {
    if ($.fn.DataTable.isDataTable('#productsDashTable')) {
        $('#productsDashTable').DataTable()
            .clear()
            .draw();
        $('#productsDashTable').DataTable().destroy();
    }

    _allProductsToList.forEach((producto, index) => {

        if (producto.subcategoria == null) {
            producto.subcategoria = ''
        }
        let tr = `<tr product_id="${producto.product_id}">
            <td>${producto.categoria}</td>
            <td>${producto.subcategoria}</td>
            <td>${producto.nombre_producto}</td>
            <td>${producto.stock}</td>
            <td>${CLPFormatter(producto.precio_arriendo)}</td>
        </tr>`
        $('#productsDashTable tbody').append(tr);

    });
    if (!$.fn.DataTable.isDataTable('#productsDashTable')) {

        dash_Client_table = new DataTable('#productsDashTable', {
            "responsive": false,
            "paging": true,
            "scrollX": false,
            "autoWidth": false,
            lengthMenu: [5, 10, 20, 50, 100, 200, 500],
            pageLength: 100,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            columnDefs: [{
                "width": "17%",
                "targets": "_all"
            }, {
                className: "ps-header",
                "targets": [0]
            }, {
                className: "tc",
                "targets": [3]
            },
            {
                "defaultContent": "-",
                "targets": "_all"
            }
            ]
        });
    }
}



