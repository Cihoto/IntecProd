<div id="viewUploadedFiles" class="sideMenu-m" >
    <button id="closeViewUploadedFiles" class="sideMenuCloseButton" style="">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>
    <!-- <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <circle cx="6" cy="6" r="6" fill="#069B99" />
        </svg>

        <p class="header-P"></p>

    </div> -->
    <div class="collapsableFormContainer hidden">
        <div class="formHeader" style="align-items: center;align-content:center;margin-left: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P">Aquí puedes ver y cargar tus archivos asjuntos al evento</p>
        </div>
    </div>
    <div style="display: flex;justify-content: center; flex-direction: column;padding: 4px 16px;">
        <input type="file" id="excel_input" style="visibility: hidden;" multiple>
        <div id="file-input-face">
            <label id="fileLabel" for="excel_input" class="labelForFile" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                <img src="../../assets/svg/uploadFile.svg" alt="" width="40px" height="40px" style="display:flex;margin-left:49%;margin-top:15px;">
                <span class="bt">Click para cargar</span> <span class="bkt">o arrastrar el archivo</pspan>
            </label>
        </div>
        <div id="fileName"></div>
        <table id='file-table'>
            <thead>
                <tr>
                    <th width="45%">Nombre</th>
                    <th width="25%">Propietario</th>
                    <th width="20%">Subido</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td><img src="../../assets/svg/fileExtensions/Adobe PDF.svg" alt="aa" height="64" width="64">PDF DE PRUEBAS</td>
                    <td>YO</td>
                    <td>

                    </td>
                    <td>
                        <div class="-file-box-header">
                            <div class="-file-options-container">
                                <div class='-file-option'>
                                    <span class='sPfileOption'>Eliminar</span>
                                </div>
                                <div class='-file-option'>
                                    <span class='sPfileOption'>Descargar</span>
                                </div>
                            </div>
                            <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-file-options">
                        </div>
                    </td>

                </tr> -->
            </tbody>

        </table>
    </div>
    <!-- <div id="file-container">
        <div class="--file-box">

            <div class="-file-box-header">
                <div class="-file-options-container">
                    <div class='-file-option'>
                        <p class='s-P'>Eliminar</p>
                    </div>
                    <div class='-file-option'>
                        <p class='s-P'>Descargar</p>
                    </div>
                </div>
                <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-file-options">
            </div>
            <div class="-file-box-body">
                <div class='-file-logo'>
                    <img src="../../assets/svg/fileExtensions/Adobe PDF.svg" alt="aa">


                </div>
                <div class='-file-info'>
                    <div class="-file-name">
                        <p>este es un pdf</p>
                    </div>
                </div>
            </div>
            <iframe src='./ws/BussinessDocuments/documents/buss1/Ev61/Estado de cuenta_1709071812088.pdf'></iframe>
        </div>
        <div class="--file-box">
            <div class="-file-box-header">
                <img src="./assets/svg/trashCan.svg" alt="">
            </div>
            <div class="-file-box-body">
                <div class='-file-logo'>
                    <img src="../../assets/svg/fileExtensions/Adobe PDF.svg" alt="aa">

                </div>
                <div class='-file-info'>
                    <div class="-file-name">
                        <p>este es un pdf</p>
                    </div>
                    <div class="-file-action">
                        <img src="../../assets/svg/dwnl-logo.svg" alt="">
                    </div>
                </div>
            </div>
            <iframe src='./ws/BussinessDocuments/documents/buss1/Ev61/Estado de cuenta_1709071812088.pdf'></iframe>
        </div>
    </div> -->
    <!-- <button id="cerrarClienteModal">Cerrar</button> -->

    <div id="viewDocument"></div>
    <div id="downloadDocument"></div>
</div>

<style>
    /* #viewDocument a{
display: none;
} */
</style>