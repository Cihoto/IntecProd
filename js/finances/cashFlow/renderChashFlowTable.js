let cashFlowTotals = {
    initialBankAccount: 18895572,
    currentBankBalance: 0,
    totals: []
}

let bankMovementsCatergories = ['ingresos','egresos','projectedIncome','projectedOutcome','commonIncomeMovements','commonOutcomeMovements'];

function renderMyChasFlowTable(pickedMonth){
    // get all days on current year
    const allDaysOnYear = getAllDaysOnMonth([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
    let previousAccountBalance = cashFlowTotals.initialBankAccount;
    const totalDailyBalance = allDaysOnYear.map((date, index) => {
        const totalIncome = bankMovementsData.ingresos[index].total;
        const totalOutCome = bankMovementsData.egresos[index].total;
        const totalProjectedIncome = bankMovementsData.projectedIncome[index].total;
        const totalProjectedOutcome = bankMovementsData.projectedOutcome[index].total;
        const totalCommonIncomeMovements = bankMovementsData.commonIncomeMovements[index].total;
        const totalCommonOutcomeMovements = bankMovementsData.commonOutcomeMovements[index].total;
        const total = totalIncome + totalProjectedIncome +totalCommonIncomeMovements - totalProjectedOutcome - totalOutCome - totalCommonOutcomeMovements;
        previousAccountBalance += total;
        return {
            date,
            timestamp: moment(date).format('X'),
            dayOfYear: moment(date).dayOfYear(),
            totalIncome,
            totalOutCome,
            total,
            previousAccountBalance,
        }
    });
    cashFlowTotals.totals = totalDailyBalance;
    console.log('totalDailyBalance', totalDailyBalance);
    // remove All table trs
    removeAllTableRows();
    // Create thead and add all dates associated to the selected month
    renderMyHorizontalView([pickedMonth]);
    // income tr
    const incomeTr = setIncomeResumeRow();
    tbody.appendChild(incomeTr);
    // Projected Documents INCOME
    const projectedDocumentsTr = setProjectedDocumentsRow();
    tbody.appendChild(projectedDocumentsTr);
    // empty row
    let emptyRow1 = setEmptyRow();
    tbody.appendChild(emptyRow1);
    // OUT
    const outComeTr = setOutcomeResumeRow();
    tbody.appendChild(outComeTr);
    //Future outcome
    const outComeProjectedDocumentsTr = setOutComeProjectedDocumentsRow();
    tbody.appendChild(outComeProjectedDocumentsTr);
    // emptyRow
    let emptyRow2 = setEmptyRow();
    tbody.appendChild(emptyRow2);
    // CREATE TOTAL ROW 
    const totalTr = setTotalRow();
    tbody.appendChild(totalTr);
    // CREATE BALANCE ROW
    createDailyBalance();
    // get first and last day of selected month with his day of the year
    const firstDay = moment(pickedMonth, 'M').startOf('month').dayOfYear();
    const lastDay = moment(pickedMonth, 'M').endOf('month').dayOfYear();

    const bankMovementsOnSelectedMonth = totalDailyBalance.filter(({ dayOfYear }) => {
        return dayOfYear >= firstDay && dayOfYear <= lastDay;
    });
    // filter all days on selected month
    const selectedMonthDays = totalDailyBalance.filter(({ dayOfYear }) => {
        return dayOfYear >= firstDay && dayOfYear <= lastDay;
    });
    const totalRow = document.getElementsByClassName('resumeRowTotal')[0];
    const balanceRow = document.getElementsByClassName('resumeRowBalance')[0];

    console.log('selectedMonthDays', selectedMonthDays);
    // add all totals to corresponding day
    selectedMonthDays.forEach((day) => {
        const { date, totalIncome, totalOutCome, total, previousAccountBalance, dayOfYear } = day;
        const tr = document.createElement('tr');
        const dateIndex = getDateHeaderIndex(dayOfYear);
        if (!dateIndex) {
            return;
        }
        totalRow.children[dateIndex].innerHTML = getChileanCurrency(total);
        balanceRow.children[dateIndex].innerHTML = getChileanCurrency(previousAccountBalance);
    });
    const ingresosTr = document.getElementsByClassName('resumeRowIncome')[0];
    const egresosTr = document.getElementsByClassName('resumeRowOutCome')[0];
    const projectedIncomeRow = document.getElementById('projectedIncomeRow');
    const projectedOutComeRow = document.getElementById('projectedOutComeRow');
    // const projectedOutcomeRow = document.getElementsByClassName('resumeRowProjectedOutcome')[0];
    bankMovementsCatergories.forEach((category) => {
        const categoryData = bankMovementsData[category];
        categoryData.forEach((day) => {
            const { total, dateIndex } = day;
            
            if (!(dateIndex >= firstDay && dateIndex <= lastDay)) {
                return;
            }
            const doty = getDateHeaderIndex(dateIndex);
            if (!doty) {
                return;
            }
            if (category == 'ingresos') {
                ingresosTr.children[doty].innerHTML = getChileanCurrency(total);
            }
            if (category == 'egresos') {
                egresosTr.children[doty].innerHTML = getChileanCurrency(total);
            }
            if (category == 'projectedIncome' || category == 'commonIncomeMovements'){
            // if (category == 'projectedIncome' ){
                const totalProkectedIncome = bankMovementsData.projectedIncome[dateIndex - 1].total + bankMovementsData.commonIncomeMovements[dateIndex - 1].total;
                // console.log('bankMovementsData.projectedIncome[doty]',bankMovementsData.projectedIncome[dateIndex - 1]);
                // console.log('bankMovementsData.commonIncomeMovements[doty].total',bankMovementsData.commonIncomeMovements[dateIndex - 1]);
                projectedIncomeRow.children[doty].innerHTML = getChileanCurrency(totalProkectedIncome);
            }
            // if (category == 'projectedOutcome' || category == 'commonOutcomeMovements') {
            if (category == 'projectedOutcome' ) {
                // const totalProjectedOutCome = bankMovementsData.projectedOutcome[doty].total + bankMovementsData.commonOutcomeMovements[doty].total;
                projectedOutComeRow.children[doty].innerHTML = getChileanCurrency(total);
            }
        });
    });
}


function getDateHeaderIndex(date) {
    const dateHeaderRow = document.querySelectorAll('.allDates')[0];
    const theadData = dateHeaderRow.getElementsByClassName('dateHeader');

    for (let index = 0; index < theadData.length; index++) {
        const dateIndex = theadData[index].getAttribute('doty');
        if (dateIndex == date) {
            return index + 1;
        }
    }
}

function removeAllTableRows() {
    $('#bankMovementsTableHorizontal tr').remove();
}