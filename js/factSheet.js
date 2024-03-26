
// NEEDS GLOBAL VARIABLE EMPRESA_ID 
$('#generate1232231231152fd1f1Quotes').on('click',async function(){
    clearBottomBar();
    initBottomBar();

    $('#footerInformation').addClass('active');

    const PROJECT_IS_CREATED = await SaveOrUpdateEvent();
    let event_was_created = false;
    if(event_data.event_id !== ""){
        event_was_created = true;
    }

    if(PROJECT_IS_CREATED === false){

        completeEventDataToContinue();
       
        setTimeout(() => {
            closeBottomBar();
        }, 2000);
        return;
    }else if(PROJECT_IS_CREATED === true){
        console.log(`CREADO EXAITOSAMENTE`)
        eventWasCreatedBottomBar();
    }
    
    setTimeout(() => {

        preparingDocumentBottomBar("Generando Cotización");
        
    }, 1700);

    const date =  new Date();
    const month = date.getMonth();
    const year = date.getFullYear();
    const day = date.getDay();

    // console.log("date",date);
    // console.log("date",month);
    // console.log("date",year);
    // console.log("date",day);

    const fileNameData = {
        'month' :month,
        'year' :year,
        'day' :day
    }


    // console.log("ESTOY GENERANDO UNA COTIZACIÓN",_categoriesandsubcategories);
    // console.log("ESTOY GENERANDO UNA COTIZACIÓN",totalPerItem.equipos);
    // console.log("ESTOY GENERANDO UNA COTIZACIÓN",_selectedProducts);
    // console.log("ESTOY GENERANDO UNA COTIZACIÓN",_selectedOthersProducts);

    let personal = "";
    let tr = "";

    let tableContent = totalPerItem.equipos.map((itemProd)=>{
        tr += `<tr class="categorieQuote">
            <td>${itemProd.categorie}</td>
            <td></td>
            <td>${CLPFormatter(itemProd.value)}</td>
        </tr>`;
        _selectedProducts.forEach((selectedProd)=>{
            if(selectedProd.categoria === itemProd.categorie){
                tr += `<tr>
                    <td style="text-align:end;">${selectedProd.quantityToAdd}</td>
                    <td>${selectedProd.nombre}</td>
                    <td></td>
                </tr>`;
            }
        })
        
        const productos = _selectedProducts.filter((productos)=>{
            return productos.categoria === itemProd.categorie;
        });

        return {
            'categoria': itemProd.categorie,
            'total_categoria':CLPFormatter(itemProd.value),
            'productos': productos
        }
    });
    let totalOtros = 0;
    const otherProdsFormatted = _selectedOthersProducts.map((other)=>{
        totalOtros += other.total;

        return {
            'nombre':other.detalle,
            'quantityToAdd':other.cantidad
        }
    })

    tableContent.push(
        {
            'categoria': "Otros",
            'total_categoria':CLPFormatter(totalOtros),
            'productos': otherProdsFormatted
        }
    )
    // console.log("12837192837198237",tableContent);

    let table =`<table id="quoteDetailsTable">
        <thead>
        <tr>
            <th  style="background-color: #069B99; width: 200px;padding: 15px; border-radius: 15px 0px 0px 0px;" colspan="2">
                <p style="color: var(--White, #FCFCFC);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto;
                font-size: 20px;
                font-style: normal;
                font-weight: 500;
                text-align: start;
                line-height: 24px;
                margin: 0px;
                letter-spacing: 0.17px;">
                    Descripción
                </p>
            </th>
            <th style="background-color: #2C2D33; width: 15%; border-radius: 0px 15px 0px 0px;"> 
                <p style="color: var(--White, #FCFCFC);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto;
                font-size: 24px;
                font-style: normal;
                font-weight: 500;
                margin: 0px;
                line-height: 24px; /* 171.429% */
                letter-spacing: 0.17px;">
                Total
                </p> 
            </th>
        </tr>
        </thead> 
        <tbody>
        ${tr}
        </tbody>
        <tfoot>
        </tfoot>
    </table>`;

    


// console.log("_selectedClient",_selectedClient);

    $.ajax({
        type: "POST",
        url: "ws/BussinessDocuments/quotesGenerator.php",
        dataType: 'json',
        data:JSON.stringify({
            'empresa_id':EMPRESA_ID,
            'table' : table,
            'fileNameData' : fileNameData,
            'table_Content':tableContent,
            'totalQuoteResume':quote_resume,
            'clientData' : _selectedClient,
            'event_id' : event_data.event_id
        }),
        success: function(response){

            preparingDocumentDownload("Descargando Cotización");
            setTimeout(()=>{
                // console.log("response", response);
                let a = `<a target="_blank" id="dwnload" href="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/quotes/${response.name}"></a>`
                $('#downloadPdf').append(a);
                $('#dwnload')[0].click();
            },1000)
        },error:  function(error){
            // console.log("error",error.responseText)
        }
    })
    .then(()=>{
        closeBottomBar();
    })

})


