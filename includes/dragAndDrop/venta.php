<!-- <div class="row"  style="">
<div class="col-12 col-md-6">
    <h4>EQUIPOS</h4>
</div>
<div class="d-flex col-md-6 col-12 justify-content-center">
    <p>Filtrar productos por categoría</p>
    <select name="" id="projectResumeFilter-products">
        <option value="all">Todos</option>
    </select>
</div>
</div> -->
<div id="ventaContainer">
    <div>
        <div id="ventaEventos">
            <div id="ventaHeader">
                <p>Categoría</p>
                <p>Costos Items</p>
                <p>Monto</p>
            </div>
        </div>

    </div>
    <div id="otrosVenta"> 
        <p class = "categorieHeaderTitle">Otros</p>
        <table id="others-table" class="tableCatsAnsResume"> 
            <thead>
                <tr>
                    <th>
                        Descripción
                    </th>
                    <th>
                        <p>Cantidad</p>
                    </th>
                    <th>
                        <p>Total</p>
                    </th>
                </tr>
            </thead>    
            <tbody>

                <tr class="">
                    <td><input type="text" class="nameOthers" value=""></td>
                    <td class="cantTd"><input type="number" class="cantidadOthers" value=""></td>
                    <td class="totalTd"><input type="text" class="totalOthers" value=""></td>
                </tr>
                <!-- <tr>
                    <td><input type="text" class="nameOthers" value="Ampolleta LED"></td>
                    <td class="cantTd"><input type="text" class="totalOthers" value="2"></td>
                    <td class="totalTd"><input type="text" class="totalOthers" value="$12.000"></td>
                </tr> -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <button class="s-Button-w changeInvertHover" style="width: 200px!important;"  id="addNewOthersRow" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <g clip-path="url(#clip0_521_15624)">
                                    <path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 6V12" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 9H12" stroke="#069B99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                            <p class="s-P-g">Agregar Fila</p>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="row justify-content-end" >
            <table class="col-4">
                <thead>
                    <tr>
                        <td>NETO</td>
                        <td id="netoVenta"></td>
                    </tr>
                    <tr>
                        <td>IVA</td>
                        <td id="ivaVenta"></td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td id="totalVenta"></td>
                    </tr>
                </thead>
            </table>
    
            
    

        </div>
    </div>
</div>
<div class="projectSave-footer">
    <div class="returnPreviusPage">
        <!-- <button class="s-Button-w" style="width: 170px;" id="saveDraft">
            <p class="s-P-g">Guardar Borrador</p>
        </button> -->
    </div>

    <div class="saveProject">
        <button class="s-Button-p" style="width: 200px!important;"  id="generateQuotes" >
            <p class="s-P-g" style="margin-top: 5px;">Generar cotización</p>
            <img src="../../assets/svg/downloadIcon.svg" alt="">
        </button>
        <button class="s-Button createOrContinue" id="" style="width: 170px;margin-top: 10px;">
            <p class="s-P">guardar</p>
        </button>
    </div>
</div>

<!-- <a href="../ws/" download>DESCARGAR PDF DESCARGAR PDF</a> -->
<!-- <a href="../../ws/BussinessDocuments/documents/buss1/quotes/invoice.pdf" download>DESCARGAR PDF DESCARGAR PDF</a> -->