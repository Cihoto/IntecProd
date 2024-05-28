const MENU_OPENER_BUTTON = document.getElementById('topUserMenuButton');
const MO_MENU_OPENER_BUTTON = document.getElementById('moTopMenu');

let topMenuIsOpen = false;

MENU_OPENER_BUTTON.addEventListener('click',function(){
    console.log(topMenuIsOpen)
    
    if(!topMenuIsOpen){
        openTopMenu();
        topMenuIsOpen = !topMenuIsOpen
        return;
    }
    closeTopMenu();
    topMenuIsOpen = !topMenuIsOpen
})
MO_MENU_OPENER_BUTTON.addEventListener('click',function(){
    console.log(topMenuIsOpen)
    
    if(!topMenuIsOpen){
        openTopMenu();
        topMenuIsOpen = !topMenuIsOpen
        return;
    }
    closeTopMenu();
    topMenuIsOpen = !topMenuIsOpen
})


function openTopMenu(){
    document.getElementById('topUserMenu').classList.add('active')
}
function closeTopMenu(){
    document.getElementById('topUserMenu').classList.remove('active')
}

