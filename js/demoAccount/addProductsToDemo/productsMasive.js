async function addProductsMasivaonDemoAccount() {
    try {
        const response = await fetch('./js/demoAccount/addProductsToDemo/demoProds.json');
        const json = await response.json();
        console.log('json',json);
        console.log('json',json);
        console.log('json',json);
        console.log('json',json);
        console.log('json',json);
        const INSERTED_PRODUCTS = await insertProds(json);
        console.log('INSERTED_PRODUCTS',INSERTED_PRODUCTS);
        return INSERTED_PRODUCTS;

    } catch (error) {
        console.log(error);
    }
}

async function insertProds(request) {
    try {
        const response = await fetch('./ws/productos/demoAccountProd/addMasivaAccount.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ request: request, empresaId: EMPRESA_ID })
        });

        const PRODUCTS = await response.json();
        console.log('PRODUCTS',PRODUCTS);

        if (PRODUCTS.status === 'success') {
            console.log('Request Products insersetion processed successfully:', PRODUCTS.message);
            console.log('Request processed successfully:', PRODUCTS.data);
        } else {
            console.error('Error processing request products insertion:', PRODUCTS.message);
        }
        return PRODUCTS.data;
    } catch (error) {
        console.error('Error:', error);
    }
}
