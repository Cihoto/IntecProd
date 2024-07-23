const pDom = document.getElementById('matches');

let bankMov;
let matchData;
let libroDiario;
let allDailyMovesWithBankMovement = [];




window.addEventListener("load", async (event) => {
    renderMyHorizontalView();

    console.log('jsonMmovs', movs);

    const filteredMovs = movs.map((movement) => {
        if (movement.data.length === 0) {
            return false;
        } else {
            return movement.data;
        }
    });



    // bankMov = await fetch('ws/Clay/getBankMovements.php')
    //     .then((response) => response.json())
    //     .then((data) => {
    //         return data
    //     })
    //     .catch((error) => console.log(error));
    // pDom.innerText = JSON.stringify(bankMov);

    bankMov = await fetch('bankMovements2024.json')
        .then((response) => response.json())
        .then((data) => {
            return data
        })
        .catch((error) => console.log(error));
    console.log('bankMov', bankMov);

    // let matchData____ = await fetch('ws/Clay/getAllMatchesBankMovements.php')
    //     .then((response) => response.json())
    //     .then((data) => {
    //         return data
    //     })
    //     .catch((error) => console.log(error));
    // console.log('matchData____', matchData____);
    // pDom.innerText = JSON.stringify(matchData____);

    matchData = await fetch('matchData2024.json')
        .then((response) => response.json())
        .then((data) => {
            return data
        })
        .catch((error) => console.log(error));
    console.log('matchData', matchData);

    libroDiario = await fetch('libroDiario2024.json')
        .then((response) => response.json())
        .then((data) => {
            return data
        })
        .catch((error) => console.log(error));

    console.log('libroDiario', libroDiario);

    const allMyDocuments = await fetch('tributarieDocuments.json')
    .then((response) => response.json())
    .then((data) => {
        return data
    })
    .catch((error) => console.log(error));

    console.log('allMyDocuments', allMyDocuments);

    // libroDiario = await fetch('ws/Clay/getDailyBookMovements.php')
    //     .then((response) => response.json())
    //     .then((data) => {
    //         return data
    //     })
    //     .catch((error) => console.log(error));
    // console.log('libroDiario', libroDiario);

    getTotalOutCome(allMyDocuments);
    return;

    const trResumeIncome = document.getElementById('resumeRowIncome');
    trResumeIncome.addEventListener('click', () => {
        document.querySelectorAll('.--incomeRow').forEach((element) => { element.classList.toggle('--hide') });
    });
    const trResumeOutcome = document.getElementById('resumeRowOutcome');
    trResumeOutcome.addEventListener('click', () => {
        document.querySelectorAll('.--outcomeRow').forEach((element) => { element.classList.toggle('--hide') });
    });

    // get all tr with class codeAccountRow and get click event 
    const codeAccountRow = document.querySelectorAll('.codeAccountRow');
    codeAccountRow.forEach((element) => {
        element.addEventListener('click', () => {
            console.log('element', element);
            const getAllMyMovementsOnAccount = allDailyMovesWithBankMovement.find((movements) => {
                return movements.lvl4 == element.getElementsByTagName('td')[0].getAttribute('lvlCode')
            });

            if (!getAllMyMovementsOnAccount) {
                return;
            }
            console.log('getAllMyMovementsOnAccount', getAllMyMovementsOnAccount);
            const allMyMovementsOnAccount = getAllMyMovementsOnAccount.movements.debito.map((element) => {
                return element.data;
            });
            console.log('allMyMovementsOnAccount', allMyMovementsOnAccount);
            let allMyCustomersOnAccount = [];

            allMyMovementsOnAccount.forEach((movement) => {

                const customerIsOnArray = allMyCustomersOnAccount.find((element) => { return element.rut == movement.rut });
                if (!customerIsOnArray) {
                    allMyCustomersOnAccount.push({
                        'rut': movement.rut,
                        'name': movement.contraparte,
                        'movements': []
                    });
                }
                const indexOfCustomer = allMyCustomersOnAccount.map((element) => element.rut).indexOf(movement.rut);
                allMyCustomersOnAccount[indexOfCustomer].movements.push(movement);
            });

            console.log('allMyCustomers', allMyCustomersOnAccount);

            allMyCustomersOnAccount.forEach((customer) => {
                const tr = document.createElement('tr');
                tr.classList.add('customerRow');
                let firstTd = `<td><p>${customer.name}</p></td>`;

                let contentTd = '';
                for (let i = 1; i <= allMyDates.length; i++) {
                    contentTd += '<td></td>';
                }
                tr.innerHTML = `${firstTd}${contentTd}`;
                tbody.appendChild(tr);

                // append tr after clicked element
                element.after(tr);
            })



        });
    });


});

function dayOfTheYear(date) {
    return moment(date).dayOfYear();
}



