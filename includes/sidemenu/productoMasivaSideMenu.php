<div id="masivaProductoSideMenu" class="sideMenu-s-full-screen">
    <button id="closeMasivaProductos" style="border: none;background-color: none;padding: 30px;">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>
        <p class="header-P">Aquí puedes cargar un archivo Excel y agregar tus inventario</p>
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
        <button class="s-Button" id="saveExcelData">
            <p class="s-P">Agregar cliente</p>
        </button>
    </div>



</div>

<style>
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
    #excelTable{
        width: 100%;
        max-height: 400px;
    }

    #excelTable tbody{
        display:block;
        height: 400px;
        overflow-y: auto;
    }

    #excelTable thead tr {
        position: sticky;
        top: 0px;
    }
    #excelTable tr{
        gap: 1.55px !important;
    }
    #excelTable th ,#excelTable td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width:16.6%
    }

    #excelTable tbody td{
        padding: 16px!important;
        background: rgba(0, 0, 0, 0.00)!important; 
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
    #excelTable tbody{
        width: calc(100% + 14px) ;
    }
    #excelTable tbody::-webkit-scrollbar-horizontal {
        visibility: hidden;
    }
</style>