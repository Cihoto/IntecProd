
function newDemoAccount(){
    
    let array = {
        "categoria": value[0],
        "item": value[1],
        "categoria_id": CAT_EXISTS.id,
        "subCat_id": SUBCAT_EXISTS.id,
        "nombre": value[2],
        "marca": value[3],
        "modelo": value[4],
        "stock": value[5],
        "precioCompra": value[6] === "" ? 0 : value[6],
        "precioArriendo": value[7] === "" ? 0 : value[7],
        'sku': ""
    }
}






















async function activateDemoDataonNewAccount(empresaId) {

    addProductsMasivaonDemoAccount()
    return 

    const DEMOACCOUNT = await createDemoAccount(empresaId);
    // console.log('DEMOACCOUNT', DEMOACCOUNT);

    if (!DEMOACCOUNT.success) {
        Swal.fire({
            'icon': 'error',
            title:'Ups!',
            text:'No hemos podido agregar los datos de prueba a tu cuenta, por favor intenta nuevamente.',
            timer:2000
        })
        return;
    }

    const CHI = await getCatsHasItem_demoAccount(10);
    createCategorieHasSubCategorie(CHI);

    const newAccProdData = await newAccountProdData(empresaId);
    // console.log(newAccProdData);
    prepareProdsAndCHI(newAccProdData);

    return true;

}

//DEMO CREATION FUNCTIONS

function createCategorieHasSubCategorie(catHasItem) {
    const DEMO_PRODS = catHasItem.demo_prods;
    const CATEGORIES = catHasItem.categories;
    const SUB_CATEGORIES = catHasItem.subcats;

    let categorieHasSubcatArr = [];

    DEMO_PRODS.forEach((demo) => {

        let demo_cat_name = demo.categorie.toUpperCase();
        let demo_subcat_name = demo.subCategorie.toUpperCase();

        const CATEGORIE = CATEGORIES.find((cat) => {
            return cat.nombre.toUpperCase() === demo_cat_name
        });

        const SUBCATEGORIE = SUB_CATEGORIES.find((subcat) => {
            return subcat.item.toUpperCase() === demo_subcat_name
        });

        if (CATEGORIE && SUBCATEGORIE) {
            // console.log(CATEGORIE);
            // console.log(SUBCATEGORIE);


            if (categorieHasSubcatArr.length === 0) {
                categorieHasSubcatArr.push({
                    'catId': CATEGORIE.cat_id,
                    'subcatId': SUBCATEGORIE.subCat_id
                })
            } else {

                const CAT_SUBCAT_EXISTS = categorieHasSubcatArr.find((catSubCat) => {

                    if (catSubCat.catId === CATEGORIE.cat_id && catSubCat.subcatId === SUBCATEGORIE.subCat_id) {
                        return catSubCat
                    }
                });

                if (!CAT_SUBCAT_EXISTS) {
                    categorieHasSubcatArr.push({
                        'catId': CATEGORIE.cat_id,
                        'subcatId': SUBCATEGORIE.subCat_id
                    })
                }
            }

        }
    });

    console.log('categorieHasSubcatArr', categorieHasSubcatArr);

    setMyCatsAndSubCats(categorieHasSubcatArr);
}


function prepareProdsAndCHI(prodsChiData) {

    const PRODUCTS = prodsChiData.products;
    const CHI = prodsChiData.chi;

    const PRODS_ON_CHI = PRODUCTS.map((prod) => {

        const CATSUBCAT_ONPROD = CHI.find((chi) => {
            return chi.categorie.toUpperCase() === prod.categorie.toUpperCase()
                && chi.subcategorie.toUpperCase() === prod.subcategorie.toUpperCase()
        })

        prod.chi_id = CATSUBCAT_ONPROD.chi_id

        return prod

    });

    setMyChiOnNewBussiness(PRODS_ON_CHI, EMPRESA_ID)
}



// AJAX CALLS



function createDemoAccount(empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "createDemoAccount",
            empresa_id: empresa_id
        }),
        success: function (response) {
            console.log("DEMO_PRODS", response);
        }
    })
}

function setMyCatsAndSubCats(categorieHasSubcatArr){
    $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "setMyCatsAndSubCats",
            chiArr  : categorieHasSubcatArr,
        }),
        success: function(response) {
            console.log("DEMO_PRODS", response);
        }
    }).then((response)=>{
        if(!response.success){
            console.log('no se han podido asignar tus CHI');
        }
    })
}

function getCatsHasItem_demoAccount(empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "getCatsHasItem_demoAccount",
            'empresa_id': empresa_id
        }),
        success: function (response) {


        }
    })
}


function newAccountProdData(empresa_id) {
    return $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "newAccountProdData",
            empresa_id: empresa_id,
        }),
        success: function (response) {
            console.log("DEMO_PRODS", response);
        }
    })
}


function setMyChiOnNewBussiness(prod_data,empresa_id){
    $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "setMyChiOnNewBussiness",
            'empresa_id'  : empresa_id,
            'prod_data' : prod_data
        }),
        success: function(response) {
            console.log("CHI ASSIGMENT", response);
        }
    })
}

