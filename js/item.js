let _allSubCategoriesForProdData = []

async function GetItems(){
    return $.ajax({
        type: "POST",
        url: "/ws/categoria_item/item.php",
        data: JSON.stringify({
            action: "getItems",
            empresaId:EMPRESA_ID
        }),
        dataType: 'json',
        success: async function(data) {
            // let select = $('#itemSelect');

            _allSubCategoriesForProdData = data
            // data.forEach(cat=>{
            //     let opt  = $(select).append(new Option(capitalizeFirstLetter(cat.item), cat.id))
            // })
        },error:function(response){
            console.log(response.responseText);
        }
    })
}