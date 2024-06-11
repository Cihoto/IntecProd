
document.addEventListener('DOMContentLoaded', (event) => {
const deleteProductBtn = document.getElementById('deleteProductBtn');   

deleteProductBtn.addEventListener('click', () => { 

    // Show confirmation Sweet Alert 2 before deleting the product
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Estás a punto de eliminar el producto. Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteProduct(EMPRESA_ID, _selectedProdId);
        }
    });
    // deleteProduct(EMPRESA_ID, _selectedProdId);
    // deleteProduct(EMPRESA_ID, _selectedProdId);  
})
});


async function deleteProduct(empresaId, productId) {
    
    fetch('/ws/productos/deleteProduct.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 'empresaId': empresaId, 'productId': productId })
    })
    .then(response => response.json()) // parse the JSON from the server
    .then(data => {
        // Here's where you handle the data you've got back
        console.log('Product deleted:', data);
        
        // remove product from table
        // $(`#productsDashTable tr[product_id=${productId}]`).remove();
        const element = document.querySelector(`#productsDashTable tr[product_id="${productId}"]`);
        // check if tr exists
        if (element) {
          element.remove();
        }
        $('#productDataSideMenu').removeClass('active');
    })
    .catch(err => {
        // This is where you run code if the server returns any errors
        console.error('An error occurred:', err);
    });
}