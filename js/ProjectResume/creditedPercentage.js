const CREDITED_AMOUNT_INPUT = document.getElementById('creditedAmount');
const EVE_PAYMENT_METHOD = document.getElementById('event_payment_method');
const BACKGROUND_BAR = document.getElementById('-p-bar-bk');
const TOTAL_PROGRESS_BAR_WIDTH = document.getElementById('-p-bar-bk').getBoundingClientRect().width;
const PROGRESS_BAR = document.getElementById('-p-bar-pr');
const LITERAL_PERCENTAGE = document.getElementById('--literal-percentage');
const EVE_IS_BILLED_RADIOBTN = document.getElementById('evBilled');
const EVE_IS_PAID_RADIOBTN = document.getElementById('evPaid');
const EVE_IS_CREDITED_RADIOBTN = document.getElementById('evCredited');
const EVE_TOTAL_CREDITED_TABLE = document.getElementById('-payment-total-credited');

// let total = 1000000;


let payment_data = {
    'hasDocument':true,
    'isBilled':false,
    'isPaid' : false,
    'isCredited' : false,
    'totalIncomeToCredit':0,
    'creditedTotal':0,
    'currentPercentage': 0,
    'credited_records': [
        // {
        //     'amount' : 1,
        //     'registerUser':PERSONAL_IDS[0],
        //     // 'date'
        // }    
    ]
}


const PERCENTAJE_COLORS = {
    'red':{
        background: '#ffcccc',
        progressBar: '#ff0000'
    },
    'yellow':{
        background: '#fbf0d0',
        progressBar: '#F2C94C'
    },
    'green':{
        background: '#b3ffb3',
        progressBar: '#00cc00'
    }
}

EVE_PAYMENT_METHOD.addEventListener('change',function(){
    if(this.value === ''){
        payment_data.hasDocument = '';
        console.log(payment_data.hasDocument);
        return 
    }
    if(this.value === '1'){
        payment_data.hasDocument = true;
        return 
    }
    payment_data.hasDocument = false;
})

EVE_IS_BILLED_RADIOBTN.addEventListener('click',function(){

    if(!this.checked){
        payment_data.isBilled = false;
        return
    }
    payment_data.isBilled = true;
});


EVE_IS_PAID_RADIOBTN.addEventListener('click',function(e){

    if(payment_data.totalIncomeToCredit === 0){
        this.checked = false;
        return
    }

    if(checkifEventIsCompletePaid()){
        EVE_IS_PAID_RADIOBTN.checked = true;
        payment_data.isPaid = true;

        return;
    }

    if(!this.checked){
        payment_data.isPaid = false;
        return;
    }

    payment_data.isPaid = true;


    let remainingToPay = payment_data.totalIncomeToCredit - payment_data.creditedTotal;

    if(remainingToPay <= 0){
        return;
    }

    addCreditedAmount(remainingToPay);
    setPercentage();
    printMyCreditedRecords();
});

EVE_IS_CREDITED_RADIOBTN.addEventListener('click',function(){

    if(!this.checked){
        payment_data.isCredited = false;
        return;
    }
    payment_data.isCredited = true;
});

CREDITED_AMOUNT_INPUT.addEventListener('focusout',(e)=>{

    console.log(1);
    console.log('payment_data',payment_data);
    console.log('payment_data.totalIncomeToCredit',payment_data.totalIncomeToCredit);
    if(payment_data.totalIncomeToCredit === 0){
        e.target.value = '';
        return
    }

    let creditedValue = parseInt(e.target.value);
    if(!isNumeric(creditedValue)){
        return
    }
    addCreditedAmount(creditedValue);
    setPercentage();
    e.target.value = ''
});

function addCreditedAmount(creditedAmountToAdd){
    console.log(creditedAmountToAdd);
    console.log(2);

    payment_data.creditedTotal += parseInt(creditedAmountToAdd);

    let finalPay_record = checkifEventIsCompletePaid();

    pushNewPaymentRecord(creditedAmountToAdd,finalPay_record);

    printMyCreditedRecords();
}

