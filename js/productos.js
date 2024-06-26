let dataTableProduct = ''; 

function filterInventiryTable(value){
  if(value ===""){
    dataTableProduct.search("").draw();
    return
  }

  dataTableProduct.search(value).draw();
}


function FillProductos(empresaId) {
  if ($.fn.DataTable.isDataTable('#tableProducts')) {
    $('#tableProducts').DataTable().destroy();
    $('#tableProducts tbody tr').remove();

  }
  $.ajax({
    type: "POST",
    url: "ws/productos/Producto.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "getProductos",
      empresaId: empresaId
    }),
    success: function (response) {

      document.getElementById('palCtn').style.display = 'none';
      // document.getElementById('tableProducts').style.display = 'none';

      


      if(response.length === 0){

        return 
      }

      return
      response.forEach(producto => {
        let td = `
          <td class="productId --res-del" style="display:none">${producto.id}</td>
          <td class="catProd"> ${producto.categoria}</td>
          <td class="itemProd"> ${producto.item}</td>
          <td style="width:25%" class="productName">${producto.nombre}</td>
          <td class="productPrice"> ${producto.precio_arriendo} </td>
          <td class="productStock" >${producto.cantidad}</td>
          <td><input class="addProdInput quantityToAdd" id="" type="number" min="1" max="${producto.cantidad}"/><i class="fa-solid fa-plus addItem" onclick="AddProduct(this)"></i></td>`
          
          $('#tableProducts tbody').append(`<tr id="${producto.id}">${td}</tr>`)
      });

      dataTableProduct = $('#tableProducts').DataTable({
        // fixedHeader: true,
        responsive:true,
        columnDefs: [
          columns[
            [{ width: '20%' }, null, null, null, null]
          ]
          // { targets: '_all', visible: false }
      ]
      })
      closeSelectedProdsMobile();
    }
  })
}

function GetAllProductsByBussiness(empresaId) {
  return $.ajax({
    type: "POST",
    url: "ws/productos/Producto.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "getProductos",
      empresaId: empresaId
    }),
    success: function (response) {
      // console.log(response);
    }, error: function (error) {
      console.log(error);
    }
  })
}

async function GetProductDataById(product_id) {
  return $.ajax({
    type: "POST",
    url: "ws/productos/Producto.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "GetProductDataById",
      product_id: product_id
    }),
    success: function (response) {
      // console.log(response);
    }, error: function (error) {
      console.log(error);
    }
  })
}


function SetResumeProductsValue() {

  let personalCost = $('.valorProductoResume')
  let totalPersonal = 0

  Array.from(personalCost).forEach(pCost => {
    totalPersonal = totalPersonal + parseInt(ClpUnformatter($(pCost).text()));
  });

  console.log("total de PRODUCTOS EN UPDATE", totalPersonal);

  $('#totalResumeProductos').text(CLPFormatter(totalPersonal));
  // $('#totalResumeProductos').text("totalPersonal");

}


function removeProduct(idProduct) {
  removeProductoStorage(idProduct)
  RemoveProductFromResume(idProduct);
}

function RemoveProductFromResume(id) {

  if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("7")) {

    let tdProductos = $('#projectEquipos tbody').find('.idProductoResume');

    tdProductos.each((index, td) => {
      if ($(td).text() === id) {
        $(td).closest('tr').remove();
      }
    })
    SetResumeProductsValue();

  } else {
    Swal.fire({
      title: 'Lo sentimos',
      text: "No tienes los persisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
      icon: 'warning',
      showCancelButton: false,
      showConfirmButton: true,
      confirmButtonText: "Entendido"
    })
  }


}

function AppendProductToResume(tipo) {

  let lStorage = GetProductsStorage();
  let arrayLength = lStorage.length;
  lStorage = lStorage[arrayLength - 1];

  if (tipo === "add") {
    let newTr = `<tr>
                      <td class="idProductoResume" style="display:none">${lStorage.productId}</td>
                      <td class="tbodyHeader">${lStorage.productName}</td>
                      <td class="quantity">${lStorage.quantityToAdd}</td>
                      <td class="perUnit">${lStorage.productPrice}</td>
                      <td class="valorProductoResume">${lStorage.totalPrice}</td>
                    </tr>`;
    for (let i = arrayLength - 1; i === arrayLength - 1; i++) {
      $("#projectEquipos tr:last").before(newTr);
    }

    SetResumeProductsValue();
    // $('#totalCostProject').text(CLPFormatter(parseInt(GetTotalCosts())));

  }
}

function AddProduct(el) {
  if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("7")) {

    let product_id = $(el).closest("tr").attr('product_id');
    let quantityToAdd = $(el).closest("td").find('.quantityToAdd').val();


    const PROD_EXIST = _productos.find((producto) => {
      if (producto.id === product_id) {
        return producto
      }
    });


    if (!PROD_EXIST) {
      Swal.fire(
        'Lo sentimos!',
        'Ha ocurrido un error, intente nuevamente',
        'error'
      )
      return
    }

    if (quantityToAdd === "" || quantityToAdd === undefined || quantityToAdd <= 0) {
      Swal.fire({
        'title': 'Ups!',
        'text': 'Ingresa una cantidad valida',
        'icon': 'warning',
        'showConfirmButton': false,
        'timer': 2000
      })
      return;
    }


    const prodsToAdd = [{
      'id': product_id,
      'quantityToAdd': quantityToAdd
    }]

    const addProd = setSelectedProduct_AddNewProducts(prodsToAdd);

    _searchProductValue = $('#tableProducts_filter').find('input[type="search"]').val();
    let indexTab = $("#tableProducts").DataTable().page();

    printAllProductsOnTableFromPrevSearch(_searchProductValue, indexTab);
    setCategoriesAndSubCategories();
    printAllSelectedProducts();
    setIngresos();

    // $('#tableProducts_filter').find('input').val(_searchProductValue);
    // $("#tableProducts").DataTable().page(indexTab);



    isProdQuantitySelected = false;
    prodQuantityElementSelected = "";

    if (addProd) {
      Toastify({
        text: `Se han agregado ${quantityToAdd} ${PROD_EXIST.nombre}`,
        duration: 2000,
        close: true
      }).showToast();
    } else {
      console.log("ha ocurrido un error");
    }

  } else {

    Swal.fire({
      title: 'Lo sentimos',
      text: "No tienes los permisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
      icon: 'warning',
      showCancelButton: false,
      showConfirmButton: true,
      confirmButtonText: "Entendido"
    })
  }
}


