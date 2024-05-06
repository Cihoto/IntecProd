<!-- <div class="container" style="margin: 0px;"> -->
<div class="documentPdfSelector">
    <p style="margin: 0px!important;">Selecciona para descargar</p>
    <div class="checkbox-wrapper-13">
        <input id="details-documents" type="checkbox">
        <label for="details-documents">Detalles</label>
    </div>
    <div class="checkbox-wrapper-13">
        <input id="factSheet-documents" type="checkbox">
        <label for="factSheet-documents">Ficha técnica</label>
    </div>
    <div class="checkbox-wrapper-13">
        <input id="nomDocument" type="checkbox">
        <label for="nomDocument">Generar nómina</label>
    </div>
    <button id="generateResumePdf">
        <p>Exportar PDF</p>
        <img src="../assets/svg/download.svg" alt="">
    </button>
</div>

<!-- <div id="documentSelectorContainer">
            <div id="documentOptions">
                <p style="margin: 0px!important;">Selecciona para descargar</p>
                <div class="checkbox-wrapper-13">
                    <input id="details-documents" type="checkbox">
                    <label for="details-documents">Detalles</label>
                </div>
                <div class="checkbox-wrapper-13">
                    <input id="factSheet-documents" type="checkbox">
                    <label for="factSheet-documents">Ficha técnica</label>
                </div>
                <div class="checkbox-wrapper-13">
                    <input id="nomDocument" type="checkbox">
                    <label for="nomDocument">Generar nómina</label>
                </div>
            </div>
            <button id="generateResumePdf">
                <p>Exportar PDF</p>
                <img src="../assets/svg/download.svg" alt="">
            </button>
        </div> -->

<div class="formHeader" style="align-items: center!important; margin-left: 16px;">

    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
        <circle cx="6" cy="6" r="6" fill="#069B99" />
    </svg>

    <p class="header-P" style="margin-top: -3px;">Resumen de tu evento creado</p>

</div>

