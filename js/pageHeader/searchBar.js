let searchInputTarget = '';

$('#dashIndexInput').on('keyup',function(){
    console.log($(this).val());
    console.log($(searchInputTarget));

    // $(searchInputTarget).val($(this).val())


    searchInputTarget.search($(this).val()).draw() ;

})