// AGREGAR UN ITEM A LA TABLA DE RESUMEN A UN COSTADO DE 
//LA TABLA, CREA RESUMEN DEPENDIENDO DE LAS CANTIDADES, NOMBRE Y PRECIO DE ARRIENDO
function AddProductssssss(el) {
  if (ROL_ID.includes("1") || ROL_ID.includes("2") || ROL_ID.includes("7")) {
    // if (ROL_ID !== 3) {
    let tdProductos = $('#projectEquipos tbody').find('.idProductoResume');
    // tdProductos.each((index, td) => {
    //   if ($(td).text() === id) {
    //     $(td).closest('tr').remove();
    //   }
    // })
    SetResumeProductsValue();

    let quantityToAdd = $(el).closest("td").find('.quantityToAdd').val();
    let productId = $(el).closest("tr").find('.productId').text();
    let productName = $(el).closest("tr").find('.productName').text();
    let productPrice = $(el).closest("tr").find('.productPrice').text();
    let stock = parseInt($(el).closest("tr").find('.productStock').text());
    let finalStock = stock - parseInt(quantityToAdd);

    if (quantityToAdd === 0 || quantityToAdd === undefined || quantityToAdd === null || quantityToAdd === "") {
      Swal.fire({
        icon: 'info',
        title: 'Ups!',
        text: `Debes agregar la cantidad de ${productName} que deseas añadir`,
      })
      return;
    }


    if (finalStock < 0) {
      Swal.fire({
        icon: 'error',
        title: 'Ups!',
        text: `Has seleccionado más ${productName} de los que dispones`,
      });

    } else {

      $(el).closest("tr").find('.productStock').text(finalStock);
      $(el).closest("td").find('.quantityToAdd').val("");
      AddDivProduct(productName, productPrice, productId, quantityToAdd);
      let totalPrice = productPrice * quantityToAdd;
      ProductsStorage(productId, productName, productPrice, quantityToAdd, totalPrice);
      TotalCosts(totalPrice);
      AppendProductToResume("add");
    }
  } else {
    Swal.fire({
      title: 'Lo sentimos',
      text: "No tienes los permisos para poder ejecutar esta acción, si deseas tenerlos debes ponerte en contacto con el administrador de tú organización",
      icon: 'warning',
      showCancelButton: false,
      showConfirmButton: true,
      confirmButtonText: "Entendido"
    })
  }
}

function AppendProductosTableResumeArray(arrayProductos) {
  for (let i = 0; i < arrayProductos.length; i++) {
    let newTr = `<tr>
                <td class="idProductoResume" style="display:none">${arrayProductos[i].productId}</td>
                <td class="tbodyHeader">${arrayProductos[i].productName}</td>
                <td class="quantity">${arrayProductos[i].quantityToAdd}</td>
                <td class="perUnit">${arrayProductos[i].productPrice}</td>
                <td class="valorProductoResume">${CLPFormatter(arrayProductos[i].totalPrice)}</td>
              </tr>`;
    $("#projectEquipos tr:last").before(newTr);
    TotalCosts(arrayProductos[i].totalPrice)
  }
  SetResumeProductsValue();
  // console.log(GetTotalCosts());
  $('#totalCostProject').text(CLPFormatter(parseInt(GetTotalCosts())));
}

let lastSelProdQty = 0;

$(document).on('click', '.selProdQty', async function () {
  lastSelProdQty = $(this).val();
})

$(document).on('blur','.selProdQty',function(){
  const currentValue = $(this).val();
  if (currentValue === "" || currentValue === null || currentValue === undefined) {
    $(this).val(lastValue)
    return;
  }
  if (!isNumeric(currentValue)) {
    Swal.fire(
      'Ups!',
      'Debes ingresar un número',
      'error'
    );
    $(this).val(lastSelProdQty)
    return
  }

  const PRODUCT_ID = $(this).closest('tr').attr('product_id');


  changeSelectedProductQuantity(PRODUCT_ID,currentValue);
})




//ASIGNACION DE PRODUCTOS Y PAQUETES DATOS TOMADOS DESDE EL DOM, FUNCIONES DE MODULO PRODUCTOS
let lastValue = 0;
$(document).on('click', '.addProdInputResume', async function () {
  lastValue = $(this).val();
})
$(document).on('blur', '.addProdInputResume', async function () {
  const currentValue = $(this).val();
  if (currentValue === "" || currentValue === null || currentValue === undefined) {
    $(this).val(lastValue)
    return;
  }
  if (!isNumeric(currentValue)) {
    Swal.fire(
      'Ups!',
      'Debes ingresar un número',
      'error'
    );
    $(this).val(lastValue);
    return
  }

  const PRODUCT_ID = $(this).closest('tr').attr('product_id');
  changeSelectedProductQuantity(PRODUCT_ID,currentValue);
})