let noFolioMovements = [];
let allDaysOnYear = []
function getTotalOutCome(allMyDocuments){


    const notPaidDocuments = allMyDocuments.data.items.filter((document)=>{return document.pagado == false});

    console.log('notPaidDocuments',notPaidDocuments);

    const getDocumentOutPaimentDate = notPaidDocuments.filter((document)=>{
        let today = moment().format('YYYY-MM-DD');
        let documentDate = moment(document.fecha_emision,'X').format('YYYY-MM-DD');
        // get difference in days between today and document date
        const diff = moment(today).diff(documentDate, 'days');
        console.log('diff',diff);
        return diff > 30;
    });

    console.log('getDocumentOutPaimentDate',getDocumentOutPaimentDate);
    

    let accountCodes = [];
    let incomeAccountCodes = [];
    let outcomeAccountCodes = [];

    allDaysOnYear = getAllDaysOnYearTemplate();

    let totalEgresos = 0;
    let totalIngresos = 0;
    const classificatedMovements = classifyAllMovements(bankMov);
    const incomeBankMovements = classificatedMovements.incomeMovements;
    const outcomeBankMovements = classificatedMovements.outcomeMovements;
    const noMatchMovements = classificatedMovements.noMatchMovements;
    let noMatch = [];
    // Toma los movimientos de ingreso bancario y busca su match en el matchData
    let incomeMovementsWithMatchInfo = [];
    incomeBankMovements.forEach((bankMovement)=>{
        const matches = bankMovement.matches;
        // iterar sobre los matches y buscar el match en el matchData
        const matchInfo = matches.map((bankMatch)=>{
            const dataMatch = matchData.data.items.find(({movimiento_id,folio,fecha_movimiento_humana,monto_match})=>{
                return movimiento_id === bankMovement.id 
                && folio === bankMatch.numero 
                && fecha_movimiento_humana === bankMovement.fecha_humana
                && monto_match === bankMatch.monto_conciliado;
            })
            if(!dataMatch){
                noMatch.push({
                    bankMovement
                });
                return;
            }

            return {
                folio: dataMatch.folio,
                monto: dataMatch.monto_match,
                montoConciliado: bankMatch.monto_conciliado,
                montoInsoluto: bankMovement.monto_original === bankMovement.monto ? 0 : bankMovement.saldo_insoluto,
                fechaMovimiento: moment(dataMatch.fecha_movimiento_humana).format('YYYY-MM-DD'),
                fechaMatch: moment(dataMatch.fecha_match).format('YYYY-MM-DD'),
                receptor: dataMatch.receptor_obligacion,
                emisor: dataMatch.emisor_obligacion,
                abono: dataMatch.abono,
                rutReceptor: parseInt(`${dataMatch.receptor_obligacion.rut}${dataMatch.receptor_obligacion.dv}`),
                rutEmisor: parseInt(`${dataMatch.emisor_obligacion.rut}${dataMatch.emisor_obligacion.dv}`),
            }
            
        });

        // for (let index = 0; index < matchInfo.length; index++) {
        //     return matchInfo[index];
        // }

        // Buscar info. de match en libro diario
        let arrayToReturn = [];
        
        const libroDiarioMatch = matchInfo.map((match)=>{
            // console.log(match.folio)

            const libroDiarioMovement = libroDiario.data.items.filter((dailyBookMovement)=>{
                const bookRut = dailyBookMovement.rut === null ? '' : parseInt(dailyBookMovement.rut.replaceAll('-',''));
                if(bookRut === '' || bookRut === undefined){
                    arrayToReturn.push({
                        'Rut': dailyBookMovement.rut,
                        'bookRut': bookRut
                    })
                    return;
                }
                const folio_str =  dailyBookMovement.detalles.split('#')[1];
                if (folio_str == undefined) {
                    arrayToReturn.push({
                        'Folio': dailyBookMovement.detalles,
                        'bookFolio': folio_str
                    })
                    return;
                }
                const folio = parseInt(folio_str.split(' ')[0]);
                return folio == parseInt(match.folio) 
                && bookRut == match.rutReceptor;
            });
            
            if(libroDiarioMovement.length === 0){
                return;
            }

            let out = {
                folio : match.folio,
                movements : [],
                lvl4: '',
                lvlName : '',
            };
            let lvl4 = libroDiarioMovement.find((bookMovement)=>{return bookMovement.ruta.level4.codigo.split('.')[0] == 4});
            const bankMovements = libroDiarioMovement.filter((bookMovement)=>{

                let codes = bookMovement.ruta.level4.codigo.split('.');
                
                return codes[0] == 1 && codes[1] == '02';
            });


            if(lvl4 === undefined){
                lvl4 = libroDiarioMovement.find((bookMovement)=>{
                    return bookMovement.ruta.level4.codigo.split('.')[0] == 1 && bookMovement.ruta.level4.codigo.split('.')[1] != '02'
                });
            } 
            out.movements = bankMovements;
            out.lvl4 = lvl4.ruta.level4.codigo;
            out.lvlName = lvl4.ruta.level4.nombre;

            const indexOfFolio = incomeMovementsWithMatchInfo.map((element)=>element.folio).indexOf(match.folio);

            if(indexOfFolio === -1){
                return out;
            }
            if(incomeMovementsWithMatchInfo[indexOfFolio].movements === bankMovements){
                return [];
            }

        });

        libroDiarioMatch.forEach((element)=>{
            if(element){
                incomeMovementsWithMatchInfo.push(element);
                // get if account code exists
                const accountCode = accountCodes.find((acc)=>{return acc.lvl4 == element.lvl4});
                if(accountCode){
                    return;
                }
                console.log('element.lvl4',element.lvl4);
                accountCodes.push({
                    lvl4: element.lvl4,
                    lvl4Name: element.lvlName,
                })
            }
        });
    });

    // REMOVE THIS LINES AFTER FINISH
    // start
        let sorted = incomeMovementsWithMatchInfo.sort((a,b)=>{return a.folio - b.folio});
        console.log('incomeMovementsWithMatchInfo',sorted);
    // end

    incomeMovementsWithMatchInfo.forEach((incomeMovement)=>{
        incomeMovement.movements.forEach((movement)=>{
            let date = moment(movement.fecha_contabilizacion_humana,'DD-MM-YYYY').format('YYYY-MM-DD');
            const dayOfYear = dayOfTheYear(date);
            allDaysOnYear.ingresos[dayOfYear - 1].total += parseInt(movement.debito);
        });
    });

    let outcomeMovementsWithMatchInfo = [];
    let notMatchedOutcomeMovements = [];
    let noDailyBookMovements = [];
    let noMatchCounter_OutCome = 0
    let falseSeat = [];
    let counterOuitCome = 0 ;
    let montosInsolutos = [];
    outcomeBankMovements.forEach((outcomeMovement)=>{
        const dayday = dayOfTheYear(outcomeMovement.fecha_humana);
        let isSearchDay = false;

        if(dayday == 53){
            isSearchDay = true;
        }

        let insoluto = 0;
        if(outcomeMovement.monto_original != outcomeMovement.saldo_insoluto){
            insoluto = outcomeMovement.saldo_insoluto;
            montosInsolutos.push({
                fechaMovimiento: moment(outcomeMovement.fecha_humana).format('YYYY-MM-DD'),
                montoInsoluto: insoluto,
            })
        }
        


        const matches = outcomeMovement.matches;
        if(isSearchDay == true){
            console.log('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
            console.log('outcomeMovement',outcomeMovement);
            counterOuitCome += outcomeMovement.monto;
            console.log('matches',matches);
        }
        const matchInfo = matches.map((bankMatch)=>{
            const dataMatch = matchData.data.items.find(({movimiento_id,folio,fecha_movimiento_humana,monto_match})=>{
                return movimiento_id === outcomeMovement.id 
                && folio === bankMatch.numero 
                && fecha_movimiento_humana === outcomeMovement.fecha_humana
                && monto_match === bankMatch.monto_conciliado;
            })
            if(!dataMatch){
                noMatch.push({
                    outcomeMovement
                });
                return;
            }
            return {
                folio: dataMatch.folio,
                monto: dataMatch.monto_match,
                montoConciliado: bankMatch.monto_conciliado,
                montoInsoluto: insoluto,
                fechaMovimiento: moment(dataMatch.fecha_movimiento_humana).format('YYYY-MM-DD'),
                fechaMovimientoBook: moment(dataMatch.fecha_movimiento_humana).format('DD-MM-YYYY'),
                fechaMatch: moment(dataMatch.fecha_match).format('YYYY-MM-DD'),
                receptor: dataMatch.receptor_obligacion,
                emisor: dataMatch.emisor_obligacion,
                abono: dataMatch.abono,
                rutReceptor: parseInt(`${dataMatch.receptor_obligacion.rut}${dataMatch.receptor_obligacion.dv}`),
                rutEmisor: parseInt(`${dataMatch.emisor_obligacion.rut}${dataMatch.emisor_obligacion.dv}`),
            }
        });
        
        
        if(matchInfo[0] == undefined){
            noMatchCounter_OutCome++;
            // skip one loop
            return;
        }

        if(isSearchDay == true){
            console.log('matchInfo',matchInfo);
        }
  
        // Buscar info. de match en libro diario
        let arrayToReturn = [];
        let FoundSeatNumber = false;
        let pushElement = false;
        // const libroDiarioMatch = matchInfo.map((match)=>{

        matchInfo.forEach((match)=>{

            let out = {
                folio : match.folio,
                montoInsoluto: 0,
                movements : [],
                lvl4: '',
                lvlName : '',
                id: 0
            };

            let found = false;

            const libroDiarioMovement = libroDiario.data.items.filter((dailyBookMovement)=>{
                const bookRut = dailyBookMovement.rut === null ? '' : parseInt(dailyBookMovement.rut.replaceAll('-',''));
                if(bookRut === '' || bookRut === undefined){
                    arrayToReturn.push({
                        'Rut': dailyBookMovement.rut,
                        'bookRut': bookRut
                    })
                    return;
                }
                const folio_str =  dailyBookMovement.detalles.split('#')[1];
                if (folio_str == undefined) {
                    arrayToReturn.push({
                        'Folio': dailyBookMovement.detalles,
                        'bookFolio': folio_str
                    })
                    return;
                }
                const folio = parseInt(folio_str.split(' ')[0]);
                return folio == parseInt(match.folio) 
                && bookRut == match.rutEmisor
                && (dailyBookMovement.debito == match.monto || dailyBookMovement.credito == match.monto)
            });

            if(libroDiarioMovement.length === 0){
                // console.log('no daily book movement',match.folio);
                if(isSearchDay == true){
                    console.log('------------ 1');
                    totalEgresos += match.monto;
                    console.log('monto 1',match.monto);
                }
                noDailyBookMovements.push({
                    folio: match.folio,
                    data: match
                });

                return 
            }
            if(isSearchDay == true){
                console.log('match',match);
                console.log('libroDiarioMovement',libroDiarioMovement);
            }


            let dailyBookMovements = [];

            libroDiarioMovement.forEach((element)=>{
                const asientoExists = dailyBookMovements.find((dailyBookMovement)=>{
                    return dailyBookMovement.numero_asientos === element.numero_asientos;
                });
                if(!asientoExists){
                    dailyBookMovements.push({
                        numero_asientos: element.numero_asientos,
                        data: []
                    });
                }
                const indexOfAsiento = dailyBookMovements
                    .map((dailyBookMovement)=>dailyBookMovement.numero_asientos)
                        .indexOf(element.numero_asientos);
                dailyBookMovements[indexOfAsiento].data.push(element);
            });
            if(isSearchDay == true){
                console.log('dailyBookMovements',dailyBookMovements);
                
            }
            const movementsDataArray = getDailyBookMovementsWithBankAccount(dailyBookMovements);
            if(isSearchDay == true){
                console.log('esto falta',movementsDataArray);
            }

            if(movementsDataArray.length === 0){
                noDailyBookMovements.push({
                    folio: match.folio,
                    data: match
                });
                return;
            }
            movementsDataArray.forEach((movementsData)=>{
                
                movementsData.movements.forEach((movement)=>{
                    movement['fechaMovimiento'] = match.fechaMovimiento;
                });
                if(isSearchDay == true){
                    console.log('movementsData inside ',movementsData);
                    totalEgresos += movementsData.movements[0].credito;
                    console.log('movementsData.movements[0].credito',movementsData.movements[0].credito);
                }
                if(!movementsData.found){
                    if(isSearchDay == true){
                        totalEgresos += match.monto;
                        console.log('------------ 2');
                        console.log('monto 2',match.monto);
                    }
                    noDailyBookMovements.push({
                        folio: match.folio,
                        data: match
                    });
                    return;
                }

                out.movements = movementsData.movements;
                out.lvl4 = movementsData.lvl4;
                out.lvlName = movementsData.lvlName;
                if(match.rutEmisor == 0 || match.rutEmisor == null || match.rutEmisor == undefined){
                    match.rutReceptor = 0;
                }
                if(match.rutReceptor == 0 || match.rutReceptor == null || match.rutReceptor == undefined){
                    match.rutReceptor = 0;
                }
                let id = parseInt(`${match.folio}${match.rutReceptor}${match.rutEmisor}`)/1000;
                out.id = id;

                const accIndex = accountCodes.map((element)=>element.lvl4).indexOf(out.lvl4);
                if(accIndex === -1){
 
                    accountCodes.push({
                        lvl4: out.lvl4,
                        lvl4Name: out.lvlName
                    });
                }   

                const indexOfFolio = outcomeMovementsWithMatchInfo.map((element)=>element.id).indexOf(id);
                if(isSearchDay == true){
                   console.log('indexOfFolio',indexOfFolio);
                   console.log('outcomeMovementsWithMatchInfo',outcomeMovementsWithMatchInfo[indexOfFolio]);
                }
                if(indexOfFolio === -1){
                    if(isSearchDay == true){
                        console.log('NO EXISTE ID EN OUTCOME');
                        console.log('out1',out);
                        console.log('NO EXISTE ID EN OUTCOME');
                    }
                    pushElement = true;
                    out.montoInsoluto = match.montoInsoluto;
                    outcomeMovementsWithMatchInfo.push(out);
                    return;
                }


                out.movements.forEach((movements)=>{

                    const movementIndex = outcomeMovementsWithMatchInfo[indexOfFolio].movements.map((element)=>element.numero_asientos).indexOf(movements.numero_asientos);
                    if(isSearchDay == true){
                      console.log('movementIndex',movementIndex);
                      console.log('outcomeMovementsWithMatchInfo[indexOfFolio].movements',outcomeMovementsWithMatchInfo[indexOfFolio].movements[movementIndex]);
                    }
                    if(movementIndex === -1){
                        if(isSearchDay == true){
                            console.log('NO EXISTE MOVIMIENTO EN OUTCOME');
                            console.log('out2',out);
                            console.log('NO EXISTE MOVIMIENTO EN OUTCOME');
                        }
                        outcomeMovementsWithMatchInfo[indexOfFolio].movements.push(movements);
                    }
                    return

                    outcomeMovementsWithMatchInfo[indexOfFolio].movements.push(movements);
                })
            });
           
        });
        if(isSearchDay == true){
            console.log('');
            console.log('');
            console.log('');
            console.log('.');
        }
    });


    let sortedOut = outcomeMovementsWithMatchInfo.sort((a,b)=>{return a.folio - b.folio});
    console.log('sortedOut',sortedOut);

    console.log('outcomeMovementsWithMatchInfo',outcomeMovementsWithMatchInfo);
    console.log('noMatchCounter_OutCome',noMatchCounter_OutCome);
    console.log('noDailyBookMovements',noDailyBookMovements);
    console.log('falseSeat',falseSeat);
    console.log('accountCodes',accountCodes);
    console.log('montosInsolutos',montosInsolutos);


    let filter29enero = [];
    outcomeMovementsWithMatchInfo.filter((element)=>{
        // console.log('element',element);
        element.movements.forEach((movement)=>{
            let date = moment(movement.fecha_contabilizacion_humana,'DD-MM-YYYY').format('YYYY-MM-DD');
            const dayOfYear = dayOfTheYear(date);
            if(dayOfYear == 53){
                filter29enero.push(movement);
            }
        });
    });
    noDailyBookMovements.forEach(({data})=>{
        // let date = moment(movement.fecha_contabilizacion_humana,'DD-MM-YYYY').format('YYYY-MM-DD');
        const dayOfYear = dayOfTheYear(data.fechaMovimiento); 
        if(dayOfYear == 22){
            filter29enero.push(data);
        }
    })

    console.log('filter29enero',filter29enero);

    const folio699 = outcomeMovementsWithMatchInfo.filter((element)=>{return element.folio === '699'});
    console.log('folio699',folio699);

    outcomeMovementsWithMatchInfo.forEach((outcomeMovement)=>{
        if(!outcomeMovement.movements){
            return
        }
        let montoInsouto = outcomeMovement.montoInsoluto;
        let dayOfYear = 0;
        const accountData = {
            lvl4: outcomeMovement.lvl4,
            lvlName: outcomeMovement.lvlName,
        }
        outcomeMovement.movements.forEach((movement,index)=>{
            let date = moment(movement.fecha_contabilizacion_humana,'DD-MM-YYYY').format('YYYY-MM-DD');
            dayOfYear = dayOfTheYear(date);
            if(movement.fecha_contabilizacion_humana == "22/02/2024"){
                console.log('movement',movement);
            }

            pushMovementToCalendar(movement,dayOfYear,accountData);
            if(dayOfYear == 53){
                console.log('++++++outcomeMovement+++++',outcomeMovement)
            }
        });
    });

    const accountData_OutcomeNoDocumentWithFolio = {
        lvl4: '00.00.00.33',
        lvlName: 'Egresos sin documento',
        debito: false
    }
    const accountData_IncomeNoDocumentWithFolio = {
        lvl4: '00.00.00.33',
        lvlName: 'Ingresos sin documento',
        debito: true
    }

    accountCodes.push(accountData_IncomeNoDocumentWithFolio);
    accountCodes.push(accountData_OutcomeNoDocumentWithFolio);

    noDailyBookMovements.forEach(({data})=>{
        const movement = data
        let date = movement.fechaMovimiento;
        const dayOfYear = dayOfTheYear(date);
        pushMovementToCalendar(movement,dayOfYear,accountData_OutcomeNoDocumentWithFolio);
    });
    noMatchMovements.credito.forEach((noMatchMovement)=>{
        const dayOfYear = dayOfTheYear(noMatchMovement.fecha_humana);
        pushMovementToCalendar(noMatchMovement,dayOfYear,accountData_OutcomeNoDocumentWithFolio);
    });
    noMatchMovements.debito.forEach((noMatchMovement)=>{
        const dayOfYear = dayOfTheYear(noMatchMovement.fecha_humana);
        pushMovementToCalendar(noMatchMovement,dayOfYear,accountData_IncomeNoDocumentWithFolio);
    });

    console.log('counterOuitCome',counterOuitCome);
    montosInsolutos.forEach((movement)=>{
        let date = movement.fechaMovimiento;
        const dayOfYear = dayOfTheYear(date);
        allDaysOnYear.egresos[dayOfYear - 1].total += parseInt(movement.montoInsoluto);
    });



    // render dailyBook table titles
    const titleTr = setIncomeResumeRow();
    tbody.appendChild(titleTr);
    const outComeTr = setOutcomeResumeRow();
    tbody.appendChild(outComeTr);
    renderDailyTotalRow(allDaysOnYear);

    const pendingDocumentsTr = setPendingResumeRow();
    tbody.appendChild(pendingDocumentsTr);

    const totalTr = setTotalRow();
    tbody.appendChild(totalTr);

    createDailyBalance();
    const balanceTr = document.querySelectorAll('tbody .resumeRowBalance')[0];

    let previousAccountBalance = 18895572;
    const totalDailyBalance = allMyDates.map((date, index) => {
        const totalIncome = allDaysOnYear.ingresos[index].total;
        const totalOutCome = allDaysOnYear.egresos[index].total;
        const total = totalIncome - totalOutCome;
        previousAccountBalance += total;
        return {
            date,
            totalIncome,
            totalOutCome,
            total,
            previousAccountBalance,
        }
    });


    totalDailyBalance.forEach(({ date, totalIncome, totalOutCome, total, previousAccountBalance }, index) => {
        totalTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(total);
        balanceTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(previousAccountBalance);
    });
    console.log('totalDailyBalance', totalDailyBalance);

    
    getDocumentOutPaimentDate.forEach((notPaidDocument)=>{
        console.log("NOT PAID DOCUMENT",notPaidDocument);
        const dayOfYear = dayOfTheYear(notPaidDocument.fecha_humana_emision);

        let today = moment().format('YYYY-MM-DD');
        let documentDate = moment(notPaidDocument.fecha_emision,'X').format('YYYY-MM-DD');
        const expirationDate = moment(documentDate).add(1, 'months').format('YYYY-MM-DD');

        console.log('DOCUMENT DATE',documentDate);
        // get difference in days between today and document date
        const diffFromExpiration = moment(today).diff(expirationDate, 'days');
        const diff = moment(today).diff(documentDate, 'days');

        // if(diffFromEmissionDate < 0){}
        const weeksToMove = Math.round(diffFromExpiration / 7);

        




        
        const weeksFromEmition = Math.round(diff / 7);
        // ADD DIFF days to document date
        // ADD WEEKS TO DOCUMENT DATE
        const newDate = moment(documentDate).add(weeksFromEmition, 'weeks').format('YYYY-MM-DD');
        console.log('weeksToMove',weeksToMove);
        console.log('weeksToMove',weeksToMove);
        console.log('weeksToMove',weeksToMove);
        console.log('weeksToMove',weeksToMove);
        console.log('weeksToMove',weeksToMove);
        console.log('weeksToMove',weeksToMove);
        const newDayOfYear = dayOfTheYear(newDate);

        
        if(weeksToMove > 1){
            pendingDocumentsTr.querySelectorAll('td')[newDayOfYear].classList.add('red');
        }else{
            pendingDocumentsTr.querySelectorAll('td')[newDayOfYear].classList.add('yellow');
        }
        pendingDocumentsTr.querySelectorAll('td')[newDayOfYear].innerText = getChileanCurrency(notPaidDocument.total.total);
        console.log(`pendingDocumentsTr.querySelectorAll('td')[dayOfYear].innerText`,pendingDocumentsTr.querySelectorAll('td')[newDayOfYear]);
    })


    console.log('totalEgresos',totalEgresos);
    console.log('totalIngresos',totalIngresos);
    console.log('allDaysOnYear',allDaysOnYear);
    console.log('noMatch',noMatch);




}

function pushMovementToCalendar(movement,dayOfYear,accountData){
    let movementType = 'ingresos';
    let incomeOrOutcome = 'debito'
    if(!movement.abono){
        movementType = 'egresos';
        incomeOrOutcome = 'credito';
    }
    if(movement.monto){
        incomeOrOutcome = 'monto'
    }
    let totalToAdd = parseInt(movement[incomeOrOutcome]);
    allDaysOnYear[movementType][dayOfYear - 1].total += parseInt(totalToAdd);

    const codeExists = allDaysOnYear[movementType][dayOfYear - 1].lvlCodes.find((acc)=>acc.lvl4 == accountData.lvl4);

    if(!codeExists){
        allDaysOnYear[movementType][dayOfYear - 1].lvlCodes.push({
            lvl4: accountData.lvl4,
            lvlName: accountData.lvlName,
            total: totalToAdd,
            movements:[]
        });
        return;
    }
    const accIndex = allDaysOnYear[movementType][dayOfYear - 1].lvlCodes.map((acc)=>acc.lvl4).indexOf(accountData.lvl4);
    allDaysOnYear[movementType][dayOfYear - 1].lvlCodes[accIndex].total += totalToAdd;
    allDaysOnYear[movementType][dayOfYear - 1].lvlCodes[accIndex].movements.push(movement);
}


function getDailyBookMovementsWithBankAccount(dailyBookMovements){


    // let data = {
    //     movements : [],
    //     lvl4: '',
    //     lvlName : '',
    //     found: false,
    // }


    let response = [];

    dailyBookMovements.forEach((dailyBookData)=>{

        if(dailyBookData.numero_asientos == 2281 || dailyBookData.numero_asientos == 2482){
            console.log('dailyBookData',dailyBookData);
        }
        const bookHasBankAccount = dailyBookData.data.filter((bookMovement)=>{
            let codes = bookMovement.ruta.level4.codigo.split('.');
            return codes[0] == 1 && codes[1] == '02';
        });
        if(bookHasBankAccount.length === 0){
            return;
        }

        let data = {
            movements : [],
            lvl4: '',
            lvlName : '',
            found: false,
        }

        data.lvl4 = 0;
        let lvl4 = dailyBookData.data.find((bookMovement)=>{
            return bookMovement.ruta.level4.codigo.split('.')[0] == 2
        });
        if(lvl4 === undefined){
            lvl4 = dailyBookData.data.find((bookMovement)=>{
                return bookMovement.ruta.level4.codigo.split('.')[0] == 1 && bookMovement.ruta.level4.codigo.split('.')[1] != '02'
            });
        }
        data.lvl4 = lvl4.ruta.level4.codigo;
        data.lvlName = lvl4.ruta.level4.nombre;
        data.movements = bookHasBankAccount;

        data.found = true;

        response.push(data);
    });


    return response;
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
 


function getAllDaysOnYearTemplate(){
    let movementsByDate = {
        ingresos: [],
        egresos: [],
        pendientes : []
    };

    allMyDates.forEach((date, index) => {
        const timeStampDate = moment(date).format('X');
        // console.log('timeStampDate',timeStampDate);
        movementsByDate.ingresos.push({
            humanDate: date,
            timestamp: timeStampDate,
            lvlCodes: [

            ],
            total: 0
        });
        movementsByDate.egresos.push({
            humanDate: date,
            timestamp: timeStampDate,
            lvlCodes: [

            ],
            total: 0
        });
        movementsByDate.pendientes.push({
            humanDate: date,
            timestamp: timeStampDate,
            movements: [

            ],
            total: 0,
        });

    });

    return movementsByDate;

}


function classifyAllMovements(bankMovements){
    let incomeMovements = [];
    let outcomeMovements = [];
    let noMatchMovements = {
        credito: [],
        debito: []
    };  
    
    bankMovements.data.items.forEach((element)=>{
        if(element.matches == null || element.matches.length === 0){

            if(element.abono){
                noMatchMovements.debito.push(element);
            }else{
                noMatchMovements.credito.push(element);
            }
            return;
        }

        if(element.abono){
            incomeMovements.push(element);
        }else{
            outcomeMovements.push(element);
        }
    });
    return {
        incomeMovements,
        outcomeMovements,
        noMatchMovements
    }
}

function matchAllMyMovements() {

    // filtrar los movimientos que tienen match
    let customBankMovementsAccounts = [
        {
            lvl4: 'CSTM.00.00.044',
            lvlName: 'Ingresos sin documento',
            movements: {
                credito: [],
                debito: []
            }
        },
        {
            lvl4: 'CSTM.00.00.033',
            lvlName: 'Egresos sin documento',
            movements: {
                credito: [],
                debito: []
            }
        }
    ];

    let bankMovementsWithMatch = bankMov.data.items.filter((movement) => movement.matches != null);
    const newMatchFilter = bankMovementsWithMatch.filter((element) => { return element.matches.length > 0 });
    bankMovementsWithMatch = newMatchFilter;

    // filtrar los movimientos que no tienen match
    const filtered_nomatch = bankMov.data.items.filter((movement) => movement.matches == null || movement.matches.length === 0);


    filtered_nomatch.forEach((movement) => {
        if (movement.abono) {
            customBankMovementsAccounts[0].movements.debito.push(movement);
        } else {
            customBankMovementsAccounts[1].movements.credito.push(movement);
        }
    });

    console.log('filtered_nomatch', filtered_nomatch);
    console.log('customBankMovementsAccounts', customBankMovementsAccounts)

    let movement_noMatch = [];
    let MATCH_DATA_BY_BANK_MOVEMENT_ID = [];

    console.log('bankMo123v', bankMov);
    console.log('bankMovementsWithMatch', bankMovementsWithMatch);
    bankMovementsWithMatch.forEach((bankMovementMatch) => {
        const matchDataExists = matchData.data.items.filter(({ movimiento_id }) => {
            if (bankMovementMatch.id == movimiento_id) {
                return true;
            }
        });
      
        if (matchDataExists) {
            const matchData_filter = matchDataExists.map(({ movimiento_id, folio, receptor_obligacion, monto_match, abono, emisor_obligacion }) => {
                return {
                    'movimiento_id': movimiento_id,
                    'folio': folio,
                    'rut_receptor': receptor_obligacion.rut,
                    'dv_receptor': receptor_obligacion.dv,
                    'rut_emisor': emisor_obligacion.rut,
                    'dv_emisor': emisor_obligacion.dv,
                    'monto_match': bankMovementMatch.monto_match,
                    'bankMovementAmount': bankMovementMatch.monto,
                    'abono': abono,
                    emisor_obligacion,
                    receptor_obligacion,
                }
            });

            for (let index = 0; index < matchData_filter.length; index++) {
                if (matchData_filter[index].folio == 216 || matchData_filter[index].folio == 219) {
                    console.log('matchData_filter[index]', matchData_filter[index])
                }
                MATCH_DATA_BY_BANK_MOVEMENT_ID.push(matchData_filter[index])
            }
        } else {
            movement_noMatch.push(bankMovementMatch)
        }
    });

    console.log('movement_noMatch', movement_noMatch);
    console.log('MATCH_DATA_BY_BANK_MOVEMENT_ID', MATCH_DATA_BY_BANK_MOVEMENT_ID);

    let sorted = MATCH_DATA_BY_BANK_MOVEMENT_ID.sort((a, b) => { return a.folio - b.folio });
    console.log('sorted', sorted);

    const debito_match = MATCH_DATA_BY_BANK_MOVEMENT_ID.filter((matchData) => {
        return matchData.abono == true
    });
    const credito_match = MATCH_DATA_BY_BANK_MOVEMENT_ID.filter((matchData) => {
        return matchData.abono == false
    });

    console.log('debito_match', debito_match);
    console.log('credito_match', credito_match);
    console.log('movement_noMatch', movement_noMatch);

    let debitoDailyBookMovements = MATCH_DATA_BY_BANK_MOVEMENT_ID.map((matchData) => {

        const matchFolio = matchData.folio;

        let matchRut = '';


        if (matchData.abono == true) {
            matchRut = parseInt(`${matchData.receptor_obligacion.rut}${matchData.receptor_obligacion.dv}`);
        } else {

            matchRut = parseInt(`${matchData.emisor_obligacion.rut}${matchData.emisor_obligacion.dv}`);
        }
        const matchMonto = matchData.monto_match;

        let found = false;
        const bookMovements = libroDiario.data.items.filter((bMovement) => {
            let bookFolio_str = bMovement.detalles.split('#')[1];
            if (bookFolio_str === undefined) {
                return;
            }

            const bookFolio = bookFolio_str.split(' ')[0];
            const bookRut = parseInt(bMovement.rut.replaceAll('-', ''));
            const bookMonto = bMovement.debito;
            // const bookRut = bMovement.rut.split('-')[0];
            // && bookRut == matchRut && matchMonto == bookMonto
            // && matchMonto == bookMonto
            // && bookRut == matchRut
            if (matchFolio == bookFolio && bookRut === matchRut) {
                found = true;
                return bMovement;
            }
        });

        outinCome = [];
        if (bookMovements) {
            outinCome = bookMovements.filter((bMovement) => {
                const ruta = bMovement.ruta;
                let codigos = ruta.level4.codigo.split('.');

                return codigos[0] == 2 || (codigos[0] == 1 && codigos[1] == '02');
                if (matchData.abono == true) {
                    return codigos[0] == 4 || (codigos[0] == 1 && codigos[1] == '02');
                } else {
                }
            });
        }
        if (outinCome.length === 0) {
            const bankMovement = bankMov.data.items.find((element) => {
                return matchData.movimiento_id === element.id;
            });

            if (bankMovement) {
                if (bankMovement.matches.length > 0 || bankMovement.matches != null) {
                    bankMovement.matches.forEach((movement) => {
                        const { subtipo_obligacion } = movement;
                        let newFolio = `${subtipo_obligacion.split(' ')[0].toLowerCase()}${movement.numero}`;
                        const folioIsOnMovements = noFolioMovements.find((mov) => {
                            return mov.folio === newFolio
                        });
                        if (!folioIsOnMovements) {
                            noFolioMovements.push({
                                folio: newFolio,
                                data: [],
                                abono: bankMovement.abono
                            })
                        }
                        const movementToPush = {
                            ...movement,
                            'monto_total': matchData.bankMovementAmount
                        }
                        const noFolioIndex = noFolioMovements.map((element) => element.folio).indexOf(newFolio);
                        noFolioMovements[noFolioIndex].data.push(movementToPush);
                    })
                }
            }
        }
        return {
            folio: matchFolio,
            data: outinCome,
            abono: matchData.abono,
            rut: matchRut,
        }
    });

    console.log('NOFOLIO__ NOFOLIO__', noFolioMovements);
    let accountCodesNoFolio = [];

    noFolioMovements.forEach((uniqueNoFolio) => {

        const data = uniqueNoFolio.data;
        data.forEach((noFolioMovement) => {
            const normalizedAbreviation = noFolioMovement.subtipo_obligacion.split(' ')[0].toLowerCase();
            const incomeOrOutcome = noFolioMovement.abono ? 'C44' : 'C33';
            let lvl4 = `CSTM.${normalizedAbreviation}.00.${incomeOrOutcome}`
            const accountCode = accountCodesNoFolio.find((acc) => {
                return acc.lvl4 === lvl4;
            });
            if (!accountCode) {
                accountCodesNoFolio.push({
                    lvl4: lvl4,
                    lvlName: noFolioMovement.subtipo_obligacion,
                    movements: {
                        credito: [],
                        debito: []
                    }
                });
            }
            const indexOfCode = accountCodesNoFolio.map((element) => element.lvl4).indexOf(lvl4);
            accountCodesNoFolio[indexOfCode].movements[noFolioMovement.abono ? 'debito' : 'credito'].push(noFolioMovement);
        });
    });

    debitoDailyBookMovements = debitoDailyBookMovements.sort((a, b) => {
        return a.folio - b.folio;
    });
    console.log('debitoDailyBookMovements', debitoDailyBookMovements);
    let total2enero = 0;
    debitoDailyBookMovements.forEach((element)=>{
        // console.log('element',element);
        // console.log('element',element);
        element.data.forEach((data)=>{  
            if(data.fecha_contabilizacion_humana == '02/01/2024'){
                total2enero += parseInt(data.credito);
            }
        })
    });
    console.log('total2enero',total2enero);

    const filtered_debitoDailyBookMovements = debitoDailyBookMovements.filter((element) => {
        return element.data.length > 0;
    });

    console.log('filtered_debitoDailyBookMovements', filtered_debitoDailyBookMovements);

    // new set of movements
    // set new array with only unique values sorted by filtered_debitoDailyBookMovements.folio 
    let uniquevalues = [];
    filtered_debitoDailyBookMovements.forEach((bookMovements) => {
        let found = false;
        // console.log('element',element);

        const folioAll = bookMovements.folio;
        uniquevalues.forEach((uniqueElement, index) => {

            const folioUnique = uniqueElement.folio;

            if (folioAll == folioUnique && bookMovements.rut == uniqueElement.rut) {
                found = true;
            } else {
                found = false;
            }
        });

        if (!found) {
            uniquevalues.push(bookMovements);
        }


        // uniquevalues.forEach((uniqueElement,index)=>{
        //     if(element.folio == uniqueElement.folio && element.abono == uniqueElement.abono){
        //         if(element.data.length === 0){
        //             return ;
        //         }
        //         if(uniquevalues[index].data.length < element.data.length){
        //             uniquevalues[index] = element;
        //         }
        //         if(uniqueElement.data[0].rut === element.data[0].rut){
        //             found = true;
        //         }
        //     }
        // });
        // if(!found){
        //     uniquevalues.push(element);
        // }
    });
    console.log('uniquevalues', uniquevalues);

    // const sortedMovs = uniquevalues.sort((a,b)=>{
    //     return a.folio - b.folio;
    // });



    filtered_debitoDailyBookMovements.forEach((movement, index) => {
        let currentCode = 0;
        const cuentaContable = movement.data.filter((dailyBookMovements) => {
            let codes = dailyBookMovements.ruta.level4.codigo.split('.');
            currentCode = codes[0];
            return codes[0] == 4 || codes[0] == 2 ;
        });
        if (cuentaContable.length === 0) {
            return;
        };
        const movimientoCuentaActivo = movement.data.filter((dailyBookMovements) => {
            let codes = dailyBookMovements.ruta.level4.codigo.split('.');
            return codes[0] == 1;
        });

        if (movimientoCuentaActivo.length === 0) {
            return;
        }
        const codeExistsOnArray = allDailyMovesWithBankMovement.find((element) => {
            return element.lvl4 === cuentaContable[0].ruta.level4.codigo;
        });
        if (!codeExistsOnArray) {
            allDailyMovesWithBankMovement.push({
                lvl4: cuentaContable[0].ruta.level4.codigo,
                lvlName: cuentaContable[0].ruta.level4.nombre,
                total: 0,
                movements: {
                    credito: [],
                    debito: []
                }
            });
        }
        const indexOfCode = allDailyMovesWithBankMovement.map((element) => element.lvl4).indexOf(cuentaContable[0].ruta.level4.codigo);
        movimientoCuentaActivo.forEach((bankMovement) => {
            if (bankMovement.debito > 0 && bankMovement.credito === 0) {
                allDailyMovesWithBankMovement[indexOfCode].total += bankMovement.debito;
                allDailyMovesWithBankMovement[indexOfCode].movements.debito.push({
                    folio: movement.folio,
                    data: bankMovement
                });
            }
            if (bankMovement.debito === 0 && bankMovement.credito > 0) {

                allDailyMovesWithBankMovement[indexOfCode].total += bankMovement.credito;
                allDailyMovesWithBankMovement[indexOfCode].movements.credito.push({
                    folio: movement.folio,
                    data: bankMovement
                });
            }
        })
    });

    // push all custom bank movements to allDailyMovesWithBankMovement
    customBankMovementsAccounts.forEach((customMovement) => {
        allDailyMovesWithBankMovement.push(customMovement);
    });

    // PUSH ALL NOFOLIOMOVEMENTS ACCOUNTS TO allDailyMovesWithBankMovement
    accountCodesNoFolio.forEach((customMovement) => {
        allDailyMovesWithBankMovement.push(customMovement);
    })


    console.log('allDailyMovesWithBankMovement', allDailyMovesWithBankMovement);
    createIncomeRows(allDailyMovesWithBankMovement);
    createCustomIncomeRows(allDailyMovesWithBankMovement);
    createOutComeRows(allDailyMovesWithBankMovement);
    createCustomOutcomeRows(allDailyMovesWithBankMovement);
    createDailyTotalRow();
    createDailyBalance();


    let previousAccountBalance = 18895572;


    const allDaysMovementsArray = orderAllMyMovementsByDate(allDailyMovesWithBankMovement);

    // get all my tr inside array
    const theadTr = document.querySelectorAll('thead tr');
    const tbodyTr = document.querySelectorAll('tbody .codeAccountRow');
    const tbodyTrIncome = document.querySelectorAll('tbody .--incomeRow');
    const tbodyTrOutIncome = document.querySelectorAll('tbody .--outcomeRow');
    const incomeTrResume = document.querySelectorAll('tbody .resumeRowIncome');
    const outComeTrResume = document.querySelectorAll('tbody .resumeRowOutCome');
    const totalTr = document.querySelectorAll('tbody .resumeRowTotal')[0];
    const balanceTr = document.querySelectorAll('tbody .resumeRowBalance')[0];


    const totalDailyBalance = allMyDates.map((date, index) => {
        const totalIncome = allDaysMovementsArray.ingresos[index].total;
        const totalOutCome = allDaysMovementsArray.egresos[index].total;
        const total = totalIncome - totalOutCome;
        previousAccountBalance += total;
        return {
            date,
            totalIncome,
            totalOutCome,
            total,
            previousAccountBalance,
        }
    });
    console.log('totalDailyBalance', totalDailyBalance);

    allDaysMovementsArray.ingresos.forEach(({ humanDate, timestamp, lvlCodes }) => {
        let diarioAcumulado = 0;
        const dayOfYear = moment(timestamp, 'X').dayOfYear();

        incomeTrResume[0]
            .querySelectorAll('td')[dayOfYear]
            .innerText = getChileanCurrency(allDaysMovementsArray.ingresos[dayOfYear - 1].total);

        if (lvlCodes.length === 0) { return }

        if (lvlCodes.length === 0) {
            if (dayOfYear === 0) {
            }
            return;
        }

        lvlCodes.forEach((data) => {
            const indexOfAccountCode = allDailyMovesWithBankMovement.map((element) => element.lvl4).indexOf(data.lvl4);
            let total = 0;
            let codes = data.lvl4.split('.');

            if (codes[0] == 'CSTM' && codes[3] == '044') {
                data.customMovements.forEach(({ monto }) => {
                    total += parseInt(monto);
                })
            } else {
                data.movements.forEach(({ debito }) => {
                    total += parseInt(debito);
                });
            }

            let trIndex = 0;
            tbodyTrIncome.forEach((element, index) => {
                const accCode = element.querySelectorAll('td')[0].getAttribute('lvlCode') == data.lvl4;
                if (accCode) {
                    trIndex = index;
                }
            });
            tbodyTrIncome[trIndex].querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(total);

        });
    });

    allDaysMovementsArray.egresos.forEach(({ humanDate, timestamp, lvlCodes }) => {
        let diarioAcumulado = 0;
        const dayOfYear = moment(timestamp, 'X').dayOfYear();
        outComeTrResume[0].querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(allDaysMovementsArray.egresos[dayOfYear - 1].total);
        if (lvlCodes.length === 0) { return }

        if (lvlCodes.length === 0) {
            if (dayOfYear === 0) {
            }
            return;
        }
        lvlCodes.forEach((data) => {

            let total = 0;
            let codes = data.lvl4.split('.');

            if (codes[0] == 'CSTM' && codes[3] == '033') {
                data.customMovements.forEach(({ monto }) => {
                    total += parseInt(monto);
                });
            } else {
                data.movements.forEach(({ credito }) => {
                    total += parseInt(credito);
                });
            }

            let trIndex = 0;
            tbodyTrOutIncome.forEach((element, index) => {
                const accCode = element.querySelectorAll('td')[0].getAttribute('lvlCode') == data.lvl4;

                if (accCode) {
                    trIndex = index;
                }
            });
            tbodyTrOutIncome[trIndex].querySelectorAll('td')[dayOfYear].innerText = getChileanCurrency(total);
        });
    });

    totalDailyBalance.forEach(({ date, totalIncome, totalOutCome, total, previousAccountBalance }, index) => {
        totalTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(total);
        balanceTr.querySelectorAll('td')[index + 1].innerText = getChileanCurrency(previousAccountBalance);
    })

}

function orderAllMyMovementsByDate(allDailyMovesWithBankMovement) {
    let movementsByDate = {
        ingresos: [],
        egresos: []
    };
    let sinFecha = [];

    let counter = 0;

    allMyDates.forEach((date, index) => {
        const timeStampDate = moment(date).format('X');
        // console.log('timeStampDate',timeStampDate);
        movementsByDate.ingresos.push({
            humanDate: date,
            timestamp: timeStampDate,
            lvlCodes: [

            ],
            total: 0
        });
        movementsByDate.egresos.push({
            humanDate: date,
            timestamp: timeStampDate,
            lvlCodes: [

            ],
            total: 0
        });
    });

    allDailyMovesWithBankMovement.forEach(({ lvl4, movements, lvlName }) => {

        if (lvl4.split('.')[0] === "CSTM" && lvl4.split('.')[3] === "C44") {
            console.log('movements.debito', movements.debito);
            movements.debito.forEach((data) => {
                const dayOfYear = moment(data.fecha_emision_humana, 'YYYY-MM-DD').dayOfYear();
                movementsByDate.ingresos[dayOfYear - 1].total += parseInt(data.monto);
                const contableAccountExists = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;
                });
                if (!contableAccountExists) {
                    movementsByDate.ingresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }
                const indexOfAcc = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                movementsByDate.ingresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .noFolioMovements
                    .push(data);
                counter++;
            });
        }
        if (lvl4.split('.')[0] === "CSTM" && lvl4.split('.')[3] === "044") {
            movements.debito.forEach((data) => {

                //get year day number from date using dayOfYear
                const dayOfYear = moment(data.fecha_humana, 'YYYY-MM-DD').dayOfYear();
                // find if contable account exists
                let pretotal = movementsByDate.ingresos[dayOfYear - 1].total;

                movementsByDate.ingresos[dayOfYear - 1].total += parseInt(data.monto);
                const contableAccountExists = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;;
                });
                // create account Object for calendar day
                // push account to calendar day if it does not exist
                if (!contableAccountExists) {
                    movementsByDate.ingresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }
                // find account name index on date array
                const indexOfAcc = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                // push data to account movements on dailyBookMovement date
                movementsByDate.ingresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .customMovements
                    .push(data);
                counter++
            });
        }
        if (lvl4.split('.')[0] === "CSTM" && lvl4.split('.')[3] === "C33") {
            movements.credito.forEach((data) => {
                const dayOfYear = moment(data.fecha_emision_humana, 'YYYY-MM-DD').dayOfYear();
                // console.log('data',data);
                // console.log('datOfYear',dayOfYear); 
                // console.log('movementsByDate.egresos[dayOfYear - 1]',movementsByDate.egresos[dayOfYear - 1]);
                movementsByDate.egresos[dayOfYear - 1].total += parseInt(data.monto_conciliado);
                // console.log('data.monto_conciliado',data.monto_conciliado);
                const contableAccountExists = movementsByDate.egresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;
                });
                if (!contableAccountExists) {
                    movementsByDate.egresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }
                const indexOfAcc = movementsByDate.egresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                movementsByDate.egresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .noFolioMovements
                    .push(data);
                counter++;
            });
        }


        movements.credito.forEach((data) => {

            if (lvl4.split('.')[0] === "CSTM" && lvl4.split('.')[3] === "033") {
                //get year day number from date using dayOfYear
                const dayOfYear = moment(data.fecha_humana, 'YYYY-MM-DD').dayOfYear();
                // find if contable account exists

                movementsByDate.egresos[dayOfYear - 1].total += parseInt(data.monto);

                const contableAccountExists = movementsByDate.egresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;
                });
                // create account Object for calendar day
                // push account to calendar day if it does not exist
                if (!contableAccountExists) {
                    movementsByDate.egresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }

                // find account name index on date array
                const indexOfAcc = movementsByDate.egresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                // push data to account movements on dailyBookMovement date
                movementsByDate.egresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .customMovements
                    .push(data);
                counter++
            }
        });

        if (lvl4.split('.')[0] == 4) {
            movements.debito.forEach(({ folio, data }) => {


                //get year day number from date using dayOfYear
                const dayOfYear = moment(data.fecha_contabilizacion_humana, 'DD-MM-YYYY').dayOfYear();
                const dayTimeStamp = moment(data.fecha_contabilizacion_humana, 'DD-MM-YYYY').format('X');
                // find if contable account exists

                movementsByDate.ingresos[dayOfYear - 1].total += parseInt(data.debito);
                const contableAccountExists = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;
                });

                // create account Object for calendar day
                // push account to calendar day if it does not exist
                if (!contableAccountExists) {
                    movementsByDate.ingresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }

                // find account name index on date array
                const indexOfAcc = movementsByDate.ingresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                // push data to account movements on dailyBookMovement date
                movementsByDate.ingresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .movements
                    .push(data);
                counter++
            });
        }

        movements.credito.forEach(({ folio, data }, index) => {
            if (lvl4.split('.')[0] == 2 || lvl4.split('.')[0] == 3) {
                //get year day number from date using dayOfYear
                const dayOfYear = moment(data.fecha_contabilizacion_humana, 'DD-MM-YYYY').dayOfYear();
                // find if contable account exists
                movementsByDate.egresos[dayOfYear - 1].total += parseInt(data.credito);
                if (dayOfYear === 1 || dayOfYear === 2) {
                    console.log('data', data);
                }
                const contableAccountExists = movementsByDate.egresos[dayOfYear - 1].lvlCodes.find((accCode) => {
                    return accCode.lvl4 == lvl4;
                });
                // create account Object for calendar day
                // push account to calendar day if it does not exist
                if (!contableAccountExists) {
                    movementsByDate.egresos[dayOfYear - 1].lvlCodes.push(accToPush(lvl4, lvlName));
                }
                // find account name index on date array
                const indexOfAcc = movementsByDate.egresos[dayOfYear - 1].lvlCodes.map(account => account.lvl4).indexOf(lvl4);
                // push data to account movements on dailyBookMovement date
                movementsByDate.egresos[dayOfYear - 1]
                    .lvlCodes[indexOfAcc]
                    .movements
                    .push(data);
                counter++
            }
        })

    });


    console.log('movementsByDate', movementsByDate);
    console.log('counter', counter);
    console.log('sinFecha', sinFecha);

    return movementsByDate;
}

