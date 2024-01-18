let _allMyOtherCosts = [];
let others_costs_temp_id = 1;

$('#addNewRowOtherCosts').on('click',function(){

    appendNewRowOtherCosts("","","");

})


function appendNewRowOtherCosts(detalle,cantidad,total){
    let tr = `<tr other_cost_id = ${others_costs_temp_id}>
        <td><input type="text" class="nameOtherCost" value="${detalle}"></td>
        <td class=""><input type="text" class="cantidadOtherCost" value="${cantidad}"></td>
        <td class=""><input type="text" class="totalOtherCost" value="${CLPFormatter(total)}"></td>
        <td style="width: 57px;" class="removeOtherCost"><img src="/assets/svg/trashCan.svg" alt=""></td>
    </tr>`;
    $('#otherCosts-table tbody').append(tr);
    others_costs_temp_id ++;

    
}   


$(document).on('blur','.nameOtherCost',function(){
 checkIfOtherCostsRowIsReady($(this));
})
$(document).on('blur','.cantidadOtherCost',function(){
 checkIfOtherCostsRowIsReady($(this));
})
$(document).on('blur','.totalOtherCost',function(){
 checkIfOtherCostsRowIsReady($(this));
})
$(document).on('click','.removeOtherCost',function(){
 const OTHER_PROD = $(this).closest('tr').attr('other_cost_id')
 const TR = $(this).closest('tr');
 removeOtherCostsRow(OTHER_PROD);
 $(TR).remove();
})



function checkIfOtherCostsRowIsReady(el) {
    const element = $(el).closest('tr');
    const TEMP_ID = $(el).closest('tr').attr('other_cost_id');
    if ($(element).find('.nameOtherCost').val() !== "" &&
        $(element).find('.cantidadOtherCost').val() !== "" &&
        $(element).find('.totalOtherCost').val() !== "") 
    {
        const TEMP_ID = $(el).closest('tr').attr('other_cost_id');
        $(element).removeClass("incomplete");
        _allMyOtherCosts.push({
            'temp_id':TEMP_ID,
            'name': $(element).find('.nameOtherCost').val(),
            'cantidad': $(element).find('.cantidadOtherCost').val(),
            'monto': $(element).find('.totalOtherCost').val()
        });
        rendicion_temp_id ++;
    
    } else{
        const otherCostExistsOnList = _allMyOtherCosts.find((cost)=>{
            return cost.temp_id === TEMP_ID
        })
        if(otherCostExistsOnList){
            _allMyOtherCosts.splice(_allMyOtherCosts.indexOf(otherCostExistsOnList),1);
        }
        $(element).addClass("incomplete");
    }
        
}


function removeOtherCostsRow(otherProdId){
    const OTHER_COST_EXIST = _allMyOtherCosts.find((other,i)=>{  index = i;
        return other.temp_id === otherProdId;
    });
    if(OTHER_COST_EXIST){
        _allMyOtherCosts.splice(_allMyOtherCosts.indexOf(OTHER_COST_EXIST),1);
    }
}