function changeSelectedProductQuantity(product_id,currentValue){
  let minProducts = [];
  let minvalue = 0;

  if (_selectedPackages.length > 0) {

    const prodExists = _selectedProducts.find((product) => {
      return product.id === product_id
    })
    if (!prodExists) {
      Swal.fire(
        'Ups!',
        'Ha ocurrido un error, por favor intenta nuevamente',
        'error'
      );
      $(this).val(lastValue);
      return
    }
    const totalToRemove = _selectedProducts.find((product) => {
      if (product.id === product_id) {
        return product.quantityToAdd
      }
    });
    let totalOnPackages = 0;
    let packageTakenProducts = _selectedPackages.map((selectedPackage) => {
      const prodsPerPackage = selectedPackage.package_products.find((product) => {
        return product.product_id === product_id
      })
      if (prodsPerPackage) {
        totalOnPackages += parseInt(prodsPerPackage.quantity);
        return {
          'package_name': selectedPackage.package_name,
          'products': prodsPerPackage
        }
      }
    }).filter((value) => { return value !== undefined })

    const totalToSubstract = parseInt(totalOnPackages) - parseInt(currentValue)

    if (parseInt(currentValue) < parseInt(totalOnPackages)) {
      $(this).val(totalToRemove.quantityToAdd);
      let trs = '';
      packageTakenProducts.forEach((prod) => {
        trs += `<tr>
              <td>${prod.package_name}</td>
              <td>${prod.products.quantity}</td>
          </tr>`
      });

      Swal.fire({
        'icon': 'warning',
        'title': 'Ups!',
        'html': `<p>No se puede asignar ${currentValue} ${totalToRemove.nombre} ya que todos los equipos seleccionados pertenecen a un paquete</p>
          <table class="table">
          <thead>
              <tr>
                  <th>Paquete</th>
                  <th>Cantidad</th>
              </tr>
          <thead>
          <tbody>
              ${trs}
          </tbody>
      </table>`
      })
      return
    }

    // SUMAR DIFERENCIA EN CASO DE QUE LOS SELECCIONADOS DE DISTINTOS ORIGENES(PACQUETES , SELECCION MANUAL PRODUCTOS RESERVADOS DESDE OTROS EVENTOS)
    if (parseInt(currentValue) > parseInt(totalToRemove.quantityToAdd)) {
      let quantityToAdd = parseInt(currentValue) - parseInt(totalToRemove.quantityToAdd);
      const productsToAdd = [{
        'id': totalToRemove.id,
        'quantityToAdd': quantityToAdd
      }]
      const removedProducts = setSelectedProduct_AddNewProducts(productsToAdd);
      setCategoriesAndSubCategories();
      printAllProductsOnTable();
      printAllSelectedProducts();
      setIngresos();
      return;
    }

    if (parseInt(currentValue) < parseInt(totalToRemove.quantityToAdd)) {

      let quantityToRemove = parseInt(totalToRemove.quantityToAdd) - parseInt(currentValue);
      const productsToRemove = [{
        'id': totalToRemove.id,
        'quantity': quantityToRemove
      }]
      const removedProducts = setSelectedProduct_RemoveProducts(productsToRemove);
      setCategoriesAndSubCategories();
      printAllProductsOnTable();
      printAllSelectedProducts();
      setIngresos();
      return;
    }
  } else {

    if (parseInt(currentValue) > 0) {
      // product_id

      const prodToUpdate = _selectedProducts.find((prod) => {
        return prod.id === product_id;
      });
      if (prodToUpdate) {
        prodToUpdate.quantityToAdd = currentValue;
      }
      setCategoriesAndSubCategories();
      printAllProductsOnTable();
      printAllSelectedProducts();
      setIngresos();
      return;

    } else {
      const prodToUpdate = _selectedProducts.find((prod) => {
        return prod.id === product_id;
      });
      if (prodToUpdate) {
        const indexof = _selectedProducts.indexOf(prodToUpdate);
        let newarray = _selectedProducts.splice(indexof, 0);

      }
      setCategoriesAndSubCategories();
      printAllProductsOnTable();
      printAllSelectedProducts();
      setIngresos();
      return;
    }
  }
}

async function GetAllProductsByBussiness(empresa_id) {
  return $.ajax({
    type: "POST",
    url: "ws/productos/Producto.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "GetAllProductsByBussiness",
      empresa_id: empresa_id
    }),
    success: function (response) {
    }
  })
}

function GetUnavailableProductsByDate(data, empresa_id) {
  return $.ajax({
    type: "POST",
    url: "ws/productos/Producto.php",
    dataType: 'json',
    data: JSON.stringify({
      "action": "GetUnavailableProductsByDate",
      'empresa_id': empresa_id,
      'request': {
        'data': data
      }
    }),
    success: function (response) {

    },
    error: function (error) {
      console.log(error);
    }
  })
}

// function to call and fill table products without dates restrictions
async function FillAllProducts() {

  allMyProducts = []
  listProductArray = [];

  const responseAllProducts = await GetAllProductsByBussiness(EMPRESA_ID);

  if (responseAllProducts.success) {

    allMyProducts = responseAllProducts.data;

    // SET listProductArray (GLOBAL VARIABLE), CONFIG JSON OBJECT BY MAP FUNCTION WITH DB AJAX DATA
    // THIS ARRAY WILL BE USED ON EVERY MOVE ON PRODUCTS ASSIGMENT
    listProductArray = allMyProducts.map(function (producto) {
      let disponibles = producto.cantidad
      return {
        'id': producto.id,
        'categoria': producto.categoria,
        'item': producto.item,
        'nombre': producto.nombre,
        'precio_arriendo': producto.precio_arriendo,
        'cantidad': producto.cantidad,
        'disponibles': disponibles,
        'faltantes': 0
      }
    })
    fillProductsTableAssigments();
  }
}

async function FillAllAvailableProducts(dates) {

  allMyProducts = [];
  allMyTakenPoducts = [];
  listProductArray = [];

  const fecha_inicio = dates.fecha_inicio;
  const fecha_termino = dates.fecha_termino;
  const data = {
    'fecha_inicio': fecha_inicio,
    'fecha_termino': fecha_termino
  }
  const responseUnavailableProducts = await GetUnavailableProductsByDate(data, EMPRESA_ID);
  const responseAllProducts = await GetAllProductsByBussiness(EMPRESA_ID);

  if (responseUnavailableProducts.success && responseAllProducts.success) {
    allMyProducts = responseAllProducts.data;
    allMyTakenPoducts = responseUnavailableProducts.data;
    if (allMyTakenPoducts.length === 0) {

      // listProductArray = allMyProducts

      listProductArray = allMyProducts.map(function (producto) {
        let disponibles = producto.cantidad
        return {
          'id': producto.id,
          'categoria': producto.categoria,
          'item': producto.item,
          'nombre': producto.nombre,
          'precio_arriendo': producto.precio_arriendo,
          'cantidad': producto.cantidad,
          'disponibles': disponibles,
          'faltantes': 0
        }
      })
    } else {
      listProductArray = allMyProducts.map((producto, index) => {
        let disponibles = producto.cantidad;
        const takenProduct = allMyTakenPoducts.find((taken) => {
          if (taken.producto_id === producto.id) {
            return taken
          }
        });
        if (takenProduct) {
          disponibles = parseInt(producto.cantidad) - parseInt(takenProduct.cantidad)
        }
        return {
          'id': producto.id,
          'categoria': producto.categoria,
          'item': producto.item,
          'nombre': producto.nombre,
          'precio_arriendo': producto.precio_arriendo,
          'cantidad': producto.cantidad,
          'disponibles': disponibles,
          'faltantes': 0
        }
      })
    }

    // FILL TABLE WITH listProductArray
    // this array contains a json object returned by map all data given by ajax db call
    // map gives format to this json, after we can manage this array to disocunt available stock or whatever we need
    fillProductsTableAssigments();
    // allAndselectedProductsList = listProductArray;
  }
}





