function printUploadedLogo(){
    const FILE = document.getElementById('logoUploader');
    document.getElementById('bussinessLogo').src = window.URL.createObjectURL(FILE.files[0]);
    let formData = new FormData();
    formData.append('files', FILE.files[0]);

    uploadNewLogo(formData)
}



function uploadNewLogo(formData){
    return $.ajax({
        type: "POST",
        url: "ws/BussinessDocuments/businessLogoUpload.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response)
        },error:  function(error){
            // console.log("error",error.responseText)
        }
    })
}