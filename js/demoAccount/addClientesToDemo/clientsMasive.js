// Init the clients mass insertion

/**
 * Adds clients to the demo account.
 * @returns {Promise<Array>} The array of clients added to the demo account.
 */
async function addClientsMasiveOnDemoAccount() {
    try {
        /**
         * Fetch client JSON data.
         * @returns {Promise<Response>} The response object containing the client JSON data.
         */
        const response = await fetch('./js/demoAccount/addClientesToDemo/clientData.json');
        const json = await response.json();
        const clients = await insertClient(json);
        return clients; // Return the clients added to the demo account.
    } catch (error) {
        console.log(error);
    }
}

/**
 * Inserts a client into the demo account.
 * @param {Object} request - The client request object.
 * @returns {Promise<Object>} - A promise that resolves to the client response object.
 */
async function insertClient(request) {
    try {
        const response = await fetch('./ws/cliente/demoAccount/addClientToDemoAccount.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ request: request, empresaId: EMPRESA_ID })
        });

        const clientResponse = await response.json();

        if (clientResponse.error) {
            console.log('Error:', clientResponse.message);
            return;
        }

        console.log('Success:', clientResponse);
        return clientResponse;
    } catch (error) {
        console.error('Error:', error);
    }
}

