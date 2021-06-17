$(document).on('click','.backBtn',function(e){
    console.log('backBrn');
    e.preventDefault();
    window.history.back();
});

$(document).on('click','a',function(e){
    //console.log($(this).attr('href'));
    if($(this).attr('target')===undefined && $(this).attr('href')!==undefined && $(this).attr('href')!='' && $(this).attr('href')!='#'){
        pageLoaderShow();
    }
    
});
$(document).on('submit','form',function(e){
    pageLoaderShow();
});

function pageLoaderShow(){
    //$('.pageLoader').fadeIn();
}
function pageLoaderHide(){
    $('.pageLoader').hide();
}

$(document).on('click','.postTableList tbody tr td.link',function(e){
    window.location = $(this).closest('tr').attr('data-href');
});
$(document).on('click','.goBack',function(e){    
    window.history.back();
});