
function addProductsMasivaonDemoAccount(){
    fetch('./js/demoAccount/addProductsToDemo/demoProds.json')
    .then((response) => response.json())
    .then((json) => {
        insertProds(json)
    })
    .catch((err)=>console.log(err));
}


// function insert

function insertProds(request){
    fetch('./ws/productos/demoAccountProd/addMasivaAccount.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({request:request,empresaId:EMPRESA_ID})
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Request processed successfully:', data.message);
        } else {
            console.error('Error processing request:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