function accToPush(lvl4, lvlName) {
    return {
        'lvl4': lvl4,
        'lvlName': lvlName,
        'movements': [],
        'customMovements': [],
        'noFolioMovements': []
    }
}

const getChileanCurrency = (value) => {

    if (value < 0) {
        return `-$${Math.abs(value).toLocaleString('es-CL')}`;
    } else {
        return `$${value.toLocaleString('es-CL')}`;
    }
    // return value.toLocaleString('es-CL');
}

const setIncomeResumeRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowIncome', '--headerRow');
    let firstTd = `<td id="resumeRowIncome">Ingresos</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;
}
const setPendingResumeRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowPending', '--headerRow');
    let firstTd = `<td id="resumeRowPending">Documentos pendientes</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;
}

const setOutcomeResumeRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowOutCome', '--headerRow');
    let firstTd = `<td id="resumeRowOutcome">Egresos</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;

}
const setTotalRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowTotal', '--headerRow');
    let firstTd = `<td id="resumeTotalRow">Total</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;

}

function createIncomeRows(allDailyMovesWithBankMovement) {
    const incomeCodes = allDailyMovesWithBankMovement.map((accCodes) => {
        return {
            lvl4: accCodes.lvl4,
            lvlName: accCodes.lvlName
        }
    }).filter((element) => { return element.lvl4.split('.')[0] == 4; });
    const titleTr = setIncomeResumeRow();
    tbody.appendChild(titleTr);
    incomeCodes.forEach(({ lvl4, lvlName }) => {
        const tr = document.createElement('tr');
        tr.classList.add('codeAccountRow', '--selectableRow', '--incomeRow');
        let firstTd = `<td lvlCode=${lvl4}>${lvlName}</td>`;
        let contentTd = ''
        for (let i = 1; i <= allMyDates.length; i++) {
            contentTd += '<td></td>';
        }
        tr.innerHTML = `${firstTd}${contentTd}`;
        tbody.appendChild(tr);
    });
}