$('#generateResumePdf').on('click',async function(){   
    clearBottomBar();
    initBottomBar();

    $('#footerInformation').addClass('active');

    const PROJECT_IS_CREATED = await SaveOrUpdateEvent();

    if(PROJECT_IS_CREATED === false){

        completeEventDataToContinue();
       
        setTimeout(() => {
            closeBottomBar();
        }, 2000);
        return;
    }else if(PROJECT_IS_CREATED === true){
        console.log(`CREADO EXAITOSAMENTE`)
        eventWasCreatedBottomBar();
    }
   
    if($('#factSheet-documents').is(':checked') === true){
        // console.log("GENERANDO LA FICHA TECNICA")
        const factSheetWasGenerated = await generateFactSheet();

        console.log("factSheetWasGenerated",factSheetWasGenerated);
        console.log("factSheetWasGenerated",factSheetWasGenerated);
        console.log("factSheetWasGenerated",factSheetWasGenerated);


        if(factSheetWasGenerated){
            preparingDocumentDownload("Descargando Cotización");
            $('#downloadPdf a').remove();
            // console.log("response", response);
            // let a = `<a target="_blank" id="dwnload" href="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/factSheet/${factSheetWasGenerated.name}"></a>`
            let a = `<a id="dwnload" href="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/factSheet/${factSheetWasGenerated.name}" download></a>`
            $('#downloadPdf').append(a);
            $('#dwnload')[0].click();
            $('#downloadPdf a').remove();
        }
    }
    setTimeout(()=>{
        closeBottomBar();
    },1000)
});

async function generateFactSheet(){

    preparingDocumentBottomBar("Generando Ficha Técnica");

    const date =  new Date();
    const month = date.getMonth();
    const year = date.getFullYear();
    const day = date.getDay();

    const fileNameData = {
        'month' :month,
        'year' :year,
        'day' :day
    }

    let personal = "";
    let tr = "";

    let tableContent = totalPerItem.equipos.map((itemProd)=>{
        tr += `<tr class="categorieQuote">
            <td>${itemProd.categorie}</td>
            <td></td>
            <td>${CLPFormatter(itemProd.value)}</td>
        </tr>`;
        _selectedProducts.forEach((selectedProd)=>{
            if(selectedProd.categoria === itemProd.categorie){
                tr += `<tr>
                    <td style="text-align:end;">${selectedProd.quantityToAdd}</td>
                    <td>${selectedProd.nombre}</td>
                    <td></td>
                </tr>`;
            }
        })
        
        const productos = _selectedProducts.filter((productos)=>{
            return productos.categoria === itemProd.categorie;
        });

        return {
            'categoria': itemProd.categorie,
            'total_categoria':CLPFormatter(itemProd.value),
            'productos': productos
        }
    });
    let totalOtros = 0;
    const otherProdsFormatted = _selectedOthersProducts.map((other)=>{
        totalOtros += other.total;
        return {
            'nombre':other.detalle,
            'quantityToAdd':other.cantidad
        }
    });

    tableContent.push(
        {
            'categoria' : "Otros",
            'total_categoria' : CLPFormatter(totalOtros),
            'productos' : otherProdsFormatted
        }
    )
    // console.log("12837192837198237",tableContent);

    let table =`<table id="quoteDetailsTable">
        <thead>
        <tr>
            <th  style="background-color: #069B99; width: 200px;padding: 15px; border-radius: 15px 0px 0px 0px;" colspan="2">
                <p style="color: var(--White, #FCFCFC);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto;
                font-size: 20px;
                font-style: normal;
                font-weight: 500;
                text-align: start;
                line-height: 24px;
                margin: 0px;
                letter-spacing: 0.17px;">
                    Descripción
                </p>
            </th>
            <th style="background-color: #2C2D33; width: 15%; border-radius: 0px 15px 0px 0px;"> 
                <p style="color: var(--White, #FCFCFC);
                font-feature-settings: 'clig' off, 'liga' off;
                font-family: Roboto;
                font-size: 24px;
                font-style: normal;
                font-weight: 500;
                margin: 0px;
                line-height: 24px; /* 171.429% */
                letter-spacing: 0.17px;">
                Total
                </p> 
            </th>
        </tr>
        </thead> 
        <tbody>
        ${tr}
        </tbody>
        <tfoot>
        </tfoot>
    </table>`;

    


// console.log("_selectedClient",_selectedClient);

    return $.ajax({
        type: "POST",
        url: "ws/BussinessDocuments/factSheetGenerator.php",
        dataType: 'json',
        data:JSON.stringify({
            'empresa_id':EMPRESA_ID,
            'table' : table,
            'fileNameData' : fileNameData,
            'table_Content':tableContent,
            'clientData' : _selectedClient,
            'event_id' : event_data.event_id
        }),
        success: function(response){
            console.log(response)

            
        },error:  function(error){
            // console.log("error",error.responseText)
        }
    })
}




