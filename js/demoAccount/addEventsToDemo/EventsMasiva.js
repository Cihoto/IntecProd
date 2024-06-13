//function to fetch eventData.json and insert events to demo account

function addEventsMasiveOnDemoAccount(insertedPersonal,insertedProducts, insertedVehicles,insertedClients) {
    fetch('./js/demoAccount/addEventsToDemo/eventData.json')
        .then((response) => response.json())
        .then((json) => {
            insertEvent(insertedPersonal,insertedProducts, insertedVehicles,insertedClients,json)
        })
        .catch((err) => console.log(err));
}
// function to insert events to demo account
function insertEvent(insertedPersonal,insertedProducts, insertedVehicles,insertedClients, request) {

    console.log('insertedPersonal',insertedPersonal);
    console.log('insertedClients',insertedClients);
    console.log('insertedVehicles',insertedVehicles);
    console.log('insertedProducts',insertedProducts);
    console.log('request',request);
    
    // interate request and find client id on client variable and replace it
    request.forEach((event) => {
        const clientExists = insertedClients.find((client) => client.nombre_fantasia.toLowerCase() == event.cliente.toLowerCase())
        // check if client exists
        if (clientExists) {
            event.cliente_id = clientExists;
        }
        event.cliente_id = clientExists.clientId;
    });


    request.forEach((event) => {

        let personalToAssign = event.personalToAssign;

        personalToAssign.forEach((personAssign) => {
            const personalExists = insertedPersonal.find((person) => person.name.toLowerCase() == personAssign.name.toLowerCase())
            // check if personal exists
            if (personalExists) {

                if (personalExists.tipo_contrato_id != 5) {
                    let salaryPerHour = getSalaryPerHour(parseInt(personalExists.salary));
                    personAssign.salary = salaryPerHour * 8;
                    personAssign.workedHours = 8;
                }else{
                    personAssign.workedHours = 1;

                }
                personAssign.personalId = personalExists.personalId;
            }
        });
    });


    //iterate request.productsToAssign and find product id on insertedProducts and compare lowerCase names
    request.forEach((event) => {
        let productsToAssign = event.productsToAssign;
        productsToAssign.forEach((productAssign) => {
            const productExists = insertedProducts.find((product) => product.productName.toLowerCase() == productAssign.prodName.toLowerCase())
            // check if product exists
            if (productExists) {
                productAssign.prodId = productExists.productId;
                productAssign.totalProd = productExists.rentPrice;
            }
        });
    });

    // iterate request.vehiclesToAssign and find vehicleId on insertedVehicles and compare lowerCase vehiclesToAssign.plate with insertedVehicles.patente
    request.forEach((event) => {
        let vehiclesToAssign = event.vehiclesToAssign;
        vehiclesToAssign.forEach((vehicleAssign) => {
            const vehicleExists = insertedVehicles.find((vehicle) => vehicle.patente.toLowerCase() == vehicleAssign.plate.toLowerCase())
            // check if vehicle exists
            if (vehicleExists) {
                vehicleAssign.vehicleId = vehicleExists.id;
            }
        });
    });


    console.log(request);
    // fetch request to add events to demo account


    fetch('./ws/proyecto/demoAccount/addEventsToDemoAccount.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({request:request,empresaId:EMPRESA_ID})
    })
    .then(response => response.json())
    .then(eventReponse => {
        if (eventReponse.error) {
          console.log('Error:', eventReponse.message);
          return 
        } 
        if (eventReponse.success) {
          console.log('Error:', eventReponse.message);
          return
        } 
        console.log('Success:', eventReponse);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// function to calculate salary per hour
function getSalaryPerHour(salary) {
    const daysInMonth = 30;
    const hoursInWeek = 45;
    const weeksInMonth = daysInMonth / 7;
    const salaryPerHour = Math.round(salary / (weeksInMonth * hoursInWeek));
    return salaryPerHour;
}




