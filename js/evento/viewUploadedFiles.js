let _uploadedFiles = [];
let fileOptionsIsOpen = false;
let canClose_fileOptions = false;
let iFrameIsOpen = false;
let fileExtensionLogos = [
    {
        name: 'pdf',
        svg: 'Adobe PDF.svg'
    },
    {
        name: 'xlsx',
        svg: 'Microsoft-Excel.svg'
    },
    {
        name: 'xls',
        svg: 'Microsoft-Excel.svg'
    },
    {
        name: 'png',
        svg: 'picture-svgrepo-com.svg'
    },
    {
        name: 'jpg',
        svg: 'picture-svgrepo-com.svg'
    },
    {
        name: 'jpeg',
        svg: 'picture-svgrepo-com.svg'
    },
    {
        name: 'pptx',
        svg: 'powerpoint-svgrepo-com.svg'
    }
]

function printDroppedFiles(fileData) {
    $('#file-table').append(createTrDroppedFilesTable(fileData))
}


function printUploadedFiles() {
    _uploadedFiles.forEach((file) => {
        console.log('file', file)
        $('#file-table').append(createTrUploadedFilesTable(file))
    })
}

$(document).click(function (event) {

    if ($(event.target).hasClass('-file-options')) {
        closeAllFileMenu();
        openFileMenu(event.target);
        return;
    }
    if ($(event.target).hasClass('-file-option')) {
        return;
    }
    if ($(event.target).hasClass('sPfileOption')) {
        return;
    }

    closeAllFileMenu();

})

$(document).on('click', '.-file-options', function () {
    console.log('asdasds')
    openFileMenu($(this));

});


function createTrUploadedFilesTable(fileData) {

    const FILE_EXTENSION = getFileExtension(fileData.name);

    const FILE_EXTENSION_LOGO = fileExtensionLogos.find((logo) => { return logo.name === FILE_EXTENSION });


    return `<tr file_id="${fileData.file_id}" class="assigned">
        <td><img src="../../assets/svg/fileExtensions/${FILE_EXTENSION_LOGO.svg}" alt="aa" height="64" width="64">${fileData.name}</td>
        <td></td>
        <td>
        </td>
        <td>
            <div class="-file-box-header">
                <div class="-file-options-container" >
                    <div class='-file-option'>
                        <span class='sPfileOption --delete-file'>Eliminar</span>
                    </div>
                    <div class='-file-option '>
                        <span class='sPfileOption --download-file'>Descargar</span>
                    </div>
                </div>
                <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-file-options">
            </div>
        </td>
    </tr>`
}

function createTrDroppedFilesTable(fileData){

    const FILE_EXTENSION = getFileExtension(fileData.name);

    const FILE_EXTENSION_LOGO = fileExtensionLogos.find((logo) => { return logo.name === FILE_EXTENSION });

    return `<tr temp_file_id="${fileData.temp_file_id}" class="uploaded">
        <td><img src="../../assets/svg/fileExtensions/${FILE_EXTENSION_LOGO.svg}" alt="aa" height="64" width="64">${fileData.name}</td>
        <td></td>
        <td>${getTodayForFileDisplay()}</td>
        <td>
            <div class="-file-box-header">
                <div class="-file-options-container" >
                    <div class='-file-option'>
                        <span class='sPfileOption --delete-file'>Eliminar</span>
                    </div>
                    <div class='-file-option '>
                        <span class='sPfileOption --download-file'>Descargar</span>
                    </div>
                </div>
                <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-file-options">
            </div>
        </td>
    </tr>`
}

function getTodayForFileDisplay(){

    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    const formattedToday = dd + '/' + mm + '/' + yyyy;
    return formattedToday
}

$(document).on('click', '.--download-file', function (event) {

    // console.log('download')
    // console.log($(this))
    // console.log($(this).closest('tr'))
    // console.log($(this).closest('tr').attr('file_id'))

    const FILE_ID = $(this).closest('tr').attr('file_id');
    const FILE_DATA = _uploadedFiles.find((file) => { return file.file_id === FILE_ID })

    if (FILE_DATA) {
        dowloadFile(FILE_DATA);
    }
});