$(document).on('change', '#filter ', function () {
  // console.log("estoy haciendo algo en el chagne de las categorias");
  const categorieToSearch = $(this).val()

  if (categorieToSearch === "all") {
    filterProductsResume(selectedProdsAndCategories)
    return
  }
  const catExists = selectedProdsAndCategories.find((categorie) => {
    if (categorie.categoria === categorieToSearch) {
      return true;
    }
  })
  if (catExists) {
    console.log(catExists);
    filterProductsResume([catExists])
  }
})



$('#getAvailableProducts').on('click', function () {
  let navItem = $(this).find('.projectAssigmentTab')
  if ($(navItem).hasClass('active')) {
    $(navItem).removeClass('active')
    $('#products').removeClass('active show').addClass('fade');
  } else {
    CloseAllTabsOnProjectsAssigments();
    $(navItem).addClass('active')
    $('#products').removeClass('fade')
    $('#products').addClass('active show');
  }
})

let _productos = [];
let _takenProducts = [];
let _lastTakenProducts = [];
let _selectedProducts = [];
let _categoriesandsubcategories = [];
let _allMycats = [];
let _allMySubCats = [];
let _searchProductValue = "";

// GET AND SET ALL PRODUCTS BY BUSSINESS
// NO TAKEN PRODUCTS OR SELECTED PRODUCTS HAS BEEN DISCOUNT YET
async function GetAllMyProducts() {
  const allMyProds = await GetAllProductsByBussiness(EMPRESA_ID);
  // console.table('allMyProds.data',allMyProds.data);
  _productos = allMyProds.data.map((producto) => {
    return {
      'id': producto.id,
      'categoria': producto.categoria,
      'item': producto.item,
      'nombre': producto.nombre,
      'precio_arriendo': parseInt(producto.precio_arriendo),
      'cantidad': parseInt(producto.cantidad),
      'disponibles': parseInt(producto.cantidad),
      'faltantes': 0
    }
  });
}

/*  SET DISCOUNT ON ALL PRODUCTS 
GET ALL SELECTED AND TAKEN PRODUCTS AND DISCOUNT FROM */
function setAllProducts_DiscountTakenProd() {
  // RETURN STOCK FROM LAST TAKEN PRODS
  _lastTakenProducts.forEach((takenProd) => {

    const productoE = _productos.find((prod) => {
      if (prod.id === takenProd.producto_id) {
        return true;
      }
    });

    if (productoE) {
      productoE.disponibles = parseInt(productoE.disponibles) + parseInt(takenProd.cantidad);
      if (productoE.disponibles < 0) {
        productoE.faltantes = Math.abs(productoE.disponibles);
      } else {
        productoE.faltantes = 0;
      }
    }
  })


  // RETURN STOCK TO _SELECTEDPRODS

  _selectedProducts.forEach((selectedProd) => {
    const prodExists = _productos.find((producto) => {
      return producto.id === selectedProd.id
    })
    if (prodExists) {
      selectedProd.disponibles = prodExists.disponibles;
      selectedProd.faltantes = prodExists.faltantes;
    }
  });

  

  // DISCOUNT TAKENPRODS FROM _PRODUCTOS
  _takenProducts.forEach((takenProd) => {
    // console.log("takenProd",takenProd);
    const productoE = _productos.find((prod) => {
      if (takenProd.producto_id === prod.id) {
        return true;
      }
    })
    // console.log("PRODUCTO ENCONTRADO", productoE);
    if (productoE) {
      productoE.disponibles = parseInt(productoE.disponibles) - parseInt(takenProd.cantidad);
      if (productoE.disponibles < 0) {
        productoE.faltantes = Math.abs(productoE.disponibles);
      } else {
        productoE.faltantes = 0;
      }
    }
  });

  // DISCOUNT TAKEN PRODUCTS FROM _SELECTEDPRODUCTS
  _selectedProducts.forEach((selectedProd) => {
    const prodExists = _productos.find((producto) => {
      return producto.id === selectedProd.id
    })
    if (prodExists) {
      selectedProd.disponibles = prodExists.disponibles;
      selectedProd.faltantes = prodExists.faltantes;
    }
  });

  _lastTakenProducts = _takenProducts;
}


// GET AND SET ALL TAKEN PRODS ON CHANGE EVENT
// ON SELECTED DATE (PROJECT MODULE)
async function setTakenProdsByRangeDate() {
  const fecha_inicial = $('#fechaInicio').val();
  const fecha_termino = $('#fechaTermino').val();
  if (fecha_inicial === "" || fecha_termino === "") {
    return false;
  }
  // set dates to get taken prods and substract from productList
  const dates = {
    'fecha_inicio': projectDates.start_date,
    'fecha_termino': projectDates.finish_date
  }
  const takenProds = await GetUnavailableProductsByDate(dates, EMPRESA_ID);

  _takenProducts = takenProds.data;
  console.table("_takenProducts", _takenProducts);
  return true;
}

