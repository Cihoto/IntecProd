<div id="masivaProductoSideMenu" class="sideMenu-s-full-screen">
    <button id="closeMasivaProductos" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>


    <div style="display: flex;justify-content: space-between;">
        <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P">Aquí puedes cargar un archivo Excel y agregar tus inventario</p>
        </div>

        <button class="s-Button-w" id="" style="width: 150px;margin-right: 16px;">
            <p class="s-P-g" style="line-height: normal;"><a href="../../ExcelFiles/Productos carga masiva excel tipo.xlsx" download="">Descargar Excel</a></p>
        </button>
    </div>
    
    <div style="margin: 0px 14px;">

        <input type="file" id="excel_input" style="visibility: hidden;">
        <div id="file-input-face">
            <label id="fileLabel" for="excel_input" class="labelForFile" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                <img src="../../assets/svg/uploadFile.svg" alt="" width="40px" height="40px" style="display:flex;margin-left:49%;margin-top:15px;">
                <span class="bt">Click para cargar</span> <span class="bkt">o arrastrar el archivo</pspan>
            </label>
        </div>
        <div id="fileName"></div>
        <div id="masivaTableContainer">

            <table id="excelTable" class="s-table">
                <thead>
                    <!-- <th>Nombre Empresa</th>
                    <th>Nombre Cliente</th>
                    <th>Rut</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Info</th> -->
                </thead>
                <tbody>
                    <!-- <tr>
                        <td>Nombre Empresa</td>
                        <td>Nombre Cliente</td>
                        <td>Rut</td>
                        <td>Dirección</td>
                        <td>Teléfono</td>
                        <td>Correo</td>
                        <td>Info</td>
                    </tr> -->
                </tbody>
            </table>
            <section id="loading-section-prods-masiva">
                <div id="loader-prods-masiva-content">

                </div>
            </section>
        </div>
        <div class="--exp-content" style="display: none;">
            <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;width: 1000px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="6" fill="#069B99" />
                </svg>
                <p class="header-P" style="line-height: normal;width: 1000px;text-align: start ;">Estas categorías y/o subcategorías no fueron encontradas en tú organización, aquí puedes agregar las que necesites</p>
            </div>
            <div id="exceptionContainer" class="exception-cats-subcats-container">
                <div class="exception-card" id="cats-exp-card">
                    <div class="table-container--exp">
                        <table class="exp-table" id="categorie-exp-table">
                            <thead>
                                <tr>
                                    <th style="width:60%;">Categoría</th>
                                    <th style="width:40%;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="--exp-footer-container">
                        <button class="s-Button-w changeInvertHover" style="width: 150px;" id="addAllCategories">
                            <p class="s-P-g">Agregar todos</p>
                        </button>
                    </div>

                    <section id="loading-section">
                        <div id="loader-cat-content">

                        </div>
                    </section>
                </div>

                <div class="exception-card" id="subCats-exp-card">
                    <div class="table-container--exp">
                        <table class="exp-table" id="subCategorie-exp-table">
                            <thead>
                                <tr>
                                    <th style="width:65%;">Sub categoría</th>
                                    <th style="width:35%;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="--exp-footer-container">
                        <button class="s-Button-w changeInvertHover" style="width: 150px;" id="addAllSubCategories">
                            <p class="s-P-g">Agregar todos</p>
                        </button>
                    </div>
                    <section id="loading-section-subcats">
                        <div id="loader-sub-cat-content">

                        </div>
                    </section>
                </div>
            </div>
            <p style="margin:25px 0px 10px 0px!important;line-height: normal;text-align: start;">
            *Los productos que no tengan una categoría o subcategoría <strong>NO</strong> serán agregados
            </p>
        </div>
        <button class="s-Button" id="saveExcelData">
            <p class="s-P">Agregar productos</p>
        </button>
    </div>



</div>

