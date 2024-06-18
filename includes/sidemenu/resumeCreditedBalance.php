<div id="creditedBalanceSideMenu" class="sideMenu-s">
    <button id="" class="sideMenuCloseButton" onclick="closeCreditedBalance()">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>

    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Revisa y edita el estado financiero</p>
    </div>




    <div class="--ev-payment-status" style="padding: 16px;">

        <!-- payment status div container -->
        <div class="--ev-payment-choise">
            <div class="--ev-pay-check">
                <input type="checkbox" value="1" class="switch" id="evBilled">
                <p>Facturado</p>
            </div>

            <div class="--ev-pay-check">
                <input type="checkbox" value="1" class="switch" id='evPaid'>
                <p>Pagado</p>
            </div>

            <div class="--ev-pay-check">
                <input type="checkbox" value="1" class="switch" id='evCredited'>
                <p>Abonado</p>
            </div>

        </div>






        <div class="--ev-payment-perc">
            <p>Estado de pago</p>
            <div class="--perc-container" id="-p-bar-bk">
                <div class="--perc-view" id="-p-bar-pr">

                </div>
            </div>
            <p id="--literal-percentage" class="--number">0%</p>
        </div>

        <div class="--ev-pay-credited">


            <input type="text" id="creditedAmount" placeholder="Agregar abono">
        </div>

        <div class="--payment-resume-section">
            <div style="height: 180px; overflow-x: scroll;width: 100%;scrollbar-width: none;">

            <div class="--balance-resume">
                <p class="--paymentHiustory-CreditedBalance">Historial de abonos</p>
                <p id="-payment-total-credited" style="text-align:end;">$0</p>
            </div>

                <table class="" id="evPaymentResume">
                    <thead>
                        <tr class="">
                            <th>
                                <p>Fecha</p>
                            </th>
                            <th>
                                <p>usuario</p>
                            </th>
                            <th>
                                <p>Monto</p>
                            </th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>




<script>
    function openCreditedBalance() {
        $('#creditedBalanceSideMenu').addClass('active');
    }

    function closeCreditedBalance() {
        $('#creditedBalanceSideMenu').removeClass('active');
    }
</script>


<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
        padding: .375rem 1.75rem .375rem .75rem !important;
        border: 1px solid gray !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px !important;
    }

    .select2-selection__arrow {
        top: -5px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }

    #vehicleCreateType-error {
        position: relative;
        top: 70px;
    }

    #vehicleCreateType .err .selection {
        position: relative;
        top: -10px;
    }
</style>