function setSelectedProduct_AddNewProducts(prodsToAdd) {

  console.log("prods to add ", prodsToAdd);

  prodsToAdd.forEach((prodToAdd) => {
    const productExists = _productos.find((producto) => {
      return producto.id === prodToAdd.id
    })
    if (!productExists) {
      return;
    }
    // SUBSTRACT QUANTITY TO ADD TO ALL PRODS ON LIST
    // MODIFY AVAILABILITY
    _productos.forEach((producto) => {
      if (producto.id === prodToAdd.id) {
        producto.disponibles = producto.disponibles - parseInt(prodToAdd.quantityToAdd);
        if (producto.disponibles < 0) {
          producto.faltantes = Math.abs(producto.disponibles);
        } else {
          producto.faltantes = 0
        }
      }
    })

    const prodIsSelected = _selectedProducts.find((selectedProduct) => {
      if (selectedProduct.id === prodToAdd.id) {
        return selectedProduct;
      }
    })

    if (!prodIsSelected) {

      const actualProdStatus = _productos.find((producto) => {
        return producto.id === prodToAdd.id
      })

      _selectedProducts.push({
        'id': actualProdStatus.id,
        'categoria': actualProdStatus.categoria,
        'item': actualProdStatus.item,
        'nombre': actualProdStatus.nombre,
        'precio_arriendo': parseInt(actualProdStatus.precio_arriendo),
        'cantidad': parseInt(actualProdStatus.cantidad),
        'disponibles': parseInt(actualProdStatus.disponibles),
        'faltantes': actualProdStatus.faltantes,
        'quantityToAdd': prodToAdd.quantityToAdd,
        'comentario': ''
      });

    } else {
      const actualProdStatus = _productos.find((producto) => {
        return producto.id === prodToAdd.id
      })
      prodIsSelected.quantityToAdd = parseInt(prodIsSelected.quantityToAdd) + parseInt(prodToAdd.quantityToAdd);
      prodIsSelected.faltantes = actualProdStatus.faltantes;
      prodIsSelected.disponibles = actualProdStatus.disponibles
    }
  })
  console.log("SELECTED PRODS", _selectedProducts);
  return true;
}


// GIVE FORMAT AND RETURN NEW JSON OBJECT THAT CONTAINS 
// CATEGORIES AND SUBCATEGORIES BASED ON SELECTED PRODUCTS

function setCategoriesAndSubCategories() {
  _categoriesandsubcategories = [];

  _allMycats = [];
  _allMySubCats = [];

  _selectedProducts.forEach((selectedProd) => {
    if (!_allMycats.includes(selectedProd.categoria)) {
      _allMycats.push(selectedProd.categoria);
    }
  })

  _selectedProducts.forEach((selectedProd) => {

    const subCatExists = _allMySubCats.find((subcat) => {
      if (subcat.subcategoria === selectedProd.item && subcat.categoria === selectedProd.categoria) {
        return subcat
      }
    })

    if (!subCatExists) {
      _allMySubCats.push({
        'categoria': selectedProd.categoria,
        'subcategoria': selectedProd.item
      });
    }
  });



  const catAndSubcats = _allMycats.map((categoria) => {
    // search categorie on selectedProducts
    const subcats = _allMySubCats.map((subcat) => {
      if (subcat.categoria === categoria) {

        const productosSubCat = _selectedProducts.filter((selectedProd) => {
          return selectedProd.item === subcat.subcategoria && selectedProd.categoria === subcat.categoria
        });

        console.log('____subcat.categorie', subcat.categoria)
        console.log('____productosSubCat', productosSubCat);

        let isEmptySubCategorie = subcat.subcategoria;

        if(isEmptySubCategorie == null ){
          isEmptySubCategorie = 'sin subcateogría'
        }

        return {
          'nombre': isEmptySubCategorie,
          'productos': productosSubCat
        }
      }
    });


    return {
      'categoria': categoria,
      'subcategorias': subcats
    }
  });

  catAndSubcats.forEach((categoria) => {
    categoria.subcategorias = categoria.subcategorias.filter((subcategorias) => { return subcategorias !== undefined });
    categoria.subcategorias.forEach((subcategoria) => {
      const productosFiltered = subcategoria.productos.filter((producto) => { return producto !== undefined; })
      subcategoria.productos = productosFiltered;
    })
  })

  _categoriesandsubcategories = catAndSubcats;

}

function printAllProductsOnTable(searchValue, indexTab) {
  
    // if(_productos.length === 0){
    //   document.getElementById('palCtn').style.display = 'none';
    //   document.getElementById('palCtn').style.display = 'flex';
    //   return;
    // }
  
  

  if ($.fn.DataTable.isDataTable('#tableProducts')) {

    $('#tableProducts tbody tr').remove();

    $('#tableProducts').DataTable()
      .clear()
      .draw();

    $('#tableProducts')
      .DataTable()
      .destroy();
  }


  _productos.forEach((producto) => {
    let tr = `<tr product_id="${producto.id}">
          <td class="catProd --res-del"> <p class="--h-text-lg">${producto.categoria}</p></td>
          <td class="itemProd --res-del"> <p class="--h-text-lg">${producto.item == null ? ' ' :producto.item}</p></td>
          <td class="productName"><p class="--h-text-lg w250">${producto.nombre}</p></td>
          <td class="productStock --res-del" >${producto.cantidad}</td>
          <td class="productAvailable --res-del">${(producto.disponibles) < 0 ? 0 : producto.disponibles}</td>
          <td><input class="addProdInput quantityToAdd quantityProductInput" id="" type="number" min="1"/><i class="fa-solid fa-plus addItem plusProd" onclick="AddProduct(this)"></i></td>
        </tr>`
    $('#tableProducts tbody').append(tr);
  });

  if (!$.fn.DataTable.isDataTable('#tableProducts')) {
    dataTableProduct = $('#tableProducts').DataTable(
      {
        pageLength: 100,
        responsive:true,
        columns: [{ width: '25%' }, { width: '25%' }, { width: '30%' }, { width: '5%' }, { width: '5%' },{width: '10%'}]
      }
    );
    closeSelectedProdsMobile();
  }
}