$(document).on('click', '.--delete-file', async function (event) {

    const ROW_IS_TEMP_FILE = $(this).closest('tr').hasClass('uploaded');


    if(ROW_IS_TEMP_FILE){

        const TEMP_FILE_ID = $(this).closest('tr').attr('temp_file_id');
        const TEMP_FILE_DATA = _tempFiles.find((tempFile)=>{
            return tempFile.temp_file_id == TEMP_FILE_ID
        });

        if(TEMP_FILE_DATA){
            deleteTempFile(TEMP_FILE_DATA);
        }
        return 
    }

    const FILE_ID = $(this).closest('tr').attr('file_id');
    const FILE_DATA = _uploadedFiles.find((file) => { return file.file_id === FILE_ID })

    if (FILE_DATA) {
        deleteAssignedFile(FILE_DATA);

    }
});

$(document).on('click', '#file-table tbody tr', function (event) {

    if ($(event.target).hasClass('--download-file')
        || $(event.target).hasClass('--delete-file')
        || $(event.target).hasClass('-file-options')){
        return;
    }

    const ROW_CLASS_IS_UPLOADED = $(this).hasClass('uploaded');

    if(ROW_CLASS_IS_UPLOADED){
        
        const TEMP_FILE_ID =  $(this).attr('temp_file_id');
        const NOT_ASSIGNED_FILE_DATA = _tempFiles.find((tempFile)=>{return tempFile.temp_file_id ==  TEMP_FILE_ID});

        if(NOT_ASSIGNED_FILE_DATA){
            
            $('#file-frame-top-menu').addClass('active');
            iFrameIsOpen = true;
            printTempFileFrame(NOT_ASSIGNED_FILE_DATA);

        }
        return;
    }

    const FILE_ID = $(this).attr('file_id');
    const FILE_DATA = _uploadedFiles.find((file) => { return file.file_id === FILE_ID });

    if (FILE_DATA) {
        $('#file-frame-top-menu').addClass('active');
        iFrameIsOpen = true;
        printFileFrame(FILE_DATA);
    }

});

$(document).on('click', '#file-frame-top-menu', function (event) {

    if ($(this).hasClass('active') && iFrameIsOpen) {
        $(this).find('iframe').remove();
        $(this).find('img').remove();
        $(this).removeClass('active');
        iFrameIsOpen = false;
    }
});

function printFileFrame(FILE_DATA) {

    const FILE_EXTENSION = getFileExtension(FILE_DATA.name);
    let file_frame = '';

    if (FILE_EXTENSION === 'png' || FILE_EXTENSION === 'jpg' || FILE_EXTENSION === 'jpeg') {
        file_frame = `<img width='75%' height='90%' src="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${FILE_DATA.event_id}/bsd${FILE_DATA.name}" alt="${FILE_DATA.name}">`;
    } else {
        file_frame = `<iframe class="-file-frame" src='./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${FILE_DATA.event_id}/bsd${FILE_DATA.name}' frameborder="1"></iframe>`;
    }

    $('#file-frame-top-menu').append(file_frame);

}

function printTempFileFrame(FILE_DATA) {
    const FILE_EXTENSION = getFileExtension(FILE_DATA.name);
    let file_frame = '';
    
    if (FILE_EXTENSION === 'png' || FILE_EXTENSION === 'jpg' || FILE_EXTENSION === 'jpeg') {
        file_frame = `<img width='75%' height='90%' src="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/documents/bsd${FILE_DATA.name}" alt="${FILE_DATA.name}">`;
    } else {
        file_frame = `<iframe class="-file-frame" src='./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/documents/bsd${FILE_DATA.name}' frameborder="1"></iframe>`;
    }
    $('#file-frame-top-menu').append(file_frame);
}

function viewFileOnPage(FILE_ID) {
    let aHref = `<a id="viewFile${FILE_ID.file_id}" href="../ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${FILE_ID.event_id}/bsd${FILE_ID.name}" target="_blank"></a>`;
    $('#viewDocument').append(aHref);
    $(`#viewFile${FILE_ID.file_id}`)[0].click();
}

