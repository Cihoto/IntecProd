
// const DEMO_BUTTON = document.getElementById('activeDemoDataInAccount');


// DEMO_BUTTON.addEventListener('click', function () {
//     // alert(bussinessIsDemo)
//     // headbreadcrumb variable init on script
    
//     if (bussinessIsDemo) {

//         showModalDeleteDemoData();
        
//         return
//     }

//     showModalAddDemoData();
// });

document.addEventListener('click', function (e) {
    if (e.target.id === 'activeDemoDataInAccount') {
        if (bussinessIsDemo) {

            showModalDeleteDemoData();
            
            return
        }
    
        showModalAddDemoData();
    }
});




function showModalAddDemoData(){
    const SWAL_DEMO_CONFIRM = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    SWAL_DEMO_CONFIRM.fire({
        title: "¿Deseas agregar los datos de prueba a tu cuenta?",
        text: "Podrás deshacer esta desición en un futuro",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, agregar.",
        cancelButtonText: "No, cancelar.",
        reverseButtons: true,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: async (demoDataInsert) => {
            try {
                const createNewDemoAccount = await activateDemoDataonNewAccount(EMPRESA_ID);
                return createNewDemoAccount
            } catch (error) {
                Swal.showValidationMessage(`Ha ocurrido un error, se revertirán los cambios efectuados.`);
                // Swal.showValidationMessage(`Error found: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // setTimeout(() => {
                if(result.value === true){
                    
                    SWAL_DEMO_CONFIRM.fire({
                        title: "Excelente!",
                        text: "Tus datos demo han sido agregados exitosamente.",
                        icon: "success"
                    });
                }
            // }, 2500);
        } 
        // else if (result.dismiss === Swal.DismissReason.cancel) {}
    });
}

function showModalDeleteDemoData(){
    const SWAL_DEMO_REMOVE = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    
    SWAL_DEMO_REMOVE.fire({
        title: "¿Deseas eliminar los datos de prueba a tu cuenta?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar.",
        cancelButtonText: "No, conservar.",
        reverseButtons: true,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: async (demoDataInsert) => {
            try {
                const deleteDemoDataFromBussiness = await removeDemoDataFromBussiness(EMPRESA_ID);
                return deleteDemoDataFromBussiness
            } catch (error) {
                // Swal.showValidationMessage(`Ha ocurrido un error, se revertirán los cambios efectuados.`);
                Swal.showValidationMessage(`Error found: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // setTimeout(() => {
                if(result.value === true){
                    
                    SWAL_DEMO_REMOVE.fire({
                        title: "Excelente!",
                        text: "Tus datos demo han sido eliminados exitosamente.",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });

                }
            // }, 2500);
        } 
        // else if (result.dismiss === Swal.DismissReason.cancel) {}
    });
}