<style>

    #masivaTableContainer{
        position: relative;
    }

    #loading-section-prods-masiva{
        display: none;
    }
    #loading-section-prods-masiva.active{
        position: absolute;
        display: flex;
        top : 0px;
        width: 100%;
        height: 100%;
        background-color: #ffffffd4;
        /* background-color: red; */
        white-space: nowrap;
        justify-content: center;
        align-items: center;
        /* filter: blur(10px); */
    }

    
    #loading-section{
        display: none;
    }
    #loading-section.active{
        
        position: absolute;
        display: flex;
        margin-top: -32px;
        width: 100%;
        height: 100%;
        background-color: #ffffffd4;
        white-space: nowrap;
        justify-content: center;
        align-items: center;
    }
    #loading-section-subcats{
        display: none;
    }
    #loading-section-subcats.active{
        
        position: absolute;
        display: flex;
        margin-top: -32px;
        width: 100%;
        height: 100%;
        background-color: #ffffffd4;
        white-space: nowrap;
        justify-content: center;
        align-items: center;
    }

    #fileLabel {
        position: relative;
        text-align: center;
        align-items: start;
        flex-direction: row;
        bottom: 0px;
        top: 0px;
        width: 100%;
        display: inline-block;
        cursor: pointer;
        height: 100px;
    }

    #fileLabel span {
        position: relative;
        bottom: -5px;

    }

    span.bt {
        color: var(--Blue-Info, #2F80ED);
        font-feature-settings: 'clig' off, 'liga' off;
        /* typography/subtitle1 */
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 175%;
        /* 28px */
        letter-spacing: 0.15px;
        cursor: pointer;
    }

    span.bkt {
        color: var(--Text-primary, #2C2D33);
        font-feature-settings: 'clig' off, 'liga' off;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 175%;
        /* 28px */
        letter-spacing: 0.15px;
    }

    #excelTable {
        width: 100%;
        max-height: 400px;
    }

    #excelTable tbody {
        display: block;
        height: 400px;
        overflow-y: auto;
    }

    #excelTable thead tr {
        position: sticky;
        top: 0px;
    }

    #excelTable tr {
        gap: 1.55px !important;
    }

    #excelTable th,
    #excelTable td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 12.5%
    }

    #excelTable tbody td {
        padding: 10px 16px!important;
        background: rgba(0, 0, 0, 0.00) !important;
    }


    /* #excelTable tbody::-webkit-scrollbar {
      background-color: blueviolet;
      width: 5px;
      position: relative;
      right: -40px;
      
    } */
    /* #excelTable tbody::-webkit-scrollbar-horizontal {
        display: none;
        visibility: hidden!important;
    } */

    #excelTable tbody::-webkit-scrollbar-horizontal {
        visibility: hidden;
    }

    .exception-cats-subcats-container {
        display: none;
        flex-direction: row;
        justify-content: space-evenly;
        transition: all .4s ease;
    }

    .exception-card {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 32px 16px;
        gap: 8px;
        align-items: center;
        width: 350px;
        border: none;
        -webkit-box-shadow: 0px 0px 41px -6px rgba(0, 0, 0, 0.5);
        -moz-box-shadow: 0px 0px 41px -6px rgba(0, 0, 0, 0.5);
        box-shadow: 0px 0px 41px -6px rgba(0, 0, 0, 0.5);
        height: 440px;
        border-radius: 8px;
    }

    .table-container--exp {
        height: 332px;
        overflow-y: scroll;
    }

    .exp-table tbody {
        height: 332px;
    }

    .exp-table thead {
        display: flex;
        table-layout: fixed;
        width: 100%;
        position: sticky;
        top: 0px;
    }

    .exp-table thead tr {
        display: flex;
        width: 300px;
        padding: var(--none, 0px);
        align-items: center;
        gap: var(--1, 8px);
        align-self: stretch;
        border-radius: var(--none, 0px);
        border-top: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
        border-right: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
        border-bottom: 1px solid var(--divider, rgba(0, 0, 0, 0.12));
        border-left: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
        background: var(--Fondo-cyan, #E8F3F3);
    }

    .exp-table tbody tr {
        display: flex;
        padding: var(--none, 0px);
        align-items: center;
        gap: var(--1, 8px);
        align-self: stretch;
        border-radius: var(--none, 0px);
        border-top: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
        border-right: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
        border-bottom: 1px solid var(--divider, rgba(0, 0, 0, 0.12));
        border-left: var(--none, 0px) solid var(--divider, rgba(0, 0, 0, 0.12));
    }


    .exp-table tbody tr:hover {
        border-radius: var(--none, 0px);
        border: 1px solid var(--Secondary-color, #6136AB);
        background: var(--Purple-200, #DCD0F1);
    }

    .exp-table thead th {
        padding: 16px;
    }

    .exp-table tbody td {
        border-right: 1px solid var(--Line-table, #DDDDE1);
        background: rgba(0, 0, 0, 0.00);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 12px 16px;
    }

    .exp-table tbody td p {
        margin: 0px !important;
        line-height: normal;
    }

    .exp-table tbody td .--desc {
        margin: 0px !important;
        overflow: hidden;
    }

    .exp-table tbody {
        border: 1px solid var(--Line-table, #DDDDE1);
    }

    .exp-table thead th,
    .exp-table tbody td {
        display: flex;
        align-items: center;
    }

    .--exp-add-cat {
        cursor: pointer;
    }
    .--exp-add-subCat {
        cursor: pointer;
    }


    .--exp-footer-container {
        display: flex;
        justify-content: center;
        align-items: end;
        height: 70px;
    }

    .--exp-footer-container p {
        line-height: normal;
    }
</style>