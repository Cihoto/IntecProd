function printDailyBookTable(tbody,allDaysOnYear,
    getDocumentOutPaymentDate,
    incomeAccountRows,
    accountData_IncomeNoDocumentWithFolio, 
    accountData_OutcomeNoDocumentWithFolio,
    outRows,
    futureDocuments,
    totalDailyBalance){

    // renderMyHorizontalView()

    // INCOME
    const incomeTr = setIncomeResumeRow();
    tbody.appendChild(incomeTr);
    // INCOME ACCOUNTS
    incomeAccountRows.forEach((row)=>{
        tbody.appendChild(row);
    });
    // INCOME NO DOCUMENT
    const incomeNoDocumentTr = setIncomeNoDocumentRow(accountData_IncomeNoDocumentWithFolio);
    tbody.appendChild(incomeNoDocumentTr);
    // Projected Documents
    const projectedDocumentsTr = setProjectedDocumentsRow();
    tbody.appendChild(projectedDocumentsTr);
    // OUT
    const outComeTr = setOutcomeResumeRow();
    tbody.appendChild(outComeTr);
    // OUTA ACCOUNTS
    outRows.forEach((row)=>{
        tbody.appendChild(row);
    });
    // OUT NO DOCUMENT
    const outComeNoDocumentTr = setOutNoDocumentRow(accountData_OutcomeNoDocumentWithFolio);
    tbody.appendChild(outComeNoDocumentTr);
    // OUT PROJECTED DOCUMENTS
    const outComeProjectedDocumentsTr = setOutComeProjectedDocumentsRow();
    tbody.appendChild(outComeProjectedDocumentsTr);

    renderDailyTotalRow(allDaysOnYear);

    const totalTr = setTotalRow();
    tbody.appendChild(totalTr);

    createDailyBalance();
    const balanceTr = document.querySelectorAll('tbody .resumeRowBalance')[0];

    // GET ALL TR TYPES
    const incomeTrResume = document.querySelectorAll('tbody .--incomeRow');
    const outcomeTrResume = document.querySelectorAll('tbody .--outcomeRow');
    // alldays on year is an array with 365 objects
    allDaysOnYear.ingresos.forEach((day,index)=>{
        const dayOfYear = index + 1;
        const total = day.total;
        day.lvlCodes.forEach((lvlCode)=>{
            let trIndex = 0;
            let totalMovements = 0;
            let objToAdd = 'debito';
            let codes = lvlCode.lvl4.split('.');
            if(codes[0] == '00' && codes[1] == '00' && codes[2] == '00' && codes[3] == '44'){
                objToAdd = 'monto';
            }

            lvlCode.movements.forEach((movement)=>{
                totalMovements += parseInt(movement[objToAdd]);
                incomeTrResume.forEach((element, index) => {
                    const accCode = element.querySelectorAll('td')[0].getAttribute('lvlCode') == lvlCode.lvl4;
                    if (accCode) {
                        trIndex = index;
                    }
                });
            });
            incomeTrResume[trIndex].querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(totalMovements);
        })
    })
    allDaysOnYear.egresos.forEach((day,index)=>{
        const dayOfYear = index + 1;
        const total = day.total;
        day.lvlCodes.forEach((lvlCode)=>{
            let trIndex = 0;
            let totalMovements = 0;
            let objToAdd = 'credito';
            let codes = lvlCode.lvl4.split('.');
            if(codes[0] == '00' && codes[1] == '00' && codes[2] == '00' && codes[3] == '33'){
                objToAdd = 'monto';
            }

            lvlCode.movements.forEach((movement)=>{
                totalMovements += parseInt(movement[objToAdd]);
                outcomeTrResume.forEach((element, index) => {
                    const accCode = element.querySelectorAll('td')[0].getAttribute('lvlCode') == lvlCode.lvl4;
                    if (accCode) {
                        trIndex = index;
                    }
                });
            });
            outcomeTrResume[trIndex].querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(totalMovements);
        })
    });
    totalDailyBalance.forEach(({ date, totalIncome, totalOutCome, total, previousAccountBalance }, index) => {
        totalTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(total);
        balanceTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(previousAccountBalance);
    });
    
    getDocumentOutPaymentDate.forEach((notPaidDocument)=>{
        const dayOfYear = dayOfTheYear(notPaidDocument.fecha_humana_emision);
        let today = moment().format('YYYY-MM-DD');
        let documentDate = moment(notPaidDocument.fecha_emision,'X').format('YYYY-MM-DD');
        const expirationDate = moment(documentDate).add(1, 'months').format('YYYY-MM-DD');
        // get difference in days between today and document date
        const diffFromExpiration = moment(today).diff(expirationDate, 'days');
        const diff = moment(today).diff(documentDate, 'days');
        // if(diffFromEmissionDate < 0){}
        const weeksToMove = Math.round(diffFromExpiration / 7);
        const weeksFromEmition = Math.round(diff / 7);
        // ADD DIFF days to document date
        // ADD WEEKS TO DOCUMENT DATE
        const newDate = moment(documentDate).add(weeksFromEmition, 'weeks').format('YYYY-MM-DD');
        const newDayOfYear = dayOfTheYear(newDate);
        if(weeksToMove > 1){
            projectedDocumentsTr.querySelectorAll('td')[newDayOfYear].classList.add('red');
        }else{
            projectedDocumentsTr.querySelectorAll('td')[newDayOfYear].classList.add('yellow');
        }
        projectedDocumentsTr.querySelectorAll('td')[newDayOfYear].innerText = getChileanCurrency(notPaidDocument.total.total);
    });

    futureDocuments.forEach((futureDocument)=>{ 
        const dayOfYear = dayOfTheYear(moment(futureDocument.futureDate,'X').format('YYYY-MM-DD'));
        if(futureDocument.recibida == true){
            // outComeProjectedDocumentsTr.querySelectorAll('td')[dayOfYear].classList.add('yellow');
            outComeProjectedDocumentsTr.querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(futureDocument.total.total);
        }else{
            // projectedDocumentsTr.querySelectorAll('td')[dayOfYear].classList.add('yellow');
            projectedDocumentsTr.querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(futureDocument.total.total);
        }
    });
    const CARD_DATA = getMyCardsData(totalDailyBalance,futureDocuments);
    setBankResumeData(CARD_DATA);
}


