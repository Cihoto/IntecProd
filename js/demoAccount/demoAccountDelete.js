function removeDemoDataFromBussiness(empresa_id){
    return $.ajax({
        type: "POST",
        url: "ws/demoAccount/demoAccount.php",
        dataType: 'json',
        data: JSON.stringify({
            "action": "removeDemoAccount",
            empresa_id: empresa_id
        }),
        success: function (response) {
            console.log("DEMO_PRODS", response);
        }
    })
}