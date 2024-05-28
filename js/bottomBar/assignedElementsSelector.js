const ASSIGNED_BUTTON = document.getElementById('assigmentSelector');
const DETAILS_TAB = document.getElementById('details-tab');
const INVENTORY_TAB = document.getElementById('products-tab');
const PERSONAL_TAB = document.getElementById('personal-tab');
const VEHICLES_TAB = document.getElementById('vehicle-tab');
let assignationToOpen;

ASSIGNED_BUTTON.addEventListener('click',function(){
    if(assignationToOpen === 'inv'){
        // function from includes php file drag products
        openSelectedProdsMobile();
    }
    if(assignationToOpen === 'per'){
        // function from includes php file drag products
        openSelectedPersonal() ;
    }
    if(assignationToOpen === 'veh'){
        // function from includes php file drag products
        openSelectedVehicles();
    }
});

// DETAILS TAB
DETAILS_TAB.addEventListener('click',function(){
    ASSIGNED_BUTTON.classList.remove('active');
    assignationToOpen = '';
});

// INVENTORY TAB CONTROLLER
// openSelectedProdsMobile();
// closeSelectedProdsMobile();
INVENTORY_TAB.addEventListener('click',function(){
    ASSIGNED_BUTTON.classList.add('active');
    assignationToOpen = 'inv';
});

// PERSONAL TAB CONTROLLER
// openSelectedPersonal() ;
// closeSelectedPersonal() ;
PERSONAL_TAB.addEventListener('click',function(){
    ASSIGNED_BUTTON.classList.add('active');
    assignationToOpen = 'per';
});


// VEHICLES TAB CONTROLLER
// openSelectedVehicles();
// closeSelectedVehicles();
VEHICLES_TAB.addEventListener('click',function(){
    ASSIGNED_BUTTON.classList.add('active');
    assignationToOpen = 'veh';
});