function dowloadFile(FILE_DATA) {
    let aHref = `<a id="viewFile${FILE_DATA.file_id}" href="../ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${FILE_DATA.event_id}/bsd${FILE_DATA.name}" download></a>`;
    $('#viewDocument').append(aHref);
    $(`#viewFile${FILE_DATA.file_id}`)[0].click();
}


function deleteTempFile(tempFileData){

    Swal.fire({
        title: "¿Quieres Eliminar este archivo?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Conservar",
        denyButtonText: `Eliminar`
      }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          return;
        } else if (result.isDenied) {
          const TEMP_FILE_WAS_DELETED = await deleteTempFileFromServer(tempFileData.name, EMPRESA_ID);
          if(TEMP_FILE_WAS_DELETED.success){
            const TEMP_FILE_INDEX = _tempFiles.indexOf(tempFileData);
            _tempFiles.splice(TEMP_FILE_INDEX,1)
            $(`#file-table tbody tr[temp_file_id=${tempFileData.temp_file_id}]`).remove();
          }
        }
      });
}


function deleteAssignedFile(fileData){

    Swal.fire({
        title: "¿Quieres Eliminar este archivo?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Conservar",
        denyButtonText: `Eliminar`
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          return;
        } else if (result.isDenied) {

          const ASSIGNED_FILE_WAS_DELETED = await deleteAssignedFileFromServer(fileData.id, EMPRESA_ID,fileData.event_id,fileData.name);

          if(ASSIGNED_FILE_WAS_DELETED.success){

            const  INDEX_TO_DELETE = _uploadedFiles.indexOf(fileData) 
            _uploadedFiles.splice(INDEX_TO_DELETE, 1);
            $(`#file-table tbody tr[file_id=${fileData.file_id}]`).remove();
          }
        }
    });
}


function getFileExtension(fname) {
    return fname.slice((fname.lastIndexOf(".") - 1 >>> 0) + 2);
}

function openViewUploadedFileDieMenu() {
    $('#viewUploadedFiles').addClass('active');
}

function closeViewUploadedFileDieMenu() {
    $('#viewUploadedFiles').removeClass('active');
}

function openFileMenu(element) {
    $(element).closest('.-file-box-header').find('.-file-options-container').addClass('active');
    fileOptionsIsOpen = true;
}

function closeAllFileMenu() {
    $('.-file-options-container').removeClass('active');
    // $('.-file-options-container').each((element)=>{$(element).removeClass( 'active')});
    fileOptionsIsOpen = false;
}

function deleteFile(file_data, empresa_id) {
    return $.ajax({
        type: "POST",
        url: 'ws/BussinessDocuments/deleteDocument.php',
        data: JSON.stringify({
            "request": file_data,
            "empresa_id": empresa_id
        }),
        dataType: 'json',
        success: function (response) {
            $('#clientDataBtn').text("Guardar");
            // console.log(response);
        }, error: function (response) {
            // console.log(response)
        }
    })
}

function deleteAssignedFileFromServer(file_id, empresa_id,event_id,file_name) {
    return $.ajax({
        type: "POST",
        url: 'ws/BussinessDocuments/deleteAssignedFile.php',
        data: JSON.stringify({
            'file_name': file_name,
            'file_id': file_id,
            "empresa_id": empresa_id,
            'event_id': event_id
        }),
        dataType: 'json',
        success: function (response) {
        }, error: function (response) {
            // console.log(response)
        }
    })
}

function deleteTempFileFromServer(file_name, empresa_id) {
    return $.ajax({
        type: "POST",
        url: 'ws/BussinessDocuments/deleteTempFile.php',
        data: JSON.stringify({
            "file_name": file_name,
            "empresa_id": empresa_id
        }),
        dataType: 'json',
        success: function (response) {
            // console.log(response);
        }, error: function (response) {
            // console.log(response)
        }
    })
}