function renderDailyTotalRow(alldaysOnYear){
    const incomeTrResume = document.querySelectorAll('tbody .resumeRowIncome');
    const outComeTrResume = document.querySelectorAll('tbody .resumeRowOutCome');
    const ingresos = alldaysOnYear.ingresos;
    const egresos = alldaysOnYear.egresos;

    ingresos.forEach((day)=>{
        const dayOfYear = dayOfTheYear(day.humanDate);
        incomeTrResume[0]
            .querySelectorAll('td')[dayOfYear]
            .innerText = getChileanCurrency(alldaysOnYear.ingresos[dayOfYear - 1].total);
    });

    egresos.forEach((day)=>{
        const dayOfYear = dayOfTheYear(day.humanDate);
        outComeTrResume[0]
            .querySelectorAll('td')[dayOfYear]
            .innerText = getChileanCurrency(alldaysOnYear.egresos[dayOfYear - 1].total);
    });
}



function getMyCardsData(totalDailyBalance,futureDocuments){
    // console.log('totalDailyBalance',totalDailyBalance);

    const data = {
        currentBankBalance: 0,
        pendingPayments: {
            total: 0,
            pendingDocuments: 0,
        },
        pendingCharges: {
            total: 0,
            pendingDocuments: 0,
        }
    };

    const today = moment().format('YYYY-MM-DD');
    const todayIndex = dayOfTheYear(today);
    // console.log('totalDailyBalance',totalDailyBalance)
    // console.log('totalDailyBalance[todayIndex - 1]',totalDailyBalance[todayIndex - 1])
    // console.log('totalDailyBalance[todayIndex - 1]',totalDailyBalance[todayIndex - 1].previousAccountBalance)
    const todayBalance = totalDailyBalance[todayIndex - 1].previousAccountBalance;
    data.currentBankBalance = todayBalance;
    let totalPendingPayments = 0;
    let totalPendingCharges = 0;
    futureDocuments.forEach((futureDocument)=>{

        if(futureDocument.pagada == true){
            return;
        }  
        const totalDocument = futureDocument.total.total;
        console.log('totalDocument',totalDocument)
        if(futureDocument.recibida == true){
            data.pendingCharges.total += parseInt(totalDocument);
            data.pendingCharges.pendingDocuments++;
        }else{
            data.pendingPayments.total += parseInt(totalDocument);
            data.pendingPayments.pendingDocuments++;
        }
    });
    return data;
}