function createOutComeRows(allDailyMovesWithBankMovement) {
    const outComeCodes = allDailyMovesWithBankMovement.map((accCodes) => {
        return {
            lvl4: accCodes.lvl4,
            lvlName: accCodes.lvlName
        }
    }).filter((element) => { return element.lvl4.split('.')[0] == 3; });

    const outComeTr = setOutcomeResumeRow();
    tbody.appendChild(outComeTr);

    outComeCodes.forEach(({ lvl4, lvlName }) => {
        const tr = document.createElement('tr');
        tr.classList.add('codeAccountRow', '--selectableRow', '--outcomeRow');
        let firstTd = `<td lvlCode=${lvl4}>${lvlName}</td>`;
        let contentTd = ''
        for (let i = 1; i <= allMyDates.length; i++) {
            contentTd += '<td></td>';
        }
        tr.innerHTML = `${firstTd}${contentTd}`;
        tbody.appendChild(tr);
    });
}

const setCustomIncomeResumeRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('codeAccountRow', '--selectableRow');
    let firstTd = `<td>Otros Ingresos</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;
}

function createCustomIncomeRows(allDailyMovesWithBankMovement) {
    const incomeCodes = allDailyMovesWithBankMovement.map((accCodes) => {
        return {
            lvl4: accCodes.lvl4,
            lvlName: accCodes.lvlName
        }
    }).filter((element) => { return element.lvl4.split('.')[0] == 'CSTM' && element.lvl4.split('.')[3] == '044'; });

    incomeCodes.forEach(({ lvl4, lvlName }) => {
        const tr = document.createElement('tr');
        tr.classList.add('codeAccountRow', '--selectableRow', '--incomeRow');
        let firstTd = `<td lvlCode=${lvl4}>${lvlName}</td>`;
        let contentTd = ''
        for (let i = 1; i <= allMyDates.length; i++) {
            contentTd += '<td></td>';
        }
        tr.innerHTML = `${firstTd}${contentTd}`;
        tbody.appendChild(tr);
    });

}

const setCustomOutcomeResumeRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowCustomIncome');
    let firstTd = `<td>Otros Egresos</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;
}

