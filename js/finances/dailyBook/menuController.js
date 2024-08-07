const OPTION_BUTTONS = document.querySelectorAll('.btnOpt');

OPTION_BUTTONS.forEach((button) => {
    button.addEventListener('click', (e) => {
        OPTION_BUTTONS.forEach((button) => {
            button.classList.remove('active');
        });

        let optbtn = e.target;
        console.log(optbtn);
        if(!optbtn.classList.contains('btnOpt')) {
            // find the parent of the button
            optbtn = e.target.parentElement;

            while(!optbtn.classList.contains('btnOpt')) {
                optbtn = optbtn.parentElement;
            }
        }
        console.log(optbtn);
        
        let contentToPrint = optbtn.getAttribute('contentToPrint');
        printContent(contentToPrint)
        optbtn.classList.add('active');
        // get name atttribute of the button
        let opt = optbtn.getAttribute('menuName');
        changeValueHeaderMenu(opt);
        // get the content to print

    });

});

function changeValueHeaderMenu(value) {
    let header = document.getElementById('contentHeader');


    header.innerHTML = value.replaceAll('_', ' ');
}

function printContent(content) {
    //remove all tr on thead

    console.log('THEAD',thead);
    console.log('THEAD',thead);
    console.log('THEAD',thead);
    console.log('THEAD',thead);
    console.log('THEAD',thead);
    console.log('THEAD ROWS',table.rows);

    removeAllTableClasses();

    // remove tr from table
    $('#bankMovementsTableHorizontal tr').remove();

    // redirect to the correct content
    if(content === 'dash') {
        // printDash();
    }   
    if(content === 'flj') {
        table.classList.add('horizontal');
        renderMyHorizontalView();
        printDailyBookTable(tbody,
            allDaysOnYear,
            getDocumentOutPaymentDate,
            incomeAccountRows,
            accountData_IncomeNoDocumentWithFolio, 
            accountData_OutcomeNoDocumentWithFolio,
            outRows,
            futureDocuments,
            totalDailyBalance);

        setTimeout(() => {

            console.log(table.rows)
        }, 3000);

    }   
    if(content === 'pag') {
        table.classList.add('vertical');
        renderPaymentsCards()
        renderPendingPayments();
    }   
    if(content === 'cob') {
        table.classList.add('vertical');
        renderPendingCharges();
    }   
};


function removeAllTableClasses(){
    table.classList = "";
}