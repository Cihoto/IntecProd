const BREADCRUMB_CONTENT = [
    {
        'page': 'index',
        'breadCrumb': `<li class="breadcrumb-item">
                            <a class="txtDec-no">
                                <img src="./assets/svg/Dashboard.svg" alt="" style="margin-top: -5px;"> 
                                Dashboard
                            </a>
                        </li>` ,
        'breadCrumbHeaderTitle': 'Dashboard'
    },
    {
        'page': 'eventList',
        'breadCrumb': `<li class="breadcrumb-item">
                        <a class="txtDec-no">
                            <img src="./assets/svg/Eventos.svg" alt=""> 
                            Eventos
                        </a>
                       </li>
        <li class="breadcrumb-item active" aria-current="page">
            <a class="txtDec-no" >Listado de eventos</a>
        </li>` ,
        'breadCrumbHeaderTitle': 'Listado de eventos'
    },
    {
        'page': 'eventCreateOrEdit',
        'breadCrumb': `<li class="breadcrumb-item">
                <a class="txtDec-no" href="./eventos.php">
                    <img src="./assets/svg/Eventos.svg" alt=""> 
                    Eventos
                </a>
            </li>
        <li class="breadcrumb-item active" aria-current="page">
            <a class="txtDec-no createOrEditBreadcrumTitle" id="" href="#">
                Crear evento
            </a>
        </li>` ,
        'breadCrumbHeaderTitle': 'Crear evento'
    },
    {

    }
]


function createBreadCrumb(breadCrumbPage) {

    console.log(breadCrumbPage)

    const BC_CONTENT = BREADCRUMB_CONTENT.find((breadCrumb) => {
        return breadCrumb.page === breadCrumbPage
    });
    console.log(BC_CONTENT)

    if (!BC_CONTENT) {
        return;
    }

    $('#bcrumb-Container').append(BC_CONTENT.breadCrumb);
    $('#createOrEditBreadcrumTitle').text(BC_CONTENT.breadCrumbHeaderTitle);

}