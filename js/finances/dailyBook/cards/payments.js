let totalPaymentsObj = {
    totalPayments : 0,
    pendingBH:{
        total:0,
        totalDocuments:0
    },
    pendingBills : {
        total:0,
        totalDocuments:0
    },
    pendingDocuments : {
        total:0,
        totalDocuments:0
    }
}


function renderPaymentsCards(){
    const futurePayments = futureDocuments.filter(({recibida,}) => recibida);
    futurePayments.forEach(({tipo,pagada,saldo_isoluto,total}) => {
        // if(pagada){
        //     return;
        // }
        const totalDocument = saldo_isoluto == null ? total.total : parseInt(total.total) - parseInt(saldo_isoluto);
        const documentType = tipo.split(' ');
        // format the document type and set on lowercase
        const documentTypeFormatted = documentType.map((word) => word.toLowerCase());
        console.log('documentTypeFormatted',documentTypeFormatted);
        if(documentTypeFormatted.includes('factura')){
            totalPaymentsObj.pendingBills.totalDocuments++;
            totalPaymentsObj.pendingBills.total += totalDocument;
        }
        if(tipo.toLowerCase() == "boleta de honorarios"){
            totalPaymentsObj.pendingBH.totalDocuments++;
            totalPaymentsObj.pendingBH.total += totalDocument;
        }
    });
    console.log('totalPaymentsObj',totalPaymentsObj);
}