function printAllProductsOnTableFromPrevSearch(searchValue, indexTab) {





  if ($.fn.DataTable.isDataTable('#tableProducts')) {

    $('#tableProducts tbody tr').remove();

    $('#tableProducts').DataTable()
      .clear()
      .draw();

    $('#tableProducts')
      .DataTable()
      .destroy();
  }
  
  _productos.forEach((producto) => {
    let tr = `<tr product_id="${producto.id}">
          <td class="catProd --res-del"> ${producto.categoria}</td>
          <td class="itemProd --res-del"> ${producto.item == null ? ' ' :producto.item}</td>
          <td style="width:25%" class="productName">${producto.nombre}</td>
          <td class="productStock --res-del" >${producto.cantidad}</td>
          <td class="productAvailable --res-del">${(producto.disponibles) < 0 ? 0 : producto.disponibles}</td>
          <td ><input class="addProdInput quantityToAdd quantityProductInput" id="" type="number" min="1"/><i class="fa-solid fa-plus addItem addI-20" onclick="AddProduct(this)"></i></td>
        </tr>`
    $('#tableProducts tbody').append(tr);
  });

  if (!$.fn.DataTable.isDataTable('#tableProducts')) {

    dataTableProduct = $('#tableProducts').DataTable(
      {
        pageLength: 100,
        responsive:true,
        columns: [{ width: '20%' }, { width: '20%' }, { width: '20%' }, { width: '5%' }, { width: '5%' },{width: '10%'}]
      }
    );
    closeSelectedProdsMobile();
  }
  $("#tableProducts").DataTable().page(indexTab).draw(false);


  
  $('#tableProducts_filter').find('input[type="search"]').val(searchValue);
}


function printAllSelectedProducts() {

  $('#-a-m-SelProds tbody tr').remove();

  $('#selectedProdsPreview .prod-item').remove();
  $('#productResume-tables h3').remove();
  $('#productResume-tables table').remove();
  $('#filterSelectedProducts option').remove();
  $('#filterSelectedProducts').append(`<option value="all">Todos</option>`);
  $('#ventaEventos categorieSubTotal').remove();
  $('#ventaEventos h3').remove();
  // $('#ventaEventos p').remove();
  $('#ventaEventos .categorieHeaderTitle').remove();
  $('#ventaEventos input').remove();
  $('#ventaEventos table').remove();
  $('#projectResumeFilter-products option').remove();
  $('#projectResumeFilter-products').append(`<option value="all">Todos</option>`);

  // THIS IS FOR PROJECT RESUME  
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  console.log('_categoriesandsubcategories',_categoriesandsubcategories);
  _categoriesandsubcategories.forEach((categoria) => {

    $('#projectResumeFilter-products')
      .append(`<option value="${categoria.categoria}">${categoria.categoria}</option>`);

    const tableId = `projectResumeProduct-${categoria.categoria.replaceAll(' ', '_')}`;
    let selectedProdTableId = `eventSelectedProduct-${categoria.categoria.replaceAll(' ', '_')}`;
    const subCategorias = categoria.subcategorias;

    let selProdTr = `<tr>
      <td class="--sel-pr-cat" colspan="3"> <p class="-sel-cat-name">${categoria.categoria}</p> </td>
    </tr>`

  $('#-a-m-SelProds').append(selProdTr)

    $('#ventaEventos').append(
      `<div class="row categorieSubTotal">
        <p class = "categorieHeaderTitle">${categoria.categoria[0].toUpperCase() + categoria.categoria.substring(1)}</p>
      </div>
      <table id="${tableId}" class="tableCatsAnsResume" style="margin-bottom:20px;">
          <thead>
          <tr>
            <th></th>
            <th> 
              <p>Precio Unitario</p> 
            </th>
            <th> 
              <p>Cantidad</p>
            </th>
            <th> 
              <p>Total</p>
            </th>
            <th> 
              <p>Comentarios</p>
            </th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><p class="col-lg-6  col-10" style="text-align:end;">Subtotal</p></td>
              <td><input type="text" categorie_name="${categoria.categoria.replaceAll(' ', '_')}" class="col-lg-6 col-10 relativeCategorieValue" id="subtotalCategoria-${categoria.categoria.replaceAll(' ', '_')}"></td>
            </tr>
          </tfoot>
      </table>`
    );


 
    // console.table(subCategorias);
    subCategorias.forEach((subcategoria) => {
      const productos = subcategoria.productos;
      // $(`#${tableId}`).append(`<tr><td colspan="4" class="subcategorieName"><p ></p>${subcategoria.nombre}</td></tr>`);
      productos.forEach((prod) => {
        let total = parseInt(prod.quantityToAdd) * parseInt(prod.precio_arriendo);
        $(`#${tableId}`).append(`<tr product_id="${prod.id}">
          <td>${prod.nombre}</td>
          <td class="cuTd"><input type="text" class="product-price" value="${CLPFormatter(prod.precio_arriendo)}"></td>
          <td class="cantTd"><input type="number" class="addProdInputResume" min="1" max="" value="${prod.quantityToAdd}"/></td>
          <td class="totalTd"><input type="text" class="totalProdInputResume" min="1" max="" value="${CLPFormatter(total)}"/></td>
          <td class="saleProdComment"><input type="text" class="saleProdCommentInput"/></td>
          <td style="color:red;cursor:pointer;"><i class="fa-solid fa-trash removePrd"></i></td>
        </tr>`)

      //   <div class="col-lg-2 col-md-4 col-sm-5 col-12 prod-item">
      //   <p>${prod.nombre}</p>
      //   <img src="../../assets/svg/trashCan-red.svg" alt="">
      // </div>

        let selProdTr = `<tr product_id="${prod.id}" class="--sel-pr">
          <td class="--ts"> <p>${prod.nombre}</p> </td>
          <td class="--tc"><input type="number" name="" id="" class="selProdQty" min="1"  value="${prod.quantityToAdd}"></td>
          <td><img src="../../assets/svg/trashCan-red.svg" alt="" class="rmv-sel-prod"></td>
        </tr>`

        $('#-a-m-SelProds').append(selProdTr)
      })
    })
  })
}


let currentProductRentValue = 0;
$(document).on('click', '.product-price', async function () {
  currentProductRentValue = ClpUnformatter($(this).val());
  $(this).val("");
})

