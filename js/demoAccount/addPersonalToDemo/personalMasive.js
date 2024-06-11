function addPersonalMasivaToDemoAccount(){
    fetch('./js/demoAccount/addPersonalToDemo/cargo_especialidad.json')
    .then((response) => response.json())
    .then((json) => {

        console.log('json',json);
        insertPersonal(json.cargos,json.specialism);
        
    })
    .catch((err)=>console.log(err));
}



async function insertCargos(cargos,empresa_id) {
    const response = fetch('./ws/personal/demoAccount/addCargosDemo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(
            {
                'request':cargos,
                'empresaId':empresa_id
            }
        )
    })
    .then(response => response.json())
    .then(responseInsert => {
        return responseInsert
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return response;
}

async function insertspecialism(specialisms, empresa_id) {
    const response = fetch('./ws/personal/demoAccount/addSpecialismDemo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(
            {
                'request':specialisms,
                'empresaId':empresa_id
            }
        )
    })
    .then(response => response.json())
    .then(responseInsert => {
        return responseInsert
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return response;
}


async function insertPersonal(cargos,specialisms) {
    console.log('cargos',cargos);
    try {
        // Ejecutar los primeros dos fetch en paralelo
        const [responseCargo, responseSpecialism] = await Promise.all([insertCargos(cargos,EMPRESA_ID),insertspecialism(specialisms, EMPRESA_ID)]);

        console.log('responseCargo',responseCargo);
        console.log('responseSpecialism',responseSpecialism);

        // Verificar que ambas respuestas sean correctas
        if (!responseCargo.success || !responseSpecialism.success) {
            throw new Error('Uno o ambos fetch iniciales fallaron');
        }

        const DATA_CARGOS = responseCargo.cargos;
        const DATA_SPECIALISM = responseSpecialism.specialisms;


        console.log('DATA_CARGOS',DATA_CARGOS);

        // Ejecutar el tercer fetch
        const PERSONAL_DATA = await getPersonalDemoData();

        console.log(PERSONAL_DATA);

        // Verificar si el tercer fetch fue exitoso
        if (PERSONAL_DATA.length === 0) {
            deleteCargosEspecialidad(EMPRESA_ID);
            throw new Error('No se ha podido obtener la información del personal');
        }

        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);
        console.log('PERSONAL_DATA',PERSONAL_DATA);

        // Convertir la respuesta a JSON
        const RESPONSE_CREATE_DEMO_PERSONAL = await insertPersonalOnDemoAcc(PERSONAL_DATA,DATA_SPECIALISM,DATA_CARGOS,EMPRESA_ID);

        console.log('RESPONSE_CREATE_DEMO_PERSONAL',RESPONSE_CREATE_DEMO_PERSONAL);
        console.log('RESPONSE_CREATE_DEMO_PERSONAL',RESPONSE_CREATE_DEMO_PERSONAL);
        console.log('RESPONSE_CREATE_DEMO_PERSONAL',RESPONSE_CREATE_DEMO_PERSONAL);
        // Manejar la respuesta final
        
    } catch (error) {
        // Manejar errores
        console.error('Error durante el fetch:', error);
    }
}



function getPersonalDemoData(){
    const PERSONAL_JSON = fetch('./js/demoAccount/addPersonalToDemo/demoPersonalData.json')
    .then((response) => response.json())
    .then((json) => {

        return json;
        
    })
    .catch((err)=>console.log(err));

    return PERSONAL_JSON;
}

function deleteCargosEspecialidad(empresa_id){
    const RESPONSE_DELETE_C_AND_SPEC = fetch('./ws/personal/demoAccount/deleteCargoEspecialism.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(
            {
                'empresaId':empresa_id
            }
        )
    })
    .then(response => response.json())
    .then(responseDelete => {
        return responseDelete
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return RESPONSE_DELETE_C_AND_SPEC;
}
function insertPersonalOnDemoAcc(personalData, specialismData, cargoData,empresa_id){
    const RESPONSE_DELETE_C_AND_SPEC = fetch('./ws/personal/demoAccount/insertDemoPersonal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(
            {
                'empresaId':empresa_id,
                'personalData':personalData,
                'specialismData':specialismData,
                'cargoData':cargoData,
            }
        )
    })
    .then(response => response.json())
    .then(responseDelete => {
        return responseDelete
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return RESPONSE_DELETE_C_AND_SPEC;
}