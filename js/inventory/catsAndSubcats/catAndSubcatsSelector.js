_allCats = [];
_allSubCats_ = [];
tempCats = [];
tempSubCats = [];


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