function createCustomOutcomeRows(allDailyMovesWithBankMovement) {
    const incomeCodes = allDailyMovesWithBankMovement.map((accCodes) => {
        return {
            lvl4: accCodes.lvl4,
            lvlName: accCodes.lvlName
        }
    }).filter((element) => { return element.lvl4.split('.')[0] == 'CSTM' && element.lvl4.split('.')[3] == '033'; });
    incomeCodes.forEach(({ lvl4, lvlName }) => {
        const tr = document.createElement('tr');
        tr.classList.add('codeAccountRow', '--selectableRow', '--outcomeRow');
        let firstTd = `<td lvlCode=${lvl4}>${lvlName}</td>`;
        let contentTd = ''
        for (let i = 1; i <= allMyDates.length; i++) {
            contentTd += '<td></td>';
        }
        tr.innerHTML = `${firstTd}${contentTd}`;
        tbody.appendChild(tr);
    });
}

const setTotalDailyBalance = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowTotal', '--headerRow');
    let firstTd = `<td>Total</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;

}
function createDailyTotalRow() {
    const totalTr = setTotalDailyBalance();
    tbody.appendChild(totalTr);
}

const setDailyBalanceRow = () => {
    const tr = document.createElement('tr');
    tr.classList.add('resumeRowBalance', '--headerRow');
    let firstTd = `<td>Saldo</td>`;
    let contentTd = ''
    for (let i = 1; i <= allMyDates.length; i++) {
        contentTd += '<td></td>';
    }
    tr.innerHTML = `${firstTd}${contentTd}`;
    return tr;

}
function createDailyBalance() {
    const balanceTr = setDailyBalanceRow();
    tbody.appendChild(balanceTr);
}


// separar matches con folio
// const match_has_folio = MATCH_DATA_BY_BANK_MOVEMENT_ID.filter((element)=> element.folio !== null);
// buscar folio en...
// 1.02.01.01
// 1.02.01.02
// 1.02.02.03
// 1.02.02.04
// 1.02.02.05

// return
// create new tr and append to tbody for each movement 

