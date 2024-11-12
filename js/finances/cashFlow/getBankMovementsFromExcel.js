// Objetive: get bank movements from excel file and return it as an array of objects
let bankMovementsData = [];
let tributarieDocumentsCategories = ['charges','payments'];
async function getBankMovementsFromExcel(){
    const bankMovements = await readExcelFile(); 
    
    // search all days in year
    getAllDaysOnMonth([1,2,3,4,5,6,7,8,9,10,11,12]);
    bankMovementsData = setAllDaysOnYear();
    console.log('bankMovementsData',bankMovementsData);

    const bankData = bankMovements.bodyRows.map((movement) => {
        if(movement.cuenta.trim() == ""){
            return ;
        }   
        let chargeOrPayment = movement.abono > 0 ? "abono" : "cargo";
        const abono = movement.abono > 0 ? true : false;

        const fecha = moment(movement.fecha.date, 'YYYY-MM-DD HH:mm:ss.SSSSSS').format('DD-MM-YYYY');
        const fechaTimeStamp = moment(fecha,'DD-MM-YYYY').format('X');
        return {
            fecha: fecha,
            fechaTimeStamp: fechaTimeStamp,
            desc: movement.descripcion,
            monto: movement[chargeOrPayment],
            abono: abono,
        }
    }).filter((movement) => movement != undefined);
    
    // loop through all bank movements and add them to the corresponding day
    console.log(bankMovementsData['egresos']);
    bankData.forEach((movement) => {
        const { fechaTimeStamp, monto, abono } = movement;
        const egresoIngreso = abono ? 'ingresos' : 'egresos';
        const dayOnArray = bankMovementsData[egresoIngreso].find(({timestamp}) => {
            return timestamp == fechaTimeStamp;
        });
        if(!dayOnArray){
            return
        }
        dayOnArray.lvlCodes.push(movement);
        dayOnArray.total += monto;
    });

    console.log('tributarieDocumentsCategories',tributarieDocumentsCategories); 

    // Get and Set all tributarie documents on future movements
    setFutureDocumentsOnBankMovements();

    // data for INTEC business
    const data = {
        businessName: 'INTEC',
        businessId: 77604901,
        businessAccount: 63741369
    }

    const commonMovements = await getAllCommonMovements(data);
    console.log('commonMovements',commonMovements);

    commonMovements.data.forEach((movement) => {
        const { printDateTimestamp, total, nombre, income } = movement;
        if(printDateTimestamp <= moment().format('X')){
            return
        }
        const egresoIngreso = income ? 'commonIncomeMovements' : 'commonOutcomeMovements';
        const dayOnArray = bankMovementsData[egresoIngreso].find(({timestamp}) => {
            return timestamp == printDateTimestamp;
        });
        if(!dayOnArray){
            return
        }
        dayOnArray.lvlCodes.push(movement);
        dayOnArray.total += parseInt(total);
    });

    console.log('bankMovementsData',bankMovementsData);
}
async function readExcelFile(){
    const file = await fetch('ws/Clay/readClayDataFromExcel/bankMovements.php');
    const data = await file.json();
    return data;
}
function setAllDaysOnYear (){
    const bankMovementsData = setAllDaysOnCurrentYearTemplate();
    return bankMovementsData;
}

function setAllDaysOnCurrentYearTemplate(){
    let movementsByDate = {
        ingresos: [],
        egresos: [],
        projectedIncome : [],
        projectedOutcome : [],
        commonIncomeMovements : [],
        commonOutcomeMovements : []
    };

    const allCategories = ['ingresos','egresos','projectedIncome','projectedOutcome','commonIncomeMovements','commonOutcomeMovements'];

    allMyDates.forEach((date, index) => {
        console.log('date',date)
        const predate = moment(date,'YYYY-MM-DD').format('DD-MM-YYYY');
        const timeStampDate = moment(predate,'DD-MM-YYYY').format('X');
        
        const dayOfYear = moment(predate,'DD-MM-YYYY').dayOfYear();
        allCategories.forEach((category)=>{
            movementsByDate[category].push({
                humanDate: date,
                dateIndex: dayOfYear,
                timestamp: timeStampDate,
                lvlCodes: [

                ],
                total: 0
            });
        }); 
    });
    return movementsByDate;
}


function setFutureDocumentsOnBankMovements(){
    tributarieDocumentsCategories.forEach((category) => {
        const documents = tributarieDocuments[category].filter(({contable,paid}) => contable && !paid);
        documents.forEach((document) => {

            const {emitida,fecha_expiracion,saldo} = document;
            const egresoIngreso = emitida ? 'projectedIncome' : 'projectedOutcome';
            // console.log('egresoIngreso',egresoIngreso);
            const formatDate = moment(fecha_expiracion,"DD-MM-YYYY").format('X'); 
            // const printDateTimeStamp = moment(formatDate,'YYYY-MM-DD').format('X');
             
            let printDate = formatDate;
            //get difference in days between today and expiration date
            const diffOnDaysFromEmission = moment().diff(moment(formatDate,"X"), 'days');
            if(diffOnDaysFromEmission > 0){
                // get amount of weeks between today and expiration date
                const weeks = Math.ceil(diffOnDaysFromEmission / 7);
                // add weeks to expiration date
                printDate = moment(formatDate,"X").add(weeks * 7, 'days').format('X');
            }
            const dayOnArray = bankMovementsData[egresoIngreso].find(({timestamp}) => {
                return moment(timestamp,'X').format('YYYY-MM-DD') == moment(printDate,'X').format('YYYY-MM-DD');
            });
            if(!dayOnArray){
                return
            }
            dayOnArray.lvlCodes.push(document);
            // console.log('saldo',saldo); 

            if(saldo === 0){
                console.log('document',document);
            }
            // console.log('dayOnArray.total',dayOnArray.total);
            dayOnArray.total += saldo;
        });
    });
}

// RENDER FUNCTIONS