$(document).on('blur', '.product-price', async function () {

  const newRentPrice = ClpUnformatter($(this).val());
  if (newRentPrice === "" || newRentPrice === null || newRentPrice === undefined) {
    $(this).val(CLPFormatter(parseInt(currentProductRentValue)))
    return;
  }

  if (!isNumeric(newRentPrice)) {
    Swal.fire(
      'Ups!',
      'ingrese un valor',
      'warning'
    );

    $(this).val(CLPFormatter(parseInt(currentProductRentValue)));
    return;
  }
  // GET PRODUCT ID FROM DOM 
  const producto_id = $(this).closest('tr').attr('product_id');
  // CHECK IF ATTR EXISTS ON PRODUCTS ARRAY
  const prodExists = _productos.find((prod) => {
    if (prod.id === producto_id) {
      return true;
    }
  })
  // RETURN IF ATTR IS MODIFICATED BY USER ON DOM
  if (!prodExists) {
    Swal.fire('Ups!', 'Ha ocurrido un error', 'error');
    return;
  }
  // FIND PRODUCT ON ARRYA AND SELECT 
  _categoriesandsubcategories.forEach(categorie => {
    categorie.subcategorias[0].productos.forEach((prod) => {
      if (prod.id === producto_id) {
        prod.precio_arriendo = parseInt(newRentPrice);
      }
    })
  });

  _selectedProducts.forEach((prod) => {
    if (prod.id === producto_id) {
      prod.precio_arriendo = parseInt(newRentPrice);
    }
  })
  $(this).val(CLPFormatter(parseInt(newRentPrice)));
  printAllSelectedProducts();
  setIngresos();
});



function setSelectedProduct_RemoveProducts(prodsToRemove) {

  prodsToRemove.forEach((prodsToRemove) => {
    const productExists = _productos.find((producto) => {
      return producto.id === prodsToRemove.id
    });
    if (!productExists) {
      return;
    }
    // SUBSTRACT QUANTITY TO ADD TO ALL PRODS ON LIST
    // MODIFY AVAILABILITY
    _productos.forEach((producto) => {
      if (producto.id === prodsToRemove.id) {
        producto.disponibles = producto.disponibles + parseInt(prodsToRemove.quantity);
        if (producto.disponibles < 0) {
          producto.faltantes = Math.abs(producto.disponibles);
        } else {
          producto.faltantes = 0
        }
      }
    })
    const selectedProd = _selectedProducts.find((selectedProd) => {
      return selectedProd.id === prodsToRemove.id
    })
    if (selectedProd) {

      selectedProd.quantityToAdd = parseInt(selectedProd.quantityToAdd) - parseInt(prodsToRemove.quantity);

      if (selectedProd.quantityToAdd === 0) {
        // DELETE FROM _SELECTEDPRODUCTS IN CASE QUANTITYTOADD EQUAL TO 0 
        _selectedProducts.splice(_selectedProducts.indexOf(selectedProd), 1)
      } else {
        selectedProd.disponibles = parseInt(selectedProd.disponibles) + parseInt(prodsToRemove.quantity);
        if (selectedProd.disponibles > 0) {
          selectedProd.faltantes = 0
        } else {
          selectedProd.faltantes = Math.abs(selectedProd.disponibles)
        }
      }
    }
  })
  console.log("_selectedProducts", _selectedProducts);
  return true;
}

async function fillProductsTable() {
  await GetAllMyProducts();
  printAllProductsOnTable();
}






let currentRelativeCatValue = 0;
$(document).on('click', '.relativeCategorieValue', function () {
  currentRelativeCatValue = ClpUnformatter($(this).val());
  $(this).val("");
});