<div class="--resumeContainer">
    <div class="--resume-data-container">
        <!-- <div class="event-info-resume">

        </div> -->

        <table id="eventInfoResume">
            <thead> 
                    
            </thead>
            <tbody>
                <tr>
                    <td class="-r-td-left"><p class="--r-title">Evento:</p><p class="--r-info --h-text-flex-75" id="projectNameResume"></p></td>
                    <td class="-r-td-right"><p class="--r-title">Cliente:</p><p class="--r-info --h-text-flex-25" id="clienteProjectResume"></p></td>
                    
                </tr>
                <tr>
                    <td class="-r-td-left"><p class="--r-title">Dirección:</p><p class="--r-info --h-text-flex-75" id="lugarProjectResume"></p></td>
                    <td class="-r-td-right"><p class="--r-title">Fecha:</p><p class="--r-info --h-text-flex-25" id="fechaProjectResume"></p></td>
                </tr>
                <!-- <tr>
                    <td></td>
                </tr> -->
            </tbody>
        </table>

        <!-- <div class="d-flex" style="width:50%;">
                <div style="display: flex;
                        width: 100%;
                        padding: var(--none, 0px);
                        align-items: flex-start;">

                    <div style="display: flex;
                        width: 75%;
                        padding: var(--none, 0px);
                        align-items: flex-start;
                        margin-right: 400px;
                        gap: var(--1, 8px);">
                        <p class="resumeDescription" style="margin-right: 500px;">Evento:</p>
                        <p id="projectNameResume" class="resumeDetail"></p>
                    </div>
                    <div style="display: flex;
                        width: 25%;
                        padding: var(--none, 0px);
                        align-items: flex-start;
                        gap: var(--1, 8px);">
                        <p class="resumeDescription" style="margin-right: 500px;">Cliente:</p>
                        <p id="clienteProjectResume" class="resumeDetail"></p>
                    </div>

                </div>
                <div style="display: flex;
                    width: 100%;
                    padding: var(--none, 0px);
                    align-items: flex-start;">

                    <div style="display: flex;
                        padding: var(--none, 0px);
                        align-items: flex-start;
                        margin-right: 400px;
                        gap: var(--1, 8px);">
                        <p class="resumeDescription" style="margin-right: 500px; width: 75px;">Dirección:</p>
                        <p id="lugarProjectResume" class="resumeDetail"></p>
                    </div>
                </div>

                <div style="display: flex;
                    width: 100%;
                    padding: var(--none, 0px);
                    align-items: flex-start;">
                    <div style="display: flex;
                        padding: var(--none, 0px);
                        align-items: flex-start;
                        margin-right: 400px;
                        gap: var(--1, 8px);">
                        <p class="resumeDescription" style="margin-right: 500px;">Fecha:</p>
                        <p id="fechaProjectResume" class="resumeDetail"></p>
                    </div>
                </div>
        </div> -->

        <div class="resumeProjectTables" >

            <div id="resumeEventTableContainer">
                <table class="-resume-table-S -r-t-income" id="total-productResume">
                    <thead>
                        <tr style="height: 50px;">
                            <th>
                                <p>Ingresos del evento</p>
                            </th>
                            <th></th>
                            <th></th>
                            <th><p id="totalPrice-equipos">$0</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td><p></p></td>
                            <td><p>Audio</p></td>
                            <td><p></p></td>
                            <td><p>$900000</p></td>
                        </tr> -->
                    </tbody>
                </table>
                <!-- <table class="-resume-table-S -r-t-income secondary" id="total-othersResume">
                    <thead>
                        <tr>
                            <th><p>Otros</p></th>
                            <th><p></p></th>
                            <th><p></p></th>
                            <th><p id="totalOthers">$0</p></th>
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        
                        </tfoot>
                </table> -->
                        <!-- <tr>
                            <td><p>Random</p></td>
                            <td><p></p></td>
                            <td><p></p></td>
                            <td><p>$35.000</p></td>
                        </tr> -->



                <table class="-resume-table-S -r-t-costs main">
                    <thead>
                        <tr>
                            <th>
                                <p>Costos del evento</p>
                            </th>
                            <th></th>
                            <th></th>
                            <th><p id="totalCost-project"></p></th>
                        </tr>
                    </thead>
                </table>
                <table class="-resume-table-S -r-t-costs secondary" id="total-personalResume">
                    <thead>
                        <tr>
                            <th><p>Personas</p></th>
                            <th></th>
                            <th></th>
                            <th><p id="totalPersonal-resumeProject"></p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td><p>Juanito Pérez</p></td>
                            <td><p>Técnico</p></td>
                            <td><p>Contratado</p></td>
                            <td><p>$3.050.000</p></td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>

                <table class="-resume-table-S -r-t-costs secondary" id="total-vehiculosResume">
                    <thead>
                        <tr>
                            <th><p>Vehículos</p></th>
                            <th><p></p></th>
                            <th><p></p></th>
                            <th><p id="totalVehicles-resumeProject">$0</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td><p>Peugeot Partner</p> </td>
                            <td><p>Propio</p></td>
                            <td><p></p></td>
                            <td id="totalVehiculosPropios"><p>$35.000</p></td>
                        </tr>
                        <tr>
                            <td><p>Opel Combo</p></td>
                            <td><p>Externos</p></td>
                            <td><p></p></td>
                            <td id="totalVehiculosExternos"><p>$35.000</p></td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <table class="-resume-table-S -r-t-costs secondary" id="total-SubArriendosResume">
                    <thead>
                        <tr>
                            <th><p>Sub Arriendos</p></th>
                            <th><p></p></th>
                            <th><p></p></th>
                            <th><p id="totalSubArriendos-resume"></p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td><p>Random</p></td>
                            <td><p></p></td>
                            <td><p></p></td>
                            <td><p>$35.000</p></td>
                        </tr> -->
                        <!--DINAMYC CONTENT -->
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <table class="-resume-table-S -r-t-costs secondary" id="total-otherCostsResume">
                    <thead>
                        <tr>
                            <th><p>Otros</p></th>
                            <th><p></p></th>
                            <th><p></p></th>
                            <th><p id="totalOtherCosts-resume"></p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tbody> -->
                            <!-- <tr> -->
                                <!-- <td><p>Random</p></td> -->
                                <!-- <td><p></p></td> -->
                                <!-- <td><p></p></td> -->
                                <!-- <td><p>$35.000</p></td> -->
                            <!-- </tr> -->
                        <!-- </tbody> -->
                        <!--DINAMYC CONTENT -->
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <table class="-resume-table-S -r-t-income">
                    <thead>
                        <tr>
                            <th><p>Utilidad evento</p></th>
                            <th></th>
                            <th></th>
                            <th><p id="utilidadEvento">$0</p></th>
                        </tr>
                        <tr>
                            <th><p>Margen operacional</p></th>
                            <th><p></p></th>
                            <th><p></p></th>
                            <th><p id="margfenOperacional">$0</p></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

                <!-- <table class="s-resumeProjectTable" id="total-SubArriendosResume">
                <thead>
                    <tr>
                        <th style="width: 70%;">Sub Arriendos</th>
                        <th id="totalSubArriendos">$0</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table> -->


            </div>

        </div>
    </div>
    <!-- <div class="col-2"> -->

    <!-- </div> -->
</div>






<!-- </div> -->
<div class="projectSave-footer">
    <div class="returnPreviusPage">
        <!-- <button class="s-Button-w" style="width: 170px;" id="saveDraft">
            <p class="s-P-g">Guardar Borrador</p>
        </button> -->
    </div>

    <div class="saveProject">
        <button class="s-Button createOrContinue" id="" style="width: 170px;">
            <p class="s-P">guardar</p>
        </button>
    </div>
</div>