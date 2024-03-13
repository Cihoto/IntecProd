const ACCEPTED_MIME_TYPES = ["application/zip",
    "application/x-7z-compressed",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "application/vnd.ms-excel",
    "text/plain",
    "application/vnd.rar",
    "application/vnd.openxmlformats-officedocument.presentationml.presentation",
    "application/vnd.ms-powerpoint",
    "application/pdf",
    "image/apng",
    "image/avif",
    "image/gif",
    "image/jpeg",
    "image/png",
    "image/svg+xml",
    "image/webp",
    "text/csv",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    "application/gzip",
    "audio/mpeg",
    "video/mp4",
    "video/mpeg"];
let _allmyUploadedFiles = [];

let _tempFiles = [];
let _temp_file_id = 0;



$('#createProject').on('click', function () {
    // $('#addDocuments').trigger('click');
})

$('#addDocuments').on('click', async function (e) {

    // e.preventDefault();

    // var formData = new FormData();
    // const FILES = $('#archivo')[0].files;

    // console.log("formData", formData);
    // for (let i = 0; i < FILES.length; i++) {
    //     formData.delete('files');
    //     formData.append('files', FILES[i]);

    //     if (ACCEPTED_MIME_TYPES.includes(FILES[i].type)) {
    //         const fileExists = _allmyUploadedFiles.find((file)=>{
    //             return file.name === FILES[i].name;
    //         });
    //         if(fileExists){
    //             const responseReplaceFile = await getReplaceFileResponse(FILES[i]);
    //             if(!responseReplaceFile){
    //                 continue
    //             }
    //         }
    //         await $.ajax({
    //             url: "ws/BussinessDocuments/files.php",
    //             type: 'POST',
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             success: function (response) {
    //                 _allmyUploadedFiles.push({
    //                     'name':FILES[i].name,
    //                     'size':FILES[i].size,
    //                     'type':FILES[i].type
    //                 })       
    //             },
    //             error: function (xhr, status, error) {
    //                 alert(xhr.responseText);
    //             }
    //         });
    //     } else {
    //         Toastify({
    //             text: `El archivo ${FILES[i].name} no es admitido por el sistema, su extensión está restringida`,
    //             duration: 4000
    //         }).showToast();
    //     }

    // }

    // $('#archivo').val("");
});


async function saveSelectedFilesInServer() {
    // e.preventDefault();
    var formData = new FormData();
    const FILES = $('#archivo')[0].files;

    console.log("formData", formData);
    for (let i = 0; i < FILES.length; i++) {
        formData.delete('files');
        formData.append('files', FILES[i]);

        if (ACCEPTED_MIME_TYPES.includes(FILES[i].type)) {
            const fileExists = _allmyUploadedFiles.find((file) => {
                return file.name === FILES[i].name;
            });
            if (fileExists) {
                const responseReplaceFile = await getReplaceFileResponse(FILES[i]);
                if (!responseReplaceFile) {
                    continue
                }
            }
            await $.ajax({
                url: "ws/BussinessDocuments/files.php",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {

                    _allmyUploadedFiles.push({
                        'name': FILES[i].name,
                        'size': FILES[i].size,
                        'type': FILES[i].type
                    })
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        } else {
            Toastify({
                text: `El archivo ${FILES[i].name} no es admitido por el sistema, su extensión está restringida`,
                duration: 4000
            }).showToast();
        }

    }

    $('#archivo').val("");
    console.log("TERMINE DE GUYARDAR LOS ARCHIBVOS EN EL SERVIDOR")
}


async function saveTempFileOnServer() {
    
    var formData = new FormData();
    const FILES = $('#excel_input')[0].files;
    for (let i = 0; i < FILES.length; i++) {
        formData.delete('files');
        formData.append('files', FILES[i]);

        if (ACCEPTED_MIME_TYPES.includes(FILES[i].type)) {
            if (_uploadedFiles.length > 0) {

                const FILE_IS_ASSIGNED = _uploadedFiles.find((file) => {
                    return file.name === FILES[i].name;
                });

                if (FILE_IS_ASSIGNED) {
                    const responseReplaceFile = await getReplaceFileResponse(FILES[i]);
                    if (!responseReplaceFile) {
                        continue;
                    }
                    await $.ajax({
                        url: "ws/BussinessDocuments/files.php",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {

                        }
                    })

                    await $.ajax({
                        url: "ws/BussinessDocuments/replaceUploadedFile.php",
                        type: 'POST',
                        data: JSON.stringify({
                            "file_name": FILE_IS_ASSIGNED.name,
                            "empresa_id": EMPRESA_ID,
                            "event_id": FILE_IS_ASSIGNED.event_id,
                        }),
                        contentType: false,
                        processData: false,
                        success: function (response) {

                        }
                    });
                    continue;
                }
            }

            const fileExists = _tempFiles.find((file) => {
                return file.name === FILES[i].name;
            });

            if (fileExists) {
                const responseReplaceFile = await getReplaceFileResponse(FILES[i]);
                if (!responseReplaceFile) {
                    continue
                }
                await $.ajax({
                    url: "ws/BussinessDocuments/files.php",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        _tempFiles.push({
                            'name': FILES[i].name,
                            'size': FILES[i].size,
                            'type': FILES[i].type,
                            'temp_file_id': _tempFiles.length + 1
                        });

                        let newDroppedFileRowData = {
                            'name': FILES[i].name,
                            'temp_file_id': _tempFiles.length
                        }

                        // printDroppedFiles(newDroppedFileRowData);
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });

                continue;
            } else {
                await $.ajax({
                    url: "ws/BussinessDocuments/files.php",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        _tempFiles.push({
                            'name': FILES[i].name,
                            'size': FILES[i].size,
                            'type': FILES[i].type,
                            'temp_file_id': _tempFiles.length + 1
                        });

                        let newDroppedFileRowData = {
                            'name': FILES[i].name,
                            'temp_file_id': _tempFiles.length
                        }

                        printDroppedFiles(newDroppedFileRowData);
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });

                continue;
            }
        } else {
            Toastify({
                text: `El archivo ${FILES[i].name} no es admitido por el sistema, su extensión está restringida`,
                duration: 4000
            }).showToast();
        }
    }
    $('#excel_input').val("");
}

async function getReplaceFileResponse(file) {
    return await Swal.fire({
        title: `El archivo ${file.name} ya existe en este evento, ¿Deseas reemplazarlo?`,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Reemplazar archivo",
        denyButtonText: `Omitir este archivo`
    }).then(async (result) => {
        if (result.isConfirmed) {
            return true
        } else if (result.isDenied) {
            return false
        }
    });
}