$(document).on('blur', '.relativeCategorieValue', function () {
  const valor = $(this).val();

  if (valor === "" || valor === undefined || valor === null) {
    $(this).val(CLPFormatter(currentRelativeCatValue));
    return
  }

  if (!isNumeric(valor)) {
    Swal.fire({
      icon: 'warning',
      title: 'Ups!',
      text: 'Debes ingresar un número',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    $(this).val(CLPFormatter(currentRelativeCatValue));
    return;
  }

  const categorie = $(this).attr('categorie_name').replaceAll('_', ' ');
  const categoriaTotal = totalPerItem.equipos.find((categoria) => {
    if (categoria.categorie === categorie) {
      categoria.value = parseInt(valor);
      categoria.isEdited = true
      return categoria;
    }
  });




  // let totalOp = 0;
  // _selectedProducts.forEach((selprod)=>{
  //     if(selprod.categoria === categorie){
  //       totalOp += (parseFloat(selprod.precio_arriendo_edited) * parseInt(selprod.quantityToAdd))
  //     }
  // });

  $(this).val(CLPFormatter(categoriaTotal.value));
  setIngresos();
})

//$(document).on('click','.hideColumn',function(){
//   // const 
//   if($(this).closest('th').hasClass('tempHidden')){
//     $(this).closest('th').removeClass('tempHidden');
//     return;
//   }
//   $(this).closest('th').addClass('tempHidden');
//})

$(document).on('click', '.hide-cu', function () {
  if ($(this).closest('th').hasClass('tempHidden')) {
    $(this).closest('th').removeClass('tempHidden');
    $(this).closest('table').find('tbody').find('.cuTd').removeClass('tempHidden')
    return;
  }
  $(this).closest('th').addClass('tempHidden');
  $(this).closest('table').find('tbody').find('.cuTd').addClass('tempHidden')


})
$(document).on('click', '.hide-cant', function () {

  if ($(this).closest('th').hasClass('tempHidden')) {
    $(this).closest('th').removeClass('tempHidden');
    $(this).closest('table').find('tbody').find('.cantTd').removeClass('tempHidden')
    return;
  }
  $(this).closest('th').addClass('tempHidden');
  $(this).closest('table').find('tbody').find('.cantTd').addClass('tempHidden')


})
$(document).on('click', '.hide-total', function () {

  if ($(this).closest('th').hasClass('tempHidden')) {
    $(this).closest('th').removeClass('tempHidden');
    $(this).closest('table').find('tbody').find('.totalTd').removeClass('tempHidden')
    return;
  }
  $(this).closest('th').addClass('tempHidden');
  $(this).closest('table').find('tbody').find('.totalTd').addClass('tempHidden')

})

let lastProdTotal = 0;
$(document).on('click', '.totalProdInputResume', function () {
  lastProdTotal = parseInt(ClpUnformatter($(this).val()));
  $(this).val("");
})

$(document).on('blur', '.totalProdInputResume', function () {
  const valor = parseInt(ClpUnformatter($(this).val()));
  const product_id = $(this).closest('tr').attr('product_id');

  if (valor === "" || valor === undefined || valor === null) {
    $(this).val(CLPFormatter(lastProdTotal));
    return
  }

  if (!isNumeric(valor)) {
    Swal.fire({
      icon: 'warning',
      title: 'Ups!',
      text: 'Debes ingresar un número',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    $(this).val(CLPFormatter(lastProdTotal));
    return;
  }

  const prodExists = _selectedProducts.find((prod) => {
    return prod.id === product_id;
  })

  if (!prodExists) {
    Swal.fire({
      icon: 'error',
      title: 'Ups!',
      text: 'Ha ocurrido un error',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    return
  }

  let newPrecioArriendo = valor / prodExists.quantityToAdd;
  prodExists.precio_arriendo = newPrecioArriendo;
  printAllSelectedProducts();
  setIngresos();
  $(this).val(CLPFormatter(valor));
});

// capture value on inpt saleProdCommentInput
$(document).on('blur', '.saleProdCommentInput', function () {

  console.log('1827391823')

  const comentario = $(this).val();
  console.log('console.log(comentario)',comentario);
  const product_id = $(this).closest('tr').attr('product_id');

  const PROD_EXISTS = _selectedProducts.find((prod) => {

    return prod.id == product_id;
  });

  if (!PROD_EXISTS) {
    Swal.fire({
      icon: 'error',
      title: 'Ups!',
      text: 'Ha ocurrido un error',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    return
  }

  console.log('PROD_EXISTS',PROD_EXISTS);
  
  PROD_EXISTS.comentario = comentario;

  console.log('PROD_EXISTS',PROD_EXISTS);
  console.log('_selectedProducts', _selectedProducts);

  
});


$(document).on('click', '.quantityProductInput', function () {
  isProdQuantitySelected = true;
  prodQuantityElementSelected = $(this);
})

/*
  // OTHER PRODUCTS SECTION
*/

let lastCantOthers = 0;
let lastTotalOthers = 0;
let _selectedOthersProducts = [];

$('#addNewOthersRow').on('click', async function () {
  printAllSelectedOthers();
})


$(document).on('blur', '.nameOthers', function () {
  setOtherIfReady();
})

$(document).on('click', '.cantidadOthers', function () {

  if ($(this).val() === "") {
    lastCantOthers = 0;
  } else {
    lastCantOthers = $(this).val();
  }
  $(this).val("");
})


$(document).on('blur', '.cantidadOthers', function () {

  const valor = $(this).val();

  if (valor === "" || valor === undefined || valor === null) {
    $(this).val(parseInt(lastCantOthers));
    return
  }

  if (!isNumeric(valor)) {
    Swal.fire({
      icon: 'warning',
      title: 'Ups!',
      text: 'Debes ingresar un número',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    $(this).val(parseInt(lastCantOthers));
    return;
  }

  $(this).val(parseInt(valor));

  setOtherIfReady();
})


$(document).on('click', '.totalOthers', function () {
  if ($(this).val() !== "") {
    lastTotalOthers = parseInt(ClpUnformatter($(this).val()));
  }
  $(this).val("")
})


$(document).on('blur', '.totalOthers', function () {

  const valor = $(this).val();

  if (valor === "" || valor === undefined || valor === null) {
    $(this).val(CLPFormatter(lastTotalOthers));
    return
  }

  if (!isNumeric(valor)) {
    Swal.fire({
      icon: 'warning',
      title: 'Ups!',
      text: 'Debes ingresar un número',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000
    });
    $(this).val(CLPFormatter(lastTotalOthers));
    return;
  }

  $(this).val(CLPFormatter(valor));

  setOtherIfReady();
})



function printAllSelectedOthers() {

  $('#others-table tbody tr').remove();

  _selectedOthersProducts.forEach((other) => {
    console.log("NOMBRE other product", other);
    let tr = `<tr>
      <td><input type="text" class="nameOthers" value="${other.detalle}"></td>
      <td class="cantTd"><input type="text" class="cantidadOthers" value="${other.cantidad}"></td>
      <td class="totalTd"><input type="text" class="totalOthers" value="${other.total}"></td>
    </tr>`;

    $('#others-table tbody').append(tr)
  });

  let tr = `<tr class="notCompletedSubArriendo">
    <td><input type="text" class="nameOthers" value=""></td>
    <td class="cantTd"><input type="number" class="cantidadOthers" value=""></td>
    <td class="totalTd"><input type="text" class="totalOthers" value=""></td>
  </tr>`;
  $('#others-table tbody').append(tr)

  tippy('.notCompletedSubArriendo', {
    content: '<strong>Debes completar todos los campos para poder agregar otros equipos  al venta</strong>',
    animation: 'perspective'
  });
}
function printOthersProds() {

  $('#others-table tbody tr').remove();

  _selectedOthersProducts.forEach((other) => {
    let tr = `<tr>
      <td><input type="text" class="nameOthers" value="${other.detalle}"></td>
      <td class="cantTd"><input type="text" class="cantidadOthers" value="${other.cantidad}"></td>
      <td class="totalTd"><input type="text" class="totalOthers" value="${CLPFormatter(other.total)}"></td>
    </tr>`;
    $('#others-table tbody').append(tr)
  });
}

function setOtherIfReady() {
  _selectedOthersProducts = [];
  $('#others-table tbody tr').each((key, element) => {
    console.log("ELEMENT", element);
    if ($(element).find('.nameOthers').val() &&
      $(element).find('.cantidadOthers').val() &&
      $(element).find('.totalOthers').val()) {

      $(element).removeClass('notCompletedSubArriendo');
      $(element).addClass('isCompletedSubArriendo');

      _selectedOthersProducts.push({
        'detalle': $(element).find('.nameOthers').val(),
        'cantidad': parseInt(ClpUnformatter($(element).find('.cantidadOthers').val())),
        'total': parseInt(ClpUnformatter($(element).find('.totalOthers').val()))
      });
    } else {
      $(element).addClass('notCompletedSubArriendo');
    }
  });
  setIngresos();
}




/*
  // END OTHER PRODUCTS SECTION
*/





// HEADER SEARCH INPUT FOR PROD TABLE

$('#products-tab').on('click',function(){

  searchInputTarget = dataTableProduct;
})


