


async function getAllProjectData(event_id, empresa_id) {
    const projectRequest = {
        'idProject': event_id,
        'empresa_id': empresa_id,
        'asignados': true
    }
    const responseGetData = await $.ajax({
        type: "POST",
        url: 'ws/proyecto/proyecto.php',
        data: JSON.stringify({
            request: {
                projectRequest
            },
            action: "getProjectResume"
        }),
        dataType: 'json',
        success: function (response) {
            // console.log("event_Data", response);
        }
    });

    if (responseGetData.fatalError) {
        window.location.href = "/index.php";
    }

    console.log('EVENT DATA',responseGetData);



    responseGetData.dataProject.forEach(data => {
        let nombre_cliente;

        if (data.nombre_proyecto === "" || data.nombre_proyecto === undefined || data.nombre_proyecto === null) {
            data.nombre_proyecto = "";
        }
        if (data.fecha_inicio === "" || data.fecha_inicio === undefined || data.fecha_inicio === null) {
            data.fecha_inicio = "";
        }
        if (data.fecha_termino === "" || data.fecha_termino === undefined || data.fecha_termino === null) {
            data.fecha_termino = "";
        }
        // console.log("NOMBRE CLIENTE",nombre_cliente);
        if (nombre_cliente === "" || nombre_cliente === undefined || nombre_cliente === null) {
            nombre_cliente = "";
        }
        if (data.comentarios === "" || data.comentarios === undefined || data.comentarios === null) {
            comentarios = "";
        }
        if (data.direccion === "" || data.direccion === undefined || data.direccion === null) {
            data.direccion = "";
        }

        $('#inputProjectName').val(data.nombre_proyecto);
        $('#direccionInput').val('');
        $('#event_type').val(data.event_type_id);
        $('#dirInput').val(data.direccion);
        $('#dirInput').blur();
        $('#inputNombreCliente').val(data.nombre_cliente);
        $('#commentProjectArea').val(data.comentarios);
        // $('#estadoProyecto').text(data.estado);

        let owner_id = 0;

        if(data.owner === null || data.owner === undefined || data.owner === ""){
            owner_id = event_data.owner_id;
        }else{
            owner_id = data.owner;
        }
        if(owner_id !== null || owner_id !== undefined || owner_id !== ''){

            $('#ownerSelect').val(owner_id);
            $('#ownerSelect').change();
            
        }else{

            $('#ownerSelect').val(PERSONAL_IDS[0]);
            $('#ownerSelect').change();

        }

        const button = $(`.event-status-btn[status_id='${data.estado}']`);

        $(button)[0].click();
    });

    console.log('responseGetData.asignados.comments',responseGetData.asignados.comments)
    console.log('responseGetData.asignados.comment_replies',responseGetData.asignados.comment_replies)



    _assignedComments = responseGetData.asignados.comments;
    _assignedCommentsReplies = responseGetData.asignados.comment_replies.map((reply)=>{
        return {
            'comment_id' : reply.comment_id,
            'reply_id' : reply.reply_id,
            'post_user_id' : reply.post_user_id,
            'reply_text' : reply.text,
            'user_name' : reply.user_name ,
            'post_date': reply.post_date
        }
    });

    responseGetData.asignados.comments.forEach((comment)=>{
        // createComment(comment.text);
        $('.--comments-container').append(createAssignedComment(comment))

    });

    $('.--comment-wrapper').each((index,element)=>{

        let comment_id = $(element).find('.assignedComment').attr('comment_id');
        
        const COMMENT_REPLIES = _assignedCommentsReplies.filter((replyData)=>{
            return replyData.comment_id == comment_id
        });

        if(COMMENT_REPLIES){

            COMMENT_REPLIES.forEach((reply)=>{

                $(element).find('.--comment-reply-wrapper').append(createAssiReply(reply));
            })
        }

    })

    if(responseGetData.asignados.schedules.length > 0){
        
        $('#schedule-container .schedule-item').remove();
        responseGetData.asignados.schedules.forEach((schedule)=>{
            let scheduleContainer = `<div class="schedule-item" schedule_id="${schedule_id}">
                <div class="schedule-data">
                    <img class="delete-schedule" src="../assets/svg/trashCan-red.svg" alt="">
                    <input type="text" class="detail" placeholder="desc" value="${schedule.schedule_detail}">
                    <input type="time" class="hour" name="appt" value="${schedule.schedule_hour}"/>
                </div>
            </div>`;
            $('#schedule-container').append(scheduleContainer);
            _all_my_selected_schedules.push({
                'schedule_id' : schedule_id,
                'schedule_detail' : schedule.schedule_detail,
                'schedule_hour' : schedule.schedule_hour
            });
            schedule_id ++;
        })
    }

    if (responseGetData.asignados.cliente.length > 0) {
        // console.log("responseGetData.asignados.cliente",responseGetData.asignados.cliente);

        responseGetData.asignados.cliente.forEach(cliente => {
            let name = "";
            if(cliente.nombre_persona !== "" || cliente.nombre_persona !==null){
                name = cliente.persona_contacto
            }
            if(cliente.nombre_persona !== "" || cliente.nombre_persona !==null){
                name = cliente.nombre_persona
            }
            if(cliente.nombre_fantasia !== "" || cliente.nombre_fantasia !==null){
                name = cliente.nombre_fantasia
            }
            $('#inputTelefono').val(cliente.telefono);
            $('#inputNombreCliente').val(name);
            event_data.client_id = cliente.cliente_id
            $('#clienteSelect').val(cliente.cliente_id);
            $('#clienteSelect').change();
        });
    }

    if (responseGetData.asignados.eventData_json.length > 0) {
        const EVENT_JSON = responseGetData.asignados.eventData_json[0];

        console.log('EVENT_JSON',EVENT_JSON); 
        
        const SELECTED_PRODUCTS = JSON.parse(EVENT_JSON.selected_prods_json);
        const SELECTED_PERSONAL = JSON.parse(EVENT_JSON.selectedPersonal_json);
        const SELECTED_VEHICLES = JSON.parse(EVENT_JSON.selectedVehicles_json);
        
        const RESPONSE_TOTAL_PER_ITEM = JSON.parse(EVENT_JSON.totalPerItem_json)
        const TOTAL_PER_ITEM_PRODUCTOS = RESPONSE_TOTAL_PER_ITEM.equipos;

        _selectedProducts = SELECTED_PRODUCTS; 
        totalPerItem.equipos = TOTAL_PER_ITEM_PRODUCTOS



        printAllProductsOnTable();
        printAllSelectedProducts();
        setIngresos();

        if(SELECTED_PERSONAL === ""){
            if (responseGetData.asignados.personal.length > 0) {
                responseGetData.asignados.personal.forEach(personal => {
                    AddSelectedPersonal(personal.id);
                });
                printAllSelectedPersonal();
            } else { }
        }else{
            allSelectedPersonal = SELECTED_PERSONAL
            printAllSelectedPersonal();
        }
        if(SELECTED_VEHICLES === ""){
            if (responseGetData.asignados.vehiculos.length > 0) {
                responseGetData.asignados.vehiculos.forEach(vehiculo => {

                    addVehicle(vehiculo.id)
                });
            } else { }
        }else{
            
            selectedVehicles = SELECTED_VEHICLES    

            
            printSelectedVehicles()
        }
        


        
    }else{

        responseGetData.asignados.productos.forEach(producto => {
            const productsToAdd = [{
                'id': producto.id,
                'quantityToAdd': producto.cantidad
            }];
            setSelectedProduct_AddNewProducts(productsToAdd);
            printAllProductsOnTable();
            printAllSelectedProducts();
            setIngresos();
        });
        
        if (responseGetData.asignados.personal.length > 0) {
            responseGetData.asignados.personal.forEach(personal => {
                AddSelectedPersonal(personal.id);
            });
            printAllSelectedPersonal();
        } else { }

        if (responseGetData.asignados.vehiculos.length > 0) {
            responseGetData.asignados.vehiculos.forEach(vehiculo => {
                addVehicle(vehiculo.id)
            });
        } else { }


        // if (responseGetData.asignados.productos.length > 0) {
      
        // }
    }

    if(responseGetData.asignados.otherProds.length > 0){
        responseGetData.asignados.otherProds.forEach(otherProd => {
            _selectedOthersProducts.push({
            'detalle': otherProd.detalle,
                'cantidad': otherProd.cantidad,
                'total': otherProd.valor
            })
        });

        printOthersProds();;
        setIngresos();
    }

    if (responseGetData.asignados.assignedPackages.length > 0) {
        
        // console.log("responseGetData.asignados.assignedPackages",responseGetData.asignados.assignedPackages)
        responseGetData.asignados.assignedPackages.forEach(async (package) => {
            // console.log("package",package)
            // const productsOnPackage = await GetPackageDetails(package.paquete_id);
            // const productsToAdd = productsOnPackage.products.map((productsOnPackage)=>{
            //     return{
            //         'id': productsOnPackage.product_id,
            //         'quantityToAdd' : productsOnPackage.quantity
            //     }
            // });

            // _selectedPackages.push({
            //     'package_id' : productsOnPackage.data[0].id,
            //     'package_name' : productsOnPackage.data[0].nombre,
            //     'package_products' :  productsOnPackage.products
            // });
            
            // if($(`#standardPackagesList tr[package_id = ${package.paquete_id}]`).length > 0)
            // {
            //     $(`#standardPackagesList tr[package_id = ${package.paquete_id}]`).addClass("packageSelected");
            // }
            
        });
    }


    if (responseGetData.asignados.accountables.length > 0) {
        
        responseGetData.asignados.accountables.forEach(accountable => {
            createNewFinancialReportingRow(accountable.detalle, accountable.personal_id, accountable.monto, accountable.fecha, accountable.comercio,rendicion_temp_id)
            // global variable fomr rendicion.js
            allRendiciones.push({
                'temp_id':rendicion_temp_id,
                'detalle': accountable.detalle,
                'personal_id': accountable.personal_id,
                'monto': accountable.monto,
                'fecha': accountable.fecha,
                'comercio':accountable.comercio 
            });
            rendicion_temp_id ++;

        });
    } else { }
    if (responseGetData.asignados.otherCosts.length > 0) {
 
        responseGetData.asignados.otherCosts.forEach(cost => {
            appendNewRowOtherCosts(cost.name,cost.quantity,cost.total);
            // global variable fomr otherCosts.js vvv
            _allMyOtherCosts.push({
                'temp_id':others_costs_temp_id,
                'name':cost.name,
                'cantidad': cost.quantity,
                'monto': cost.total
            });
            // global variable fomr otherCosts.js vvv
            others_costs_temp_id ++;
        });
    } else { }
    if (responseGetData.asignados.arriendos.length > 0) {
 
        responseGetData.asignados.arriendos.forEach(subRent => {
            // global variable fomr otherCosts.js vvv
            _subRentsToAssign.push({
                'detalle': subRent.detalle,
                'proveedor_id': subRent.proveedor_id,
                'valor': subRent.valor
            })
        });
        setEgresos();
    } else { }
    printNewRow_subRent();

    responseGetData.dataProject.forEach(data => {
        if (data.fecha_inicio === "" || data.fecha_inicio === undefined || data.fecha_inicio === null) {
            data.fecha_inicio = "";
        }
        if (data.fecha_termino === "" || data.fecha_termino === undefined || data.fecha_termino === null) {
            data.fecha_termino = "";
        }
        $('#fechaInicio').val(data.fecha_inicio)
        $('#fechaTermino').val(data.fecha_termino)
        $('#fechaInicio').change();
        $('#fechaTermino').change();
        $('#inputProjectName').change();
    });

    if(responseGetData.asignados.files.length > 0){
        // FILL VARIABLE FROM evento/viewUploadesFiles.js
        _uploadedFiles = responseGetData.asignados.files;
        
        responseGetData.asignados.files.forEach((file)=>{
            // console.log(`../ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${event_data.event_id}/bsd${file.name}`)
            let fileContainer = `<div class="file-container">
                <i class="fa-regular fa-file"></i>
                <a href="./ws/BussinessDocuments/documents/buss${EMPRESA_ID}/Ev${event_data.event_id}/bsd${file.name}" download>${file.name}</a>
            </div>`
            $('#fileListContainer').append(fileContainer);
        });
        printOthersProds();;
        setIngresos();
    }
}