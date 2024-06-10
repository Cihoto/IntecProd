let _allCats = [];
let _allSubCats_ = [];
let tempCats = [];
let tempSubCats = [];
let _allSubCategoriesForProdData = []


function getCatsAndSubCatsByBussiness(empresa_id) {

    fetch('ws/productos/Producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: "getCatsAndSubCatsByBussiness",
            empresa_id: empresa_id
        })
    })
        .then((response) => response.json())
        .then((catsSubCats) => {
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);
            console.log('getCatsAndSubCatsByBussiness', catsSubCats);

            if (catsSubCats.success) {
                _allCats = catsSubCats.cats
                _allSubCats_ = catsSubCats.subcats;
                tempCats = catsSubCats.cats;
                tempSubCats = catsSubCats.allSubCats;

                printMyCats();

            }
        })
        .catch((err) => console.log(err));

    // return $.ajax({
    //     type: "POST",
    //     url: "ws/productos/Producto.php",
    //     data: JSON.stringify({
    //         action: "getCatsAndSubCatsByBussiness",
    //         empresa_id: empresa_id
    //     }),
    //     dataType: 'json',
    //     success: async function (data) {
    //         console.log(data);
    //     }
    // });
}


function GetItems() {

    fetch('ws/productos/getSubcategories.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: "getItems",
            empresaId: EMPRESA_ID
        })
    })
        .then((response) => response.json())
        .then((subcats) => {

            // _allSubCategoriesForProdData = data
            console.log('SUBCATSS', subcats);
            console.log('SUBCATSS', subcats);
            console.log('SUBCATSS', subcats);
            console.log('SUBCATSS', subcats);
            console.log('SUBCATSS', subcats);
            printAllSubcatsOnProdData(subcats);


           

        })
        .catch((err) => console.log(err));

    return $.ajax({
        type: "POST",
        url: "/ws/categoria_item/item.php",
        data: JSON.stringify({
            action: "getItems",
            empresaId: EMPRESA_ID
        }),
        dataType: 'json',
        success: async function (data) {
            // let select = $('#itemSelect');

            _allSubCategoriesForProdData = data
            // data.forEach(cat=>{
            //     let opt  = $(select).append(new Option(capitalizeFirstLetter(cat.item), cat.id))
            // })
        }, error: function (response) {
            console.log(response.responseText);
        }
    })
}


function printMyCats() {
    $('#catSelect option').remove();
    $('#catSelect').append(new Option("Todas", "all"))
    // $('#catProd option').remove();
    // $('#catProd').append(new Option("Todas", "all"))
    _allCats.forEach((cat) => {
        let option = new Option(cat.nombre, cat.id);
        $('#catSelect').append(option);
        let option2 = new Option(cat.nombre, cat.id);
        $('#catProd').append(option2);
    });
}


function printAllSubcatsOnProdData() {
    $('#subCatProd option').remove();
    $('#subCatProd').append(new Option("Todas", "all"))
    _allSubCategoriesForProdData.forEach((subcat) => {

        let option2 = new Option(subcat.item, subcat.id);
        $('#subCatProd').append(option2);
    });
}