function checkifEventIsCompletePaid(){

    console.log('payment_data previoooo',payment_data);

    if(payment_data.creditedTotal >= payment_data.totalIncomeToCredit){
        
        if(!payment_data.isPaid){
            EVE_IS_PAID_RADIOBTN.click();
        }
        // if(!payment_data.credited){
        //     EVE_IS_CREDITED_RADIOBTN.click();
        // }
        // payment_data.isPaid = true;
        console.log('payment_data post 1',payment_data);
        return true;
    };

    if(payment_data.creditedTotal <= 0){
        if(payment_data.isPaid){
            EVE_IS_PAID_RADIOBTN.click();
        }
        if(payment_data.isCredited){
            EVE_IS_CREDITED_RADIOBTN.click();
        }

        return false;
    }

    if(payment_data.isPaid){
        EVE_IS_PAID_RADIOBTN.click();

        return false;
    }

    if(EVE_IS_PAID_RADIOBTN.checked){
        EVE_IS_PAID_RADIOBTN.click();
    }

    if(payment_data.creditedTotal === 0 && EVE_IS_CREDITED_RADIOBTN.checked){
        EVE_IS_CREDITED_RADIOBTN.click();    
        // console.log('paydata 2',payment_data);
        return false;
    }
    
    if(payment_data.creditedTotal > 0 && EVE_IS_CREDITED_RADIOBTN.checked){
        // console.log('paydata 3',payment_data);
        return false;
        // payment_data.isPaid = false;
    }
    // console.log('paydata 4',payment_data);
    EVE_IS_CREDITED_RADIOBTN.click();

    // EVE_IS_CREDITED_RADIOBTN.click();

    // console.log('payment_data post 3',payment_data)
      
}

function pushNewPaymentRecord(creditedAmountToAdd,isFinalPay){
    let now = moment();
    let formattedDate = now.format('YYYY-MM-DD HH:mm:ss',true);

    payment_data.credited_records.push(
        {
            'iId': payment_data.credited_records.length + 1,
            'amount' : parseInt(creditedAmountToAdd),
            'registerUser':PERSONAL_IDS[0],
            'registerDate': formattedDate,
            'isFinalPay' : isFinalPay
        }
    );
}

function setPercentage(){
    // let fromPercentaje = payment_data.currentPercentage;

    let percentage= Math.round((payment_data.creditedTotal * 100) / payment_data.totalIncomeToCredit);
    let css_percentaje = percentage;
    if(percentage > 100 ){
        css_percentaje = 100
    }

    let progressColor = []; 
    LITERAL_PERCENTAGE.innerText = `${percentage}%`;
    PROGRESS_BAR.style.width = `${css_percentaje}%`

    payment_data.currentPercentage = percentage;

    if(percentage < 33){
        progressColor = PERCENTAJE_COLORS.red;
    }
    if(percentage >= 33 && percentage <= 66){
        progressColor = PERCENTAJE_COLORS.yellow;
    }
    if(percentage >= 66){
        progressColor = PERCENTAJE_COLORS.green;
    }
    BACKGROUND_BAR.style.backgroundColor = progressColor.background;
    PROGRESS_BAR.style.backgroundColor = progressColor.progressBar;
}

function printMyCreditedRecords(){

    updateTotalCreditedPayments()
    $('#evPaymentResume tbody tr').remove();

    console.log($('#evPaymentResume'))
    console.log($('#evPaymentResume'))
    console.log($('#evPaymentResume'))
    console.log($('#evPaymentResume'))

    payment_data.credited_records.forEach((credited)=>{
        let tr =`<tr crediId="${credited.iId}">
            <td><p>${credited.registerDate}</p></td>
            <td><p>${credited.registerUser.user_name}</p></td>
            <td><p>${credited.amount}</p></td>
            <td class='--t-act deleteCreditedPayment'><img class="deleteCreditedPayment" src="../assets/svg/trashCan.svg" alt=""></td>
        </tr>`
        $('#evPaymentResume tbody').append(tr);
    });
    
}

$(document).on('click','.deleteCreditedPayment',function(){
    let crediId = this.closest('tr').getAttribute('crediId');
    deleteCreditedPayment(crediId);
})

function deleteCreditedPayment(iIdToDelete){
    const CREDITED_EXISTS = payment_data.credited_records.find((credited)=>{return credited.iId == iIdToDelete});

    if(!CREDITED_EXISTS){
        return;
    }

    payment_data.credited_records.splice(payment_data.credited_records.indexOf(CREDITED_EXISTS),1);
    payment_data.creditedTotal -= parseInt(CREDITED_EXISTS.amount);

    
    $(`#evPaymentResume tbody tr[crediId="${iIdToDelete}"]`).remove();

    updateTotalCreditedPayments();
    
    checkifEventIsCompletePaid();
    setPercentage();
}

function updateTotalCreditedPayments(){
    EVE_TOTAL_CREDITED_TABLE.innerText = CLPFormatter(parseInt(payment_data.creditedTotal));
}



// document.getElementById('clickmetestButton').addEventListener('click',function(){
//     console.log('console.log(payment_data)',payment_data)
//     console.log('console.log(payment_data)',payment_data)
//     console.log('console.log(payment_data)',payment_data)
// })