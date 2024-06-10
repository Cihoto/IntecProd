$('#catSelect').on("change", function () {
    let cat = $('#catSelect').val();
    let subCat = $('#subcatSelect').val();


    if (cat === "all") {

        printSubCats(_allSubCats_);
    } else {
        const subCatToPrint = _allSubCats_.filter((subcat) => {
            return subcat.cat_id === cat
        })

        printSubCats(subCatToPrint);
    }

    let request = {
        'cat': cat,
        'subcat': subCat
    }

    customProdSearch(request, EMPRESA_ID);

});

$('#subcatSelect').on("change", function () {
    let cat = $('#catSelect').val();
    let subCat = $('#subcatSelect').val();

    let request = {
        'cat': cat,
        'subcat': subCat
    }
    customProdSearch(request, EMPRESA_ID);

    // if (!prods.success) {
    //     Swal.fire({
    //         "icon": "error",
    //         "title": "Ups!",
    //         "text": "Intente nuevamente"
    //     })
    //     return
    // }

    // _allProductsToList = prods.data;

    // printMyProducts();
})